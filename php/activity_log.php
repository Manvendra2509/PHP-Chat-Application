<?php
session_start();
include_once "config.php";
$sql = "SELECT * FROM activity WHERE user_id = '{$_SESSION['userlog-id']}' ORDER BY activity_id DESC";
$query = mysqli_query($conn, $sql);
$output = "";
if (mysqli_num_rows($query) == 0) {
    $output .= "No user activity has been logged so far";
} else if (mysqli_num_rows($query) > 0) {
    include_once "activity_data.php";
}
echo $output;
?>