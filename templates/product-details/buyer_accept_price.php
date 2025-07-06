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

        // product dataget
        $dataget = mysqli_query($con, "select sale_price from tbl_product_master where product_id='" . $product_id . "' ");
        $data = mysqli_fetch_assoc($dataget);
        $purchased_price = $data['sale_price'];

        // get buyer product view data
        $dataget = mysqli_query($con, "select negotiation_amount from tbl_user_product_view where buyer_id='" . $session_user_code . "' and product_id='" . $product_id . "' ");
        $data = mysqli_fetch_assoc($dataget);

        if ($data['negotiation_amount'] != 0) {
            $purchased_price = $data['negotiation_amount'];
        }

        $history_res_buyer = mysqli_query($con, "
    SELECT deal_status_history 
    FROM tbl_user_product_view 
    WHERE product_id = '$product_id' AND buyer_id = '$session_user_code'
");
        $history_row_buyer = mysqli_fetch_assoc($history_res_buyer);

        // Decode existing JSON (if any)
        $current_history_buyer = [];
        if (!empty($history_row_buyer['deal_status_history'])) {
            $current_history_buyer = json_decode($history_row_buyer['deal_status_history'], true);
            if (!is_array($current_history_buyer)) {
                $current_history_buyer = []; // fallback if malformed
            }
        }

        // Append new deal status
        $current_history_buyer[] = [
            'status' => 'Offer Accepted',
            'time' => $timestamp
        ];

        // Encode JSON safely
        $new_json_buyer = mysqli_real_escape_string($con, json_encode($current_history_buyer));

        // ✅ Corrected SQL without extra comma
        mysqli_query($con, "
    UPDATE tbl_user_product_view SET 
        deal_status = 'Offer Accepted',
        negotiation_amount = '$purchased_price',
        accept_date = '$date',
        deal_status_history = '$new_json_buyer'
    WHERE buyer_id = '$session_user_code' AND product_id = '$product_id'
");

        //=========================== INSERT IN product_status_update_tbl TABLE =======================================
        // mysqli_query($con, "INSERT INTO product_status_update_tbl (
        // buyer_id,
        // product_id,
        // product_update_status
        // ) VALUES (
        // '" . $session_user_code . "',
        // '" . $product_id . "',
        // 'Offer Accepted'
        //  )");

        $history_res = mysqli_query($con, "SELECT product_status_history FROM tbl_product_master WHERE product_id = '$product_id'");
        $history_row = mysqli_fetch_assoc($history_res);

        // Decode existing JSON (if any)
        $current_history = [];
        if (!empty($history_row['product_status_history'])) {
            $current_history = json_decode($history_row['product_status_history'], true);
            if (!is_array($current_history)) {
                $current_history = []; // fallback if malformed
            }
        }

        $current_history[] = [
            'status' => 'Offer Accepted',
            'time' => $timestamp
        ];

        $new_json = mysqli_real_escape_string($con, json_encode($current_history));


        // Update product status
        mysqli_query($con, "UPDATE tbl_product_master SET 
            product_status='Offer Accepted',
            product_status_history = '" . $new_json . "'
            WHERE product_id='$product_id' ");

        // seller will notified that buyer accept product price
        $productDataget = mysqli_query($con, "select 
            tbl_product_master.product_name,
            tbl_product_master.user_id
            from tbl_product_master
            where tbl_product_master.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['product_name'];
        $seller_id = $productData['user_id'];

        $noti_title = "Buyer Accept The Item";
        $noti_details = "Good News! One buyer accept your item price ";
        $noti_url = $baseUrl . "/product-details/" . $product_id;
        $noti_to_user_id = $seller_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        $status = "success";
        $status_text = "Deal Updated Successfully";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
