<?php
session_start();
include "config.php"; 
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; 
}

// Do some simple validation to check if booking ID exists
$bookingID = $_GET['bookingID'];
if (empty($bookingID) || !is_numeric($bookingID)) {
    echo "<h2>Invalid bookingID</h2>"; 
    exit;
}

// Prepare a query and send it to the server
$query = "SELECT booking.*, room.roomname, customer.firstname, customer.lastname FROM booking
          INNER JOIN room ON booking.roomID = room.roomID
          INNER JOIN customer ON booking.customerID = customer.customerID
          WHERE booking.bookingID = $bookingID";
$result = mysqli_query($DBC, $query);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE HTML>
<html>

<head>
<title>View Booking Page</title>
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
    .box-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 40vh; 
    flex-wrap: wrap; 
    margin-top: 50px;
}
        .box {
            width: 200px;
            height: 200px;
            margin: 10px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .box a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }
        dt {
  font-weight: bold;
  display: inline;
  margin-left: 20px;
}
dd {
  margin-left: 40px;
}

fieldset {
  margin-top: 30px; 
}


  </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'menubar.php'; ?>

    <div id="site_content">
        <?php include 'sidebar.php'; ?>
        <div id="content">
            <h2>View Booking Details</h2>
            <a href="currentbooking.php">[Return to Booking Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>

            <?php
            if ($rowcount > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<fieldset><legend>Booking detail #" . $row['bookingID'] . "</legend><dl>";
                echo "<dt>Customer Name:</dt><dd>" . $row['firstname'] . " " . $row['lastname'] . "</dd>" . PHP_EOL;
                echo "<dt>Room:</dt><dd>" . $row['roomname'] . "</dd>" . PHP_EOL;
                echo "<dt>Check-in Date:</dt><dd>" . $row['checkinDate'] . "</dd>" . PHP_EOL;
                echo "<dt>Check-out Date:</dt><dd>" . $row['checkoutDate'] . "</dd>" . PHP_EOL;
                echo "<dt>Contact Number:</dt><dd>" . $row['contactNumber'] . "</dd>" . PHP_EOL;
                echo "<dt>Extras:</dt><dd>" . $row['extra'] . "</dd>" . PHP_EOL;
                echo "<dt>Review:</dt><dd>" . $row['review'] . "</dd>" . PHP_EOL;
                
                echo "</dd></dl></fieldset>" . PHP_EOL;
            } else {
                echo "<h2>No booking found!</h2>"; 
            }

            mysqli_free_result($result); 
            mysqli_close($DBC); 
            ?>

        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>
