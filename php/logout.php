<?php
    // Start a new or resume an existing session
    session_start();

    // Set the default timezone to Asia/Kolkata
    date_default_timezone_set('Asia/Kolkata');

    // Check if the user is logged in (if the 'unique_id' session variable is set)
    if(isset($_SESSION['unique_id'])){

        // Include the 'config.php' file that contains the database connection details
        include_once "config.php";

        // Get the unique ID of the logged-in user from the session data
        $logout_id = $_SESSION['unique_id'];

        // Check if the 'logout_id' is set (optional step, since we already checked if 'unique_id' is set)
        if(isset($logout_id)){

            // Get the current date and time as the 'lastseen' timestamp in 'Y-m-d H:i:s' format
            $lastseen = date('Y-m-d H:i:s');

            // Set the user's status as "Offline now"
            $status = "Offline now";

            // Update the user's status and lastseen time in the database
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}', lastseen = '{$lastseen}' WHERE unique_id={$_SESSION['unique_id']}");

            // Insert a new activity record for the logout event in the 'activity' table
            $sql2 = mysqli_query($conn, "INSERT INTO activity (user_id, session_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}', '{$_SESSION['session_id']}', '{$lastseen}', 'Logged Out')");

            // Update the 'logouttime' in the 'sessions' table for the current session
            $sql3 = mysqli_query($conn, "UPDATE sessions SET logouttime = '{$lastseen}' WHERE session_id = '{$_SESSION['session_id']}'");

            // Check if the SQL update queries were successful
            if($sql){
                // Unset all session variables and destroy the session
                session_unset();
                session_destroy();

                // Redirect the user to the login page (index.php) after successful logout
                header("location: ../index.php");
            }
        }else{
            // If 'logout_id' is not set (unlikely scenario), redirect the user to the users.php page
            header("location: ../users.php");
        }
    }else{  
        // If the 'unique_id' session variable is not set, it means the user is not logged in, so redirect them to the login page (index.php)
        header("location: ../index.php");
    }
?>
