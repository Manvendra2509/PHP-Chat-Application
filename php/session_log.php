<?php
session_start();
include_once "config.php";
$outgoing_id = $_SESSION['userlog-id'];
$output = "";
$sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE session_id = '{$_SESSION['sessionlog-id']}' ORDER BY msg_id";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['outgoing_msg_id'] === $outgoing_id) {
            $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <div class="receiver"> Message Sent To User ID:  ' . $row['outgoing_msg_id'] . '</div>
                                    <p>' . $row['msg'] . '</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
        } else if ($row['incoming_msg_id'] === $outgoing_id) {
            $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" alt="">
                                <div class="details">
                                <div class="sender"> Message Received From User ID: ' . $row['incoming_msg_id'] . '</div>
                                    <p>' . $row['msg'] . '</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
        }
    }
} else {
    $output .= '<div class="text">No messages were sent during this session.</div>';
}
echo $output;
?>