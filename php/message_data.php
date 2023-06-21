<?php
    while($row = mysqli_fetch_assoc($query)){
        $_SESSION['sessionlog-id'] = $row['session_id'];
        while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $_SESSION['userlog-id']){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])). '</div>
                                </div>
                                
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                    <div class="timestamp">' . date("M d, h:i A", strtotime($row['timestamp'])). '</div>
                                </div>
                                
                                </div>';
                }
            }
    }
?>