<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$sub_category_id = mysqli_real_escape_string($con,$sendData['sub_category_id']);

$dataget = mysqli_query($con,"SELECT 
	sub_category_id,
	sub_category_name,
	active 
	FROM tbl_sub_category_master WHERE sub_category_id='".$sub_category_id."' ");
$data = mysqli_fetch_row($dataget);

$sub_category_id = $data[0];
$sub_category_name = $data[1];
$active = $data[2];

$response = [
	'sub_category_id' => $sub_category_id,
	'sub_category_name' => $sub_category_name,
	'active' => $active,
];
echo json_encode($response,true);
?>