<?php
include("../db/db.php");
include("../db/router.php");
include("../../module_function/notification_details.php");
include("../../module_function/sms_gateway_api.php");
include("../../module_function/whatsapp_notification.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");




if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($login == "No") {
        echo json_encode(["status" => "SessionDestroy", "status_text" => ""]);
        exit;
    }

    // **Get form data**
    $product_id = mysqli_real_escape_string($con, $_POST['product_id'] ?? '');
    $product_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $sale_price = mysqli_real_escape_string($con, $_POST['expected_price']);
    $baseUrl = mysqli_real_escape_string($con, $_POST['baseUrl']);
    $address_id = mysqli_real_escape_string($con, $_POST['address_id']);
    $qty_unit = mysqli_real_escape_string($con, $_POST['unit']);
    $removedImages = $_POST['removed_images'] ?? []; 

    $status = "";
    $status_text = "";

    // ✅ **Check if the product exists**
    $query = "SELECT * FROM tbl_product_master WHERE product_id = '$product_id' AND user_id = '$session_user_code'";
    $dataget = mysqli_query($con, $query);
    $rw = mysqli_num_rows($dataget);

    if ($rw > 0) {
        // ✅ **Update `tbl_product_master`**
        mysqli_query($con, "UPDATE tbl_product_master SET  
            product_name='$product_name', 
            category_id='$category_id', 
            sale_price='$sale_price', 
            description='$description', 
            brand='$brand', 
            quantity='$quantity', 
            address_id='$address_id', 
            quantity_unit='$qty_unit',
            entry_user_code='$session_user_code', 
            update_timestamp=NOW(),
               is_draft = IF(is_draft = 1, 0, is_draft)
            WHERE product_id='$product_id'");

        // ✅ **Delete Removed Images**
        if (!empty($removedImages)) {
            foreach ($removedImages as $removedImage) {
                $filePath = "../../upload_content/upload_img/product_img/" . mysqli_real_escape_string($con, $removedImage);
                if (file_exists($filePath)) {
                    unlink($filePath); // Delete file from server
                }
                mysqli_query($con, "DELETE FROM tbl_product_file WHERE product_id = '$product_id' AND file_name = '$removedImage'");
            }
        }

        // ✅ **Upload New Images**
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = "../../upload_content/upload_img/product_img/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $product_img_array = [];

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $originalFileName = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];
                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $customFileName = "product_image_" . $product_id . "_" . date("j-n-Y") . "-" . uniqid() . "." . $fileExtension;
                $targetFilePath = $uploadDir . $customFileName;

                if (move_uploaded_file($file_tmp, $targetFilePath)) {
                    $product_img_array[] = $customFileName;
                }
            }

            // Insert New Images into Database
            if (!empty($product_img_array)) {
                foreach ($product_img_array as $file_name) {
                    mysqli_query($con, "INSERT INTO tbl_product_file (
                                        file_type,
                                        file_name,
                                        product_id,
                                        entry_user_code,
                                        entry_timestamp
                                    ) VALUES (
                                        'Photo',
                                        '" . mysqli_real_escape_string($con, $file_name) . "',
                                        '" . $product_id . "',
                                        '" . $session_user_code . "',
                                        NOW()
                                    )");
                }
            }
        }

        // ✅ **Get Updated Product Data**
        $productDataQuery = mysqli_query($con, "SELECT product_name FROM tbl_product_master WHERE product_id = '$product_id'");
        $productData = mysqli_fetch_row($productDataQuery);
        $productName = $productData[0];

        // ✅ **Get Address & Category Details**
        $addressQuery = mysqli_query($con, "SELECT pincode FROM tbl_address_master WHERE address_id='$address_id'");
        $pincode = mysqli_fetch_row($addressQuery)[0];

        $categoryQuery = mysqli_query($con, "SELECT category_name FROM tbl_category_master WHERE category_id='$category_id'");
        $category_name = mysqli_fetch_row($categoryQuery)[0];

        // ✅ **Send Notifications to Buyers**
        $buyersQuery = "SELECT tbl_user_master.user_id, tbl_user_master.ph_num, tbl_user_master.name
                        FROM tbl_user_master 
                        LEFT JOIN tbl_address_master ON tbl_address_master.user_id = tbl_user_master.user_id
                        WHERE tbl_address_master.pincode = '$pincode' AND tbl_user_master.user_type = 'Buyer'";

        $buyersResult = mysqli_query($con, $buyersQuery);
        if (mysqli_num_rows($buyersResult) > 0) {
            while ($buyer = mysqli_fetch_assoc($buyersResult)) {
                insertNotificationDetails(
                    $buyer['user_id'],
                    "Updated Post Available",
                    "A post in category $category_name has been updated. Check it now!",
                    "$baseUrl/product-details/$product_id",
                    $session_user_code
                );

                // ✅ Send SMS Notification
                sendSms($buyer['ph_num'], "Dear Buyer, an item in your area has been updated on WNDY. Check the app for details - ZAG Tech Solutions");

                // ✅ Send WhatsApp Notification
                sendWhatsappMessage($buyer['ph_num'], [
                    $buyer['name'],
                    "$baseUrl/product-details/$product_id"
                ]);
            }
        }else{

    // Update `tbl_product_master`
    mysqli_query($con, "UPDATE tbl_product_master SET  
product_name='$product_name', category_id='$category_id', 
sale_price='$sale_price', description='$description', brand='$brand', 
quantity='$quantity', address_id='$address_id', 
entry_user_code='$session_user_code', update_timestamp=NOW()
WHERE product_id='$product_id'");

    $status = "Save";
    $status_text = "Post Data Updated Successfully";

        }

        $status = "Updated";
        $status_text = "Product Updated Successfully";
    } else {
        $status = "Error";
        $status_text = "Product Not Found or Unauthorized";
    }
}


header('Content-Type: application/json');
echo json_encode(["status" => $status, "status_text" => $status_text]);
exit;
