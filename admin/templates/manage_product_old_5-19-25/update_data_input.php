<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize the input to prevent SQL injection
$product_id = mysqli_real_escape_string($con, $sendData['product_id']);

// Fetch seller data from the database
$dataget = mysqli_query($con,"SELECT 
        tbl_product_master.product_id,
        tbl_product_master.product_name,
        tbl_product_master.category_id,
		tbl_category_master.category_name,
        tbl_product_master.user_id,
		tbl_user_master.name,
        tbl_product_master.sale_price,
        tbl_product_master.description,
        tbl_product_master.brand,
        tbl_product_master.quantity,
        tbl_product_master.product_status,
        tbl_product_master.address_id,
		tbl_address_master.address_line_1,
        tbl_product_master.active,
		tbl_product_file.file_name
    FROM tbl_product_master
    LEFT JOIN tbl_product_file ON tbl_product_file.product_id = tbl_product_master.product_id
	LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
	LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_product_master.user_id 
	LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id 
    WHERE tbl_product_master.product_id = '$product_id'");

// Check if data was fetched
if ($data = mysqli_fetch_assoc($dataget)) {
    // Handle case where user_img might be empty
    $product_img = empty($data['file_name']) ? "no_image.png" : $data['file_name'];

    // Prepare response array
    $response = [
        'product_id' => $data['product_id'],
        'product_name' => $data['product_name'],
        'category_id' => $data['category_id'],
		'category_name' => $data['category_name'],
        'user_id' => $data['user_id'],
		'name' => $data['name'],
        'sale_price' => $data['sale_price'],
        'description' => $data['description'],
        'brand' => $data['brand'],
        'quantity' => $data['quantity'],
        'product_status' => $data['product_status'],
        'address_id' => $data['address_id'],
		'address_line_1' => $data['address_line_1'],
        'active' => $data['active'],
        'file_name' => $product_img,
    ];
} else {
    // Handle case where no data is found
    $response = [
        'error' => 'No Product found with the provided ID'
    ];
}

// Return the response as JSON
echo json_encode($response);
?>
