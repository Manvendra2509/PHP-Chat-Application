<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $lastReceivedMsgId = $_POST['last_received_msg_id'];
    $output = "";
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE ((outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})) AND msg_id > {$lastReceivedMsgId} ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                if ($row['type'] === "text") {
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';                                
                } else if ($row['type'] === "image") {
                    $output .= '<div class="chat outgoing">
                                <div class="details details-wrapper">
                                    <div class="details-img">
                                    <img src = "php/upload/' . $row['path'] . '">
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>   

                                </div>';
                } else if ($row['type'] === "video") {
                    $output .= '<div class="chat outgoing">
                                <div class="details details-wrapper">
                                <div class="details-video">
                                    <video controls><source src = "php/upload/' . $row['path'] . '"></video>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "audio") {
                    $output .= '<div class="chat outgoing">
                                <div class="details details-wrapper">
                                <div class="details-audio">
                                    <audio controls><source src = "php/upload/' . $row['path'] . '"></audio>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                }

            } else {
                if ($row['type'] === "text") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class= "incoming-img" alt="">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "image") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class= "incoming-img" alt="">
                                <div class="details details-wrapper">
                                <div class="details-img">
                                    <img src = "php/upload/' . $row['path'] . '">
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "video") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class= "incoming-img" alt="">
                                <div class="details details-wrapper">
                                <div class="details-video">
                                    <video controls><source src = "php/upload/' . $row['path'] . '"></video>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "audio") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class= "incoming-img" alt="">
                                <div class="details details-wrapper">
                                <div class="details-audio">
                                    <audio controls><source src = "php/upload/' . $row['path'] . '"></audio>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                }
            }
            if ($row['msg_id'] > $lastReceivedMsgId) {
                $lastReceivedMsgId = $row['msg_id'];
            }
        }
        echo json_encode(array("output" => $output, "last_received_msg_id" => $lastReceivedMsgId));
    } else {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
} else {
    header("location: ../index.php");
}

?>