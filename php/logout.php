<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata'); 
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = $_SESSION['unique_id'];
        if(isset($logout_id)){
            $lastseen = date('Y-m-d H:i:s');
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}', lastseen = '{$lastseen}' WHERE unique_id={$_SESSION['unique_id']}");
            $sql2 = mysqli_query($conn, "INSERT INTO activity (user_id, session_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}', '{$_SESSION['session_id']}', '{$lastseen}', 'Logged Out')");
            $sql3 = mysqli_query($conn, "UPDATE sessions SET logouttime = '{$lastseen}' WHERE session_id = '{$_SESSION['session_id']}'");
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