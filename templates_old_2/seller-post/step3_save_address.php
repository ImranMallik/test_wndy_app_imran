<?php
include("../db/db.php");
include("../../module_function/notification_details.php");
include("../../module_function/sms_gateway_api.php");
include("../../module_function/whatsapp_notification.php");
header("Content-Type: application/json");

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? '';
    $address_id = $_POST['address_id'] ?? '';
    $user_id = $session_user_code;
    $baseUrl = $_POST['baseUrl'] ?? ''; // Optional: make sure you pass this from frontend

    if (empty($post_id) || empty($address_id)) {
        $response = [
            "status" => "Error",
            "status_text" => "Missing post_id or address_id"
        ];
        echo json_encode($response);
        exit;
    }

    $post_id = mysqli_real_escape_string($con, $post_id);
    $address_id = mysqli_real_escape_string($con, $address_id);

    // Update tbl_product_master
    $updateQuery = "UPDATE tbl_product_master 
                    SET address_id = '$address_id', 
                        is_draft = 0, 
                        update_timestamp = NOW() 
                    WHERE post_id = '$post_id'";

    if (mysqli_query($con, $updateQuery)) {
        // Fetch product_id, category_id, user_id, product_name
        $productData = mysqli_query($con, "SELECT product_id, category_id, user_id, product_name 
                                           FROM tbl_product_master 
                                           WHERE post_id = '$post_id' LIMIT 1");
        $productRow = mysqli_fetch_assoc($productData);
        $product_id = $productRow['product_id'];
        $category_id = $productRow['category_id'];
        $product_name = $productRow['product_name'];

        // Get product image (first)
        $imgQuery = mysqli_query($con, "SELECT file_name FROM tbl_product_file 
                                        WHERE product_id = '$product_id' AND file_type = 'Photo' 
                                        ORDER BY entry_timestamp ASC LIMIT 1");
        $imgRow = mysqli_fetch_assoc($imgQuery);
        $product_image = $imgRow['file_name'] ?? 'no_image.png';

        // Get pincode
        $pinQuery = mysqli_query($con, "SELECT pincode FROM tbl_address_master WHERE address_id = '$address_id' LIMIT 1");
        $pincodeRow = mysqli_fetch_assoc($pinQuery);
        $pincode = $pincodeRow['pincode'];

        // Get category name
        $catQuery = mysqli_query($con, "SELECT category_name FROM tbl_category_master WHERE category_id = '$category_id' LIMIT 1");
        $catRow = mysqli_fetch_assoc($catQuery);
        $category_name = $catRow['category_name'];

        // Get all buyers in same pincode
        $buyersQuery = mysqli_query($con, "SELECT DISTINCT u.user_id, u.ph_num, u.name 
                                           FROM tbl_user_master u 
                                           LEFT JOIN tbl_address_master a ON a.user_id = u.user_id 
                                           WHERE u.user_type = 'Buyer' AND a.pincode = '$pincode'");

        while ($buyer = mysqli_fetch_assoc($buyersQuery)) {
            $buyer_id = $buyer['user_id'];
            $sendPhNum = $buyer['ph_num'];
            $buyer_name = $buyer['name'];

            // In-app notification
            insertNotificationDetails(
                $buyer_id,
                "New Post Available",
                "In your locality, a new post is available for $category_name. Click to view.",
                "$baseUrl/product-details/$product_id",
                $user_id
            );

            // SMS
            $sendMssg = "Dear Buyer, we have some scrap item(s) posted for sale in your location. Please log on to WNDY and check the app for details - ZAG Tech Solutions";
            sendSms(); // Ensure sendSms() uses global $sendPhNum and $sendMssg

            // WhatsApp
            $campaignName = "Final_post_creation_msg";
            $img_url = "$baseUrl/upload_content/upload_img/product_img/" . urlencode($product_image);
            $params = [$buyer_name, "$baseUrl/product-details/$product_id"];
            $media = [
                "url" => $img_url,
                "filename" => $product_image
            ];
            sendWhatsappMessage(); // Ensure this function uses $sendPhoneNumber, $params, $media, etc.
        }

        $response = [
            "status" => "PostSaved"
        ];
    } else {
        $response = [
            "status" => "Error",
            "status_text" => "Database error: " . mysqli_error($con)
        ];
    }
} else {
    $response = [
        "status" => "Error",
        "status_text" => "Invalid request method"
    ];
}

echo json_encode($response);
?>
