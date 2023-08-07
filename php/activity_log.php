<?php
// Start the PHP session
session_start();

// Include the configuration file to connect to the database
include_once "config.php";

// SQL query to fetch activity log data for the user with the specified user_id
$sql = "SELECT * FROM activity WHERE user_id = '{$_SESSION['userlog-id']}' ORDER BY activity_id DESC";

// Execute the SQL query
$query = mysqli_query($conn, $sql);

// Initialize an empty string to store the output (activity log data)
$output = "";

// Check if there are no rows (activity log data) returned from the query
if (mysqli_num_rows($query) == 0) {
    // If no activity log data is found, add a message to the output string
    $output .= "No user activity has been logged so far";
} else if (mysqli_num_rows($query) > 0) {
    // If there are rows (activity log data) returned from the query, include the activity_data.php file to format the data
    include_once "activity_data.php";
}

// Echo the output string containing the formatted activity log data or the "No user activity" message
echo $output;
?>
