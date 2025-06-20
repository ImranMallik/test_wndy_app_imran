<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con, "
    SELECT DISTINCT seller_type 
    FROM tbl_user_master 
    WHERE user_type = 'Seller' 
      AND seller_type LIKE '%" . $search . "%' 
    ORDER BY seller_type ASC 
    LIMIT 50
");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array(
        "id" => $row['seller_type'],
        "text" => $row['seller_type']
    );
}

echo json_encode($data);
?>
