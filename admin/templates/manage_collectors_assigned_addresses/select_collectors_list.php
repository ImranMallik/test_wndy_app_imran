<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT user_id, name, ph_num FROM tbl_user_master WHERE user_type='Collector' AND name LIKE '%".$search."%' ORDER BY name ASC  limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['name'];
    $data[] = array(
        "id" => $row['user_id'],
        "text" => $text,
    );
}
echo json_encode($data);
?>