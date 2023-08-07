<?php
// Start a PHP session to manage user sessions.
session_start();

// Set the default timezone to 'Asia/Kolkata' (Indian Standard Time).
date_default_timezone_set('Asia/Kolkata');

// Include the 'config.php' file to access database connection and other settings.
include_once "config.php";

// Get the password entered by the user and escape it to prevent SQL injection.
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Hash the password using the MD5 algorithm for database comparison (Note: MD5 is not recommended for password hashing in modern applications).
$user_pass = md5($password);

// Check if the password is not empty (submitted by the login form).
if (!empty($password)) {
    // Query the 'users' table in the database to find a user with the entered password.
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE password = '{$user_pass}'");

    // Check if the query returned any rows, indicating that a user with the provided password exists.
    if (mysqli_num_rows($sql) > 0) {
        // Fetch the user data from the result set.
        $row = mysqli_fetch_assoc($sql);

        // Set the user's status to "Active now".
        $status = "Active now";

        // Update the user's status in the 'users' table to reflect their current status as "Active now".
        $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

        // If the update is successful, set up the user's session and perform other necessary tasks.
        if ($sql2) {
            // Set session variables to store user data.
            $_SESSION['unique_id'] = $row['unique_id']; // User's unique identifier.
            $_SESSION['role'] = $row['role']; // User's role (if applicable).
            $_SESSION['pass'] = $row['password']; // User's password (Note: Storing password in session is not recommended).
            $_SESSION['logintime'] = date('Y-m-d H:i:s'); // Current login timestamp.
            
            // Insert a new record in the 'sessions' table to track the user's login session.
            $sql3 = mysqli_query($conn, "INSERT INTO sessions (user_id, logintime) VALUES ('{$_SESSION['unique_id']}','{$_SESSION['logintime']}')");
            $_SESSION['session_id'] = mysqli_insert_id($conn); // Get the last inserted session ID.

            // Insert a new record in the 'activity' table to log the user's login activity.
            $sql4 = mysqli_query($conn, "INSERT INTO activity (user_id, session_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}', '{$_SESSION['session_id']}', '{$_SESSION['logintime']}', 'Logged In')");

            // Echo "success" to indicate that the login was successful.
            echo "success";
        } else {
            // If something went wrong with updating the user's status, echo an error message.
            echo "Something went wrong. Please try again!";
        }
    } else {
        // If no user with the provided password exists, echo an error message.
        echo "No user with this password exists";
    }
} else {
    // If the password field was left empty, echo an error message.
    echo "All input fields are required!";
}
?>
