<?php
$status_history_raw = '[{"status":"Credit Used","time":"2025-06-04 17:40:10"},{"status":"Under Negotiation","time":"2025-06-04 17:40:20"}]'; // This would be from your DB row

$formatted_history = '';
$plain_history = ''; // NEW

if (!empty($status_history_raw)) {
    // Decode the JSON data
    $status_data = json_decode($status_history_raw, true);

    // Start the formatted history as an unordered list
    $formatted_history = '<ul style="padding-left: 18px; margin: 0;">';

    // Iterate through each status record
    foreach ($status_data as $entry) {
        $status = trim($entry['status']);
        $time = trim($entry['time']);

        // Create the formatted HTML list item
        $formatted_history .= '<li style="margin-bottom: 4px;">
            <strong style="color:#333;">' . htmlspecialchars($status) . '</strong>
            <span style="display:block; font-size:11px; color:#777;">' . htmlspecialchars($time) . '</span>
        </li>';

        // Step 1B: Plain version
        $plain_history .= $status . ' - ' . $time . "\n";
    }

    // Close the unordered list
    $formatted_history .= '</ul>';
}

// Output for testing (or use as required)
echo $formatted_history;
echo "\n\n";
echo $plain_history;
?>
