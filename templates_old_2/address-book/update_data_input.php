<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'], true);
$address_id = mysqli_real_escape_string($con, $sendData['address_id']);
$user_id = $session_user_code; // Assuming session is started

// Get default address ID of the user
$default_address_query = mysqli_query($con, "SELECT address_id FROM tbl_user_master WHERE user_id = '$user_id'");
$default_data = mysqli_fetch_assoc($default_address_query);
$default_address_id = $default_data['address_id'];

// Get address details
$dataget = mysqli_query($con, "SELECT 
    address_id, contact_name, contact_ph_num, address_name, country, state, city, landmark, pincode, address_line_1 
    FROM tbl_address_master WHERE address_id = '$address_id'");

$data = mysqli_fetch_row($dataget);

// Prepare response
$response = [
    'address_id' => $data[0],
    'contact_name' => $data[1],
    'contact_ph_num' => $data[2],
    'address_name' => $data[3],
    'country' => $data[4],
    'state' => $data[5],
    'city' => $data[6],
    'landmark' => $data[7],
    'pincode' => $data[8],
    'address_line_1' => $data[9],
    'is_default' => ($data[0] == $default_address_id) ? 'Yes' : 'No'
];

echo json_encode($response);
