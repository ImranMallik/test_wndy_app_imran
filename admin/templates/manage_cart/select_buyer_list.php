<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT buyer_id, buyer_name, ph_num FROM tbl_buyer_master WHERE buyer_name LIKE '%".$search."%' or ph_num LIKE '%".$search."%' LIMIT 50");	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id"=>$row['buyer_id'], "text"=>$row['buyer_name'] ." [". $row['ph_num']."]");
}
echo json_encode($data);
?>