<?php
include("../db/db.php");
include("../../module_function/notification_details.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {
    $sendData = json_decode($_POST['sendData'], true);

    $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);
    $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
    $view_id = mysqli_real_escape_string($con, $sendData['view_id']);
    $negotiation_amount = mysqli_real_escape_string($con, $sendData['negotiation_amount']);
    $mssg = mysqli_real_escape_string($con, $sendData['mssg']);

    $execute = 1;

    // Check if the product is valid
    if ($execute == 1) {
        $product_dataget = mysqli_query($con, "SELECT * FROM tbl_product_master WHERE product_id='$product_id'");
        $product_data = mysqli_fetch_row($product_dataget);
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {
        $history_res_buyer = mysqli_query($con, "
    SELECT deal_status_history 
    FROM tbl_user_product_view 
    WHERE view_id = '$view_id'
");
$history_row_buyer = mysqli_fetch_assoc($history_res_buyer);

// Decode JSON if any
$current_history_buyer = [];
if (!empty($history_row_buyer['deal_status_history'])) {
    $current_history_buyer = json_decode($history_row_buyer['deal_status_history'], true);
    if (!is_array($current_history_buyer)) {
        $current_history_buyer = [];
    }
}

// Append new status
$current_history_buyer[] = [
    'status' => 'Under Negotiation',
    'time' => $timestamp
];

$new_json_buyer = mysqli_real_escape_string($con, json_encode($current_history_buyer));
        // UPDATE in tbl_user_product_view
    mysqli_query($con, "UPDATE tbl_user_product_view SET 
    deal_status='Under Negotiation',
    negotiation_amount=CONCAT(negotiation_amount, ',', '" . $negotiation_amount . "'), 
    negotiation_by='$session_user_type',
    mssg='$mssg',
    negotiation_date='$date',
    
    entry_timestamp='$timestamp'
    WHERE view_id='$view_id' ");


               $history_res = mysqli_query($con, "SELECT product_status_history FROM tbl_product_master WHERE product_id = '$product_id'");
     $history_row = mysqli_fetch_assoc($history_res);

// Decode existing JSON (if any)
     $current_history = [];
     if (!empty($history_row['product_status_history'])) {
     $current_history = json_decode($history_row['product_status_history'], true);
     if (!is_array($current_history)) {
        $current_history = []; 
     }
     }


            $current_history[] = [
            'status' => 'Under Negotiation',
            'time' => $timestamp
            ];

            $new_json = mysqli_real_escape_string($con, json_encode($current_history));

        // UPDATE in tbl_product_master
        mysqli_query($con, "UPDATE tbl_product_master SET 
            product_status='Under Negotiation',
            product_status_history = '" . $new_json . "'
            WHERE product_id='$product_id' ");
            

                  //=========================== INSERT IN product_status_update_tbl TABLE =======================================
//     mysqli_query($con, "INSERT INTO product_status_update_tbl (
//     seller_id,
//     product_id,
//     product_update_status
// ) VALUES (
//     '" . $session_user_code . "',
//     '" . $product_id . "',
//     'Under Negotiation'
// )");


 // INSERT into message_history
    mysqli_query($con, "INSERT INTO message_history (
        user_id,
        product_id,
        brid_message,
        created_at,
        updated_at
    ) VALUES (
        '$session_user_code',
        '$product_id',
        '$mssg',
        NOW(),
        NOW()
    )");

        // buyer & collector will notified that seller send request for a product
        $dataget = mysqli_query($con, "select buyer_id, assigned_collecter from tbl_user_product_view where view_id='" . $view_id . "' ");
        $data = mysqli_fetch_row($dataget);

        $buyer_id = $data[0];
        $assigned_collecter = $data[1];

        $productDataget = mysqli_query($con, "select 
            tbl_product_master.product_name
            from tbl_product_master
            where tbl_product_master.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['product_name'];

        $noti_title = "Price Request From Seller";
        $noti_details = "Attention! The seller of ".$product_name . "'s  has sent you a new price request.";
        $noti_url = $baseUrl . "/product-details/" . $product_id;
        $noti_to_user_id = $buyer_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        // assigned collector not blank
        if ($assigned_collecter != "") {
            $noti_to_user_id = $assigned_collecter;
            insertNotificationDetails();
        }

        $status = "success";
        $status_text = "Request Submitted Successfully";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
