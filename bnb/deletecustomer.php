<?php
session_start();
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

//function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}

//retrieve the customerid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Customer ID</h2>"; //simple error feedback
        exit;
    } 
}

//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Delete')) {     
    $error = 0; //clear our error flag
    $msg = 'Error: ';  
//customerID (sent via a form it is a string not a number so we try a type conversion!)    
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
       $id = cleanInput($_POST['id']); 
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid Customer ID '; //append error message
       $id = 0;  
    }        
    
//save the customer data if the error flag is still clear and customer id is > 0
    if ($error == 0 and $id > 0) {
        $query = "DELETE FROM customer WHERE customerID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'i', $id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Customer details deleted.</h2>";     
        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      

}

//prepare a query and send it to the server
//NOTE for simplicity purposes ONLY we are not using prepared queries
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

fieldset {
  margin-top: 30px; 
}
dt {
    font-weight: bold;
    margin-left: 20px;
}

dd {
    margin-left: 30px;
}

  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="content">
    <h2>Delete Customer</h2>
    <a href="customerlist.php">[Return to Customer Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>
    <?php

//makes sure we have the customer
if ($rowcount > 0) {  
    echo "<fieldset><legend>Customer detail #$id</legend><dl>"; 
    $row = mysqli_fetch_assoc($result);
    echo "<dt>First Name:</dt><dd>".$row['firstname']."</dd>".PHP_EOL;
    echo "<dt>Last Name:</dt><dd>".$row['lastname']."</dd>".PHP_EOL;
    echo "<dt>Country:</dt><dd>".$row['country']."</dd>".PHP_EOL; 
    echo "<dt>Email:</dt><dd>".$row['email']."</dd>".PHP_EOL;
    echo "<dt>Phone Number:</dt><dd>".$row['phonenumber']."</dd>".PHP_EOL; 
    echo "<dt>Password:</dt><dd>".str_repeat('*', strlen($row['password']))."</dd>".PHP_EOL; // Masking the password
    echo '</dl></fieldset>'.PHP_EOL;  
   ?>
   <form method="POST" action="deletecustomer.php">
     <h2>Are you sure you want to delete this customer?</h2>
     <input type="hidden" name="id" value="<?php echo $id; ?>">
     <input type="submit" name="submit" value="Delete">
     <a href="listcustomers.php">[Cancel]</a>
     </form>
<?php    
} else echo "<h2>Customer Successfully Deleted!</h2>"; //suitable feedback

mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done
?>
</table>
    
</div>

  
  </div>

    <?php include 'footer.php'; ?>
</body>
</html>
