<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$wishlist_id = mysqli_real_escape_string($con,$sendData['wishlist_id']);

$query = "SELECT tbl_buyer_wishlist.wishlist_id,
tbl_buyer_master.buyer_name, 
tbl_buyer_master.buyer_id, 
tbl_product_master.product_name,
tbl_product_master.product_id
FROM
tbl_buyer_wishlist
LEFT JOIN tbl_buyer_master ON tbl_buyer_wishlist.buyer_id  = tbl_buyer_master.buyer_id
LEFT JOIN tbl_product_master ON tbl_buyer_wishlist.product_id = tbl_product_master.product_id
WHERE wishlist_id='".$wishlist_id."' ";

$dataget = mysqli_query($con,$query);
$data = mysqli_fetch_row($dataget);


$response[] = [
	'wishlist_id' => $data[0],
	'buyer_name' => $data[1],
	'buyer_id' => $data[2],
	'product_name' => $data[3],
	'product_id' => $data[4],
];
echo json_encode($response,true);
?>