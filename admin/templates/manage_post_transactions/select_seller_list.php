<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con, "SELECT user_id, name, ph_num FROM tbl_user_master WHERE user_type='Seller' AND active='Yes' AND ( name LIKE '%" . $search . "%' OR ph_num LIKE '%" . $search . "%' ) ORDER BY name ASC LIMIT 50");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['name'] . " [ " . $row['ph_num'] . " ]";
    $data[] = array(
        "id" => $row['user_id'],
        "text" => $text,
    );
}
echo json_encode($data);
