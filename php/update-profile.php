<?php
    session_start();
    include_once "config.php";
    $user_id = $_SESSION['unique_id'];
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $oldpassword = mysqli_real_escape_string($conn, $_POST['oldpassword']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if (!empty($fname)) {
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $sql = mysqli_query($conn, "UPDATE users SET fname = '{$fname}' WHERE unique_id = '{$user_id}'");
    }
    
    if (!empty($lname)) {    
    $sql2 = mysqli_query($conn, "UPDATE users SET lname = '{$lname}' WHERE unique_id = '{$user_id}'");
    }

    if (!empty($password) && !empty($oldpassword)) {
    $encrypt_pass = md5($password);
    if ($_SESSION['pass'] == md5($oldpassword)) {
        $sql3 = mysqli_query($conn, "UPDATE users SET password = '{$encrypt_pass}' WHERE unique_id = '{$user_id}'");
    }
    }

  echo "success";
   
    ?>