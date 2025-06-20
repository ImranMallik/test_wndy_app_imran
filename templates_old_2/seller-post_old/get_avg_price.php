<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'], true);
$category_id = mysqli_real_escape_string($con, $sendData['category_id']);
$product_name = mysqli_real_escape_string($con, $sendData['product_name']);

$productDataget = mysqli_query($con,"select count(*), sum(sale_price) from tbl_product_master where category_id='".$category_id."' and product_name LIKE '%".$product_name."%' ");
$productData = mysqli_fetch_row($productDataget);

$total_rec = $productData[0];
$total_amount = $productData[1];

$avgPrice = round($total_amount / $total_rec);

$response = [
	'avgPrice' => $avgPrice,
	'total_amount' => $total_amount,
	'total_rec' => $total_rec,
];
echo json_encode($response, true);
