<?php
include("../db/db.php");
// session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $session_user_code; // Ensure this session value is set correctly
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']); // The product_id to update
    $current_timestamp = date('Y-m-d H:i:s');

    // Check if the product_id exists for the given user_id
    $checkProductQuery = "SELECT product_id FROM tbl_product_master WHERE product_id = '$product_id' AND user_id = '$user_id' AND is_draft = 1 LIMIT 1";
    $checkProductResult = mysqli_query($con, $checkProductQuery);

    if (mysqli_num_rows($checkProductResult) > 0) {
        // If the product_id exists, proceed with updating the existing record
        $updateQuery = "UPDATE tbl_product_master SET 
            category_id = '$category_id',
            update_timestamp = '$current_timestamp'
            WHERE product_id = '$product_id' AND user_id = '$user_id' AND is_draft = 1";

        if (mysqli_query($con, $updateQuery)) {
            echo json_encode(["status" => "DraftUpdated", "status_text" => "Product draft updated successfully."]);
        } else {
            echo json_encode(["status" => "Error", "status_text" => mysqli_error($con)]);
        }
    } else {
        echo json_encode(["status" => "Error", "status_text" => "Product not found or invalid product_id."]);
    }
}
?>
