<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT category_id, category_name FROM tbl_category_master WHERE tbl_category_master.active='Yes' AND tbl_category_master.category_name LIKE '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id"=>$row['category_id'], "text"=>$row['category_name']);
}
echo json_encode($data);
?>