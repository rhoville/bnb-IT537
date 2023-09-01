<?php
session_start();
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conn = connect();

  $email = $conn->real_escape_string($_POST['username']);
  $entered_password = $conn->real_escape_string($_POST['password']);

  $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $stored_password = $row['password'];
      $is_hashed = $row['is_hashed'];
      $isAdmin = $row['isAdmin']; 

      $is_verified = false;

      if ($is_hashed) {
          $is_verified = password_verify($entered_password, $stored_password);
      } else {
          $is_verified = ($entered_password === $stored_password);
          if ($is_verified) {
              // Hash the plain text password and update it in the database
              $new_hashed_password = password_hash($entered_password, PASSWORD_DEFAULT);
              $update_stmt = $conn->prepare("UPDATE customer SET password = ?, is_hashed = 1 WHERE email = ?");
              $update_stmt->bind_param("ss", $new_hashed_password, $email);
              $update_stmt->execute();
              $update_stmt->close();
          }
      }

      if ($is_verified) {
          $_SESSION['email'] = $email;
          $_SESSION['firstname'] = $row['firstname'];
          $_SESSION['isAdmin'] = $isAdmin; 
          $_SESSION['customerID'] = $row['customerID'];


          echo "<script type='text/javascript'>
                  alert('Login successful');
                  window.location.href = 'index.php';
                </script>";
      } else {
          $error_message = "Invalid email or password";
          echo "<script type='text/javascript'>alert('$error_message');</script>";
      }
  } else {
      $error_message = "Invalid email or password";
      echo "<script type='text/javascript'>alert('$error_message');</script>";
  }

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
    .login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-top: 100px;
    margin-bottom: 130px;
}

.login-container-box {
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 360px;
    border-radius: 5px;
    margin-left: 100px;
    margin-top: 80px;
}

.input-container {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.label {
    flex-basis: 30%;
    text-align: right;
    margin-right: 10px;
}

input[type="text"], .password-wrapper {
    flex-grow: 1;
    width: 100%;
    position: relative;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    padding-right: 40px;
    box-sizing: border-box; 
}

.password-wrapper input[type="password"] {
    padding-right: 40px; 
}

.password-wrapper .fas.fa-key {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: gold;
    pointer-events: none; 
}

.error-message {
    color: red;
    margin-bottom: 10px;
}

.login-buttons {
    text-align: center;
    margin-top: 20px;
}

.login-button {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    padding: 10px;
    margin-bottom: 10px;
    transition: background-color 0.3s;
}

.login-button:hover {
    background-color: #2980b9;
}

.signup-button {
    color: #3498db;
    text-decoration: none;
}

.signup-button:hover {
    text-decoration: underline;
}
.logout-button {
    background-color: red;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    padding: 10px;
    margin-bottom: 10px;
    transition: background-color 0.3s;
}

.logout-button:hover {
    background-color: #d32f2f;
}
  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
      <div id="content">
    <div class="login-container-box">
        <h2>Customer Login</h2>
        <form action="" method="POST">
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="input-container password">
                <label for="password">Password:</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password">
                    <i class="fas fa-key"></i>
                </div>
            </div>
    <div class="error-message" id="error-message">
              <?php if(isset($error_message)) echo $error_message; ?>
            </div>

            <div class="login-buttons">
                <button type="submit" class="login-button">Login</button>
                <button type="submit" class="logout-button">Logout</button>
                <p>Not yet registered?</p>
                <a href="signup.php" class="signup-button">Sign up</a>

            </div>
        </form>
    </div>
</div>
  </div>
  <?php include 'footer.php'; ?>

</body>
</html>
