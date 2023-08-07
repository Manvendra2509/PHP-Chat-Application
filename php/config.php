<?php
// Database configuration
$hostname = "localhost"; // The hostname of the database server (usually "localhost" for local development)
$username = "root";      // The username for the database connection (replace with appropriate username)
$password = "";          // The password for the database connection (replace with appropriate password)
$dbname = "chatapp";     // The name of the database you want to connect to (replace with appropriate database name)

// Establish the database connection using the MySQLi extension
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    // If there was an error connecting to the database, display an error message.
    // The mysqli_connect_error() function provides the specific error message from MySQL.
    echo "Database connection error: " . mysqli_connect_error();
}
?>
