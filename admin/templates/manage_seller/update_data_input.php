<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize the input to prevent SQL injection
$user_id = mysqli_real_escape_string($con, $sendData['user_id']);

// Fetch seller data from the database
$dataget = mysqli_query($con,"SELECT 
        tbl_user_master.user_id,
        tbl_user_master.name,
        tbl_user_master.country_code,
        tbl_user_master.ph_num,
        tbl_user_master.email_id,
        tbl_user_master.dob,
        tbl_user_master.pan_num,
        tbl_user_master.gst_num,
        tbl_user_master.seller_type,
        tbl_user_master.active,
        tbl_address_master.pincode,
        tbl_address_master.address_id,
        tbl_user_master.user_img
    FROM tbl_user_master
     LEFT JOIN tbl_address_master 
        ON tbl_user_master.address_id = tbl_address_master.address_id
    WHERE tbl_user_master.user_id = '$user_id'");

// $dataget = mysqli_query($con, $query);

// Check if data was fetched
if ($data = mysqli_fetch_assoc($dataget)) {
    // Handle case where user_img might be empty
    $user_img = empty($data['user_img']) ? "default.png" : $data['user_img'];

    // Prepare response array
    $response = [
        'user_id' => $data['user_id'],
        'name' => $data['name'],
        'country_code' => $data['country_code'],
        'ph_num' => $data['ph_num'],
        'email_id' => $data['email_id'],
        'dob' => $data['dob'],
        'pan_num' => $data['pan_num'],
        'gst_num' => $data['gst_num'],
        'seller_type' => $data['seller_type'],
        'active' => $data['active'],
        'user_img' => $user_img,
        'pincode' => $data['pincode'] ?? '',
        'address_id' => $data['address_id'] ?? ''
    ];
} else {
    // Handle case where no data is found
    $response = [
        'error' => 'No seller found with the provided ID'
    ];
}

// Return the response as JSON
echo json_encode($response);
?>
