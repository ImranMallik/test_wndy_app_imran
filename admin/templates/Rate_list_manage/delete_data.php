<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

$sendData = json_decode($_POST['sendData'],true);
$menu_code = mysqli_real_escape_string($con,$sendData['menu_code']);
mysqli_query($con,"delete from menu_master where menu_code='".$menu_code."' ");
$activity_details = "You Delete A Record In Manage Menu Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>