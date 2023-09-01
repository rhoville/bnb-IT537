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
<script>
  document.addEventListener("DOMContentLoaded", function() {
  let currentHeroIndex = 0;

  function showHeroSlide(index) {
    const slides = document.querySelectorAll('.hero .hero-slide');
    slides[currentHeroIndex].style.left = '100%';
    slides[index].style.left = '0';
    currentHeroIndex = index;
  }

  // Initial display
  showHeroSlide(0);

  // Loop through slides
  setInterval(function() {
    const slides = document.querySelectorAll('.hero .hero-slide');
    const nextIndex = (currentHeroIndex + 1) % slides.length;
    showHeroSlide(nextIndex);
  }, 3000);  // Change image every 3000 milliseconds (3 seconds)
});

document.addEventListener("DOMContentLoaded", function() {
  let currentIndex = 0;

  function showSlide(index) {
    const slides = document.querySelectorAll('.room .slide');
    slides[currentIndex].style.left = '100%';
    slides[index].style.left = '0';
    currentIndex = index;
  }

  // Initial display
  showSlide(0);

  // Loop through slides
  setInterval(function() {
    const slides = document.querySelectorAll('.room .slide');
    const nextIndex = (currentIndex + 1) % slides.length;
    showSlide(nextIndex);
  }, 3000);  // Change image every 3000 milliseconds (3 seconds)
});


</script>
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
    .hero {
  position: relative;
  width: 100%;
  height: 500px;
  overflow: hidden;
}

.hero-slide {
  position: absolute;
  top: 0;
  left: 100%;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  transition: left 0.5s ease-in-out;
  z-index: 1;
}

.hero-slide:first-child {
  left: 0;
}

.hero h1 {
  position: absolute;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 2;
  color: white;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10px;
  white-space: nowrap; 
}


   
    .about-us img {
      width: 100%;
      height: auto;
    }

    .room-gallery {
  position: relative;
  width: 100%;
  height: 300px;
  overflow: hidden;
}

.slide {
  position: absolute;
  top: 0;
  left: 100%;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  transition: left 0.5s ease-in-out;
}

.slide:first-child {
  left: 0;
}



  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
      <div id="content">
         
          <div class="hero">
  <div class="hero-slide" style="background-image: url('images/onga.png');"></div>
  <div class="hero-slide" style="background-image: url('images/swimming.jpg');"></div>
  <div class="hero-slide" style="background-image: url('images/bike.jpg');"></div>
  <h1>Welcome to Ongaonga Bed & Breakfast</h1>
</div>


   
      <div class="about-us">
        <h2>About Us</h2>
        <img src="images/ongaonga.jpg" alt="About Ongaonga Bed & Breakfast">
        <p>After years of sharing countless memories in our sprawling homestead, we decided it was time to open our doors to guests. Living by ourselves in this vast space felt a tad too quiet. Thus, the idea of turning our home into a B&B was born. With the guidance of our trusted consultant, we ventured into making our home known to both locals and tourists alike. Our aim is to provide a homely, comfortable space where our guests can feel relaxed and rejuvenated.</p>
        <a href="aboutus.php" class="see-more">See More</a>
      </div>

    
<div class="rooms">
  <h2>Our Rooms</h2>
 
<div class="room">
<div class="room-gallery">
    <div class="slide" style="background-image: url('images/bed.jpg');"></div>
    <div class="slide" style="background-image: url('images/bed2.jpg');"></div>
    <div class="slide" style="background-image: url('images/bed3.jpg');"></div>
    <div class="slide" style="background-image: url('images/bed4.jpeg');"></div>
  </div>
</div>

</div>

      </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
