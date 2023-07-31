<?php
// Assuming you have fetched the data from the SQL table and stored it in $query variable.

// Array to store sessions and their corresponding cards
$sessions = array();

// Loop through the query result to group sessions
while ($row = mysqli_fetch_assoc($query)) {
    $session_id = $row['session_id'];
    if (!isset($sessions[$session_id])) {
        $sessions[$session_id] = array();
    }
    $sessions[$session_id][] = $row;
}

// Loop through the sessions and their cards
foreach ($sessions as $session_id => $session_cards) {
    $accordion_id = 'accordion_' . $session_id;

    $isExpanded = isset($_POST[$accordion_id]) ? $_POST[$accordion_id] : 'false';
    echo '<div class="session-div accordion">
            <div class="accordion-item">
                <div class="session-div-header accordion-header">
                <button class="session-div-arrow accordion-button ' . ($isExpanded === 'true' ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $accordion_id . '" aria-expanded="' . ($isExpanded === 'true' ? 'true' : 'false') . '" aria-controls="' . $accordion_id . '">
                        <div class="session-div-title">Session ID: ' . $session_id . '</div>
                    </button>
                </div>';

    $total_cards = count($session_cards);
    $current_card = 1;
    echo '<div id="' . $accordion_id . '" class="accordion-collapse collapse ' . ($isExpanded === 'true' ? 'show' : '') . '" data-bs-parent="#accordionExample">
    <div class="accordion-body">';

    foreach ($session_cards as $row) {
        $timestamp = date("d M y, h:i A", strtotime($row['timestamp']));
        echo '
            <div class="content">
                <div class="indicator"><div class="dot"></div>' . ($current_card !== $total_cards ? '<div class="line"></div>' : '') . '</div>
                <div class="details sessioncard">
                    <div>' . date("d M y, h:i A", strtotime($row['timestamp'])) . '</div>
                    ' . $row['activity_description'] . '
                </div>
            </div>
        ';
        $current_card++;
    }
    echo '</div></div></div></div>';
}