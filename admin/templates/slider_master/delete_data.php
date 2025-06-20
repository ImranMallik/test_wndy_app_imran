<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

// mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'],true);
$slider_id = mysqli_real_escape_string($con,$sendData['slider_id']);

$dataget = mysqli_query($con,"SELECT slider_img FROM tbl_home_slider WHERE tbl_home_slider.slider_id='".$slider_id."' ");
$data = mysqli_fetch_row($dataget);
$previous_slider_img = $data[0];

if ($previous_slider_img!="") {
	unlink("../../../upload_content/upload_img/slider_img/".$previous_slider_img);
}

mysqli_query($con,"DELETE FROM tbl_home_slider WHERE tbl_home_slider.slider_id='".$slider_id."' ");
$activity_details = "You Delete A Record In Slider Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>