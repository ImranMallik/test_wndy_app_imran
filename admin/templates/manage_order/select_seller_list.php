<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT seller_id, seller_name, ph_num FROM tbl_seller_master WHERE tbl_seller_master.active = 'Yes' AND tbl_seller_master.seller_name LIKE '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['seller_name']. " [" . $row['ph_num'] . "]";
    $data[] = array(
        "id" => $row['seller_id'],
        "text" => $text,
    );
}
echo json_encode($data);
?>