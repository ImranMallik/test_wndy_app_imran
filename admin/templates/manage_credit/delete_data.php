<?php
include("../db/db.php");
include("../db/activity.php");
// mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);
$option_id = mysqli_real_escape_string($con, $sendData['option_id']);

mysqli_query($con, "DELETE FROM tbl_credit_option WHERE option_id='" . $option_id . "' ");

$activity_details = "You Delete A Record From Manage Credit Details";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
