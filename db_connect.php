<?php
// Configuration for MariaDB (XAMPP default)
$servername = "localhost";
$username = "root"; // XAMPP default username
$password = "";     // XAMPP default password
$dbname = "test_db"; // The database name we created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Stop execution and display connection error (for development/testing)
    die("Connection failed: " . $conn->connect_error);
}

// Function to safely close connection (good practice)
function close_db_connection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>