<?php
include("../db/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $session_user_code;
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']); // Get the product_id to update
    $timestamp = date('Y-m-d H:i:s');

    // Check if the product exists with the given product_id
    $checkProduct = mysqli_query($con, "SELECT product_id FROM tbl_product_master WHERE product_id = '$product_id' AND user_id = '$user_id' AND is_draft = 1 LIMIT 1");

    if (mysqli_num_rows($checkProduct) > 0) {
        // Product exists, proceed with the update
        $updateFields = [];

        // Update item name
        if (isset($_POST['item_name'])) {
            $item_name = mysqli_real_escape_string($con, $_POST['item_name']);
            $updateFields[] = "product_name = '$item_name'";
        }

        // Update description
        if (isset($_POST['description'])) {
            $description = mysqli_real_escape_string($con, $_POST['description']);
            $updateFields[] = "description = '$description'";
        }

        // Update brand
        if (isset($_POST['brand'])) {
            $brand = mysqli_real_escape_string($con, $_POST['brand']);
            $updateFields[] = "brand = '$brand'";
        }

        // Update quantity
        if (isset($_POST['quantity'])) {
            $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
            $updateFields[] = "quantity = '$quantity'";
        }

        // Update unit
        if (isset($_POST['unit'])) {
            $unit = mysqli_real_escape_string($con, $_POST['unit']);
            $updateFields[] = "quantity_unit = '$unit'";
        }

        // Update price
        if (isset($_POST['price'])) {
            $price = mysqli_real_escape_string($con, $_POST['price']);
            $updateFields[] = "sale_price = '$price'";
        }

        // If there are fields to update, proceed to update the database
        if (!empty($updateFields)) {
            $updateFields[] = "update_timestamp = '$timestamp'";
            $setClause = implode(", ", $updateFields);

            $updateQuery = "UPDATE tbl_product_master SET $setClause WHERE product_id = '$product_id' AND user_id = '$user_id' AND is_draft = 1";

            if (!mysqli_query($con, $updateQuery)) {
                echo json_encode(["status" => "Error", "status_text" => mysqli_error($con)]);
                exit;
            }
        }

        // ✅ Handle image upload (optional)
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = "../../upload_content/upload_img/product_img/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $originalFileName = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];
                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                // Validate file type (optional)
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                    continue; // skip unsupported types
                }

                $customFileName = "product_image_" . $product_id . "_" . date("j-n-Y") . "-" . uniqid() . "." . $fileExtension;
                $targetFilePath = $uploadDir . $customFileName;

                if (move_uploaded_file($file_tmp, $targetFilePath)) {
                    $safe_file_name = mysqli_real_escape_string($con, $customFileName);

                    mysqli_query($con, "INSERT INTO tbl_product_file (
                        file_type,
                        file_name,
                        product_id,
                        entry_user_code,
                        entry_timestamp
                    ) VALUES (
                        'Photo',
                        '$safe_file_name',
                        '$product_id',
                        '$user_id',
                        NOW()
                    )");
                }
            }
        }

        echo json_encode(["status" => "DraftUpdated", "status_text" => "Item details updated successfully."]);
    } else {
        echo json_encode(["status" => "Error", "status_text" => "Product not found or invalid product_id."]);
    }
}
?>
