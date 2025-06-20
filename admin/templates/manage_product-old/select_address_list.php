<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$sendData = json_decode($_POST['sendData'], true);

$user_id = mysqli_real_escape_string($con, $sendData['user_id']);

$fetchData = mysqli_query($con,"SELECT address_id, address_line_1 
FROM tbl_address_master
WHERE user_id = '".$user_id."' AND tbl_address_master.address_line_1 LIKE '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id"=>$row['address_id'], "text"=>$row['address_line_1']);
}
echo json_encode($data);
?>