<?php
include("../db/db.php");
header("Content-Type: application/json");

$response = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? '';
    $address_id = $_POST['address_id'] ?? '';

    if (empty($post_id) || empty($address_id)) {
        $response = [
            "status" => "Error",
            "status_text" => "Missing post_id or address_id"
        ];
        echo json_encode($response);
        exit;
    }

    // Sanitize input (basic)
    $post_id = mysqli_real_escape_string($con, $post_id);
    $address_id = mysqli_real_escape_string($con, $address_id);

    // Update tbl_product_master
    $sql = "UPDATE tbl_product_master 
            SET address_id = '$address_id', 
                is_draft = 0, 
                update_timestamp = NOW() 
            WHERE post_id = '$post_id'";

    if (mysqli_query($con, $sql)) {
        $response = [
            "status" => "PostSaved"
        ];
    } else {
        $response = [
            "status" => "Error",
            "status_text" => "Database error: " . mysqli_error($con)
        ];
    }
} else {
    $response = [
        "status" => "Error",
        "status_text" => "Invalid request method"
    ];
}

echo json_encode($response);

?>