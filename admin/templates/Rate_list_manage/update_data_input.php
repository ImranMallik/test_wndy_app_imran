<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$menu_code = mysqli_real_escape_string($con,$sendData['menu_code']);

$dataget = mysqli_query($con,"select 
	menu_code,
	menu_name,
	menu_icon,
	sub_menu_status,
	file_name,
	folder_name,
	order_num,
	active 
	from menu_master where menu_code='".$menu_code."' ");
$data = mysqli_fetch_row($dataget);

$menu_code = $data[0];
$menu_name = $data[1];
$menu_icon = $data[2];
$sub_menu_status = $data[3];
$file_name = $data[4];
$folder_name = $data[5];
$order_num = $data[6];
$active = $data[7];

$response[] = [
	'menu_code' => $menu_code,
	'menu_name' => $menu_name,
	'menu_icon' => $menu_icon,
	'sub_menu_status' => $sub_menu_status,
	'file_name' => $file_name,
	'folder_name' => $folder_name,
	'order_num' => $order_num,
	'active' => $active,
];
echo json_encode($response,true);
?>