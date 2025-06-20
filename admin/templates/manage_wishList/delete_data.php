<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";
$sendData = json_decode($_POST['sendData'],true);
$wishlist_id = mysqli_real_escape_string($con,$sendData['wishlist_id']);


mysqli_query($con,"DELETE FROM tbl_buyer_wishlist WHERE wishlist_id='".$wishlist_id."' ");
$activity_details = "You Delete A Record From Manage Buyers Wishlist Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>