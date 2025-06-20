<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$user_id = mysqli_real_escape_string($con, $sendData['user_id']);

$dataget = mysqli_query($con, "SELECT 
            tbl_user_master.user_id,
            tbl_user_master.name, 
            tbl_user_master.country_code,
            tbl_user_master.ph_num,
            tbl_user_master.referral_id,
            tbl_user_master.under_buyer_id,
            tbl_user_master.user_type,
            tbl_user_master.entry_timestamp, 
            tbl_user_master.active,
            tbl_user_master.user_img,
            u2.name AS buyer_name,
            u2.ph_num AS buyer_ph_num
            FROM tbl_user_master 
            LEFT JOIN tbl_user_master AS u2 ON tbl_user_master.under_buyer_id = u2.user_id
            WHERE tbl_user_master.user_type='Collector' AND tbl_user_master.user_id='$user_id'");

if ($data = mysqli_fetch_assoc($dataget)) {
    $user_img = empty($data['user_img']) ? "default.png" : $data['user_img'];

    $response = [
        'user_id' => $data['user_id'],
        'name' => $data['name'],
        'country_code' => $data['country_code'],
        'ph_num' => $data['ph_num'],
        'referral_id' => $data['referral_id'],
        'under_buyer_id' => $data['under_buyer_id'],
        'buyer_name' => $data['buyer_name'],
        'buyer_ph_num' => $data['buyer_ph_num'],
        'active' => $data['active'],
        'user_img' => $user_img,
    ];
} else {
    $response = [
        'status' => 'error',
        'status_text' => 'No data found for the given user ID'
    ];
}

echo json_encode($response);
?>
