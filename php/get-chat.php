<?php
// Starting a new session or resuming the existing one
session_start();

// Check if a user session exists
if (isset($_SESSION['unique_id'])) {
    // Including database configuration file
    include_once "config.php";

    // Setting the ID of the user sending the message (outgoing user)
    $outgoing_id = $_SESSION['unique_id'];

    // Escaping special characters in the ID of the user receiving the message (incoming user)
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    // Getting the last received message ID from the client-side
    $lastReceivedMsgId = $_POST['last_received_msg_id'];

    // Initialize the output variable to store the chat messages HTML
    $output = "";

    // SQL query to fetch messages between the outgoing and incoming users
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE ((outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})) AND msg_id > {$lastReceivedMsgId} ORDER BY msg_id";

    // Execute the SQL query
    $query = mysqli_query($conn, $sql);

    // Check if there are any messages
    if (mysqli_num_rows($query) > 0) {
        // Loop through each row in the result set and construct the chat message HTML
        while ($row = mysqli_fetch_assoc($query)) {
            // Check if the message is outgoing (sent by the current user)
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                // Construct the HTML for outgoing messages based on their type (text, image, video, audio)
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
                                    <img src="php/upload/' . $row['path'] . '">
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>   

                                </div>';
                } else if ($row['type'] === "video") {
                    $output .= '<div class="chat outgoing">
                                <div class="details details-wrapper">
                                <div class="details-video">
                                    <video controls><source src="php/upload/' . $row['path'] . '"></video>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "audio") {
                    $output .= '<div class="chat outgoing">
                                <div class="details details-wrapper">
                                <div class="details-audio">
                                    <audio controls><source src="php/upload/' . $row['path'] . '"></audio>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                }
            } else {
                // Construct the HTML for incoming messages based on their type (text, image, video, audio)
                if ($row['type'] === "text") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class="incoming-img" alt="">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "image") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class="incoming-img" alt="">
                                <div class="details details-wrapper">
                                <div class="details-img">
                                    <img src="php/upload/' . $row['path'] . '">
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "video") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class="incoming-img" alt="">
                                <div class="details details-wrapper">
                                <div class="details-video">
                                    <video controls><source src="php/upload/' . $row['path'] . '"></video>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                } else if ($row['type'] === "audio") {
                    $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" class="incoming-img" alt="">
                                <div class="details details-wrapper">
                                <div class="details-audio">
                                    <audio controls><source src="php/upload/' . $row['path'] . '"></audio>
                                    <span>' . $row['msg'] . '</span>
                                    </div>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])) . '</div>
                                </div>
                                
                                </div>';
                }
            }

            // Update the last received message ID to the current row's message ID
            if ($row['msg_id'] > $lastReceivedMsgId) {
                $lastReceivedMsgId = $row['msg_id'];
            }
        }

        // Encode the chat messages HTML and last received message ID into JSON and echo it
        echo json_encode(array("output" => $output, "last_received_msg_id" => $lastReceivedMsgId));
    } else {
        // If no messages are available, send a message indicating so
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }
} else {
    // If no user session exists, redirect to the login page
    header("location: ../index.php");
}
?>
