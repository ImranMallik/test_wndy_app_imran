<?php
include("../db/db.php");

//  GET FILE DATA 
$product_img_fl = $_FILES['product_img_fl'];

$execute = 1;

// Check file extension
if ($execute == 1) {
    if ($product_img_fl) {
        $target_file = basename($product_img_fl["name"]);
        $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
        if (!in_array($FileType, $allowedImgExt)) {
            $status = "product_img error";
            $execute = 0;
            $status_text = "File Type Not Acceptable. Only jpg, jpeg, png, gif, webp, tiff, tif Accepted";
        }
    }
}

// Check file size
if ($execute == 1) {
    if ($product_img_fl) {
        $fileSize = $product_img_fl["size"];

        $getMaxFileSizeDataget = mysqli_query($con, "SELECT product_image_max_kb_size FROM system_info WHERE 1 ");
        $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
        $getMaxFileSizeKb = $getMaxFileSizeData[0];
        $getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

        if ($fileSize > $getMaxFileSizeByets) {
            $status = "product_img error";
            $execute = 0;
            $status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
        }
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
