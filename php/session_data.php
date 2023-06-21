<?php
while ($row = mysqli_fetch_assoc($query)) {
    $_SESSION['logged_session_id'] = $row['session_id'];
    if ($row['logouttime'] === null) {
        $logoutTime = 'Not yet logged out';
    } else {
        $logoutTime = date("d M y, h:i A", strtotime($row['logouttime']));
    }
    $output .= '<a href="sessionlog.php?session_id=' . $row['session_id'] . '">
                    <div class="content">
                    <div class="details sessioncard">
                        <span> Session ID: ' . $_SESSION['logged_session_id']. '<br/> Login Time: ' . date("d M y, h:i A", strtotime($row['logintime'])) . " <br/> Logout Time: " . $logoutTime . '</span>
                    </div>
                    </div>
                </a>';
}
?>