<?php
session_start();
include_once "config.php";
$title = mysqli_real_escape_string($conn, $_POST['title']);
$display = mysqli_real_escape_string($conn, $_POST['display']);
if (!empty($title)) {
    $sql = mysqli_query($conn, "UPDATE homepage SET title = '{$title}' WHERE id=0");
} 

$sql2 = mysqli_query($conn, "UPDATE homepage SET display = '{$display}' WHERE id=0");



if (isset($_FILES['image'])) {
    $img_name = $_FILES['image']['name'];
    $img_type = $_FILES['image']['type'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode);

    $extensions = ["jpeg", "png", "jpg"];
    if (in_array($img_ext, $extensions) === true) {
        $types = ["image/jpeg", "image/jpg", "image/png"];
        if (in_array($img_type, $types) === true) {
            $new_img_name = "logo.png";
        }
    }
}

echo "success";

?>