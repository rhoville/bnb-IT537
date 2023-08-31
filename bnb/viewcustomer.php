<?php
session_start();
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit; //stop processing the page further
}

//do some simple validation to check if id exists
$id = $_GET['id'];
if (empty($id) or !is_numeric($id)) {
    echo "<h2>Invalid customerID</h2>"; //simple error feedback
    exit;
}

//prepare a query and send it to the server
//NOTE: for simplicity purposes ONLY we are not using prepared queries
//make sure you ALWAYS use prepared queries when creating custom SQL like below
$query = 'SELECT * FROM customer WHERE customerid='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);
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
    <table border="1">
        <h2>Customer Details Room</h2>
        <a href="customerlist.php">[Return to Customer Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>
        
        <?php
            // makes sure we have the customer
            if ($rowcount > 0) {
                echo "<fieldset><legend>Customer detail #$id</legend><dl>";
                $row = mysqli_fetch_assoc($result);
                echo "<dt>Name:</dt><dd>" . $row['firstname'] . "</dd>" . PHP_EOL;
                echo "<dt>Lastname:</dt><dd>" . $row['lastname'] . "</dd>" . PHP_EOL;
                echo "<dt>Email:</dt><dd>" . $row['email'] . "</dd>" . PHP_EOL;
                echo "<dt>Country:</dt><dd>" . $row['country'] . "</dd>" . PHP_EOL;  // Added this line
                echo "<dt>PhoneNumber:</dt><dd>" . $row['phonenumber'] . "</dd>" . PHP_EOL;  // Added this line
                echo '</dl></fieldset>' . PHP_EOL;
            } else {
                echo "<h2>No customer found!</h2>"; // suitable feedback
            }
            
            mysqli_free_result($result); // free any memory used by the query
            mysqli_close($DBC); // close the connection once done
        ?>
        
    </table>
</div>


      
</div>

<?php include 'footer.php'; ?>

</body>
</html>

