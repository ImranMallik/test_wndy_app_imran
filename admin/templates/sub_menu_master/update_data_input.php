<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$sub_menu_code = mysqli_real_escape_string($con,$sendData['sub_menu_code']);

$query = "select 
		sub_menu_code,
		sub_menu_name,
		menu_icon,
		menu_code,
		file_name,
		folder_name,
		order_num,
		active
		from sub_menu_master where sub_menu_code='".$sub_menu_code."' ";
$dataget = mysqli_query($con,$query);
$data = mysqli_fetch_row($dataget);

$response[] = [
	'sub_menu_code' => $data[0],
	'sub_menu_name' => $data[1],
	'menu_icon' => $data[2],
	'menu_code' => $data[3],
	'file_name' => $data[4],
	'folder_name' => $data[5],
	'order_num' => $data[6],
	'active' => $data[7],
];
echo json_encode($response,true);
?>