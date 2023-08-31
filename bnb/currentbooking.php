<?php
session_start();
include 'config.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$conn = connect();

// Fetch all bookings
$sql = "SELECT booking.bookingID, room.roomname, booking.checkinDate, booking.checkoutDate, customer.firstname, customer.lastname
        FROM booking
        INNER JOIN room ON booking.roomID = room.roomID
        INNER JOIN customer ON booking.customerID = customer.customerID
        ORDER BY booking.checkinDate DESC";
$result = $conn->query($sql);

// Closing the database connection
$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
  <title>Current Booking Page</title>
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


  </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'menubar.php'; ?>

    <div id="site_content">
        <?php include 'sidebar.php'; ?>
        <div id="mainWrapper">
            <div id="content">
                <h2>View Bookings</h2>
                <a href="booking.php">Make a Booking</a> | <a href="maintenance.php">Return to Maintenance Page</a>
                <table>
                    <tr>
                        <th>Booking</th>
                        <th>Customer Name</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['roomname']},<br>{$row['checkinDate']} to {$row['checkoutDate']}</td>";
                        echo "<td>{$row['lastname']}, {$row['firstname']}</td>";
                        echo "<td>";
                        echo "<button onclick=\"window.location.href='viewbooking.php?bookingID={$row['bookingID']}'\">View</button>";
                        echo "<button onclick=\"window.location.href='editbooking.php?bookingID={$row['bookingID']}'\">Edit</button>";
                        echo "<button onclick=\"window.location.href='managereview.php?bookingID={$row['bookingID']}'\">Manage Review</button>";
                        echo "<button onclick=\"window.location.href='deletebooking.php?bookingID={$row['bookingID']}'\">Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
