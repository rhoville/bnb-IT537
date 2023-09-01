<?php
session_start();
include "config.php";
$conn = connect();  // Add this line to call the function and initialize $conn
?>


<!DOCTYPE HTML>
<html>

<head>
  <title>Rooms Page</title>
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
        .room {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.room-image {
  flex: 1;
  max-width: 50%;
  padding: 10px;
}

.room-image img {
  width: 100%;
  height: auto;
}

.room-details {
  flex: 2;
  padding: 10px;
}

.book-button {
  padding: 10px 20px;
  background-color: blue;
  color: white;
  text-align: center;
  cursor: pointer;
}
h2 {
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
      <h2>Our Rooms</h2>
      <div class="container">
      <?php
        // SQL query to select data from database
        $sql = "SELECT roomID, roomname, roomtype, description, beds FROM room";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Output data for each row
          while($row = $result->fetch_assoc()) {
        ?>
        <!-- Single room -->
        <div class="room">
  <div class="room-image">
    <img src="./images/bed.jpg" alt="Room <?php echo $row['roomID']; ?>">
  </div>
  <div class="room-details">
    <h2><?php echo $row['roomname']; ?></h2>
    <p>Room Type: <?php echo $row['roomtype']; ?></p>
    <p>Beds: <?php echo $row['beds']; ?></p>
    <p>Description: <?php echo $row['description']; ?></p>
  
    <a href="booking.php">
      <div class="book-button">Book</div>
    </a>
  </div>
</div>

        <hr>
        <?php
          }
        } else {
          echo "No rooms found.";
        }
        ?>


      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
