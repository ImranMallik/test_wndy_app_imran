<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT product_id, product_name FROM tbl_product_master WHERE active='Yes' AND product_name LIKE '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id"=>$row['product_id'], "text"=>$row['product_name']);
}
echo json_encode($data);
?>