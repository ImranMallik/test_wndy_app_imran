<?php
include("../db/db.php");

// Decode received JSON data
$sendData = isset($_POST['sendData']) ? json_decode($_POST['sendData'], true) : null;
$sendDataIDs = isset($_POST['sendDataIDs']) ? json_decode($_POST['sendDataIDs'], true) : null;


$category_id_array = [];
if (!empty($sendData['category_id'])) {
    $category_id_array[] = mysqli_real_escape_string($con, $sendData['category_id']);
}

// Store product_ids in an array
$product_ids = isset($sendDataIDs['product_id']) ? $sendDataIDs['product_id'] : [];

$product_id_array = [];
if (!empty($product_ids)) {
    foreach ($product_ids as $id) {
        $product_id_array[] = mysqli_real_escape_string($con, $id);
    }
}


$product_id_list = implode(",", $product_id_array);
$category_id_list = implode(",", $category_id_array); 



$product_name_new = $description = $brand = "";

// ✅ Query Execution
if (!empty($product_id_list)) {
    $query = mysqli_query(
        $con,
        "SELECT 
            GROUP_CONCAT(DISTINCT product_name SEPARATOR ', ') AS product_name_new, 
            GROUP_CONCAT(DISTINCT description SEPARATOR ', ') AS description, 
            GROUP_CONCAT(DISTINCT brand SEPARATOR ', ') AS brand 
         FROM tbl_product_master 
         WHERE product_id IN ($product_id_list)"
    );

    if ($query && mysqli_num_rows($query) > 0) {
        $row_value = mysqli_fetch_assoc($query);
        $product_name_new = $row_value['product_name_new'];
        $description = $row_value['description'];
        $brand = $row_value['brand'];
    }
}

// ✅ Return JSON Response
echo json_encode([
    "status" => "success",
    "category_ids" => $category_id_array, 
    "product_ids" => $product_id_array,
    "product_name_new" => $product_name_new,
    "description" => $description,
    "brand" => $brand
]);
?>
