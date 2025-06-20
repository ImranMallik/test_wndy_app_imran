<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";
$sendData = json_decode($_POST['sendData'],true);
$request_id = mysqli_real_escape_string($con,$sendData['request_id']);


mysqli_query($con,"DELETE FROM tbl_buy_request WHERE tbl_buy_request.request_id='".$request_id."' ");
$activity_details = "You Delete A Record From Manage Order Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>