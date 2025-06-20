<?php
include("../db/db.php");
include("../db/router.php");
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

           $history_res_buyer = mysqli_query($con, "SELECT 	deal_status_history FROM tbl_user_product_view WHERE product_id = '$product_id' AND buyer_id='$session_user_code' ");
     $history_row_buyer = mysqli_fetch_assoc($history_res_buyer);

// Decode existing JSON (if any)
     $current_history_buyer = [];
     if (!empty($history_row_buyer['deal_status_history'])) {
     $current_history_buyer = json_decode($history_row_buyer['deal_status_history'], true);
     if (!is_array($current_history_buyer)) {
        $current_history_buyer = []; // fallback if malformed
     }
     }

                $current_history_buyer[] = [
                  'status' => 'Under Negotiation',
                  'time' => $timestamp
                   ];

               $new_json_buyer = mysqli_real_escape_string($con, json_encode($current_history_buyer));
        // UPDATE in tbl_user_product_view
        mysqli_query($con, "UPDATE tbl_user_product_view SET 
            deal_status='Under Negotiation',
            negotiation_amount='" . $negotiation_amount . "', 
            negotiation_by='$session_user_type',
            mssg='$mssg',
            negotiation_date='$date',
            deal_status_history ='$new_json_buyer',
            entry_timestamp='$timestamp'
            WHERE buyer_id='$session_user_code' AND product_id='$product_id' ");

         //=========================== INSERT IN product_status_update_tbl TABLE =======================================
//     mysqli_query($con, "INSERT INTO product_status_update_tbl (
//     buyer_id,
//     product_id,
//     product_update_status
// ) VALUES (
//     '" . $session_user_code . "',
//     '" . $product_id . "',
//     'Under Negotiation'
// )");

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
                  'status' => 'Under Negotiation',
                  'time' => $timestamp
                   ];

               $new_json = mysqli_real_escape_string($con, json_encode($current_history));
                // Data Insert product_status_history this column 
            //     mysqli_query($con, "INSERT INTO tbl_product_master product_status_history = '" . $new_json . "'
            // WHERE product_id='$product_id'");

        // UPDATE in tbl_product_master
       mysqli_query($con, "UPDATE tbl_product_master SET 
    product_status = 'Under Negotiation',
    product_status_history = '$new_json'
    WHERE product_id = '$product_id'");



        // INSERT into message_history


      mysqli_query($con, "
    INSERT INTO message_history (
        user_id,
        product_id,
        message,
        created_at,
        updated_at
    ) VALUES (
        '$session_user_code',
        '$product_id',
        '$mssg',
        NOW(),
        NOW()
    )
");


        // seller will notified that buyer send request for a product
        $productDataget = mysqli_query($con, "select 
            tbl_product_master.product_name,
            tbl_product_master.user_id
            from tbl_product_master
            where tbl_product_master.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['product_name'];
        $seller_id = $productData['user_id'];

        $noti_title = "Buyer Sent a Price Request";
        $noti_details = "A buyer has sent a price request for purchasing your (" . $product_name . ") item.";
        $noti_url = $baseUrl . "/product-details/" . $product_id;
        $noti_to_user_id = $seller_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        ## seller will get sms if buyer send a offer request
        ## Fetch seller's phone number
        $sellerPhnNumDataGet = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE user_id = '$seller_id'");
        $sellerPhnNumData = mysqli_fetch_row($sellerPhnNumDataGet);
        $sellerPhnNum = $sellerPhnNumData[0];
        $sellerName = $sellerPhnNumData[1];

        if ($sellerPhnNum) {
            ## SMS notification
            $sendPhNum = $sellerPhnNum;
            $sendMssg = "Hi, You have received an offer against the item(s) you posted for Sale on WNDY. Please log into the app to check, negotiate and finalise the deal - ZAG Tech Solutions";
            sendSms();

            ## Whatsapp notification
            $sendPhoneNumber = $sellerPhnNum;
            $fetchUserName = $sellerName;
            $campaignName = "Final_offer_seller_notification02";
            $params = [
                "$fetchUserName",
                "$negotiation_amount"
            ];
            $media = [
                "url" => $baseUrl . "/upload_content/whtasapp_assets/offer_received.jpg",
                "filename" => "no_image.png"
            ];
            sendWhatsappMessage();
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
