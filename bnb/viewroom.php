<?php
session_start();
include "config.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Room ID.");
}
$id = $_GET['id'];

$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    die("Error: Unable to connect to MySQL. " . mysqli_connect_error());
}

$query = 'SELECT * FROM room WHERE roomID=?';
$stmt = mysqli_prepare($DBC, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("No room found!");
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
    <h2>View Room</h2>
    <a href="roomlist.php">[Return to Room Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>

    <fieldset>
        <legend>Room detail #<?php echo htmlspecialchars($id); ?></legend>
        <dl>
            <dt>Room name:</dt>
            <dd><?php echo htmlspecialchars($row['roomname']); ?></dd>
            <dt>Description:</dt>
            <dd><?php echo htmlspecialchars($row['description']); ?></dd>
            <dt>Room type:</dt>
            <dd><?php echo htmlspecialchars($row['roomtype']); ?></dd>
            <dt>Beds:</dt>
            <dd><?php echo htmlspecialchars($row['beds']); ?></dd>
        </dl>
    </fieldset>

    <?php
    mysqli_free_result($result);
    mysqli_close($DBC);
    ?>
</div>

  
  </div>

    <?php include 'footer.php'; ?>
</body>
</html>

