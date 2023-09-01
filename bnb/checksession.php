<?php
// Start a new session or resume the existing session
session_start();

// Function to check if the user is logged in
function checkUser() {
    // Check if the 'userid' exists in the session
    if (!isset($_SESSION['userID'])) {
        // Redirect to the login page if the user is not logged in
        header("Location: login.php");
        exit;
    }
}

// Function to display login status
function loginStatus() {
    // Check if the 'user_id' exists in the session
    if (isset($_SESSION['userID'])) {
        echo "<p>You are logged in as User ID: " . $_SESSION['userID'] . "</p>";
    } else {
        echo "<p>You are not logged in.</p>";
    }
}
?>
