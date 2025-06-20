<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'],true);
$cart_id = mysqli_real_escape_string($con,$sendData['cart_id']);


mysqli_query($con,"DELETE FROM tbl_buyer_cart WHERE tbl_buyer_cart.cart_id='".$cart_id."' ");
$activity_details = "You Delete A Record From Manage Buyer Cart Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>