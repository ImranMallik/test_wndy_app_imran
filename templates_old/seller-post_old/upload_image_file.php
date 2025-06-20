<?php
require_once "../db/db.php";

// Get all POST data
if (isset($_POST['sendData'])) {
    $postData = json_decode($_POST['sendData'], true);
    $file_name = mysqli_real_escape_string($con, $postData['file_name']);
    $type = mysqli_real_escape_string($con, $postData['type']);

    // Get uploaded file data
    if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === UPLOAD_ERR_OK) {
        $uploaded_file = $_FILES['uploaded_file'];
        $target_dir = "../../upload_content/upload_img/product_img/";

        // Create unique file name
        $image_name = $file_name;
        $temp_file = $uploaded_file['tmp_name'];

        // Move file to target directory
        if (move_uploaded_file($temp_file, $target_dir . $image_name)) {
            $status = "Success";
            $message = $type . " Uploaded Successfully";
        } else {
            $status = "Error";
            $message = "Failed to upload " . $type . ".";
        }
    } else {
        $status = "Error";
        $message = "No file uploaded or an error occurred.";
    }

    $response = [
        'status' => $status,
        'message' => $message,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    $response = [
        'status' => "Error",
        'message' => "No data received.",
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
