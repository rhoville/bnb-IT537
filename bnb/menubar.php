<div id="menubar">
    <ul id="menu">
      <li class="selected"><a href="index.php">Home</a></li>
      <li><a href="booking.php">Booking</a></li>
      <li><a href="contactus.php">Contact Us</a></li>

      <?php 
   // This part will only show if the user is logged in as an admin
   if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
       echo '<li><a href="maintenance.php">Maintenance</a></li>';
   }

  // Check if user is logged in and display their first name
  if (isset($_SESSION['firstname'])) {
    echo '<li><a href="logout.php">Logout</a></li>'; // Logout button
  } else {
    echo '<li><a href="login.php">Login</a></li>';
  }
?>


    </ul>
</div>
