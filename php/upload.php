<?php
// File Upload
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once "config.php";
// Check if file was uploaded without errors
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['attachment'];

    // Define the directory to store uploaded files
    $uploadDir = 'upload/';

    // Generate a unique filename to avoid conflicts
    $filename = uniqid() . '_' . $file['name'];

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        // File uploaded successfully

        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $_SESSION['incoming_id'];
        $timestamp = date('Y-m-d H:i:s');
        $caption = isset($_POST['caption']) ? $_POST['caption'] : '';
        $mime = mime_content_type($uploadDir . $filename);
        if (strstr($mime, "video/")) {
            $type = "video";
        } else if (strstr($mime, "image/")) {
            $type = "image";
        } else if (strstr($mime, "audio/")) {
            $type = "audio";
        }
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, path, type, timestamp, session_id)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$caption}', '{$filename}','{$type}','{$timestamp}', '{$_SESSION['session_id']}')") or die();
        echo 'File uploaded.';
    } else {
        // Handle upload error
        echo 'File upload error.';
    }
}
?>