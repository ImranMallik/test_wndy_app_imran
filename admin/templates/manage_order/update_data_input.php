<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$request_id = mysqli_real_escape_string($con, $sendData['request_id']);

$dataget = mysqli_query($con, "SELECT
		tbl_buy_request.request_id,
		tbl_buyer_master.buyer_name,
		tbl_buy_request.buyer_id,
		tbl_product_master.product_name,
		tbl_buy_request.product_id,
		tbl_seller_master.seller_name,
		tbl_buy_request.seller_id,
		tbl_buy_request.seen_status,
		tbl_buy_request.note
		FROM tbl_buy_request
		LEFT JOIN tbl_buyer_master ON tbl_buyer_master.buyer_id = tbl_buy_request.buyer_id 
		LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_buy_request.product_id 
		LEFT JOIN tbl_seller_master ON tbl_seller_master.seller_id = tbl_buy_request.seller_id
		WHERE tbl_buy_request.request_id='".$request_id."' ");

$data = mysqli_fetch_row($dataget);

$response[] = [
	'request_id' => $data[0],
	'buyer_name' => $data[1],
	'buyer_id' => $data[2],
	'product_name' => $data[3],
	'product_id' => $data[4],
	'seller_name' => $data[5],
	'seller_id' => $data[6],
	'seen_status' => $data[7],
	'note' => $data[8],
];

echo json_encode($response,true);
?>