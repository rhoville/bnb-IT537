<?php
session_start();
include "config.php"; // Load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was successful
if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
  exit; // Stop processing the page further
}

// Function to clean input but not validate type and content
function cleanInput($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

// Retrieve the booking ID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $bookingID = $_GET['bookingID'];
  if (empty($bookingID) or !is_numeric($bookingID)) {
    echo "<h2>Invalid Booking ID</h2>"; 
    exit;
  }
}

// Check if we are deleting data
if (isset($_POST['submit']) && !empty($_POST['submit']) && ($_POST['submit'] == 'Delete')) {
  $error = 0; 
  $msg = 'Error: ';
  
  // Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['submit'] == 'Delete') {
    // Get the booking ID from the form
    $bookingID = $_POST['bookingID'];

    // Prepare a query to delete the booking
    $deleteQuery = "DELETE FROM booking WHERE bookingID=?";
    $stmt = mysqli_prepare($DBC, $deleteQuery);

    // Bind the parameter and execute the statement
    mysqli_stmt_bind_param($stmt, 'i', $bookingID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Set a session variable to indicate the successful deletion
    $_SESSION['booking_deleted'] = true;
    
    // Redirect to the booking listing page after deletion
    header("Location: currentbooking.php");
    exit;
}
  // Booking ID
  if (isset($_POST['bookingID']) && !empty($_POST['bookingID']) && is_integer(intval($_POST['bookingID']))) {
    $bookingID = cleanInput($_POST['bookingID']);
  } else {
    $error++; // Bump the error flag
    $msg .= 'Invalid Booking ID ';
    $bookingID = 0;
  }
  
  // Delete the booking if the error flag is still clear and booking ID is > 0
  if ($error == 0 && $bookingID > 0) {
    $query = "DELETE FROM booking WHERE bookingID=?";
    $stmt = mysqli_prepare($DBC, $query); 
    mysqli_stmt_bind_param($stmt, 'i', $bookingID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<h2>Booking deleted.</h2>";
  } else {
    echo "<h2>$msg</h2>";
  }
}

// Prepare a query and send it to the server
$query = 'SELECT * FROM booking WHERE bookingID=' . $bookingID;
$result = mysqli_query($DBC, $query);

// Make sure we have the booking
if ($result && mysqli_num_rows($result) > 0) 
    $row = mysqli_fetch_assoc($result);
  
   // Fetch room name for the booking
$roomQuery = "SELECT roomname, roomtype, beds FROM room WHERE roomID=" . $row['roomID'];
$roomResult = mysqli_query($DBC, $roomQuery);

// Check if the query was successful and if there are any rows returned
if ($roomResult && mysqli_num_rows($roomResult) > 0) {
    $roomData = mysqli_fetch_assoc($roomResult);

    $roomName = $roomData['roomname'];
    $roomType = $roomData['roomtype'];
    $beds = $roomData['beds'];

   
} else {
   
}
?>

<!DOCTYPE HTML>
<html>
<head>
  <title>Delete Booking</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script>
function confirmDelete() {
    if (confirm("Are you sure you want to delete this booking?")) {
        return true;
    } else {
        return false;
    }
}
</script>

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
      text-align: right;
    }

    fieldset {
      margin-top: 30px; 
    }
    dt {
      font-weight: bold;
      margin-left: 20px;
    }

    dd {
      margin-left: 30px;
    }

  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

<div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="content">
    <h2>Delete Booking</h2>
    <a href="currentbooking.php">[Return to Booking Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>
    <?php

if ($row) {
    echo "<fieldset><legend>Booking detail #$bookingID</legend><dl>";
    echo "<dt>Room Name:</dt><dd>".$roomName."</dd>".PHP_EOL; 
    echo "<dt>Room Type:</dt><dd>".$roomType."</dd>".PHP_EOL; 
    echo "<dt>Bed:</dt><dd>".$beds."</dd>".PHP_EOL; 
    echo "<dt>Check-in Date:</dt><dd>".$row['checkinDate']."</dd>".PHP_EOL;
    echo "<dt>Check-out Date:</dt><dd>".$row['checkoutDate']."</dd>".PHP_EOL;
    echo "<dt>Contact Number:</dt><dd>".$row['contactNumber']."</dd>".PHP_EOL;
    echo "<dt>Extras:</dt><dd>".$row['extra']."</dd>".PHP_EOL;
    echo "<dt>Review:</dt><dd>".$row['review']."</dd>".PHP_EOL;
    echo '</dl></fieldset>'.PHP_EOL;
      ?>
    <form method="POST" action="deletebooking.php?bookingID=<?php echo $bookingID; ?>" onsubmit="return confirmDelete();">
  <h2>Are you sure you want to delete this booking?</h2>
  <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">
  <input type="submit" name="submit" value="Delete">
  <a href="currentbooking.php">[Cancel]</a>
</form>

    <?php
    } else {
      echo "<h2>Booking not found with that ID</h2>";
    }

    mysqli_free_result($result); 
    mysqli_close($DBC); 
    ?>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>