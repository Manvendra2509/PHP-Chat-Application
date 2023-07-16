<?php
while ($row = mysqli_fetch_assoc($query)) {

    $timestamp = date("d M y, h:i A", strtotime($row['timestamp']));
    $output .= '
                    <div class="content">
                        <div class="dot"></div>
                        <div class="details sessioncard">
                        <div> ' . date("d M y, h:i A", strtotime($row['timestamp'])) . '</div>
                        ' . $row['activity_description'] . '
                        </div>
                    </div>
                ';
}
?>