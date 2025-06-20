<?php
include("../db/db.php");
include("../../module_function/notification_details.php");
include("../../module_function/sms_gateway_api.php");
include("../../module_function/whatsapp_notification.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {
    $sendData = json_decode($_POST['sendData'], true);
    if (!isset($_POST['sendData'])) {
        die(json_encode(['status' => 'error', 'message' => 'No data received']));
    }
    $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);
    $create_post_id = mysqli_real_escape_string($con, $sendData['create_post_id']);
    $negotiation_amount = mysqli_real_escape_string($con, $sendData['negotiation_amount']);
    $mssg = mysqli_real_escape_string($con, $sendData['mssg']);

    $execute = 1;

    // Check if the product is valid
    if ($execute == 1) {
        $product_dataget = mysqli_query($con, "SELECT * FROM tbl_create_post WHERE create_post_id='$create_post_id'");
        $product_data = mysqli_fetch_row($product_dataget);
        $product_id = $product_data[1];
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {
        // UPDATE in tbl_tbl_create_post_item_transactions
        mysqli_query($con, "UPDATE tbl_create_post_item_transactions SET 
            deal_status='Under Negotiation',
            negotiation_amount='" . $negotiation_amount . "', 
            mssg='$mssg',
            negotiation_date='$date',
            entry_timestamp='$timestamp'
            WHERE buyer_id='$session_user_code' AND product_id='$product_id' ");

        // UPDATE in tbl_product_master
        mysqli_query($con, "UPDATE tbl_create_post SET 
            product_status='Under Negotiation'
            WHERE product_id='$product_id' ");

        // seller will notified that buyer send request for a product
        $productDataget = mysqli_query($con, "select 
            tbl_create_post.create_post_name,
            tbl_create_post.create_post_by_id
            from tbl_create_post
            where tbl_create_post.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['create_post_name'];
        $seller_id = $productData['create_post_by_id'];

        $noti_title = "New Price Request";
        $noti_details = "One buyer send you a price request for purchase your's " . $product_name . " item";
        $noti_url = $baseUrl . "/create_post_details/" . $create_post_id;
        $noti_to_user_id = $seller_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        ## seller will get sms if buyer send a offer request
        ## Fetch seller's phone number
        $sellerPhnNumDataGet = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE user_id = '$seller_id'");
        $sellerPhnNumData = mysqli_fetch_row($sellerPhnNumDataGet);
        $sellerPhnNum = $sellerPhnNumData[0];
        $sellerName = $sellerPhnNumData[1];

        // if ($sellerPhnNum) {
        //     ## SMS notification
        //     $sendPhNum = $sellerPhnNum;
        //     $sendMssg = "Hi, You have received an offer against the item(s) you posted for Sale on WNDY. Please log into the app to check, negotiate and finalise the deal - ZAG Tech Solutions";
        //     sendSms();

        //     ## Whatsapp notification
        //     $sendPhoneNumber = $sellerPhnNum;
        //     $fetchUserName = $sellerName;
        //     $campaignName = "offer_seller_notification";
        //     $params = [
        //         "Nadim",
        //         97
        //     ];
        //     sendWhatsappMessage();
        // }

        $status = "success";
        $status_text = "Request Submitted Successfully";
    }
}

header('Content-Type: application/json');
$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log('JSON Error: ' . json_last_error_msg());
    echo json_encode(['status' => 'error', 'status_text' => 'JSON encoding error']);
} else {
    echo json_encode($response);
}
