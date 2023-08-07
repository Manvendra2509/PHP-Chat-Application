<?php
    // Loop through each row of the result set ($query) and fetch an associative array
    // The while loop will continue as long as there are rows in the result set
    while($row = mysqli_fetch_assoc($query)){

        // Check if the user status is "Offline now"
        // If the user status is "Offline now", set the CSS class for the status dot to "offline"
        // Otherwise, leave it empty (meaning the user is online)
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

        // Construct the output for each user in the result set
        // The output contains an anchor tag (<a>) wrapping the user's content and status dot
        $output .= '<a href="activity.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>
