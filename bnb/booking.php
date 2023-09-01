<?php
session_start();
include 'config.php';

$msg = ''; // Variable to hold the message

// Redirect to login page if not logged in
if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$conn = connect();
$rooms = [];

// Fetch room data for populating dropdown
$sql = "SELECT roomID, roomname, roomtype, beds FROM room";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomID = $_POST['room'];
    $checkinDate = $_POST['checkinDate'];
    $checkoutDate = $_POST['checkoutDate'];
    $contactNumber = $_POST['contactNumber'];
    $extra = $_POST['extra'];
    $customerID = $_SESSION['customerID'];

    // Check if room is already booked for the specified date range
$check_sql = "SELECT * FROM booking WHERE roomID = ? AND (checkinDate <= ? AND checkoutDate >= ?)";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("iss", $roomID, $checkoutDate, $checkinDate);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $msg = "Room is already booked for this date range.";
} 

    } else {
        $stmt = $conn->prepare("INSERT INTO booking (customerID, roomID, checkinDate, checkoutDate, contactNumber, extra) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $customerID, $roomID, $checkinDate, $checkoutDate, $contactNumber, $extra);

        if ($stmt->execute()) {
            $msg = "New booking created successfully.";
        } 

        $stmt->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $roomID = $_POST['room'];
      $checkinDate = $_POST['checkinDate'];
      $checkoutDate = $_POST['checkoutDate'];
      $contactNumber = $_POST['contactNumber'];
      $extra = $_POST['extra'];
      $review = $_POST['review'];
      $customerID = $_SESSION['customerID'];
  
      // Check if room is already booked for the specified date range
      $check_sql = "SELECT * FROM booking WHERE roomID = ? AND (checkinDate <= ? AND checkoutDate >= ?)";
      $check_stmt = $conn->prepare($check_sql);
      $check_stmt->bind_param("iss", $roomID, $checkoutDate, $checkinDate);
      $check_stmt->execute();
      $check_result = $check_stmt->get_result();
  
      if ($check_result->num_rows > 0) {
          $msg = "Room is already booked for this date range.";
      } else {
        $stmt = $conn->prepare("INSERT INTO booking (customerID, roomID, checkinDate, checkoutDate, contactNumber, extra, review) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssss", $customerID, $roomID, $checkinDate, $checkoutDate, $contactNumber, $extra, $review);
  
          if ($stmt->execute()) {
              $msg = "New booking created successfully.";
          } else {
              $msg = "Error: " . $stmt->error;
          }
  
          $stmt->close();
      }
  
      $check_stmt->close();
  }
  
  // Closing the database connection
  $conn->close();
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function () {
  // Initialize Datepicker for checkin date
  $("#checkinDate").datepicker({
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 2,
    onSelect: function (selectedDate) {
      // Set the min date for the checkout date
      $("#checkoutDate").datepicker("option", "minDate", selectedDate);
    }
  });

  // Initialize Datepicker for checkout date
  $("#checkoutDate").datepicker({
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 2,
    onSelect: function (selectedDate) {
      // Set the max date for the checkin date
      $("#checkinDate").datepicker("option", "maxDate", selectedDate);
    }
  });
  $("#startDate").datepicker({
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 2,
    onSelect: function (selectedDate) {
      // Set the min date for the end date
      $("#endDate").datepicker("option", "minDate", selectedDate);
    }
  });

  // Initialize Datepicker for end date
  $("#endDate").datepicker({
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 2,
    onSelect: function (selectedDate) {
      // Set the max date for the start date
      $("#startDate").datepicker("option", "maxDate", selectedDate);
    }
  });
  
});



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
  text-align:  right;
    }

fieldset {
  margin-top: 30px; 
}
.booking-container {
      max-width: 500px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
      margin-bottom: 30px;

    }

    .booking-form label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      margin-top: 20px;
    }

    .booking-form input[type="text"],
    .booking-form input[type="tel"],
    .booking-form select,
    .booking-form textarea {
      width: 70%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-left: 120px;
    }

    .booking-form button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .booking-form button[type="reset"] {
      background-color: #ccc;
      margin-left: 10px;
    }

    .booking-form button:hover {
      background-color: #0056b3;
    }
    .top a, h2 {
    margin-bottom: 20px;
    margin-left: 20px;
}
.top {
    margin-bottom: 20px;

}
#availabilityForm {
  max-width: 500px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.date-input {
  margin-bottom: 15px;
}

.date-input label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.date-input input[type="text"] {
  width: 70%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-left: 120px;
    
}
hr {margin-top: 30px;}

  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

<div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="mainWrapper">

    <div id="content">
        <div class= "top">
        <h2>Booking</h2>
        <a href="currentbooking.php">[Return to the Bookings List]</a> | <a href="/">[Return to the main page]</a>
</div>
    </div>
    <div class = "booking-container">
    <div class="booking-form">
        <form action="" method="POST">
            <label for="room">Room (name, type, beds):</label>
            <select id="room" name="room" required>
                <option value="">--Please choose an option--</option>
                <?php
                foreach ($rooms as $room) {
                    $id = $room['roomID'];  // Getting the roomID
                    $name = $room['roomname'];
                    $type = $room['roomtype'];
                    $beds = $room['beds'];
                    // The value of the option is set to the roomID.
                    echo "<option value='$id'>$name, $type, $beds beds</option>";
                }
                ?>
            </select>
    </div>

    <div class="booking-form">
        <label for="checkinDate">Check-in Date:</label>
        <input type="text" id="checkinDate" name="checkinDate" placeholder="yyyy-mm-dd" required>
    </div>
    <div class="booking-form">
        <label for="checkoutDate">Check-out Date:</label>
        <input type="text" id="checkoutDate" name="checkoutDate" placeholder="yyyy-mm-dd" required>
    </div>
    <div class="booking-form">
        <label for="contactNumber">Contact Number:</label>
        <input type="tel" id="contactNumber" name="contactNumber" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" placeholder="(###)###-####" title="Please enter a phone number in the format (xxx) xxx-xxxx" required>
    </div>
    <div class="booking-form">
        <label for="extra">Booking extras:</label>
        <textarea name="extra" id="extra" rows="4"></textarea>
    </div>
    <div class="booking-form">
    <label for="review">Write a Review:</label>
    <textarea name="review" id="review" rows="4"></textarea>
</div>
    <button type="submit">Book</button>
    <button type="reset">Cancel</button>
    </form>
    </div>
    <!-- Message Display -->
    <div id="message">
        <?php echo $msg; ?>
    </div>
    <hr> <!-- Next Section divided by a line -->
  <?php include 'searchavailability.php'; ?>
</div>

  </div>

    <?php include 'footer.php'; ?>
</body>
</html>

