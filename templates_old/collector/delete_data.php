<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'], true);
$user_id = mysqli_real_escape_string($con, $sendData['user_id']);


mysqli_query($con, "DELETE FROM tbl_user_master WHERE user_id='" . $user_id . "' ");

$activity_details = "You Delete A Record From Collector";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
