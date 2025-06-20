<?php
include("../db/db.php");
include("../db/router.php");
include("../../module_function/notification_details.php");
include("../../module_function/sms_gateway_api.php");
include("../../module_function/whatsapp_notification.php");


// Print all POST data



mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($login == "No") {
        echo json_encode(["status" => "SessionDestroy", "status_text" => ""]);
        exit;
    }

    // Getting form data
    $product_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $sale_price = mysqli_real_escape_string($con, $_POST['expected_price']);
    $baseUrl = mysqli_real_escape_string($con, $_POST['baseUrl']);
    $address_id = mysqli_real_escape_string($con, $_POST['address_id']);
    $qty_unit = mysqli_real_escape_string($con, $_POST['unit']);
    $all_iamge = mysqli_real_escape_string($con, $_POST['images']);

    // Auto-generated post_id  
    $post_id = "POST" . time();
    $execute = 1;
    $status = "";
    $status_text = "";

    if ($execute == 1) {
        // Check if product already exists for the user
        $query = "SELECT * FROM tbl_product_master WHERE product_name = '$product_name' 
                  AND user_id = '$session_user_code' AND product_status='Active'";
        $dataget = mysqli_query($con, $query);
        $rw = mysqli_num_rows($dataget);

        if ($rw == 0) {
            // Insert into `tbl_product_master`
            mysqli_query($con, "INSERT INTO tbl_product_master (
                product_name, post_id, category_id, user_id, sale_price, description,   
                brand, quantity, address_id, entry_user_code,quantity_unit, entry_timestamp
            ) VALUES (
                '$product_name', '$post_id', '$category_id', '$session_user_code', '$sale_price', 
                '$description', '$brand', '$quantity', '$address_id', '$session_user_code','$qty_unit', NOW()
            )");

            $product_id = mysqli_insert_id($con);

            if ($product_id != "") {
                for ($i = 0; $i < $total_img_rw; $i++) {
                    $file_name = mysqli_real_escape_string($con, $product_img_array[$i]);

                    mysqli_query($con, "INSERT INTO tbl_product_file (
                                        file_type,
                                        file_name,
                                        product_id,
                                        entry_user_code,
                                        entry_timestamp
                                        ) VALUES (
                                        'Photo',
                                        '" . $file_name . "',
                                        '" . $product_id . "',
                                        '" . $session_user_code . "',
                                        '" . $timestamp . "'
                                )");
                }
            }
            sleep(2);
            ## product name gets
            $productNameDataGet = mysqli_query($con, "SELECT 
    p.product_name, 
    f.file_name,
    f.file_type
FROM tbl_product_master p
INNER JOIN tbl_product_file f ON p.product_id = f.product_id
WHERE p.product_id = '" . $product_id . "'");
            $productNameData = mysqli_fetch_row($productNameDataGet);
            $productName = $productNameData[0];
            $product_image = $productNameData[1];

            // Get address details (pincode)
            $address_dataget = mysqli_query($con, "SELECT pincode FROM tbl_address_master WHERE address_id='$address_id'");
            $pincode = mysqli_fetch_row($address_dataget)[0];

            // Get category name
            $category_dataget = mysqli_query($con, "SELECT category_name FROM tbl_category_master WHERE category_id='$category_id'");
            $category_name = mysqli_fetch_row($category_dataget)[0];

            // Get all buyers in the same pincode
            $dataget = mysqli_query($con, "SELECT DISTINCT(tbl_user_master.user_id)
                        FROM tbl_address_master 
                        LEFT JOIN tbl_user_master ON tbl_user_master.user_id=tbl_address_master.user_id
                        WHERE tbl_user_master.user_type='Buyer' AND tbl_address_master.pincode='$pincode'");
            while ($rw = mysqli_fetch_array($dataget)) {
                insertNotificationDetails(
                    $rw['user_id'],
                    "New Post Available",
                    "In your locality, a new post is available for $category_name. Click to view.",
                    "$baseUrl/product-details/$product_id",
                    $session_user_code
                );
            }

            // Notify buyers via SMS & WhatsApp
            $buyersQuery = "SELECT tbl_user_master.ph_num, tbl_user_master.name
                            FROM tbl_user_master 
                            LEFT JOIN tbl_address_master ON tbl_address_master.user_id = tbl_user_master.user_id
                            WHERE tbl_address_master.pincode = '$pincode' AND tbl_user_master.user_type = 'Buyer'";
            $buyersResult = mysqli_query($con, $buyersQuery);

            if (mysqli_num_rows($buyersResult) > 0) {
                while ($buyer = mysqli_fetch_assoc($buyersResult)) {
                    $sendPhNum = $buyer['ph_num'];
                    $sendMssg = "Dear Buyer, we have some scrap item(s) posted for sale in your location. Please log on to WNDY and check the app for details - ZAG Tech Solutions";
                    sendSms();
                    // Whatsapp notification
                    $sendPhoneNumber = $buyer['ph_num'];
                    $fetchUserName = $buyer['name'];
                    $campaignName = "Final_post_creation_msg_new";
                    $Link = $baseUrl . "/product-details/" . $product_id;
                    // $img_url = "https://tpecom.tpddt.shop/wndyapp-local/upload_content/upload_img/product_img/product_image_1_4-2-2025-1741097838345.jpg";
                    $params =
                        [
                            $fetchUserName,
                            $Link,
                        ];
                    // $media = [
                    //     "url" => $img_url,
                    //     "filename" => "no_image.png"
                    // ];
                    sendWhatsappMessage();
                }
            }
            $status = "Save";
            $status_text = "New Post Data Added Successfully";
        } else {
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

        // Handle image uploads
        // if (!empty($_FILES['images'])) {
        //     $uploadDir = "../../uploads/";

        //     if (!is_dir($uploadDir)) {
        //         mkdir($uploadDir, 0777, true);
        //     }

        //     foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        //         $file_name = mysqli_real_escape_string($con, $_FILES['images']['name'][$key]);
        //         $file_tmp = $_FILES['images']['tmp_name'][$key];
        //         $targetFilePath = $uploadDir . basename($file_name);

        //         if (move_uploaded_file($file_tmp, $targetFilePath)) {
        //             mysqli_query($con, "INSERT INTO tbl_product_file (
        //                 file_type, file_name, product_id, entry_user_code, entry_timestamp
        //             ) VALUES (
        //                 'Photo', '$file_name', '$product_id', '$session_user_code', NOW()
        //             )");
        //         }
        //     }
        // }


        if (!empty($_FILES['images']['name'][0])) {
            // Define upload path
            $uploadDir = "../../upload_content/upload_img/product_img/";

            // Ensure directories exist, create them if not
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $product_img_array = []; // Store uploaded filenames

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $originalFileName = $_FILES['images']['name'][$key]; // Get original filename
                $file_tmp = $_FILES['images']['tmp_name'][$key];
                // Extract file extension
                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                // Generate custom filename: product_image_{product_id}_{day-month-year}-{timestamp}.{ext}
                $customFileName = "product_image_" . $product_id . "_" . date("j-n-Y") . "-" . uniqid() . "." . $fileExtension;
                $targetFilePath = $uploadDir . $customFileName;

                // Move file to the upload directory
                if (move_uploaded_file($file_tmp, $targetFilePath)) {
                    $product_img_array[] = $customFileName;
                }
            }

            // Insert All Images into Database
            $total_img_rw = count($product_img_array);
            if ($product_id != "" && $total_img_rw > 0) {
                for ($i = 0; $i < $total_img_rw; $i++) {
                    $file_name = mysqli_real_escape_string($con, $product_img_array[$i]);

                    mysqli_query($con, "INSERT INTO tbl_product_file (
                                        file_type,
                                        file_name,
                                        product_id,
                                        entry_user_code,
                                        entry_timestamp
                                    ) VALUES (
                                        'Photo',
                                        '" . $file_name . "',
                                        '" . $product_id . "',
                                        '" . $session_user_code . "',
                                        NOW()
                                    )");
                }
            }
        }


        // handal multiple iamge
        if (!empty($_FILES['images']['name'][0])) {
        }
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode(["status" => $status, "status_text" => $status_text]);
exit;
