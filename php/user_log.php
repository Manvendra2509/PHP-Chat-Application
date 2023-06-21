<?php
    session_start();
    include_once "config.php";
    $sql = "SELECT * FROM session_data WHERE user_id = '{$_SESSION['userlog-id']}' ORDER BY session_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No sessions are available to view session log";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "session_data.php";
    }
    echo $output;
?>