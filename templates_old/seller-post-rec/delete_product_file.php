<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$product_file_id = mysqli_real_escape_string($con, $sendData['product_file_id']);

$dataget = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_file_id='" . $product_file_id . "' ");
$data = mysqli_fetch_row($dataget);
$file_name = $data[0];

if ($file_name != "") {
	unlink("../../upload_content/upload_img/product_img/" . $file_name);
}

mysqli_query($con, "DELETE FROM tbl_product_file WHERE product_file_id='" . $product_file_id . "' ");