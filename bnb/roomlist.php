<?php
session_start();
include "config.php"; // Load in any variables

// Initialize database connection
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

// Query to fetch room data
$query = 'SELECT * FROM room';
$result = mysqli_query($DBC, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($DBC));
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
  <div class="header-container">
    <a href="/">
      <img class="logo" src="./images/logo.png" alt="Logo" />
    </a>
    <h1 class="slogan">
      Make Yourself at Home is our slogan. We offer some of the best beds on the east coast. Sleep well and rest well.
    </h1>
    <?php
    // Check if user is logged in and display their first name
    if (isset($_SESSION['firstname'])) {
      echo '<p class="welcome-message">Welcome, ' . htmlentities($_SESSION['firstname']) . '!</p>';
    }
    ?>
  </div>

  <div id="menubar">
    <ul id="menu">
      <li class="selected"><a href="index.php">Home</a></li>
      <li><a href="booking.php">Booking</a></li>
      <li><a href="contactus.php">Contact Us</a></li>

      <?php 
   // This part will only show if the user is logged in as an admin
   if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
       echo '<li><a href="maintenance.php">Maintenance</a></li>';
   }

  // Check if user is logged in and display their first name
  if (isset($_SESSION['firstname'])) {
    echo '<li><a href="logout.php">Logout</a></li>'; // Logout button
  } else {
    echo '<li><a href="login.php">Login</a></li>';
  }
?>


    </ul>
</div>




  <div id="site_content">
      <div class="sidebar">
        <h3>Latest News</h3>
        <h4>New Website Launched</h4>
        <h5>08 September 2023</h5>
        <p>2023 sees the redesign of our website. Take a look around and let us know what you think.<br /><a href="#">Read more</a></p>
        <p></p>
        <h4>What to do in Ongaonga</h4>
        <h5>08 September 2023</h5>
        <p>Here's a list of things do to in Ongaonga.<br /><a href="#">Read more</a></p>
        <h3>Useful Links</h3>
        <ul>
          <li><a href="#">Privacy Statement</a></li>
          <li><a href="#">link 2</a></li>
          <li><a href="#">link 3</a></li>
          <li><a href="#">link 4</a></li>
        </ul>
        <h3>Search</h3>
        <form method="post" action="#" id="search_form">
          <p>
            <input class="search" type="text" name="search_field" value="Enter keywords....." />
            <input name="search" type="image" style="border: 0; margin: 0 0 -9px 5px;" src="style/search.png" alt="Search" title="Search" />
          </p>
        </form>
      </div>
      <div id="content">
      <table border="1">
      <h2>Room List</h2>
      <a href="addroom.php">[Add a Room]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>
    <thead>
        <tr>
            <th>Room Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
           while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['roomname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['roomtype']) . "</td>";
            echo "<td>";
            echo "<a href='viewroom.php?id=" . $row['roomID'] . "'>View</a> | ";
            echo "<a href='editroom.php?id=" . $row['roomID'] . "'>Edit</a> | ";
            echo "<a href='deleteroom.php?id=" . $row['roomID'] . "'>Delete</a>| ";
            echo "</td>";
            echo "</tr>";
        }
        
        ?>
    </tbody>
</table>

<?php
mysqli_free_result($result);
mysqli_close($DBC);
?>
    
      </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>

