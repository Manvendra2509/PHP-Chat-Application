<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once "config.php";
$password = mysqli_real_escape_string($conn, $_POST['password']);
$user_pass = md5($password);
if (!empty($password)) {
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE password = '{$user_pass}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $status = "Active now";
        
        $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
        if ($sql2) {
            $_SESSION['unique_id'] = $row['unique_id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['pass'] = $row['password'];
            $_SESSION['logintime'] = date('Y-m-d H:i:s');
            $_SESSION['session_id'] = mysqli_insert_id($conn);
            $sql3 = mysqli_query($conn, "INSERT INTO activity (user_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}','{$_SESSION['logintime']}', 'Logged In')");
            echo "success";
        } else {
            echo "Something went wrong. Please try again!";
        }
    } else {
        echo "No user with this password exists";
    }
} else {
    echo "All input fields are required!";
}
?>