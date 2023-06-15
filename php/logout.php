<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata'); 
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $lastseen = date('Y-m-d H:i:s');
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}', lastseen = '{$lastseen}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../index.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../index.php");
    }
?>