<?php
include("../db/db.php");
include("../db/activity.php");

$activity_details = "";
$status = "";
$status_text = "";

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroyed In Manage Menu Details";
} else {

    if ($entry_permission == 'Yes') {

        $sendData = json_decode($_POST['sendData'], true);
        $category_img_fl = $_FILES['category_img_fl'];

        $category_id = mysqli_real_escape_string($con, $sendData['category_id']);
        $category_name = mysqli_real_escape_string($con, $sendData['category_name']);
        $active = mysqli_real_escape_string($con, $sendData['active']);
        $category_img = mysqli_real_escape_string($con, $sendData['category_img']);
        $order_number = mysqli_real_escape_string($con, $sendData['order_number']);

        $allowedImgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'tiff', 'tif'];
        $execute = 1;

        // Check file extension
        if ($category_img_fl) {
            $target_file = basename($category_img_fl["name"]);
            $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if (!in_array($FileType, $allowedImgExt)) {
                $status = "category_img error";
                $execute = 0;
                $status_text = "File Type is Not Acceptable. Only jpg, jpeg, png, gif, webp, tiff, tif Accepted";
            }
        }

        // Check file size
        if ($execute == 1 && $category_img_fl) {
            $fileSize = $category_img_fl["size"];
            $getMaxFileSizeDataget = mysqli_query($con, "SELECT profile_image_max_kb_size FROM system_info WHERE 1");
            $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
            $getMaxFileSizeKb = $getMaxFileSizeData[0];
            $getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

            if ($fileSize > $getMaxFileSizeByets) {
                $status = "category_img error";
                $execute = 0;
                $status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
            }
        }

        // Upload file
        if ($execute == 1 && $category_img_fl) {
            $target_dir = "../../../upload_content/upload_img/category_img/";
            $image_name = $category_img;
            $temp_file = $category_img_fl["tmp_name"];
            move_uploaded_file($temp_file, $target_dir . $image_name);
        }

        if ($category_id == "") {
            // Check if category name already exists
            if ($execute == 1) {
                $dataget = mysqli_query($con, "SELECT * FROM tbl_category_master WHERE category_name='$category_name'");
                if (mysqli_fetch_row($dataget)) {
                    $status = "category_name Exists";
                    $status_text = "Category Name Already Exists!";
                    $execute = 0;
                }
            }

            if ($execute == 1) {
                mysqli_query($con, "INSERT INTO tbl_category_master (
                    category_id, 
                    category_name,
                    category_img,
                    order_number,
                    active, 
                    entry_user_code) VALUES (
                    NULL,
                    '$category_name',
                    '$category_img',
                    '$order_number',
                    '$active',
                    '$session_user_code')");

                $status = "Save";
                $status_text = "New Product Category Added Successfully";
                $activity_details = "You Inserted A New Record In Manage Category Details";
            }
        } else {
            // Check if category name already exists
            if ($execute == 1) {
                $dataget = mysqli_query($con, "SELECT * FROM tbl_category_master WHERE category_id<>'$category_id' AND category_name='$category_name'");
                if (mysqli_fetch_row($dataget)) {
                    $status = "category_name Exists";
                    $status_text = "Category Name Already Exists!";
                    $execute = 0;
                }
            }

            if ($execute == 1) {
                mysqli_query($con, "UPDATE tbl_category_master SET 
                    category_name='$category_name',
                    order_number='$order_number', 
                    active='$active', 
                    entry_user_code='$session_user_code', 
                    update_timestamp='$timestamp' 
                    WHERE category_id='$category_id'");

                // Update the category image if a new image is uploaded
                if ($category_img_fl && $category_img != "") {
                    $dataget = mysqli_query($con, "SELECT category_img FROM tbl_category_master WHERE category_id='$category_id'");
                    $data = mysqli_fetch_row($dataget);
                    $previous_category_img = $data[0];

                    if ($previous_category_img != "") {
                        unlink("../../../upload_content/upload_img/category_img/" . $previous_category_img);
                    }
                    mysqli_query($con, "UPDATE tbl_category_master SET category_img='$category_img' WHERE category_id='$category_id'");
                }

                $status = "Save";
                $status_text = "Product Category Updated Successfully";
                $activity_details = "You Updated A Record In Manage Category Details";
            }
        }
    } else {
        $status = "NoPermission";
        $status_text = "You Don't Have Permission To Entry Any Data!";
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
?>
