<?php
// Loop through the query result and fetch each row as an associative array.
while ($row = mysqli_fetch_assoc($query)) {
    // Prepare the SQL query to retrieve the latest message exchanged between the current user and the fetched user.
    $sql2 = "SELECT * FROM messages WHERE 
                (incoming_msg_id = {$row['unique_id']} OR outgoing_msg_id = {$row['unique_id']}) 
                AND (outgoing_msg_id = {$outgoing_id} OR incoming_msg_id = {$outgoing_id}) 
                ORDER BY msg_id DESC LIMIT 1";

    // Execute the SQL query to get the latest message.
    $query2 = mysqli_query($conn, $sql2);

    // Fetch the result of the second query as an associative array.
    $row2 = mysqli_fetch_assoc($query2);

    // If there is at least one message exchanged between the two users, store it in the $result variable; otherwise, set it to "No message available".
    (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "No message available";

    // Shorten the message to a maximum of 28 characters, appending "..." if it exceeds the limit.
    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

    // Determine whether the message was sent by the current user ("You: ") or the other user (empty).
    if (isset($row2['outgoing_msg_id'])) {
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
    } else {
        $you = "";
    }

    // Determine whether the user is offline ("offline") or online (empty).
    ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

    // Determine whether to hide the message preview for the current user's entry in the list.
    ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

    // Generate the HTML code for each user entry in the list.
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="php/images/' . $row['img'] . '" alt="">
                    <div class="details">
                        <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
?>
