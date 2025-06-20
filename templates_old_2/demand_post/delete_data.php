<?php
include("../db/db.php");
include("../db/activity.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$activity_details = "";
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'], true);
$demand_post_id = mysqli_real_escape_string($con, $sendData['demand_post_id']);

echo json_encode($demand_post_id);

if ($create_post_id) {
    $deleteQuery = "DELETE FROM tbl_demand_post WHERE demand_post_id='" . $demand_post_id . "'";
    if (mysqli_query($con, $deleteQuery)) {
        $activity_details = "You Delete A Record From Collector";
        if ($activity_details != "") {
            insertActivity($activity_details, $con, $session_user_code);
        }
        $response = [
            'status' => 'Success',
            'status_text' => 'Item deleted successfully.'
        ];
    } else {
        $response = [
            'status' => 'Error',
            'status_text' => 'Failed to delete item: ' . mysqli_error($con)
        ];
    }
} else {
    $response = [
        'status' => 'Error',
        'status_text' => 'Invalid create_post_id.'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
