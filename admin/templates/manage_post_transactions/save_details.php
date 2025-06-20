<?php
include("../db/db.php");
include("../db/activity.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$activity_details = "";
$response = [];

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroyed In Manage Post Transactions";
} else {
    if ($entry_permission == 'Yes') {

        $sendData = json_decode($_POST['sendData'], true);

        // Sanitize input values
        $view_id = trim(mysqli_real_escape_string($con, $sendData['view_id']));
        $seller_id = trim(mysqli_real_escape_string($con, $sendData['seller_id']));
        $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
        $buyer_id = trim(mysqli_real_escape_string($con, $sendData['buyer_id']));
        $assigned_collecter = trim(mysqli_real_escape_string($con, $sendData['assigned_collecter']));
        $view_date = trim(mysqli_real_escape_string($con, $sendData['view_date']));
        $deal_status = mysqli_real_escape_string($con, $sendData['deal_status']);
        $purchased_price = mysqli_real_escape_string($con, $sendData['purchased_price']);
        $negotiation_amount = mysqli_real_escape_string($con, $sendData['negotiation_amount']);
        $negotiation_by = mysqli_real_escape_string($con, $sendData['negotiation_by']);
        $mssg = mysqli_real_escape_string($con, $sendData['mssg']);
        $negotiation_date = mysqli_real_escape_string($con, $sendData['negotiation_date']);
        $accept_date = mysqli_real_escape_string($con, $sendData['accept_date']);
        $pickup_date = mysqli_real_escape_string($con, $sendData['pickup_date']);
        $pickup_time = mysqli_real_escape_string($con, $sendData['pickup_time']);
        $complete_date = mysqli_real_escape_string($con, $sendData['complete_date']);

        // New fields for product master update
        $quantity_pcs = mysqli_real_escape_string($con, $sendData['quantity_pcs']);
        $quantity_kg = mysqli_real_escape_string($con, $sendData['quantity_kg']);
        $withdrawal_date = mysqli_real_escape_string($con, $sendData['withdrawal_date']);
        $close_reason = mysqli_real_escape_string($con, $sendData['close_reason']);

        $execute = 1;

        if ($execute == 1) {
            $query = "SELECT * FROM tbl_user_product_view WHERE buyer_id='$buyer_id' AND product_id='$product_id'";
            if ($view_id != "") {
                $query .= " AND view_id <> '$view_id'";
            }
            $dataget = mysqli_query($con, $query);
            $data = mysqli_fetch_row($dataget);

            if ($data) {
                $status = "error";
                $status_text = "This buyer already viewed the item";
                $execute = 0;
            }
        }

        // Insert or update
        if ($execute == 1) {
            if ($view_id == "") {
                // INSERT new record
                $trans_id = "WNDY" . uniqid() . time();

                

                mysqli_query($con, "INSERT INTO tbl_user_product_view (
                    trans_id,
                    buyer_id, 
                    assigned_collecter,
                    product_id, 
                    seller_id, 
                    view_date,
                    deal_status,
                    purchased_price,
                    negotiation_amount,
                    negotiation_by,
                    mssg,
                    negotiation_date,
                    accept_date,
                    pickup_date,
                    pickup_time,
                    complete_date,
                    entry_user_code,
                    entry_timestamp
                ) VALUES (
                    '$trans_id',
                    '$buyer_id',
                    '$assigned_collecter',
                    '$product_id',
                    '$seller_id',
                    '$view_date',
                    '$deal_status',
                    '$purchased_price',
                    '$negotiation_amount',
                    '$negotiation_by',
                    '$mssg',
                    '$negotiation_date',
                    '$accept_date',
                    '$pickup_date',
                    '$pickup_time',
                    '$complete_date',
                    '$session_user_code',
                    '$timestamp'
                )");

                $status = "success";
                $status_text = "Data Saved Successfully";
                $activity_details = "You Inserted A Record In Manage Post Transactions";

            } else {
               
                $current_negotiation_sql = mysqli_query($con, "SELECT negotiation_amount FROM tbl_user_product_view WHERE view_id = '$view_id'");
                $current_negotiation_row = mysqli_fetch_assoc($current_negotiation_sql);
                $current_negotiation_amount = $current_negotiation_row['negotiation_amount'];

                // Replace last value with the new one
                $negotiation_parts = explode(',', $current_negotiation_amount);
                $negotiation_parts[count($negotiation_parts) - 1] = $negotiation_amount;
                $updated_negotiation_amount = mysqli_real_escape_string($con, implode(',', $negotiation_parts));
                mysqli_query($con, "UPDATE tbl_user_product_view SET  
                    buyer_id='$buyer_id', 
                    assigned_collecter='$assigned_collecter', 
                    product_id='$product_id', 
                    seller_id='$seller_id',
                    view_date='$view_date', 
                    deal_status='$deal_status',
                    purchased_price='$purchased_price',
                    negotiation_amount='$updated_negotiation_amount',
                    negotiation_by='$negotiation_by', 
                    mssg='$mssg', 
                    negotiation_date='$negotiation_date', 
                    accept_date='$accept_date', 
                    pickup_date='$pickup_date', 
                    pickup_time='$pickup_time', 
                    complete_date='$complete_date',
                    entry_user_code='$session_user_code', 
                    entry_timestamp='$timestamp',
                    update_timestamp='$timestamp' 
                    WHERE view_id='$view_id'");

               
                mysqli_query($con, "UPDATE tbl_product_master SET  
                    quantity_pcs = '$quantity_pcs',
                    quantity_kg = '$quantity_kg',
                    withdrawal_date = '$withdrawal_date',
                    close_reason = '$close_reason'
                    WHERE product_id = '$product_id'");

                $status = "success";
                $status_text = "Data Updated Successfully";
                $activity_details = "You Updated A Record In Manage Post Transactions";
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

    // Debug values - remove later
    'debug' => [
        'quantity_pcs' => $quantity_pcs,
        'quantity_kg' => $quantity_kg,
        'withdrawal_date' => $withdrawal_date,
        'close_reason' => $close_reason
    ]
];


echo json_encode($response, true);

if ($activity_details != "") {
    insertActivity($activity_details, $con, $session_user_code);
}
