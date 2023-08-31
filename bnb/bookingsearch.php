<?php
// Include database configuration
include 'config.php';

// Initialize an empty array to hold our search results
$response = [];

// Connect to the database
$conn = connect();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search dates from the POST data
$from_date = $_POST['sqa'];
$to_date = $_POST['sqb'];

// Prepare and execute the SQL query
$sql = "SELECT * FROM room WHERE availability='Available' AND 
        (NOT (checkinDate >= ? AND checkoutDate <= ?))";

if($stmt = $conn->prepare($sql)) {
    // Bind the variables to the prepared statement as parameters
    $stmt->bind_param("ss", $from_date, $to_date);
    
    // Attempt to execute the prepared statement
    if($stmt->execute()) {
        $result = $stmt->get_result();
        
        // Check the number of rows in the result set
        if ($result->num_rows > 0) {
            // Fetch all rows as an associative array
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        }
    } else {
        $response['error'] = "Couldn't execute query.";
    }
    
    // Close the statement
    $stmt->close();
} else {
    $response['error'] = "Couldn't prepare query.";
}

// Close the database connection
$conn->close();

// Return the JSON response
echo json_encode($response);
?>
