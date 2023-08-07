<?php
// Start a new or resume an existing session
session_start();

// Include the configuration file with the database connection details
include_once "config.php";

// Get the data from the POST request and escape it to prevent SQL injection
$title = mysqli_real_escape_string($conn, $_POST['title']);
$display = mysqli_real_escape_string($conn, $_POST['display']);

// Update the title in the 'homepage' table if it is not empty
if (!empty($title)) {
    $sql = mysqli_query($conn, "UPDATE homepage SET title = '{$title}' WHERE id=0");
} 

// Update the 'display' value in the 'homepage' table
$sql2 = mysqli_query($conn, "UPDATE homepage SET display = '{$display}' WHERE id=0");

// Check if an image was uploaded
if (isset($_FILES['image'])) {
    $img_name = $_FILES['image']['name'];
    $img_type = $_FILES['image']['type'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Extract the image extension from the image name
    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode);

    // List of allowed image extensions
    $extensions = ["jpeg", "png", "jpg"];

    // Check if the uploaded image has an allowed extension
    if (in_array($img_ext, $extensions) === true) {
        $types = ["image/jpeg", "image/jpg", "image/png"];

        // Check if the image type is also allowed
        if (in_array($img_type, $types) === true) {
            // If the image is valid, set a fixed name "logo.png" for it
            $new_img_name = "logo.png";
        }
    }
}

// Echo "success" to indicate that the update was successful
echo "success";
?>
