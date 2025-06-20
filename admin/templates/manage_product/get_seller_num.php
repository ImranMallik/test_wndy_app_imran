<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con,"SELECT user_id, ph_num FROM tbl_user_master WHERE active='Yes' AND user_type='Seller' AND name LIKE '%".$search."%' LIMIT 50");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['ph_num'];
    $data[] = array(
        "id" => $row['user_id'],
        "text" => $text,
    );
}
echo json_encode($data);
?>
