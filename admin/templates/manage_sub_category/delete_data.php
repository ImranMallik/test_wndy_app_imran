<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

// mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'],true);
$sub_category_id = mysqli_real_escape_string($con,$sendData['sub_category_id']);

mysqli_query($con,"DELETE FROM tbl_sub_category_master WHERE sub_category_id='".$sub_category_id."' ");

$activity_details = "You Delete A Record From Manage Product Sub-Category Details";

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>