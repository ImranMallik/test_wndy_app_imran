<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"select user_mode_code, user_mode from user_mode where active='Yes' and user_mode like '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
	$data[] = array("id"=>$row['user_mode_code'], "text"=>$row['user_mode']);
}
echo json_encode($data);
?>