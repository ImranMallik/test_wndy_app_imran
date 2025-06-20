<?php
include("../db/db.php");
include("../db/activity.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);
$product_id = mysqli_real_escape_string($con, $sendData['product_id']);

$dataget = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id='" . $product_id . "' ");
$data = mysqli_fetch_row($dataget);
$previous_product_img = $data[0];

if ($previous_product_img != "") {
	unlink("../../../upload_content/upload_img/product_img/" . $previous_product_img);
}

mysqli_query($con, "DELETE FROM tbl_product_master WHERE product_id='" . $product_id . "' ");
mysqli_query($con, "DELETE FROM tbl_product_file WHERE product_id='" . $product_id . "' ");

$activity_details = "You Delete A Record From Manage Product Details";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
