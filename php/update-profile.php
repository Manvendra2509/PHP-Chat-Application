<?php
// Start a new or resume an existing session
session_start();

// Include the configuration file with the database connection details
include_once "config.php";

// Get the unique_id of the user from the session data
$user_id = $_SESSION['unique_id'];

// Get the updated first name and escape it to prevent SQL injection
$fname = mysqli_real_escape_string($conn, $_POST['fname']);

// Check if the first name is not empty and update it in the database
if (!empty($fname)) {
    // Escape the first name again to prevent SQL injection and update the 'fname' column in the 'users' table
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $sql = mysqli_query($conn, "UPDATE users SET fname = '{$fname}' WHERE unique_id = '{$user_id}'");
}

// Get the updated last name and escape it to prevent SQL injection
$lname = mysqli_real_escape_string($conn, $_POST['lname']);

// Check if the last name is not empty and update it in the database
if (!empty($lname)) {
    // Update the 'lname' column in the 'users' table
    $sql2 = mysqli_query($conn, "UPDATE users SET lname = '{$lname}' WHERE unique_id = '{$user_id}'");
}

// Get the updated new password and escape it to prevent SQL injection
$password = mysqli_real_escape_string($conn, $_POST['password']);
$oldpassword = mysqli_real_escape_string($conn, $_POST['oldpassword']);

// Check if both the old password and new password are not empty
if (!empty($password) && !empty($oldpassword)) {
    // Encrypt the new password using md5
    $encrypt_pass = md5($password);

    // Check if the provided old password matches the current password in the session
    if ($_SESSION['pass'] == md5($oldpassword)) {
        // Update the 'password' column in the 'users' table with the new encrypted password
        $sql3 = mysqli_query($conn, "UPDATE users SET password = '{$encrypt_pass}' WHERE unique_id = '{$user_id}'");
    }
}

// Echo "success" to indicate that the update was successful
echo "success";
?>
