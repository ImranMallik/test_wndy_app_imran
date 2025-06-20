<?php
include("../db/db.php");
include("../db/activity.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);
$user_id = mysqli_real_escape_string($con, $sendData['user_id']);

$dataget = mysqli_query($con, "SELECT user_img FROM tbl_user_master WHERE tbl_user_master.user_id='" . $user_id . "' ");
$data = mysqli_fetch_row($dataget);
$previous_user_img = $data[0];

if ($previous_user_img != "") {
	unlink("../../../upload_content/upload_img/user_img/" . $previous_user_img);
}

mysqli_query($con, "DELETE FROM tbl_user_master WHERE tbl_user_master.user_id='" . $user_id . "' ");

$activity_details = "You Delete A Record From Manage Collector Details";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
