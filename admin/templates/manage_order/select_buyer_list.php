<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT buyer_id, buyer_name, ph_num FROM tbl_buyer_master WHERE tbl_buyer_master.active = 'Yes' AND tbl_buyer_master.buyer_name LIKE '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['buyer_name']. " [" . $row['ph_num'] . "]";
    $data[] = array(
        "id" => $row['buyer_id'],
        "text" => $text,
    );
}
echo json_encode($data);
?>