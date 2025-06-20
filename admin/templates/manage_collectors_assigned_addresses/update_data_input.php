<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$user_id = mysqli_real_escape_string($con, $sendData['user_id']);

$dataget = mysqli_query($con, "SELECT 
				tbl_user_master.user_id,
				tbl_user_master.name AS collector_name,
				tbl_user_master.ph_num AS collector_ph_num,
				tbl_user_master.under_buyer_id,
				tbl_buyer.name AS buyer_name,
				tbl_buyer.ph_num AS buyer_ph_num,
				tbl_address_master.address_id,
				tbl_address_master.country,
				tbl_address_master.state,
				tbl_address_master.city,
				tbl_address_master.landmark,
				tbl_address_master.pincode,
				tbl_address_master.address_line_1
			FROM tbl_address_master 
			LEFT JOIN tbl_user_master ON tbl_address_master.address_id = tbl_user_master.address_id
			LEFT JOIN tbl_user_master AS tbl_buyer ON tbl_user_master.under_buyer_id = tbl_buyer.user_id
			WHERE tbl_user_master.user_id ='" .$user_id. "' ");

$data = mysqli_fetch_row($dataget);

$response = [
	'user_id' => $data[0],
	'collector_name' => $data[1],
	'collector_ph_num' => $data[2],
	'under_buyer_id' => $data[3],
	'buyer_name' => $data[4],
	'buyer_ph_num' => $data[5],
	'address_id' => $data[6],
	'country' => $data[7],
	'state' => $data[8],
	'city' => $data[9],
	'landmark' => $data[10],
	'pincode' => $data[11],
	'address_line_1' => $data[12],
];
echo json_encode($response,true);
?>