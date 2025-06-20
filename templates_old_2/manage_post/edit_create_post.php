<?php
include("../db/db.php");
include("../db/activity.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize inputs to avoid SQL injection
$create_post_id = mysqli_real_escape_string($con, $sendData['create_post_id']);
$product_name = mysqli_real_escape_string($con, $sendData['product_name']);
$description = mysqli_real_escape_string($con, $sendData['description']);
$brand = mysqli_real_escape_string($con, $sendData['brand']);
$sale_price = mysqli_real_escape_string($con, $sendData['sale_price']);


echo json_encode($sendData);
echo json_encode($create_post_id);
echo json_encode($product_name);
echo json_encode($description);
echo json_encode($brand);
echo json_encode($sale_price);


// Check if all required data is provided
if (!empty($create_post_id) && !empty($product_name) && !empty($description) && !empty($brand) && !empty($sale_price)) {
    // Update query to modify the post details in the database
    $update_query = "
      UPDATE tbl_create_post 
        SET 
            create_post_name = '$product_name', 
            description = '$description', 
            brand = '$brand', 
            create_post_sale_price = '$sale_price'
        WHERE create_post_id = '$create_post_id'
    ";

    $result = mysqli_query($con, $update_query);
    if ($result) {
        echo json_encode(["status" => "success", "message" => "Post updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update post."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data."]);
}
