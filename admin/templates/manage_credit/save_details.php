<?php
include("../db/db.php");
include("../db/activity.php");

$activity_details = "";
$response = [];

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroyed In Manage Credit Details";
} else {
    if ($entry_permission == 'Yes') {
        $sendData = json_decode($_POST['sendData'], true);

        $option_id = mysqli_real_escape_string($con, $sendData['option_id']);
        $credit = trim(mysqli_real_escape_string($con, $sendData['credit']));
        $purchase_amount = strtolower(trim(mysqli_real_escape_string($con, $sendData['purchase_amount'])));
        $active = mysqli_real_escape_string($con, $sendData['active']);

        $execute = 1;

        // CHECK credit 
        if ($execute == 1) {
            if ($option_id == "") {
                $dataget = mysqli_query($con, "SELECT * FROM tbl_credit_option WHERE credit='" . $credit . "' ");
            } else {
                $dataget = mysqli_query($con, "SELECT * FROM tbl_credit_option WHERE option_id<>'" . $option_id . "' AND credit='" . $credit . "' ");
            }

            $data = mysqli_fetch_row($dataget);

            if ($data) {
                $status = "credit error";
                $status_text = "Credit Already Exists !!";
                $execute = 0;
            }
        }

        // CHECK purchase amount 
        if ($execute == 1) {
            if ($option_id == "") {
                $dataget = mysqli_query($con, "SELECT * FROM tbl_credit_option WHERE purchase_amount='" . $purchase_amount . "' ");
            } else {
                $dataget = mysqli_query($con, "SELECT * FROM tbl_credit_option WHERE option_id<>'" . $option_id . "' AND purchase_amount='" . $purchase_amount . "' ");
            }

            $data = mysqli_fetch_row($dataget);

            if ($data) {
                $status = "purchase_amount error";
                $status_text = "Purchase Amount Already Exists !!";
                $execute = 0;
            }
        }

        // Insert and update
        if ($execute == 1) {
            if ($option_id == "") {
                mysqli_query($con, "INSERT INTO tbl_credit_option (
                    option_id, 
                    credit,
                    purchase_amount,
                    active,
                    entry_user_code,
                    entry_timestamp) VALUES (
                        NULL,
                        '$credit',
                        '$purchase_amount',
                        '$active',
                        '$session_user_code',
                        '$timestamp')");

                $status = "success";
                $status_text = "New Credit Added Successfully";
                $activity_details = "You Inserted A Record In Manage Credit Details";
            } else {
                mysqli_query($con, "UPDATE tbl_credit_option SET  
                    credit='$credit', 
                    purchase_amount='$purchase_amount', 
                    active='$active', 
                    entry_user_code='$session_user_code', 
                    update_timestamp='$timestamp' 
                    WHERE option_id='$option_id'");

                $status = "Save";
                $status_text = "Credit Details Updated Successfully";
                $activity_details = "You Updated A Record In Manage Credit Details";
            }
        }
    } else {
        $status = "NoPermission";
        $status_text = "You Don't Have Permission To Enter Any Data !!";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);

if ($activity_details != "") {
    insertActivity($activity_details, $con, $session_user_code);
}
?>
