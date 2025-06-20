<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode(file_get_contents('php://input'), true);

// Sanitize and retrieve input
$product_id = isset($sendData['product_id']) ? $sendData['product_id'] : '';
$product_name = isset($sendData['product_name']) ? $sendData['product_name'] : '';
$description = isset($sendData['description']) ? $sendData['description'] : '';
$quantity = isset($sendData['quantity']) ? $sendData['quantity'] : '';
$sale_price = isset($sendData['sale_price']) ? $sendData['sale_price'] : '';

// Update the post details in the database
$query = "UPDATE tbl_demand_post SET 
          demand_post_name = '$product_name', 
          description = '$description',
          quantity = '$quantity',
          demand_post_sale_price = '$sale_price'
          WHERE demand_post_id = '$product_id'";

// Execute the query
$result = mysqli_query($con, $query);

// Check for errors
if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update post']);
    exit();
}

echo json_encode(['status' => 'success', 'message' => 'Post updated successfully']);
mysqli_close($con);
?>
