<?php
include("../db/db.php");
include("../../module_function/user_credit_details.php");
include("../../module_function/notification_details.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {

    $sendData = json_decode($_POST['sendData'], true);

    $create_post_id = mysqli_real_escape_string($con, $sendData['create_post_id']);
    $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);

    $userCreditBalance = getCreditBalance($session_user_code);

    $system_info_dataget = mysqli_query($con, "select product_view_credit from system_info where 1 ");
    $system_info_data = mysqli_fetch_row($system_info_dataget);
    $product_view_credit = $system_info_data[0];

    $execute = 1;

    // check credit balance
    if ($execute == 1) {
        if ($product_view_credit > $userCreditBalance) {
            $status = "balance error";
            $status_text = "Insufficient Credit Balance. Please purchase some credit";
            $execute = 0;
        }
    }

    // check product valid or not
    if ($execute == 1) {
        $product_dataget = mysqli_query($con, "select * from tbl_create_post where create_post_id='" . $create_post_id . "' ");
        $product_data = mysqli_fetch_row($product_dataget);
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {

        $product_dataget = mysqli_query($con, "select create_post_by_id ,product_id from tbl_create_post where create_post_id='" . $create_post_id . "' ");
        $product_data = mysqli_fetch_assoc($product_dataget);
        $seller_id = $product_data['create_post_by_id'];
        $product_id = $product_data['product_id'];

        $buyer_id = $session_user_code;
        $view_date = $date;
        $deal_status = "Credit Used";
        $product_status = "Post viewed";
        $trans_id = "WNDY" . uniqid() . time();

        //========================= INSERT IN tbl_create_post_item_transactionsTABLE =======================
        mysqli_query($con, "INSERT INTO tbl_create_post_item_transactions(
            trans_id,
            buyer_id,
            product_id,
            view_date, 
            seller_id,
            deal_status,      
            entry_user_code,
            entry_timestamp
        ) VALUES ( 
            '" . $trans_id . "',
            '" . $buyer_id . "',
            '" . $product_id . "',
            '" . $view_date . "',
            '" . $seller_id . "',
            '" . $deal_status . "',                   
            '" . $session_user_code . "',
            '" . $timestamp . "'
        )");

        $view_id = mysqli_insert_id($con);

        // ========================= UPDATE IN tbl_product_master TABLE =======================
        mysqli_query($con, "UPDATE tbl_create_post SET 
            product_status = '" . $product_status . "'
            WHERE create_post_id = '" . $create_post_id . "'
        ");

        // deduct credit from buyer
        $transBuyerId = $buyer_id;
        $transCredit = $product_view_credit;
        $transDate = $date;
        $transType = 'Product View Deduct';
        $transStatus = "Out";
        $credit_trans_id = insertCreditTransDetails();

        // update credit trans id in product_view_table
        mysqli_query($con, "UPDATE tbl_create_post_item_transactions SET 
        credit_trans_id='" . $credit_trans_id . "', 
        used_credits='" . $product_view_credit . "' 
        WHERE view_id='" . $view_id . "'");


        // seller will notified that buyer want to purchase 
        $productDataget = mysqli_query($con, "SELECT 
            tbl_create_post.create_post_name,
            tbl_create_post.create_post_by_id
          FROM tbl_create_post
          WHERE tbl_create_post.create_post_id = '$create_post_id'
          LIMIT 1");

        $productData = mysqli_fetch_assoc($productDataget);
        $product_name = $productData['create_post_name'];
        $seller_id = $productData['create_post_by_id'];

        $noti_title = "New Purchase Request";
        $noti_details = "One buyer send you a request for purchase your's " . $product_name . " item.";
        $noti_url = $baseUrl . "/create_post_details/" . $create_post_id;
        $noti_to_user_id = $seller_id;
        $noti_from_user_id = $session_user_code;
        // insertNotificationDetails();

        $status = "success";
        $status_text = "10 Credits Has Been Deducted. You can view seller details now for this product 🤩";
    }
}

$response = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response);
