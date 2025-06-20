<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

// mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'],true);
$category_id = mysqli_real_escape_string($con,$sendData['category_id']);

$dataget = mysqli_query($con,"SELECT category_img FROM tbl_category_master WHERE tbl_category_master.category_id='".$category_id."' ");
$data = mysqli_fetch_row($dataget);
$previous_category_img = $data[0];

if ($previous_category_img!="") {
	unlink("../../../upload_content/upload_img/category_img/".$previous_category_img);
}

mysqli_query($con,"DELETE FROM tbl_category_master WHERE tbl_category_master.category_id='".$category_id."' ");

$activity_details = "You Delete A Record From Manage Category Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>