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

// Sanitize and validate input
$title = mysqli_real_escape_string($con, $input['title'] ?? '');
$details = mysqli_real_escape_string($con, $input['details'] ?? '');
$notification_url = mysqli_real_escape_string($con, $input['negotiation_url'] ?? '');
$from_user_id = mysqli_real_escape_string($con, $input['from_user_id'] ?? '');
$entry_user_code = mysqli_real_escape_string($con, $input['entry_user_code'] ?? '');
$negotiation_price = mysqli_real_escape_string($con, $input['negotiation_price'] ?? '');
$negotiation_quantity = mysqli_real_escape_string($con, $input['negotiation_quantity'] ?? '');
$quantity_unit = mysqli_real_escape_string($con, $input['quantity_unit'] ?? '');
$negotiation_message = mysqli_real_escape_string($con, $input['negotiation_message'] ?? null);
$toUser = mysqli_real_escape_string($con, $input['to_notification'] ?? '');
$demand_post_id = mysqli_real_escape_string($con, $input['demand_post_id'] ?? '');
$negotation_id = mysqli_real_escape_string($con, $input['negotation_id'] ?? '');
$timestamp = date("Y-m-d H:i:s");

// Start transaction
mysqli_begin_transaction($con);

try {
    // Insert notification
    $query = "INSERT INTO tbl_user_notification 
              (title, details, notification_url, to_user_id, from_user_id, notification_timestamp, entry_user_code, is_demand, entry_timestamp, negotiation_price, negotiation_quantity, quantity_unit, negotiation_message, demand_id, is_negotiation) 
              VALUES 
              ('$title', '$details', '$notification_url', '$toUser', '$from_user_id', '$timestamp', '$entry_user_code', 1, '$timestamp', '$negotiation_price', '$negotiation_quantity', '$quantity_unit', '$negotiation_message', '$demand_post_id', 1)";

    if (!mysqli_query($con, $query)) {
        throw new Exception("Error inserting notification: " . mysqli_error($con));
    }

    $notification_id = mysqli_insert_id($con);
    $final_notification_url = "$notification_url/$notification_id";

    // Update notification URL
    $update_query = "UPDATE tbl_user_notification 
                     SET notification_url = '$final_notification_url' 
                     WHERE notification_id = $notification_id";

    if (!mysqli_query($con, $update_query)) {
        throw new Exception("Error updating notification URL: " . mysqli_error($con));
    }

    // Update is_negotiation for the existing negotiation ID
    $update_nego_id = "UPDATE tbl_user_notification 
                       SET is_negotiation = 1 
                       WHERE notification_id = $negotation_id";

    if (!mysqli_query($con, $update_nego_id)) {
        throw new Exception("Error updating negotiation ID: " . mysqli_error($con));
    }

    // Update demand post quantity
    $quantity_update_query = "UPDATE tbl_demand_post 
                              SET quantity = quantity - $negotiation_quantity 
                              WHERE demand_post_id = '$demand_post_id'";

    if (!mysqli_query($con, $quantity_update_query)) {
        throw new Exception("Error updating demand post quantity: " . mysqli_error($con));
    }

    // Commit transaction
    mysqli_commit($con);

    echo json_encode([
        "success" => true,
        "message" => "Negotiation sent successfully and quantity updated.",
        "final_url" => $final_notification_url,
        "notification_id" => $notification_id
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($con);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

// Close connection
mysqli_close($con);
?>
