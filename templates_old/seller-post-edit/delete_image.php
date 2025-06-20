<?php
include("../db/db.php");

$response = [];

file_put_contents("debug_log.txt", "Script started\n", FILE_APPEND);

if (!empty($_POST['image_name'])) {
    file_put_contents("debug_log.txt", "Received image_name: " . $_POST['image_name'] . "\n", FILE_APPEND);

    $imageName = trim(mysqli_real_escape_string($con, $_POST['image_name']));
    $imagePath = "../../upload_content/upload_img/product_img/" . $imageName;

    $checkQuery = mysqli_query($con, "SELECT * FROM tbl_product_file WHERE file_name = '$imageName' LIMIT 1");

    if (mysqli_num_rows($checkQuery) > 0) {
        file_put_contents("debug_log.txt", "Image found in DB\n", FILE_APPEND);

        $deleteQuery = mysqli_query($con, "DELETE FROM tbl_product_file WHERE file_name = '$imageName'");

        if ($deleteQuery) {
            file_put_contents("debug_log.txt", "Deleted from DB successfully\n", FILE_APPEND);

            $response = [
                "status" => "success",
                "message" => "Image deleted successfully."
            ];
        } else {
            file_put_contents("debug_log.txt", "Failed to delete from DB\n", FILE_APPEND);

            $response = [
                "status" => "error",
                "message" => "Failed to delete from database."
            ];
        }
    } else {
        file_put_contents("debug_log.txt", "Image not found in DB\n", FILE_APPEND);

        $response = [
            "status" => "error",
            "message" => "Image not found in database."
        ];
    }
} else {
    file_put_contents("debug_log.txt", "No image_name received\n", FILE_APPEND);

    $response = [
        "status" => "error",
        "message" => "No image name received."
    ];
}

echo json_encode($response);
