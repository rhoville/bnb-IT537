<?php
session_start();

// Handle the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'config.php';
    $conn = connect();

    // Secure inputs by escaping special characters
    $firstname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password for storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO customer (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);

    if ($stmt->execute()) {
        // Execution successful
        $msg = "Customer added to list";
    } else {
        // Execution failed
        // Display an error message
        echo "Error: " . $stmt->error; // Display the specific error message from the statement
        
        // You might want to log the error as well for debugging purposes
        // error_log("Error executing statement: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

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
    .signup-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 50vh;
}

.signup-container h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.signup-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 360px;
    background: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.form-group-signup {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-bottom: 20px;
}

.form-group-signup label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.form-group-signup input {
    padding: 10px 40px 10px 40px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    color: #555;
}

.form-group-signup .input-icon {
    position: absolute;
    top: 65%;
    left: 10px;
    transform: translateY(-50%);
    color: #aaa;
}

.form-group-signup .input-icon.fa-user,
.form-group-signup .input-icon.fa-envelope,
.form-group-signup .input-icon.fa-globe,
.form-group-signup .input-icon.fa-lock {
    font-size: 18px;
    
}

button {
    width: 100%;
    background-color: #4caf50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s;
}

  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
      <div id="content">
      <h2>Add a Customer</h2>
    <a href="customerlist.php">[Return to Customer List]</a> | <a href="maintenance.php">[Return to Maintenance Page]</a>
      <div class="signup-container">
    
    <form action="" method="POST">
        
        <div class="form-group-signup">
            <label for="firstName">First Name:</label>
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="firstName" name="firstName" placeholder="Enter your First Name" required>
        </div>

       
        <div class="form-group-signup">
            <label for="lastName">Last Name:</label>
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="lastName" name="lastName" placeholder="Enter your Last Name" required>
        </div>

       
        <div class="form-group-signup">
            <label for="email">Email:</label>
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" placeholder="example@email.com" required>
        </div>

        
        <div class="form-group-signup">
            <label for="password">Password:</label>
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password" name="password" placeholder="Enter a Password" minlength="8" required>
        </div>

       
        <button type="submit">Register</button>
        
    </form>
</div>
<div id="message">
        <?php echo $msg; ?> <!-- Display the success message -->
      </div>
      </div>
      
</div>
<?php include 'footer.php'; ?>

</body>
</html>
