<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'], true);
$category_rate_list_id = mysqli_real_escape_string($con, $sendData['category_rate_list_id']);

$dataget = mysqli_query($con, "SELECT
	tbl_category_rate_list.category_rate_list_id,
	tbl_category_rate_list.category_id,
	tbl_category_master.category_name,
	tbl_category_rate_list.product_name,
	tbl_category_rate_list.lowest_price,
	tbl_category_rate_list.highest_price,
	tbl_category_rate_list.active
	FROM tbl_category_rate_list 
	LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_category_rate_list.category_id
	WHERE tbl_category_rate_list.category_rate_list_id = '" . $category_rate_list_id . "' ");

$data = mysqli_fetch_row($dataget);

$response = [
	'category_rate_list_id' => $data[0],
	'category_id' => $data[1],
	'category_name' => $data[2],
	'product_name' => $data[3],
	'lowest_price' => $data[4],
	'highest_price' => $data[5],
	'active' => $data[6],
];
echo json_encode($response, true);
