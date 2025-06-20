<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'], true);
$address_id = mysqli_real_escape_string($con, $sendData['address_id']);

$dataget = mysqli_query($con, "SELECT
	tbl_address_master.address_id,
	tbl_address_master.user_id,
	tbl_user_master.name,
	tbl_user_master.ph_num,
	tbl_address_master.address_name,
	tbl_address_master.contact_name,
	tbl_address_master.contact_ph_num,
	tbl_address_master.country,
	tbl_address_master.state,
	tbl_address_master.city,
	tbl_address_master.landmark,
	tbl_address_master.pincode,
	tbl_address_master.address_line_1,
	tbl_user_master.seller_type
	FROM tbl_address_master 
	LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id
	WHERE tbl_address_master.address_id = '" . $address_id . "' ");

$data = mysqli_fetch_row($dataget);

// check this address is default address or not of the user
$default_address = "No";
$defaultAddressDataget = mysqli_query($con, "select * from tbl_user_master where user_id='" . $data[1] . "' and address_id='" . $data[0] . "' ");
$defaultAddressData = mysqli_fetch_row($defaultAddressDataget);
if ($defaultAddressData) {
	$default_address = "Yes";
}

$response = [
	'address_id' => $data[0],
	'user_id' => $data[1],
	'name' => $data[2],
	'ph_num' => $data[3],
	'address_name' => $data[4],
	'contact_name' => $data[5],
	'contact_ph_num' => $data[6],
	'country' => $data[7],
	'state' => $data[8],
	'city' => $data[9],
	'landmark' => $data[10],
	'pincode' => $data[11],
	'address_line_1' => $data[12],
	'default_address' => $default_address,
	'seller_type' => $data[13]
];
echo json_encode($response, true);
