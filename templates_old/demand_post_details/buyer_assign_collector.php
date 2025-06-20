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
    $collector_id = mysqli_real_escape_string($con, $sendData['collector_id']);

    $execute = 1;

    // check product valid or not
    if ($execute == 1) {
        $product_dataget = mysqli_query($con, "select * from tbl_demand_post where product_id='" . $product_id . "' ");
        $product_data = mysqli_fetch_row($product_dataget);
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {
        mysqli_query($con, "update tbl_demand_post_item_transactions set assigned_collecter='" . $collector_id . "' where buyer_id='" . $session_user_code . "' and product_id='" . $product_id . "' ");

        // collector will notified that buyer assigned him
        $productDataget = mysqli_query($con, "select 
                        tbl_demand_post.demand_post_name,
                        from tbl_demand_post
                        where tbl_demand_post.product_id='" . $product_id . "' ");
        $productData = mysqli_fetch_assoc($productDataget);
        $product_name = $productData['demand_post_name'];

        $noti_title = "New Item Assigned";
        $noti_details = "You Assigned For the " . $product_name . " item.";
        $noti_url = $baseUrl . "/demand_product_details/" . $product_id;
        $noti_to_user_id = $collector_id;
        $noti_from_user_id = $session_user_code;
        insertNotificationDetails();

        $status = "success";
        $status_text = "👍 Collector Assigned Successfully";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
