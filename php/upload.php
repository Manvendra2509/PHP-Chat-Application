<?php
// Start a new or resume an existing session
session_start();

// Set the default timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');

// Include the configuration file with the database connection details
include_once "config.php";

// Check if the file was uploaded without errors
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['attachment'];

    // Define the directory to store uploaded files
    $uploadDir = 'upload/';

    // Generate a unique filename to avoid conflicts using 'uniqid()' and the original file name
    $filename = uniqid() . '_' . $file['name'];

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        // File uploaded successfully

        // Get the unique IDs of the sender and recipient from the session data
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $_SESSION['incoming_id'];

        // Get the current timestamp in 'Y-m-d H:i:s' format
        $timestamp = date('Y-m-d H:i:s');

        // Get the caption (if provided) for the uploaded file
        $caption = isset($_POST['caption']) ? $_POST['caption'] : '';

        // Get the MIME type of the uploaded file using 'mime_content_type'
        $mime = mime_content_type($uploadDir . $filename);

        // Determine the type of the file (video, image, audio) based on the MIME type
        if (strstr($mime, "video/")) {
            $type = "video";
        } else if (strstr($mime, "image/")) {
            $type = "image";
        } else if (strstr($mime, "audio/")) {
            $type = "audio";
        }

        // Insert the file details into the 'messages' table
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, path, type, timestamp, session_id)
            VALUES ({$incoming_id}, {$outgoing_id}, '{$caption}', '{$filename}','{$type}','{$timestamp}', '{$_SESSION['session_id']}')") or die();

        // Insert an activity log entry for the file upload into the 'activity' table
        $sql2 = mysqli_query($conn, "INSERT INTO activity (session_id, timestamp, user_id, activity_description) 
            VALUES ('{$_SESSION['session_id']}', '{$timestamp}', '{$outgoing_id}', 'User sent {$type} attachment to User ID: {$incoming_id}')");

        // Echo 'File uploaded.' to indicate a successful file upload
        echo 'File uploaded.';
    } else {
        // Handle upload error
        echo 'File upload error.';
    }
}
?>
