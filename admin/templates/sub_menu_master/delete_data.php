<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

$sendData = json_decode($_POST['sendData'],true);
$sub_menu_code = mysqli_real_escape_string($con,$sendData['sub_menu_code']);
mysqli_query($con,"delete from sub_menu_master where sub_menu_code='".$sub_menu_code."' ");
$activity_details = "You Delete A Record In Manage Sub Menu";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>