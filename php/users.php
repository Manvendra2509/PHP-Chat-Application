<?php
// Start a PHP session to manage user sessions.
session_start();

// Include the 'config.php' file to access database connection and other settings.
include_once "config.php";

// Get the 'unique_id' of the current user and store it in the 'outgoing_id' variable.
$outgoing_id = $_SESSION['unique_id'];

// Get the current role of the user and store it in the 'current_role' variable.
$current_role = $_SESSION['role'];

// Prepare the SQL query to select users from the 'users' table whose role is different from the current user's role.
$sql = "SELECT * FROM users WHERE role != '{$current_role}' ORDER BY user_id DESC";

// Execute the SQL query.
$query = mysqli_query($conn, $sql);

// Initialize the 'output' variable to an empty string.
$output = "";

// Check if there are no users available to chat.
if (mysqli_num_rows($query) == 0) {
    $output .= "No users are available to chat";
} elseif (mysqli_num_rows($query) > 0) {
    // If there are users available to chat, include the 'data.php' file to format and display the user data.
    include_once "data.php";
}

// Output the final result to the client-side (JavaScript).
echo $output;
?>
