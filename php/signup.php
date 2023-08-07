<?php
// Start the PHP session
session_start();

// Include the "config.php" file which contains the database connection details using mysqli
include_once "config.php";

// Retrieve form data submitted via POST method and escape them to prevent SQL injection
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$role = mysqli_real_escape_string($conn, $_POST['role']);

// Check if all required fields (first name, last name, email, password) are not empty
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // Validate the email address using FILTER_VALIDATE_EMAIL to ensure it is in a valid format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the provided email already exists in the database by querying the "users" table
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            // If the email already exists, return an error message indicating that the email is already taken
            echo "$email - This email already exists!";
        } else {
            // If the email is not already in use, check if an image file was uploaded as part of the form
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // Extract the file extension from the image name
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                // Define allowed extensions for images
                $extensions = ["jpeg", "png", "jpg"];
                // Check if the uploaded image has an allowed extension
                if (in_array($img_ext, $extensions) === true) {
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    // Check if the uploaded image has an allowed type
                    if (in_array($img_type, $types) === true) {
                        // If the image passes the checks, move the uploaded image to a specified directory
                        $time = time();
                        $new_img_name = $time . $img_name;
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                            // Generate a unique ID for the user
                            $ran_id = rand(time(), 100000000);
                            // Set the status of the user as "Active now"
                            $status = "Active now";
                            // Encrypt the password using md5
                            $encrypt_pass = md5($password);

                            // Insert the user data (including the image file name) into the "users" table
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status, role)
                            VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}', '{$role}')");

                            // Check if the user was successfully inserted into the database
                            if ($insert_query) {
                                // Return "User added" message to the AJAX request
                                echo "success";
                            } else {
                                // If the user insertion fails, return an error message
                                echo "Something went wrong. Please try again!";
                            }
                        }
                    } else {
                        // If the image type is not allowed, return an error message
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                } else {
                    // If the image extension is not allowed, return an error message
                    echo "Please upload an image file - jpeg, png, jpg";
                }
            }
        }
    } else {
        // If the email is not in a valid format, return an error message
        echo "$email is not a valid email!";
    }
} else {
    // If any of the required fields are empty, return an error message
    echo "All input fields are required!";
}
?>
