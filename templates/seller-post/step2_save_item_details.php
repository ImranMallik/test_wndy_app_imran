<?php
include("../db/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $session_user_code;
    $post_id = mysqli_real_escape_string($con, $_POST['post_id']);
    $item_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    // ✅ New quantity fields
    $quantity_kg = mysqli_real_escape_string($con, $_POST['quantity_kg']);
    $quantity_pcs = isset($_POST['quantity_pcs']) ? mysqli_real_escape_string($con, $_POST['quantity_pcs']) : null;

    $timestamp = date('Y-m-d H:i:s');

    // Check if draft post exists
    $checkPost = mysqli_query($con, "SELECT product_id FROM tbl_product_master WHERE post_id = '$post_id' AND user_id = '$user_id' AND is_draft = 1 LIMIT 1");

    if (mysqli_num_rows($checkPost) > 0) {
        $row = mysqli_fetch_assoc($checkPost);
        $product_id = $row['product_id'];

        // ✅ Update query with new fields
        $updateQuery = "UPDATE tbl_product_master SET 
                            product_name = '$item_name', 
                            description = '$description', 
                            brand = '$brand', 
                            quantity_kg = '$quantity_kg', 
                            quantity_pcs = " . ($quantity_pcs !== null ? "'$quantity_pcs'" : "NULL") . ",
                            sale_price = '$price',
                            update_timestamp = '$timestamp'
                        WHERE post_id = '$post_id' 
                        AND user_id = '$user_id' 
                        AND is_draft = 1";

        if (mysqli_query($con, $updateQuery)) {
            // ✅ Handle image upload
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = "../../upload_content/upload_img/product_img/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $originalFileName = $_FILES['images']['name'][$key];
                    $file_tmp = $_FILES['images']['tmp_name'][$key];
                    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                    $customFileName = "product_image_" . $product_id . "_" . date("j-n-Y") . "-" . uniqid() . "." . $fileExtension;
                    $targetFilePath = $uploadDir . $customFileName;

                    if (move_uploaded_file($file_tmp, $targetFilePath)) {
                        $safe_file_name = mysqli_real_escape_string($con, $customFileName);

                        // mysqli_query($con, "INSERT INTO tbl_product_file (
                        //     file_type,
                        //     file_name,
                        //     product_id,
                        //     entry_user_code,
                        //     entry_timestamp
                        // ) VALUES (
                        //     'Photo',
                        //     '$safe_file_name',
                        //     '$product_id',
                        //     '$user_id',
                        //     NOW()
                        // )");
                    }
                }
            }

            echo json_encode(["status" => "DraftUpdated", "status_text" => "Item details updated successfully."]);
        } else {
            echo json_encode(["status" => "Error", "status_text" => mysqli_error($con)]);
        }

    } else {
        echo json_encode(["status" => "Error", "status_text" => "Invalid Post ID or Draft not found."]);
    }
}

?>
