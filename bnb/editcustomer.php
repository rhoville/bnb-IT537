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
    
    /* Container holding the form */
    .editbox {
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      margin-top: 30px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .editbox p, .editbox div {
      margin-bottom: 20px;
    }
   
    .editbox label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    
    .editbox input[type="text"],
    .editbox input[type="email"],
    .editbox input[type="tel"],
    .editbox input[type="password"] {
      width: 90%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
   
    .editbox input[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    
    .editbox input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="content">
  <h2>Edit Customer Details</h2>
  <a href="customerlist.php">[Return to Customer Listing]</a> | <a href="./maintenance.php">[Return to Maintenance Page]</a>

  <?php
  include "config.php"; // Load in variables
  $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

  if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit;
  }

  function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
  }

  // Retrieve customer ID from URL
 // Retrieve customer ID from URL or POST data
$id = $_GET['id'] ?? ($_POST['id'] ?? '');
  if (empty($id) or !is_numeric($id)) {
    echo "<h2>Invalid Customer ID</h2>";
    exit;
  }

  // If we are saving data
  if (isset($_POST['submit']) && $_POST['submit'] === 'Update') {
    $error = 0;
    $msg = 'Error: ';
    $id = cleanInput($_POST['id']);
    $firstname = cleanInput($_POST['firstname']);
    $lastname = cleanInput($_POST['lastname']);
    $email = cleanInput($_POST['email']);
    $country = cleanInput($_POST['country']);
    $phonenumber = cleanInput($_POST['phonenumber']);
    $password = cleanInput($_POST['password']); // Do not store plaintext password in the database

    if ($error === 0 && $id > 0) {
      $query = "UPDATE customer SET firstname=?, lastname=?, email=?, country=?, phonenumber=?, password=? WHERE customerID=?";
      $stmt = mysqli_prepare($DBC, $query);
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssssi', $firstname, $lastname, $email, $country, $phonenumber, $password, $id);
        $executed = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        if ($executed) {
          echo "<h2 style='color: green;'>Customer details updated.</h2>";

        } else {
          echo "<h2 style='color: red;'>Failed to update the customer details.</h2>";
        }
      } else {
        echo "<h2>Error preparing the query.</h2>";
      }
    } else {
      echo "<h2>$msg</h2>";
    }
  }

  // Fetch existing customer details
  $query = 'SELECT customerID, firstname, lastname, email, country, phonenumber, password FROM customer WHERE customerID='.$id;
  $result = mysqli_query($DBC, $query);
  $rowcount = mysqli_num_rows($result);

  if ($rowcount > 0) {
    $row = mysqli_fetch_assoc($result);
  ?>
  <div class="editbox">
  <form method="POST" action="editcustomer.php?id=<?php echo $id; ?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <p><label for="firstname">First Name:</label>
         <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" required>
      </p>
      <p><label for="lastname">Last Name:</label>
         <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" required>
      </p>
      <p><label for="email">Email:</label>
         <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
      </p>
      <p><label for="country">Country:</label>
         <input type="text" id="country" name="country" value="<?php echo $row['country']; ?>" required>
      </p>
      <p><label for="phonenumber">Phone Number:</label>
         <input type="tel" id="phonenumber" name="phonenumber" value="<?php echo $row['phonenumber']; ?>" required>
      </p>
      <p><label for="password">Password:</label>
         <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required>
      </p>
      <input type="submit" name="submit" value="Update">
    </form>
  </div>
  <?php
  } else {
    echo "<h2>Customer not found with that ID</h2>";
  }

  mysqli_close($DBC);
  ?>
</div>

      
</div>
    
<?php include 'footer.php'; ?>

</body>
</html>




