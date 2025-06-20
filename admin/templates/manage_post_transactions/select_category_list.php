<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con, "SELECT category_id, category_name FROM tbl_category_master WHERE active='Yes' AND category_name LIKE '%" . $search . "%' ORDER BY order_number ASC LIMIT 50");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['category_name'];
    $data[] = array(
        "id" => $row['category_id'],
        "text" => $text,
    );
}
echo json_encode($data);
