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
    .welcome-message {
  color: yellow;
  font-size: 16px;
  margin-bottom: 10px;
  text-align:  right;
    }
  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
  
<div id="content">
  <h1>Contact Us</h1>

  <!-- Contact Information -->
  <div class="contact-info">
    <h2>Contact Information</h2>
    <p><strong>Phone:</strong> +1 123 456 7890</p>
    <p><strong>Email:</strong> info@ongaongabb.co.nz</p>
    <p><strong>Address:</strong> 83 Bridge Street, Ongaonga, New Zealand 4278</p>
  </div>

  <?php
    if (isset($_GET['message']) && $_GET['message'] === 'success') {
      echo "<p>Your message has been successfully sent! </br> We will be in contact with you soon!</p>";
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      include 'config.php';
      
      $conn = connect(); 

      
      $your_name = mysqli_real_escape_string($conn, $_POST['your_name']);
      $your_email = mysqli_real_escape_string($conn, $_POST['your_email']);
      $your_enquiry = mysqli_real_escape_string($conn, $_POST['your_enquiry']);

      
      $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $your_name, $your_email, $your_enquiry);

     
      if ($stmt->execute() === TRUE) {
        $stmt->close();
        $conn->close();
        header("Location: contactus.php?message=success");
        exit();
      } else {
        echo "<p>Error: " . $stmt->error . "</p>";
        $stmt->close();
        $conn->close();
      }
    }
    ?>

  <!-- Contact Form -->
  <form action="#" method="post">
    <div class="form_settings">
      <h2>Contact Form</h2>
      <p><span>Name</span><input class="contact" type="text" required name="your_name" value="" /></p>
      <p><span>Email Address</span><input class="contact" type="text" required name="your_email" value="" /></p>
      <p><span>Message</span><textarea class="contact textarea" required rows="8" cols="50" name="your_enquiry"></textarea></p>
      <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="contact_submitted" value="submit" /></p>
    </div>
  </form>

  <!-- Google Map -->
  <div class="map-container">
    <h2>Find Us On Map</h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3231.416465971708!2d176.35307!3d-39.889628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d69fd0004198b15%3A0x500ef6143a328c0!2sOngaonga!5e0!3m2!1sen!2s!4v1629831345251!5m2!1sen!2s" width="380" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>

</div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
