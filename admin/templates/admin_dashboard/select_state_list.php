<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con, "SELECT distinct(state) FROM tbl_address_master WHERE state LIKE '%" . $search . "%' limit 50");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id" => $row['state'], "text" => $row['state']);
}
echo json_encode($data);
