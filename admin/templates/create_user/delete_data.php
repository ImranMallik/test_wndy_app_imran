<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

$sendData = json_decode($_POST['sendData'],true);
$user_code = mysqli_real_escape_string($con,$sendData['user_code']);

$dataget = mysqli_query($con,"select profile_img from user_master where user_code='".$user_code."' ");
$data = mysqli_fetch_row($dataget);
$previous_profile_img = $data[0];

if ($previous_profile_img!="") {
	unlink("../../../upload_content/upload_img/profile_img/".$previous_profile_img);
}

mysqli_query($con,"delete from user_master where user_code='".$user_code."' ");
$activity_details = "You Delete A Record In Manage User Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>