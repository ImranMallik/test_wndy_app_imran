<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

$sendData = json_decode($_POST['sendData'],true);
$user_mode_code = mysqli_real_escape_string($con,$sendData['user_mode_code']);

mysqli_query($con,"delete from user_mode where user_mode_code='".$user_mode_code."' ");

$activity_details = "You Delete A Record In Manage User Mode Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>