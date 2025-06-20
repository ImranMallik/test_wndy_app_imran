<?php
include("../db/db.php");
include("../db/activity.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);
$view_id = mysqli_real_escape_string($con, $sendData['view_id']);

$dataget = mysqli_query($con,"select credit_trans_id from tbl_user_product_view where view_id='".$view_id."' ");
$data = mysqli_fetch_assoc($dataget);

$credit_trans_id = $data['credit_trans_id'];

mysqli_query($con, "DELETE FROM tbl_user_product_view WHERE view_id='" . $view_id . "' ");
mysqli_query($con, "DELETE FROM tbl_credit_trans WHERE credit_trans_id='" . $credit_trans_id . "' ");

$activity_details = "You Delete A Record From Manage Post Transactions";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
