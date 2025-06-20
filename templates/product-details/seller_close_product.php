<?php
include("../db/db.php");

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
        $product_dataget = mysqli_query($con, "SELECT * FROM tbl_product_master WHERE product_id='$product_id'");
        $product_data = mysqli_fetch_row($product_dataget);
        if (!$product_data) {
            $status = "error";
            $status_text = "Product Details Not Found";
            $execute = 0;
        }
    }

    if ($execute == 1) {
        // UPDATE in tbl_product_master

// 1. Fetch existing history from DB
$history_res = mysqli_query($con, "
    SELECT product_status_history 
    FROM tbl_product_master 
    WHERE product_id = '$product_id'
");
$history_row = mysqli_fetch_assoc($history_res);

// 2. Decode existing JSON (if any)
$current_history = [];
if (!empty($history_row['product_status_history'])) {
    $current_history = json_decode($history_row['product_status_history'], true);
    if (!is_array($current_history)) {
        $current_history = []; // fallback
    }
}

// 3. Append new status at the end
$current_history[] = [
    'status' => 'Completed',
    'time' => $timestamp
];

// 4. Encode & escape JSON
$new_json = mysqli_real_escape_string($con, json_encode($current_history));

// 5. Update the product status + history
mysqli_query($con, "
    UPDATE tbl_product_master SET 
        product_status = 'Completed',
        product_status_history = '$new_json'
    WHERE product_id = '$product_id'
");


         //=========================== INSERT IN product_status_update_tbl TABLE =======================================
//     mysqli_query($con, "INSERT INTO product_status_update_tbl (
//     seller_id,
//     product_id,
//     product_update_status
// ) VALUES (
//     '" . $session_user_code . "',
//     '" . $product_id . "',
//     'Completed'
// )");


        $status = "success";
        $status_text = "Product Closed Successfully";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
