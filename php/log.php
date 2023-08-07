<?php
    // Start the session to access session variables
    session_start();

    // Include the configuration file to establish a database connection
    include_once "config.php";

    // SQL query to select all users from the database, ordered by user_id in descending order
    $sql = "SELECT * FROM users ORDER BY user_id DESC";

    // Execute the SQL query
    $query = mysqli_query($conn, $sql);

    // Initialize an empty variable to store the output
    $output = "";

    // Check if there are no users available to view chat log
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to view chat log";
    }
    // If there are users available to view chat log
    elseif(mysqli_num_rows($query) > 0){
        // Include the "logdata.php" file to display the log data for each user
        include_once "logdata.php";
    }

    // Output the final result
    echo $output;
?>
