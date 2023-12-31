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
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
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

