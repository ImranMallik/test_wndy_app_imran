<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$category_id = mysqli_real_escape_string($con,$sendData['category_id']);

$dataget = mysqli_query($con,"SELECT 
	category_id,
	category_name,
	category_img,
	order_number,
	active
	FROM tbl_category_master WHERE tbl_category_master.category_id='".$category_id."' ");
$data = mysqli_fetch_row($dataget);

$category_id = $data[0];
$category_name = $data[1];
$category_img = $data[2] == "" ? "no_image.png" : $data[2];
$order_number = $data[3];
$active = $data[4];

$response = [
	'category_id' => $category_id,
	'category_name' => $category_name,
	'category_img' => $category_img,
	'order_number' => $order_number,
	'active' => $active,
];
echo json_encode($response,true);
?>