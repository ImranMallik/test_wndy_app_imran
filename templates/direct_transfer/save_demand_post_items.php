<?php

include("../db/db.php");

// Disable foreign key checks
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

// Response initialization
$response = [];

// Check if the session is valid
if ($login == "No") {
    $response = [
        'status' => "SessionDestroy",
        'status_text' => "Session expired."
    ];
    echo json_encode($response);
    exit;
}

// Decode incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

$product_ids = isset($sendData['product_id']) ? $sendData['product_id'] : [];
$user_id = $session_user_code;
$product_name = mysqli_real_escape_string($con, $sendData['product_name']);
$category_id = mysqli_real_escape_string($con, $sendData['category_id']);
$description = mysqli_real_escape_string($con, $sendData['description']);
$sale_price = mysqli_real_escape_string($con, $sendData['sale_price']);
$brand = mysqli_real_escape_string($con, $sendData['brand']);
$address = mysqli_real_escape_string($con, $sendData['address']);
$product_img_array = isset($sendData['product_img_array']) ? $sendData['product_img_array'] : [];
$total_img_rw = mysqli_real_escape_string($con, $sendData['total_img_rw']);

$product_id_index = 0;

// Calculate total quantity
$quantityQuery = "
    SELECT SUM(quantity) AS total_quantity 
    FROM tbl_product_master 
    WHERE product_id IN ('" . implode("','", $product_ids) . "')";
$result = mysqli_query($con, $quantityQuery);
$quantityData = mysqli_fetch_assoc($result);
$total_quantity = isset($quantityData['total_quantity']) ? $quantityData['total_quantity'] : [];

// Initialize status variables
$status = "Error";
$status_text = "An error occurred.";

foreach ($product_ids as $product_id) {
    $product_id = mysqli_real_escape_string($con, $product_id);

    // Fetch next create_post_id
    $maxIdResult = mysqli_query($con, "SELECT MAX(demand_post_id) AS max_id FROM tbl_demand_post");
    $nextId = (int)mysqli_fetch_assoc($maxIdResult)['max_id'] + 1;

    if (!empty($product_id)) {
        // Insert new product post
        $insertQuery = "INSERT INTO tbl_demand_post (
            demand_post_id,
            product_id,
            category_id,
            demand_post_name,
            demand_post_sale_price,
            demand_post_status,
            demand_post_by_id,
            entry_timestamp,
            description,
            demand_post_address,
            brand
        ) VALUES (
            '$nextId',
            '$product_id',
            '$category_id',
            '$product_name',
            '$sale_price',
            'active',
            '$user_id',
            NOW(),
            '$description',
            '$address',
            '$brand'
        )";
        $insertResult = mysqli_query($con, $insertQuery);

        // Check if insert was successful
        if ($insertResult) {
            $status = "Save";
            $status_text = "New Post Data Added Successfully";
        } else {
            $status = "Error";
            $status_text = "Failed to insert post data.";
        }

        $product_id = mysqli_insert_id($con);
    }

    // Optional: Insert product images (if needed)

    foreach ($product_img_array as $file_name) {
        $file_name = mysqli_real_escape_string($con, $file_name);
        $imageQuery = "
            INSERT INTO tbl_demand_post_file(
                file_type,
                file_name,
                product_id,
                entry_user_code,
                entry_timestamp,
                demand_post_id
            ) VALUES (
                'Photo',
                '$file_name',
                '$product_id',
                '$session_user_code',
                NOW(),
                '$nextId'
            )";
        mysqli_query($con, $imageQuery);
    }
    mysqli_query($con, "UPDATE tbl_user_product_view SET
      demand_post_item_status = 'Yes' WHERE buyer_id= $user_id");
}

// Add response and return JSON
$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response);