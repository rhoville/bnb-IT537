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
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password for storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO customer (firstname, lastname, email, country, phonenumber, password, is_hashed) VALUES (?, ?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $country, $phonenumber, $hashed_password);

    // Execute the statement and check for success
    if ($stmt->execute() === TRUE) {
        $stmt->close();
        $conn->close();
        header('Location: index.php?message=success'); // Redirect to index.php with a success message
        exit();
    } 
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
    height: 100vh;
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
    margin-bottom: 20px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

.backtologin {
    margin-top: 20px;
    color: #007BFF;
    text-decoration: none;
}

.backtologin:hover {
    text-decoration: underline;
}
  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
      <div id="content">
      <div class="signup-container">
    <h2>Sign Up</h2>
    <form action="" method="POST"><!-- will redirect to login once button is clicked-->
        
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
            <label for="country">Country of Origin:</label>
            <i class="fas fa-globe input-icon"></i>
            <input type="text" id="country" name="country" placeholder="Enter your Country of Origin" required>
        </div>

       
        <div class="form-group-signup">
            <label for="phoneNumber">Phone Number:</label>
            <i class="fas fa-phone input-icon"></i>
            <input type="text" id="phoneNumber" name="phoneNumber" placeholder="(064) 123-1234" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" title="Please enter a phone number in the format (xxx) xxx-xxxx" required>
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
        <p>Already registered?</p>
        <a href="./login.php" class="back2login">
            <i class="fas fa-arrow-left" style="font-size: 2em;"></i>
        </a>
       
    </form>
</div>
      </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
