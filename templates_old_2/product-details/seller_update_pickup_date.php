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

    $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);
    $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
    $view_id = mysqli_real_escape_string($con, $sendData['view_id']);
    $pickup_date = mysqli_real_escape_string($con, $sendData['pickup_date']);
    // $pickup_time = mysqli_real_escape_string($con, $sendData['pickup_time']);

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

        $dataget = mysqli_query($con, "select negotiation_amount from tbl_user_product_view where view_id='$view_id' ");
        $data = mysqli_fetch_row($dataget);
        $negotiation_amount = $data[0];

        // UPDATE in tbl_user_product_view
        mysqli_query($con, "UPDATE tbl_user_product_view SET 
            deal_status='Pickup Scheduled',
            purchased_price='" . $negotiation_amount . "',
            pickup_date='" . $pickup_date . "',
            entry_timestamp='$timestamp'
            WHERE view_id='$view_id' ");

        // UPDATE in tbl_user_product_view all request will be closed 
        mysqli_query($con, "UPDATE tbl_user_product_view SET 
            deal_status='Offer Rejected',
            entry_timestamp='$timestamp'
            WHERE view_id<>'$view_id' and product_id='$product_id' and seller_id='$session_user_code' ");

        // UPDATE in tbl_product_master
        mysqli_query($con, "UPDATE tbl_product_master SET 
            product_status='Pickup Scheduled'
            WHERE product_id='$product_id' ");

        // buyer & collector will be notified that seller accept and schedule the pickup for a product
        $dataget = mysqli_query($con, "select buyer_id, assigned_collecter, seller_id from tbl_user_product_view where view_id='" . $view_id . "' ");
        $data = mysqli_fetch_row($dataget);

        $buyer_id = $data[0];
        $assigned_collecter = $data[1];
        $seller_id = $data[2];

        $productDataget = mysqli_query($con, "select 
            tbl_product_master.product_name
            from tbl_product_master
            where tbl_product_master.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['product_name'];

       $noti_title = "Seller Update Pickup Date";
        $noti_details = "Date Fixed! The pickup for (" . $product_name . ") has been scheduled by the seller on (" . $pickup_date . ")";
        $noti_url = $baseUrl . "/product-details/" . $product_id;
        $noti_to_user_id = $buyer_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        // assigned collector not blank
        if ($assigned_collecter != "") {
            $noti_to_user_id = $assigned_collecter;
            insertNotificationDetails();
        }

        ## buyer & collector will get sms if seller has been accepted and scheduled for a pickup
        ## seller primary phone number gets
        $sellerPrimaryPhoneNumDataGet = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE user_id = '" . $seller_id . "'");
        $sellerPrimaryPhoneNumData = mysqli_fetch_row($sellerPrimaryPhoneNumDataGet);
        $sellerPrimaryPhoneNum = $sellerPrimaryPhoneNumData[0];
        $sellerName = $sellerPrimaryPhoneNumData[1];

        ## seller secondary phone number gets
        $sellerSecondaryPhoneNumDataGet = mysqli_query($con, "SELECT contact_ph_num FROM tbl_address_master WHERE user_id = '" . $seller_id . "'");
        $sellerSecondaryPhoneNumData = mysqli_fetch_row($sellerSecondaryPhoneNumDataGet);
        $sellerSecondaryPhoneNum = $sellerSecondaryPhoneNumData[0];

        ## buyer phone number gets
        $buyerPhoneNumDataGet = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE user_id = '" . $buyer_id . "'");
        $buyerPhoneNumData = mysqli_fetch_row($buyerPhoneNumDataGet);
        $buyerPhoneNum = $buyerPhoneNumData[0];
        $buyerName = $buyerPhoneNumData[1];

        ## collector phone number gets if not blank
        if ($assigned_collecter) {
            $collectorPhoneNumDataGet = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE user_id = '" . $assigned_collecter . "'");
            $collectorPhoneNumData = mysqli_fetch_row($collectorPhoneNumDataGet);
            $collectorPhoneNum = $collectorPhoneNumData[0];
            $collectorName = $collectorPhoneNumData[1];
        }
        ## Sending SMS to buyer
        if ($buyerPhoneNum) {
            // Buyer message
            $sendPhNum = $buyerPhoneNum;
            $sendMssg = "Please contact " . $sellerPrimaryPhoneNum . " / " . $sellerSecondaryPhoneNum . " to pickup the scrap items - ZAG Tech Solutions";
            sendSms();
            ## Send whatsapp notification to the buyer
            $sendPhoneNumber = $buyerPhoneNum;
            $fetchUserName = $sellerName;
            $BuyerName = $buyerName;
            $campaignName = "Pickup_conformation";
            $params = [
                "$BuyerName",
                "$fetchUserName"
            ];
            $media = [
                "url" => $baseUrl . "/upload_content/whtasapp_assets/pickup-complete.png",
                "filename" => "sample_media"
            ];
            sendWhatsappMessage();
        }

        ## Sending SMS to assigned collector if phone number is available
        if ($collectorPhoneNum) {
            // Collector message
            $sendPhNum = $collectorPhoneNum;
            $sendMssg = "Please contact " . $sellerPrimaryPhoneNum . " / " . $sellerSecondaryPhoneNum . " to pickup the scrap items - ZAG Tech Solutions";
            sendSms();

            // ## Send whatsapp notification to the buyer
            // $sendPhNum = $collectorPhoneNum;
            // $sendTextMessage = "Dear '" . $collectorName . "', Your offer is accpeted by the '" . $sellerName . "', kindly get the scrap collected on  Date & Time.";
            // sendWhatsappMessage();

        }

        $status = "success";
        $status_text = "Pickup Scheduled Successfully";
    }
}

header('Content-Type: application/json');
$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
