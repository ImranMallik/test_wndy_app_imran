<?php
include("../db/db.php");
include("../../module_function/notification_details.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


// $user_type_data_get = mysqli_query($con, "SELECT address_id FROM tbl_address_master WHERE user_id=$session_user_code");
// $address_id = mysqli_fetch_row($user_type_data_get);
// $address_id = $address_id[0];
// echo json_encode("Addresss Id", $address_id);
// Disable foreign key checks
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

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
$baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);
// $address_id = mysqli_real_escape_string($con, $sendData['address_id']);
// $product_img_array = isset($sendData['product_img_array']) ? $sendData['product_img_array'] : [];
// $total_img_rw = mysqli_real_escape_string($con, $sendData['total_img_rw']);

$product_ids_escaped = array_map(function ($product_id) use ($con) {
    return mysqli_real_escape_string($con, $product_id);
}, $product_ids);

// /Fetch all the images associated with the products
$fetchImages = mysqli_query($con, "SELECT file_type, file_name FROM tbl_product_file WHERE product_id IN ('" . implode("','", $product_ids_escaped) . "')");
$product_img_array = mysqli_fetch_all($fetchImages, MYSQLI_ASSOC);
// print_r($product_img_array);




// Calculate total quantity
$quantityQuery = "
    SELECT SUM(quantity) AS total_quantity
    FROM tbl_product_master 
    WHERE product_id IN ('" . implode("','", $product_ids) . "')";
$result = mysqli_query($con, $quantityQuery);
$quantityData = mysqli_fetch_assoc($result);
$total_quantity = $quantityData['total_quantity'] ?? 0;

// Fetch next create_post_id ONCE
$maxIdResult = mysqli_query($con, "SELECT MAX(create_post_id) AS max_id FROM tbl_create_post");
$nextCreatePostId = (int)mysqli_fetch_assoc($maxIdResult)['max_id'] + 1;

// Initialize status variables
$status = "Error";
$status_text = "An error occurred.";

// Insert products into tbl_create_post
foreach ($product_ids as $product_id) {
    $product_id = mysqli_real_escape_string($con, $product_id);

    if (!empty($product_id)) {
        $insertQuery = "
        INSERT INTO tbl_create_post (
            create_post_id,
            product_id,
            category_id,
            create_post_name,
            create_post_sale_price,
            create_post_status,
            create_post_by_id,
            entry_timestamp,
            description,
            quantity,
            brand
        ) VALUES (
            '$nextCreatePostId',
            '$product_id',
            '$category_id',
            '$product_name',
            '$sale_price',
            'active',
            '$session_user_code',
            NOW(),
            '$description',
            '$total_quantity',
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
    }
}

// Insert images for all products, associating them with the same create_post_id
// Variable to keep track of the current image index
$currentImageIndex = 0;

// Insert images for all products, associating them with the same create_post_id
foreach ($product_ids as $product_id) {
    $product_id = mysqli_real_escape_string($con, $product_id);

    // Check if there's an image available at the current index
    if (isset($product_img_array[$currentImageIndex])) {
        $file = $product_img_array[$currentImageIndex];
        $file_name = mysqli_real_escape_string($con, $file['file_name']);

        // Insert into database
        $imageQuery = "
            INSERT INTO tbl_create_post_file (
                file_type,
                file_name,
                create_post_id,
                product_id,
                entry_user_code,
                entry_timestamp
            ) VALUES (
                'Photo',
                '$file_name',
                '$nextCreatePostId',
                '$product_id',
                '$session_user_code',
                NOW()
            )";

        // Execute the query
        if (!mysqli_query($con, $imageQuery)) {
            echo "Error: " . mysqli_error($con);
            exit;
        }

        $currentImageIndex++;
    } else {
        break;
    }
}
// // Update create_post_item_status for the user
// mysqli_query($con, "UPDATE tbl_user_product_view SET
//   create_post_item_status = 'Yes' WHERE buyer_id = $user_id");

// $address_dataget = mysqli_query($con, "select pincode from tbl_address_master where address_id='" . $address_id . "' ");
// $address_data = mysqli_fetch_row($address_dataget);
// $pincode = $address_data[0];

// // category details get
$category_dataget = mysqli_query($con, "select category_name from tbl_category_master where category_id='" . $category_id . "' ");
$category_data = mysqli_fetch_row($category_dataget);
$category_name = $category_data[0];


// }
// Add response and return JSON
$dataget = mysqli_query($con, "SELECT um.user_id
FROM tbl_user_master AS um
INNER JOIN tbl_address_master AS am 
ON um.user_id = am.user_id
WHERE um.user_type = 'Buyer'
  AND um.user_id != '$session_user_code'
  AND am.pincode IN (
      SELECT pincode
      FROM tbl_address_master
      WHERE user_id = '$session_user_code'
  ) ");

while ($rw = mysqli_fetch_array($dataget)) {
    $noti_title = "New Post Available";
    $noti_details = "In your locality new  post available of " . $category_name . ". click for view the item";
    $noti_url = $baseUrl . "/create_post_details/" . $product_id;
    $noti_to_user_id = $rw['user_id'];
    $noti_from_user_id = $session_user_code;
    insertNotificationDetails();
}
$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response);
