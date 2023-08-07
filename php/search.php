<?php
    // Start a new or resume an existing session
    session_start();

    // Include the configuration file with the database connection details
    include_once "config.php";

    // Get the unique ID of the logged-in user from the session data
    $outgoing_id = $_SESSION['unique_id'];

    // Get the search term entered by the user and sanitize it to prevent SQL injection
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    // SQL query to select users whose first name or last name matches the search term
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";

    // Variable to store the output
    $output = "";

    // Execute the SQL query
    $query = mysqli_query($conn, $sql);

    // Check if any matching users were found
    if(mysqli_num_rows($query) > 0){
        // Include the "data.php" file to format and display the user data
        include_once "data.php";
    }else{
        // If no matching users were found, set a message in the output variable
        $output .= 'No user found related to your search term';
    }

    // Output the result to the client-side (e.g., an AJAX response)
    echo $output;
?>
