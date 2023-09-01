<?php
session_start();
include 'config.php'; 
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
    #content {
  padding: 5px;
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin-top: 20px; 
}

#content h1{
    font-weight: bold;
}
#content h1, #content h2 {
  color: #333;
  margin-bottom: 10px; 
}

#content p {
  color: #666;
  line-height: 1.6;
  margin-bottom: 15px; 
}

.highlight {
  font-weight: bold;
}


.image-container {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.content-image {
  max-width: 45%;
  height: auto;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin: 5px;
}


  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
  <div id="content">
  <h1>Welcome to Smith’s Homestead B&B!</h1>
    <p>Nestled in the scenic environs of Ongaonga, the Smith’s Homestead is more than just a place to lay your head. Owned and managed by the affable Mr. and Mrs. Smith, this large and beautiful haven has been transformed from their cherished family home into a bed and breakfast that exudes warmth and hospitality.</p>
    <div class="image-container">
    <img src="images/swimming.jpg" alt="Exterior View" class="content-image">
    <img src="images/bed4.jpeg" alt="Interior View" class="content-image">
  </div>
    <h2>Our Story</h2>
    <p>After years of sharing countless memories in our sprawling homestead, we decided it was time to open our doors to guests. Living by ourselves in this vast space felt a tad too quiet. Thus, the idea of turning our home into a B&B was born. With the guidance of our trusted consultant, we ventured into making our home known to both locals and tourists alike. Our aim is to provide a homely, comfortable space where our guests can feel relaxed and rejuvenated.</p>

    <h2>Our Guests</h2>
    <ul>
        <li><span class="highlight">Local Customers:</span> While we cherish our local clientele from Napier, Hastings, Waipukurau, and beyond, many of whom have become like family with regular bookings, our website mainly serves to familiarize newcomers with what we have to offer.</li>
        <li><span class="highlight">Tourists:</span> If you're journeying from or through places like Palmerston North or Wellington, and need a cozy place to rest for a night or two, look no further. Our B&B promises a tranquil experience. And for those on the move, we've ensured our website is mobile-friendly, knowing many travellers rely on their devices to find accommodations.</li>
        <li><span class="highlight">Tourist Companies:</span> We offer a distinct New Zealand Aotearoa experience. Tourist agencies looking to give their customers an authentic taste of New Zealand hospitality will find our B&B the perfect recommendation.</li>
    </ul>
    <div class="image-container">
    <img src="images/bed2.jpg" alt="Guest Room" class="content-image">
    <img src="images/dining.jpg" alt="Dining Area" class="content-image">
  </div>
    <h2>Our Team</h2>
    <p>While Mr. and Mrs. Smith are the heart of the B&B, running the daily operations and ensuring our guests have an unforgettable experience, we also have a dedicated team of external contractors. They ensure our homestead remains sparkling clean and is always stocked with all necessary supplies.</p>

    <div class="message">
        <h2>A Message from the Owners</h2>
        <p>"We are ardent web users, mostly engaging with it for entertainment. But now, with this platform, we hope to connect with all of you. We invite you to our homestead, not just as guests, but as extended family. Here’s to new stories, laughter, and the joy of sharing our space with you!"</p>
    </div>

    <p>Come, stay with us, and be a part of our ever-growing family at Smith’s Homestead B&B.</p>
</div>

  
  </div>

    <?php include 'footer.php'; ?>
</body>
</html>

