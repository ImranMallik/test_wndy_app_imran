<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$sendData = json_decode($_POST['sendData'], true);

$state = mysqli_real_escape_string($con, $sendData['state']);

$fetchData = mysqli_query($con, "SELECT distinct(city) FROM tbl_address_master WHERE state='" . $state . "' AND city LIKE '%" . $search . "%' limit 50");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id" => $row['city'], "text" => $row['city']);
}
echo json_encode($data);
