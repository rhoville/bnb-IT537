<?php
// register.php

// Start session
session_start();

// Include your database configuration
include 'config.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $country = $_POST['country'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL to insert data
    $sql = "INSERT INTO customers (first_name, last_name, country, phone_number, email, password) VALUES (?, ?, ?, ?, ?, ?)";

    // Use prepared statements to insert data securely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $lastName, $country, $phoneNumber, $email, $hashedPassword);

    // Execute the prepared statement and check if it was successful
    if ($stmt->execute()) {
        echo "New record created successfully";
        // Redirect or do whatever you want
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
