<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT product_id, product_name FROM tbl_product_master
WHERE tbl_product_master.active = 'Yes' AND tbl_product_master.product_name LIKE '%".$search."%' limit 50");
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['product_name'];
    $data[] = array(
        "id" => $row['product_id'],
        "text" => $text,
    );
}
echo json_encode($data);
?>