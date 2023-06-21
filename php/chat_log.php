<?php
    session_start();
    include_once "config.php";
    $sql = "SELECT * FROM users ORDER BY user_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to view chat log";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "logdata.php";
    }
    echo $output;
?>