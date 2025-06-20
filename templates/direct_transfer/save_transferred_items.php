<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$response = [];

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "Session expired.";
} else {
    $sendData = json_decode($_POST['sendData'], true);

    $product_id = $sendData['product_id'];
    $category_id = mysqli_real_escape_string($con, $sendData['category_id']);
    $user_id = mysqli_real_escape_string($con, $sendData['user_id']);
    $price = mysqli_real_escape_string($con, $sendData['price']);
    $quantity = mysqli_real_escape_string($con, $sendData['quantity']);

    $timestamp = date('Y-m-d H:i:s'); 

    for ($i = 0; $i < count($product_id); $i++) {
        // Insert product transfer
        $insertTransferQuery = "
            INSERT INTO tbl_direct_transfer (
                direct_transfer_id,
                transferred_by_id,
                transferred_to_id,
                product_id,
                category_id,
                transferred_quantity,
                transferred_price,
                transferred_status,
                entry_timestamp
            ) VALUES (
                NULL,
                '$session_user_code',
                '$user_id',
                '$product_id[$i]',
                '$category_id',
                '$quantity',
                '$price',
                'Direct Transfer',
                '$timestamp'
            )";

        if (!mysqli_query($con, $insertTransferQuery)) {
            $status = "Error";
            $status_text = "Failed to transfer item.";
            echo json_encode([['status' => $status, 'status_text' => $status_text]]);
            exit;
        }

        // Update item status in user view table
        $updateStatusQuery = "
            UPDATE tbl_user_product_view SET
            transferred_items_status = 'Yes'
            WHERE buyer_id = $user_id AND product_id = '$product_id[$i]'
        ";

        if (!mysqli_query($con, $updateStatusQuery)) {
            $status = "Error";
            $status_text = "Failed to update item status.";
            echo json_encode([['status' => $status, 'status_text' => $status_text]]);
            exit;
        }
    }

    $status = "Success";
    $status_text = "Items transferred successfully.";
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];

header('Content-Type: application/json');
echo json_encode($response, true);
