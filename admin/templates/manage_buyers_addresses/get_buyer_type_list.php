<?php
include("../db/db.php");

$search = $_POST['searchTerm'];

$fetchData = mysqli_query($con, "
    SELECT DISTINCT buyer_type 
    FROM tbl_user_master 
    WHERE user_type = 'Buyer' 
      AND buyer_type LIKE '%" . $search . "%' 
    ORDER BY buyer_type ASC 
    LIMIT 50
");

$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array(
        "id" => $row['buyer_type'],
        "text" => $row['buyer_type']
    );
}

echo json_encode($data);
?>
