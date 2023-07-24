<?php
$total_rows = mysqli_num_rows($query);
$current_row = 1;
while ($row = mysqli_fetch_assoc($query)) {

    $timestamp = date("d M y, h:i A", strtotime($row['timestamp']));
    $output .= '
                    <div class="content">
                        <div class="indicator"><div class="dot"></div> ' . ($current_row !== $total_rows ? '<div class="line"></div>' : '') . '</div>
                        <div class="details sessioncard">
                        <div> ' . date("d M y, h:i A", strtotime($row['timestamp'])) . '</div>
                        ' . $row['activity_description'] . '
                        </div>
                    </div>
                ';
    $current_row++;
}
?>