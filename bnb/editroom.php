<?php
session_start();
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
        dt {
  font-weight: bold;
  display: inline;
}

fieldset {
  margin-top: 30px; 
}
.edit { 
  margin-top: 30px;
}
p {
  margin-left: 20px;
}
label {
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
  <h2>Room Detail Update</h2>
  <a href="roomlist.php">[Return to Room Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>
  <div class="edit">
    <table border="1">
      <?php
      include "config.php";
      $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

      if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
        exit;
      }

      function cleanInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
      }

      $id = $_GET['id'] ?? '';
      if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid room ID</h2>";
        exit;
      }

      $error = 0;
      $msg = '';
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['submit'] === 'Update') {
        if (isset($_POST['id']) and !empty($_POST['id']) and is_numeric($_POST['id'])) {
          $id = cleanInput($_POST['id']);
        } else {
          $error++;
          $msg .= 'Invalid room ID';
          $id = 0;
        }
        $roomname = cleanInput($_POST['roomname']);
        $description = cleanInput($_POST['description']);
        $roomtype = cleanInput($_POST['roomtype']);
        $beds = cleanInput($_POST['beds']);

        if ($error == 0 and $id > 0) {
          $query = "UPDATE room SET roomname=?, description=?, roomtype=?, beds=? WHERE roomID=?";
          $stmt = mysqli_prepare($DBC, $query);
          mysqli_stmt_bind_param($stmt, 'sssis', $roomname, $description, $roomtype, $beds, $id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
          echo "<h2>Room details updated.</h2>";
        } else {
          echo "<h2>$msg</h2>";
        }
      }

      $query = 'SELECT roomID, roomname, description, roomtype, beds FROM room WHERE roomID='.$id;
      $result = mysqli_query($DBC, $query);
      $rowcount = mysqli_num_rows($result);
      if ($rowcount > 0) {
        $row = mysqli_fetch_assoc($result);
      ?>

      <fieldset>
      <legend>Room Details #<?php echo $id; ?></legend>
      <form method="POST" action="editroom.php?id=<?php echo $id; ?>">

          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <p>
            <label for="roomname">Room name: </label>
            <input type="text" id="roomname" name="roomname" minlength="5" maxlength="50" value="<?php echo $row['roomname']; ?>" required>
          </p>
          <p>
            <label for="description">Description: </label>
            <textarea id="description" name="description" rows="3" cols="50" minlength="5" maxlength="200" required><?php echo htmlspecialchars($row['description']); ?></textarea>
          </p>
          <p>
            <label for="roomtype">Room type: </label>
            <input type="radio" id="roomtype" name="roomtype" value="S" <?php echo $row['roomtype']=='S'?'checked':''; ?>> Single
            <input type="radio" id="roomtype" name="roomtype" value="D" <?php echo $row['roomtype']=='D'?'checked':''; ?>> Double
          </p>
          <p>
            <label for="beds">Beds (1-5): </label>
            <input type="number" id="beds" name="beds" min="1" max="5" value="<?php echo $row['beds']; ?>" required>
          </p>
          <input type="submit" name="submit" value="Update" >

        </form>
      </fieldset>

      <?php
      } else {
        echo "<h2>Room not found with that ID</h2>";
      }
      mysqli_close($DBC);
      ?>
    </table>
  </div>
</div>

</div>

    <?php include 'footer.php'; ?>

</body>
</html>










