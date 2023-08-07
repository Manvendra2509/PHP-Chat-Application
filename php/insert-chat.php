<?php
// Setting timezone to 'Asia/Kolkata'
date_default_timezone_set('Asia/Kolkata');
// Starting a new session or resuming the existing one
session_start();
// Check if a user session exists
if (isset($_SESSION['unique_id'])) {
    // Including database configuration file
    include_once "config.php";
    // Setting the ID of the user sending the message
    $outgoing_id = $_SESSION['unique_id'];
    // Escaping special characters in the ID of the user receiving the message
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    // Escaping special characters in the message
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    // Getting current date and time
    $timestamp = date('Y-m-d H:i:s');
    // If message is not empty, save it into the 'messages' table and log the activity
    if (!empty($message)) {
        // SQL query to insert the message into the 'messages' table
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, type, timestamp, session_id)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}','text','{$timestamp}', '{$_SESSION['session_id']}')") or die();
        // SQL query to insert the activity into the 'activity' table
        $sql2 = mysqli_query($conn, "INSERT INTO activity (session_id, timestamp, user_id, activity_description) VALUES ('{$_SESSION['session_id']}', '{$timestamp}', '{$outgoing_id}', 'User sent message \"{$message}\" to User ID: {$incoming_id}')");
    }
} else {
    // If no user session exists, redirect to login page
    header("location: ../index.php");
}
?>
