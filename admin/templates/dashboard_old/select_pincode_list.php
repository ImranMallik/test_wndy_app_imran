<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$sendData = json_decode($_POST['sendData'], true);

$state = mysqli_real_escape_string($con, $sendData['state']);
$city = mysqli_real_escape_string($con, $sendData['city']);

$fetchData = mysqli_query($con, "SELECT distinct(pincode) FROM tbl_address_master WHERE state='" . $state . "' AND city='" . $city . "' AND pincode LIKE '%" . $search . "%' limit 50");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id" => $row['pincode'], "text" => $row['pincode']);
}
echo json_encode($data);
