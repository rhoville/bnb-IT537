<?php
session_start();
include "config.php";

// Fetch room ID from the URL
if (isset($_GET['bookingID']) && is_numeric($_GET['bookingID'])) {
    $id = $_GET['bookingID'];
} else {
    die("Invalid Room ID.");
}

// Connect to Database
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno()) {
    die("Error: Unable to connect to MySQL. " . mysqli_connect_error());
}

// Prepare Query for Room
$query = 'SELECT * FROM room WHERE roomID=?';  // Change 'bookingID' to 'roomID' or your actual column name
$stmt = mysqli_prepare($DBC, $query);

// Check if preparation of the query was successful
if ($stmt === false) {
    die('mysqli_prepare failed: ' . mysqli_error($DBC));
}

if (!mysqli_stmt_bind_param($stmt, 'i', $id)) {
    die('mysqli_stmt_bind_param failed: ' . mysqli_stmt_error($stmt));
}

if (!mysqli_stmt_execute($stmt)) {
    die('mysqli_stmt_execute failed: ' . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("No room found!");
}
$roomReview = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['review'])) {
        $updatedReview = $_POST['review'];

        // Update the review in the database
        $updateQuery = 'UPDATE booking SET review=? WHERE bookingID=?';
        $updateStmt = mysqli_prepare($DBC, $updateQuery);

        if (!mysqli_stmt_bind_param($updateStmt, 'si', $updatedReview, $id) ||
            !mysqli_stmt_execute($updateStmt)) {
            $message = "Error updating review: " . mysqli_stmt_error($updateStmt);
        } else {
            $message = "Review updated successfully!";
        }
    }
}

// Fetch the room review
$reviewQuery = 'SELECT review FROM booking WHERE bookingID=?';  // No change here as it was correct
$reviewStmt = mysqli_prepare($DBC, $reviewQuery);

// Check if preparation of the review query was successful
if ($reviewStmt === false) {
    die('Review query mysqli_prepare failed: ' . mysqli_error($DBC));
}

if (!mysqli_stmt_bind_param($reviewStmt, 'i', $id)) {
    die('Review query mysqli_stmt_bind_param failed: ' . mysqli_stmt_error($reviewStmt));
}

if (!mysqli_stmt_execute($reviewStmt)) {
    die('Review query mysqli_stmt_execute failed: ' . mysqli_stmt_error($reviewStmt));
}

$reviewResult = mysqli_stmt_get_result($reviewStmt);

if ($reviewResult) {
    $reviewRow = mysqli_fetch_assoc($reviewResult);
    $roomReview = $reviewRow['review'] ?? 'No review available';
} else {
    $roomReview = 'No review available';
}
?>


<!DOCTYPE HTML>
<html>

<head>
  <title>Home Page</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <style>
     .header-container {
      display: flex;
      flex-direction: column;
      align-items: left;
      padding: 20px;
      background-color: #000000;
    }
    .logo {
      width: 200px;
      height: auto;
      object-fit: contain;
    }
    .slogan {
      margin-top: 10px;
      font-size: 14px;
      font-weight: bold;
      color: #ffffff;
    }
    .social-media {
      margin-top: 20px;
    }
    .social-media a {
      margin: 0 10px;
      font-size: 24px;
      color: white; 
    }
    .li {
      color: #ffffff;
    }
    .welcome-message {
  color: yellow;
  font-size: 16px;
  margin-bottom: 10px;
  text-align:  right;
    }
    form {
    margin-top: 20px;
}

textarea {
    width: 100%;
    padding: 10px;
    margin: 5px 0 20px 0;
    resize: vertical;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

button:hover {
    background-color: #45a049;
}

/* Messages */
p {
    margin: 20px 0;
    padding: 15px;
    border-radius: 5px;
}

/* Success message */
p[style*='color: green;'] {
    border: 1px solid #4CAF50;
    background-color: #dff0d8;
}

/* Section */
.section {
    margin-bottom: 20px;
}

.label {
    font-weight: bold;
}
 </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

<div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="content">
    <h2>View Room</h2>
    <a href="currentbooking.php">[Return to Booking Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>
    
    <form method="post">
        <div class="section">
            <strong>Review made by:</strong> Rhoville
        </div>
        <?php
    if ($message) {
        echo "<p style='color: green;'>$message</p>";
    }
    ?>
        <div class="section">
            <label for="review">Room Review:</label><br>
            <textarea id="review" name="review" rows="4" cols="50"><?php echo htmlspecialchars($roomReview); ?></textarea>
        </div>

        <button type="submit" id="updateButton" style="margin-left: 40px;margin-bottom: 350px;">Update</button>
    </form>
    
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
