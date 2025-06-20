<?php
include("../db/db.php");

$search = $_POST['searchTerm'];
$fetchData = mysqli_query($con,"select customer_code, customer_name, ref_id from customer_master where active='Yes' and cust_type='Business Promoter' and ( customer_name like '%".$search."%' OR ref_id like '%".$search."%' ) limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id"=>$row['customer_code'], "text"=>$row['customer_name']." [ ".$row['ref_id']." ] ");
}
echo json_encode($data);
?>