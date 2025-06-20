<?php
include("../db/db.php");
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

    $execute = 1;

    // Check if the product is valid
    if ($execute == 1) {
        $product_dataget = mysqli_query($con, "SELECT * FROM tbl_demand_post WHERE product_id='$product_id'");
        $product_data = mysqli_fetch_row($product_dataget);
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {
        // UPDATE in tbl_create_post_item_transactions
        mysqli_query($con, "UPDATE tbl_demand_post_item_transactions SET 
            deal_status='Completed',
            complete_date='" . $date . "', 
            entry_timestamp='$timestamp'
            WHERE view_id='$view_id' ");

        // seller will notified that buyer complete the pickup
        $productDataget = mysqli_query($con, "select 
            tbl_demand_post.demand_post_name,
            tbl_demand_post.demand_post_by_id
            from tbl_demand_post
            where tbl_demand_post.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['demand_post_name'];
        $seller_id = $productData['demand_post_by_id'];

        $noti_title = "Pickup Complete";
        $noti_details = "The " . $session_user_type . " successfully pickup your " . $product_name . " item";
        $noti_url = $baseUrl . "/demand_post_details/" . $product_id;
        $noti_to_user_id = $seller_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        ## send whatsapp notification to seller
        $sellerQuery = mysqli_query($con, "SELECT um.name, um.ph_num, uv.purchased_price 
                        FROM tbl_demand_post_item_transactions AS uv 
                        JOIN tbl_user_master AS um ON uv.seller_id = um.user_id 
                        WHERE uv.view_id = '$view_id' AND uv.deal_status='Completed'");
        $sellerData = mysqli_fetch_assoc($sellerQuery);

        $sendPhoneNumber = $sellerData['ph_num'];
        $sendTextMessage = "Dear '" . $sellerData['name'] . "', We hope your scrap is sold at INR '" . $sellerData['purchased_price'] . "', kinldy close the status of your post. So that you stops getting calls  from other buyer. If there is any discripence please do let us know. {Yes/No}";
        sendWhatsappMessage();

        $status = "success";
        $status_text = "Deal Status Updated Successfully";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
