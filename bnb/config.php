<?php
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASSWORD', 'root');
define('DBDATABASE', 'bnb');
function connect() {
  $servername = DBHOST;
  $username = DBUSER;
  $password = DBPASSWORD;
  $dbname = DBDATABASE;

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

?>