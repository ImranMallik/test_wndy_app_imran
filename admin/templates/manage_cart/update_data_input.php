<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$cart_id = mysqli_real_escape_string($con,$sendData['cart_id']);

$dataget = mysqli_query($con, "SELECT tbl_buyer_cart.cart_id,
			tbl_buyer_master.buyer_id, 
			tbl_buyer_master.buyer_name, 
			tbl_buyer_master.ph_num,
			tbl_product_master.product_id,
			tbl_product_master.product_name
			FROM
			tbl_buyer_cart
			LEFT JOIN tbl_buyer_master ON tbl_buyer_master.buyer_id  = tbl_buyer_cart.buyer_id
			LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_buyer_cart.product_id
			WHERE tbl_buyer_cart.cart_id='".$cart_id."' ");

// $dataget = mysqli_query($con,$query);
$data = mysqli_fetch_row($dataget);


$response[] = [
	'cart_id' => $data[0],
	'buyer_id' => $data[1],
	'buyer_name' => $data[2],
	'ph_num' => $data[3],
	'product_id' => $data[4],
	'product_name' => $data[5],
];
echo json_encode($response,true);
?>