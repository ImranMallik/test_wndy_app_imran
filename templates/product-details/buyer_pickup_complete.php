<?php
include("../db/db.php");
include("../db/router.php");
include("../../module_function/notification_details.php");
include("../../module_function/whatsapp_notification.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {
    $sendData = json_decode($_POST['sendData'], true);

    $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);
    $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
    $view_id = mysqli_real_escape_string($con, $sendData['view_id']);
    $complete_date = date('Y-m-d H:i:s');
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

        // Fetch existing deal_status_history
        $history_res_buyer = mysqli_query($con, "SELECT deal_status_history FROM tbl_user_product_view WHERE product_id = '$product_id' AND buyer_id = '$session_user_code'");
        $history_row_buyer = mysqli_fetch_assoc($history_res_buyer);

        $current_history_buyer = [];
        if (!empty($history_row_buyer['deal_status_history'])) {
            $current_history_buyer = json_decode($history_row_buyer['deal_status_history'], true);
            if (!is_array($current_history_buyer)) {
                $current_history_buyer = [];  // Handle malformed history
            }
        }

        // Append new status to the history
        $current_history_buyer[] = [
            'status' => 'Completed',
            'time' => $timestamp
        ];

        // Encode the updated history back to JSON
        $new_json = mysqli_real_escape_string($con, json_encode($current_history_buyer));

        // Update the deal_status_history in tbl_user_product_view without removing previous data
        mysqli_query($con, "UPDATE tbl_user_product_view SET 
    deal_status = 'Completed',
    duration_close_time='" . $complete_date . "',
    deal_status_history = '" . $new_json . "',
    entry_timestamp = '$timestamp'
    WHERE view_id = '$view_id'");


        // seller will notified that buyer complete the pickup
        $productDataget = mysqli_query($con, "select 
            tbl_product_master.product_name,
            tbl_product_master.user_id
            from tbl_product_master
            where tbl_product_master.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['product_name'];
        $seller_id = $productData['user_id'];

        $noti_title = "Buyer Pickup Complete";
        $noti_details = "Success! (" . $session_user_type . ") has picked up your (" . $product_name . ") item.";

        $noti_url = $baseUrl . "/product-details/" . $product_id;
        $noti_to_user_id = $seller_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        ## send whatsapp notification to seller
        $sellerQuery = mysqli_query($con, "SELECT um.name, um.ph_num, uv.purchased_price 
                        FROM tbl_user_product_view AS uv 
                        JOIN tbl_user_master AS um ON uv.seller_id = um.user_id 
                        WHERE uv.view_id = '$view_id' AND uv.deal_status='Completed'");
        $sellerData = mysqli_fetch_assoc($sellerQuery);

        $sendPhoneNumber = $sellerData['ph_num'];
        ## Send whatsapp notification if user registered successfully
        $sendPhoneNumber = $sendPhoneNumber;
        $fetchUserName = $sellerData['name'];
        // $pucheasedPrice = $sellerData['purchased_price'];
        $campaignName = "Final_post_close_msg";
        $params = [
            "$fetchUserName"
        ];
        $media = [
            "url" => $baseUrl . "/upload_content/whtasapp_assets/post_close.jpg",
            "filename" => "no_image.png"
        ];
        sendWhatsappMessage();
        $status = "success";
        $status_text = "Deal Status Updated Successfully";
    }
}

$buyerQuery = mysqli_query($con, "SELECT buyer_id FROM tbl_user_product_view WHERE view_id = '$view_id'");
$buyerData = mysqli_fetch_assoc($buyerQuery);
$rating_buyer_id = $buyerData['buyer_id'];

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
    'rating_buyer_id' => $rating_buyer_id,
    'rating_view_id' => $view_id

];
echo json_encode($response, true);
