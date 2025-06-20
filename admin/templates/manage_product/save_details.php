<?php
include("../db/db.php");
include("../db/activity.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$activity_details = "";
$response = [];

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroyed In Manage Product Details";
} else {
    if ($entry_permission == 'Yes') {
        $sendData = json_decode($_POST['sendData'], true);

        // GET FILE DATA 
        $product_image_1_fl = $_FILES['product_image_1_fl'];

        $category_id = trim(mysqli_real_escape_string($con, $sendData['category_id']));
        $user_id = trim(mysqli_real_escape_string($con, $sendData['user_id']));
        $address_id = mysqli_real_escape_string($con, $sendData['address_id']);
        $product_name = trim(mysqli_real_escape_string($con, $sendData['product_name']));
        $description = strtolower(trim(mysqli_real_escape_string($con, $sendData['description'])));
        $brand = trim(mysqli_real_escape_string($con, $sendData['brand']));
        $quantity_pcs = mysqli_real_escape_string($con, $sendData['quantity_pcs']);
        $quantity_kg = mysqli_real_escape_string($con, $sendData['quantity_kg']);
        $sale_price = mysqli_real_escape_string($con, $sendData['sale_price']);
        $product_status = mysqli_real_escape_string($con, $sendData['product_status']);
        $active = mysqli_real_escape_string($con, $sendData['active']);
        $product_image_1 = mysqli_real_escape_string($con, $sendData['product_image_1']);
        $whithdrawl_reson = mysqli_real_escape_string($con, $sendData['whithdrawl_reson']);

        $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
        $closure_remark = isset($sendData['closure_remark']) ? mysqli_real_escape_string($con, $sendData['closure_remark']) : null;


        $product_img_FileType = pathinfo($product_image_1, PATHINFO_EXTENSION);
        if (!in_array($product_img_FileType, $allowedImgExt)) {
            $product_image_1 = "";
        }

        $execute = 1;
        $withdrawal_date = '';
        if (strtolower($product_status) == 'withdraw') {
        $withdrawal_date = date('Y-m-d H:i:s'); 
        }

        // Check file extension
        if ($execute == 1 && $product_image_1_fl) {
            $target_file = basename($product_image_1_fl["name"]);
            $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if (!in_array($FileType, $allowedImgExt)) {
                $status = "product_image_1 error";
                $execute = 0;
                $status_text = "File Type is Not Acceptable. Only jpg, jpeg, png, gif, webp, tiff, tif Accepted";
            }
        }

        // Check file size
        if ($execute == 1 && $product_image_1_fl) {
            $fileSize = $product_image_1_fl["size"];
            $getMaxFileSizeDataget = mysqli_query($con, "SELECT profile_image_max_kb_size FROM system_info WHERE 1 ");
            $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
            $getMaxFileSizeKb = $getMaxFileSizeData[0];
            $getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

            if ($fileSize > $getMaxFileSizeByets) {
                $status = "product_image_1 error";
                $execute = 0;
                $status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
            }
        }

        // Upload file 
        if ($execute == 1) {
            if ($product_image_1_fl) {
                $target_dir = "../../../upload_content/upload_img/product_img/";
                //current upload selected file name
                $target_file = basename($product_image_1_fl["name"]);
                //current upload selected file extension like .jpg/.png/.tif/.bmp etc
                $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
                //make a new file name like time+date+extention
                $image_name = $product_image_1;
                //uploaded file store into computer temp memory which store into varriable
                $temp_file = $product_image_1_fl["tmp_name"];
                //copy uploaded file store into desire path or location
                move_uploaded_file($temp_file, $target_dir . $image_name);
            }
        }

        // Insert and update
        if ($execute == 1) {
            if ($product_id == "") {
                mysqli_query($con, "INSERT INTO tbl_product_master (
                    product_name, 
                    category_id,
                    user_id, 
                    sale_price, 
                    description,
                    brand,
                    quantity_pcs,
                    quantity_kg,
                    product_status,
                    close_reason,
                    address_id,
                    active,
                    entry_user_code,
                    entry_timestamp) VALUES (
                        '$product_name',
                        '$category_id',
                        '$user_id',
                        '$sale_price',
                        '$description',
                        '$brand',
                         '$quantity_pcs',
                         '$quantity_kg',
                        '$product_status',
                         '$whithdrawl_reson',
                        '$address_id',
                        '$active',
                        " . ($closure_remark !== null ? "'$closure_remark'" : "NULL") . ",
                        '$session_user_code',
                        '$timestamp')");
                $product_id = mysqli_insert_id($con);

                mysqli_query($con, "INSERT INTO tbl_product_file (
                    file_type, file_name, product_id, active, entry_user_code, entry_timestamp) 
                    VALUES ('Photo', '$product_image_1', '$product_id', '$active', '$session_user_code', '$timestamp')");

                $status = "success";
                $status_text = "New Product Added Successfully";
                $activity_details = "You Inserted A Record In Manage Product Details";
            } else {
                mysqli_query($con, "UPDATE tbl_product_master SET  
                    product_name='$product_name', 
                    category_id='$category_id', 
                    user_id='$user_id', 
                    sale_price='$sale_price',
                    description='$description', 
                    brand='$brand',
                    quantity_pcs='$quantity_pcs',
                    quantity_kg='$quantity_kg',
                    product_status='$product_status',
                    close_reason='$whithdrawl_reson',
                    withdrawal_date='$withdrawal_date',
                    active='$active', 
                    closure_remark=" . ($closure_remark !== null ? "'$closure_remark'" : "NULL") . ",
                    entry_user_code='$session_user_code', 
                    update_timestamp='$timestamp' 
                    WHERE product_id='$product_id'");

                $dataget = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id='$product_id'");
                $data = mysqli_fetch_row($dataget);
                $previous_product_img = $data[0];

                if ($product_image_1 != "") {
                    mysqli_query($con, "UPDATE tbl_product_file SET file_name='$product_image_1', active='$active', entry_user_code='$session_user_code', update_timestamp='$timestamp' WHERE product_id='$product_id'");
                    if ($previous_product_img != "") {
                        unlink("../../../upload_content/upload_img/product_img/" . $previous_product_img);
                    }
                } else {
                    mysqli_query($con, "UPDATE tbl_product_file SET active='$active', entry_user_code='$session_user_code', update_timestamp='$timestamp' WHERE product_id='$product_id'");
                }

                $status = "Save";
                $status_text = "Product Details Updated Successfully";
                $activity_details = "You Updated A Record In Manage Product Details";
            }
        }
    } else {
        $status = "NoPermission";
        $status_text = "You Don't Have Permission To Enter Any Data !!";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);

if ($activity_details != "") {
    insertActivity($activity_details, $con, $session_user_code);
}
