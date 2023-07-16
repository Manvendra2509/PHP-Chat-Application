<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $timestamp = date('Y-m-d H:i:s');
    if (!empty($message)) {
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, timestamp, session_id)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}','{$timestamp}', '{$_SESSION['session_id']}')") or die();
        $sql2 = mysqli_query($conn, "INSERT INTO activity (timestamp, user_id, activity_description) VALUES ('{$timestamp}', '{$outgoing_id}', 'User sent message \"{$message}\" to User ID: {$incoming_id}')");
    }
} else {
    header("location: ../index.php");
}
?>