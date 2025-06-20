<?php
include("../db/db.php");
header('Content-Type: application/json');

if (isset($_POST['session_user_code'])) {
    $session_user_code = mysqli_real_escape_string($con, $_POST['session_user_code']);

    $query1 = mysqli_query($con, "SELECT direct_transfer_id 
                                  FROM tbl_direct_transfer 
                                  WHERE transferred_to_id = '$session_user_code' 
                                  AND transferred_status = 'Direct Transfer'");

    $success = true; // Track success status

    while ($row = mysqli_fetch_array($query1)) {
        $dt_id = $row['direct_transfer_id'];

        $query = "UPDATE tbl_direct_transfer 
                  SET transferred_status = 'Purchased' 
                  WHERE direct_transfer_id = '$dt_id' 
                  AND transferred_status = 'Direct Transfer'";

        if (!mysqli_query($con, $query)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Products accepted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to accept products.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
