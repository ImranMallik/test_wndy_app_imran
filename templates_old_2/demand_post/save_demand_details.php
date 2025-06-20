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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php'; // Include database connection

    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $sale_price = mysqli_real_escape_string($con, $_POST['sale_price']);
    $qty_type = mysqli_real_escape_string($con, $_POST['qty_type']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    $maxIdResult = mysqli_query($con, "SELECT MAX(demand_post_id) AS max_id FROM tbl_demand_post");
    $nextId = (int)mysqli_fetch_assoc($maxIdResult)['max_id'] + 1;

    $query = "INSERT INTO tbl_demand_post (
        demand_post_id,
            product_id,
            category_id,
            demand_post_name,
            demand_post_sale_price,
            demand_post_status,
            demand_post_by_id,
            entry_timestamp,
            description,
            brand,
            quantity,
            qty_type
            ) 
              VALUES (
              '$nextId',
              '$product_id',
              '$category_id',
              '$product_name',
              '$sale_price',
              'active',
              '$session_user_code',
               NOW(),
               '$description', 
              '$brand',
              '$quantity',
              '$qty_type')";

    if (mysqli_query($con, $query)) {
        echo json_encode(['success' => true]);
        $update_view_data = mysqli_query($con, "UPDATE tbl_user_product_view SET
      demand_post_item_status = 'Yes' WHERE buyer_id= $user_id");
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
    }

    mysqli_close($con);
}
