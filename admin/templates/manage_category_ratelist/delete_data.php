<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'], true);
$category_rate_list_id = mysqli_real_escape_string($con, $sendData['category_rate_list_id']);


mysqli_query($con, "DELETE FROM tbl_category_rate_list WHERE category_rate_list_id='" . $category_rate_list_id . "' ");
$activity_details = "You Delete A Record From Manage Category Rate List Details";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
