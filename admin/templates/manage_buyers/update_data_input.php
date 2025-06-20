<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$user_id = mysqli_real_escape_string($con, $sendData['user_id']);

$dataget = mysqli_query($con, "SELECT 
    tbl_user_master.user_id,
    tbl_user_master.name,
    tbl_user_master.country_code,
    tbl_user_master.ph_num,
    tbl_user_master.email_id,
    tbl_user_master.dob,
    tbl_user_master.pan_num,
    tbl_user_master.aadhar_num,
    tbl_user_master.gst_num,
    tbl_user_master.authorization_certificate_num,
    tbl_user_master.buyer_type,
	tbl_user_master.active,
    tbl_address_master.pincode,
    tbl_address_master.address_id,
    tbl_user_master.user_img
    FROM tbl_user_master
      LEFT JOIN tbl_address_master 
        ON tbl_user_master.address_id = tbl_address_master.address_id
    WHERE tbl_user_master.user_id='" . $user_id . "'");

if ($data = mysqli_fetch_assoc($dataget)) {
    $user_img = empty($data['user_img']) ? "default.png" : $data['user_img'];

    $response = [
        'status' => 'success',
        'user_id' => $data['user_id'],
        'name' => $data['name'],
        'country_code' => $data['country_code'],
        'ph_num' => $data['ph_num'],
        'email_id' => $data['email_id'],
        'address_id' => $data['address_id'],
        'dob' => $data['dob'],
        'pan_num' => $data['pan_num'],
        'aadhar_num' => $data['aadhar_num'],
        'gst_num' => $data['gst_num'],
        'authorization_certificate_num' => $data['authorization_certificate_num'],
        'buyer_type' => $data['buyer_type'],
        'active' => $data['active'],
        'pincode' => $data['pincode'] ?? '',
		'user_img' => $user_img,
    ];
} else {
    $response = [
        'status' => 'error',
        'status_text' => 'No data found for the given buyer ID'
    ];
}

echo json_encode($response, true);
?>
