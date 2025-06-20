<?php
include("../db/db.php");
header('Content-Type: application/json');
session_start();


$input = json_decode(file_get_contents('php://input'), true);


if (!$input) {
    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);
    exit;
}

// Extract and sanitize the received data
$title = mysqli_real_escape_string($con, $input['title'] ?? '');
$details = mysqli_real_escape_string($con, $input['details'] ?? '');
$notification_url = mysqli_real_escape_string($con, $input['notification_url'] ?? '');
$from_user_id = mysqli_real_escape_string($con, $input['from_user_id'] ?? '');
$entry_user_code = mysqli_real_escape_string($con, $input['entry_user_code'] ?? '');
$timestamp = date("Y-m-d H:i:s");

// Validate required fields
if (empty($title) || empty($details) || empty($notification_url) || empty($from_user_id) || empty($entry_user_code)) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

// Fetch all buyers except the sender
$seller_query = "SELECT um.user_id
FROM tbl_user_master AS um
INNER JOIN tbl_address_master AS am 
ON um.user_id = am.user_id
WHERE um.user_type = 'Buyer'
  AND um.user_id != '$from_user_id'
  AND am.pincode IN (
      SELECT pincode
      FROM tbl_address_master
      WHERE user_id = '$from_user_id'
  );
";
// SELECT um.user_id
// FROM tbl_user_master AS um
// INNER JOIN tbl_address_master AS am ON um.user_id = am.user_id
// WHERE um.user_type = 'Buyer'
//   AND um.user_id != '$from_user_id'
//   AND am.pincode = 'your_desired_pincode';

$seller_result = mysqli_query($con, $seller_query);

if (!$seller_result) {
    echo json_encode([
        "success" => false,
        "message" => "Error retrieving sellers: " . mysqli_error($con)
    ]);
    exit;
}

$to_user_ids = [];
while ($row = mysqli_fetch_assoc($seller_result)) {
    $to_user_ids[] = $row['user_id'];
}

// Validate the array before proceeding
if (empty($to_user_ids)) {
    echo json_encode([
        "success" => false,
        "message" => "No buyers found for notification."
    ]);
    exit;
}

// Insert a notification for each user into tbl_user_notification
foreach ($to_user_ids as $to_user_id) {
    $notification_insert_query = "INSERT INTO tbl_user_notification (
        title, 
        details, 
        notification_url, 
        to_user_id, 
        from_user_id, 
        seen, 
        notification_timestamp, 
        entry_user_code, 
        is_demand,
        entry_timestamp, 
        update_timestamp
    ) VALUES (
        '$title', 
        '$details', 
        '$notification_url', 
        '$to_user_id', 
        '$from_user_id', 
        'no', 
        '$timestamp', 
        '$entry_user_code', 
        '1',
        '$timestamp', 
        '$timestamp'
    )";

    if (mysqli_query($con, $notification_insert_query)) {
        $main_notification_id = mysqli_insert_id($con); // Get the ID of the inserted record

        // Insert into demand_notification for this user
        $demand_insert_query = "INSERT INTO demand_notification (
            main_notification_id,
            title,
            details,
            notification_url,
            to_user_id,
            from_user_id,
            seen,
            notification_timestamp,
            entry_user_code,
            entry_timestamp,
            update_timestamp
        ) VALUES (
            '$main_notification_id',
            '$title',
            '$details',
            '$notification_url',
            '$to_user_id',
            '$from_user_id',
            'no',
            '$timestamp',
            '$entry_user_code',
            '$timestamp',
            '$timestamp'
        )";

        if (!mysqli_query($con, $demand_insert_query)) {
            // Log error but continue with other inserts
            error_log("Error inserting into demand_notification for user $to_user_id: " . mysqli_error($con));
        }
    } else {
        // Log error but continue with other inserts
        error_log("Error inserting into tbl_user_notification for user $to_user_id: " . mysqli_error($con));
    }
}

// Set session variable for demand
$_SESSION['is_demand'] = 1;

// Return success response
echo json_encode([
    "success" => true,
    "message" => "Notifications saved successfully for all users.",
    "to_user_ids" => $to_user_ids
]);

// Close the database connection
mysqli_close($con);
