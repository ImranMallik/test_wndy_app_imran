<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$sendData = json_decode($_POST['sendData'], true);
$address_id = mysqli_real_escape_string($con, $sendData['address_id']);


mysqli_query($con, "DELETE FROM tbl_address_master WHERE address_id='" . $address_id . "' ");

mysqli_query($con, "update tbl_user_master set address_id=null where address_id='" . $address_id . "' ");

$activity_details = "You Delete A Record From Address Book";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
