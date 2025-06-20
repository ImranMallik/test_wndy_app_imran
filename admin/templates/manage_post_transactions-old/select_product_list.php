<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$sendData = json_decode($_POST['sendData'], true);
$category_id = trim(mysqli_real_escape_string($con, $sendData['category_id']));
// $seller_id = trim(mysqli_real_escape_string($con, $sendData['seller_id']));

// $query = "SELECT product_id, product_name FROM tbl_product_master WHERE user_id='" . $seller_id . "' AND active='Yes' ";
$query = "SELECT product_id, product_name, post_id FROM tbl_product_master WHERE active='Yes' AND category_id='" . $category_id . "'";

// if ($category_id != "") {
//     $query .= " AND category_id='" . $category_id . "' ";
// }

$query .= " AND (product_name LIKE '%" . $search . "%' OR post_id LIKE '%" . $search . "%') ORDER BY product_name ASC LIMIT 50";

$fetchData = mysqli_query($con, $query);

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $text = $row['product_name'] . ' [' . $row['post_id'] . ' ]';
    $data[] = array(
        "id" => $row['product_id'],
        "text" => $text,
    );
}
echo json_encode($data);
