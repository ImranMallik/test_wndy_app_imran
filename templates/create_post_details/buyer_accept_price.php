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
    $create_post_id = mysqli_real_escape_string($con, $sendData['create_post_id']);

    $execute = 1;

    // Check if the product is valid
    if ($execute == 1) {
        $product_dataget = mysqli_query($con, "SELECT * FROM tbl_create_post WHERE create_post_id='$create_post_id'");
        $product_data = mysqli_fetch_row($product_dataget);
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {

        // product dataget
        $dataget = mysqli_query($con, "select create_post_sale_price, product_id from tbl_create_post where create_post_id='" . $create_post_id . "' ");
        $data = mysqli_fetch_assoc($dataget);
        $purchased_price = $data['create_post_sale_price'];
        $product_id = $data['product_id'];

        // get buyer product view data
        $dataget = mysqli_query($con, "select negotiation_amount from tbl_create_post_item_transactions where buyer_id='" . $session_user_code . "' and product_id='" . $product_id . "' ");
        $data = mysqli_fetch_assoc($dataget);

        if ($data['negotiation_amount'] != 0) {
            $purchased_price = $data['negotiation_amount'];
        }

        // UPDATE in tbl_create_post_item_transactions
        mysqli_query($con, "UPDATE tbl_create_post_item_transactions SET 
            deal_status='Offer Accepted',
            negotiation_amount='" . $purchased_price . "',
            accept_date='" . $date . "'
            WHERE buyer_id='$session_user_code' AND product_id='$product_id' ");

        // Update product status
        mysqli_query($con, "UPDATE tbl_create_post SET 
            product_status='Offer Accepted'
            WHERE product_id='$product_id' ");

        // seller will notified that buyer accept product price
        $productDataget = mysqli_query($con, "select 
            tbl_create_post.create_post_name,
            tbl_create_post.create_post_by_id
            from tbl_create_post
            where tbl_create_post.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);

        $product_name = $productData['create_post_name'];
        $seller_id = $productData['create_post_by_id'];

        $noti_title = "Buyer Accept Item";
        $noti_details = "One buyer accept your item price ";
        $noti_url = $baseUrl . "/create_post_details/" . $create_post_id;
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
