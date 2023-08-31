<div class="header-container">
    <a href="/">
      <img class="logo" src="./images/logo.png" alt="Logo" />
    </a>
    <h1 class="slogan">
      Make Yourself at Home is our slogan. We offer some of the best beds on the east coast. Sleep well and rest well.
    </h1>
    <?php
    // Check if user is logged in and display their first name
    if (isset($_SESSION['firstname'])) {
      echo '<p class="welcome-message">Welcome, ' . htmlentities($_SESSION['firstname']) . '!</p>';
    }
    ?>
  </div>