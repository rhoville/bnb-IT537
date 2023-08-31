<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
  <title>Edit Booking</title>
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

.editbox {
  border: 1px solid #ccc;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px #ccc;
  margin-top: 20px;
}

.editbox label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.editbox input[type="text"],
.editbox input[type="tel"],
.editbox select,
.editbox textarea {
  width: 90%;
  padding: 10px;
  margin: 5px 0 20px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.editbox input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  border-radius: 4px;
}

.editbox input[type="submit"]:hover {
  background-color: #45a049;
}

  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="content">
    <h2>Edit Booking Details</h2>
    <a href="currentbooking.php">[Return to Booking Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>

    <?php
    include "config.php"; // Load in variables
    $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
      echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
      exit;
    }

    function cleanInput($data) {
      return htmlspecialchars(stripslashes(trim($data)));
    }

    // Retrieve booking ID from URL
    $bookingID = $_GET['bookingID'] ?? '';
    if (empty($bookingID) or !is_numeric($bookingID)) {
      echo "<h2>Invalid Booking ID</h2>";
      exit;
    }

   // If we are saving data
if (isset($_POST['submit']) && $_POST['submit'] === 'Update') {
  $error = 0;
  $msg = 'Error: ';
  // ... Retrieve and sanitize form data ...

  if ($error === 0 && $bookingID > 0) {
    $query = "UPDATE booking SET roomID=?, checkinDate=?, checkoutDate=?, contactNumber=?, extra=?, review=? WHERE bookingID=?";
    $stmt = mysqli_prepare($DBC, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'isssssi', $roomID, $checkinDate, $checkoutDate, $contactNumber, $extra,$review, $bookingID);

    // Assign values to variables first
$roomID = cleanInput($_POST['room']);
$checkinDate = cleanInput($_POST['checkinDate']);
$checkoutDate = cleanInput($_POST['checkoutDate']);
$contactNumber = cleanInput($_POST['contactNumber']);
$extra = cleanInput($_POST['extra']);
$review = cleanInput($_POST['review']);

// Now prepare your query
$query = "UPDATE booking SET roomID=?, checkinDate=?, checkoutDate=?, contactNumber=?, extra=?, review=? WHERE bookingID=?";
$stmt = mysqli_prepare($DBC, $query);

if ($stmt) {
    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'isssssi', $roomID, $checkinDate, $checkoutDate, $contactNumber, $extra, $review, $bookingID);

    // Execute the update query
    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {
        echo "<h2 style='color: green;'>Booking details updated.</h2>";
    } else {
        echo "<h2 style='color: red;'>Failed to update the booking details.</h2>";
    }
} else {
    echo "Statement preparation failed: " . mysqli_error($DBC);
}

    mysqli_stmt_close($stmt);
  } else {
    echo "<h2>$msg</h2>";
  }
}


    // Fetch existing booking details
    $query = 'SELECT bookingID, roomID, checkinDate, checkoutDate, contactNumber, extra, review FROM booking WHERE bookingID=' . $bookingID;
    $result = mysqli_query($DBC, $query);
    $rowcount = mysqli_num_rows($result);

    if ($rowcount > 0) {
      $row = mysqli_fetch_assoc($result);
      $selectedRoomID = $row['roomID']; // Store the selected room ID

      // Fetch rooms for the dropdown
      $roomQuery = "SELECT roomID, roomname, roomtype, beds FROM room";
      $roomResult = mysqli_query($DBC, $roomQuery);
    ?>
    <div class="editbox">
      <form method="POST" action="editbooking.php?bookingID=<?php echo $bookingID; ?>">
        <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">
        <p><label for="room">Room:</label>
          <select id="room" name="room" required>
            <option value="">--Please choose an option--</option>
            <?php
            while ($room = mysqli_fetch_assoc($roomResult)) {
              $id = $room['roomID'];
              $name = $room['roomname'];
              $type = $room['roomtype']; 
              $beds = $room['beds']; 
              $selected = ($id == $selectedRoomID) ? "selected" : "";
              echo "<option value='$id' $selected>$name, $type, $beds beds</option>"; 
            }
            ?>
          </select>
        </p>
    <p><label for="checkinDate">Check-in Date:</label>
      <input type="text" id="checkinDate" name="checkinDate" value="<?php echo $row['checkinDate']; ?>" required>
    </p>
    <p><label for="checkoutDate">Check-out Date:</label>
      <input type="text" id="checkoutDate" name="checkoutDate" value="<?php echo $row['checkoutDate']; ?>" required>
    </p>
    <p><label for="contactNumber">Contact Number:</label>
      <input type="tel" id="contactNumber" name="contactNumber" value="<?php echo $row['contactNumber']; ?>" required>
    </p>
    <p><label for="extra">Booking Extras:</label>
      <textarea name="extra" id="extra" rows="4"><?php echo $row['extra']; ?></textarea>
    </p>
    <p>
<label for="review">Write a Review:</label>
<textarea name="review" id="review" rows="4"><?php echo $row['review']; ?></textarea>
</p>

    <input type="submit" name="submit" value="Update">
  </form>
  </div>
    <?php
    } else {
      echo "<h2>Booking not found with that ID</h2>";
    }

    mysqli_close($DBC);
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
