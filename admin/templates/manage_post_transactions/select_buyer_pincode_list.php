<?php
include("../db/db.php");

header('Content-Type: application/json');

$searchTerm = $_POST['searchTerm'] ?? '';

$searchTermEscaped = mysqli_real_escape_string($con, $searchTerm);

$query = "
    SELECT 
        um.user_id, 
        am.pincode 
    FROM tbl_user_master AS um
    INNER JOIN tbl_address_master AS am ON um.user_id = am.user_id
    WHERE LOWER(TRIM(um.user_type)) = 'Buyer'
    " . ($searchTermEscaped ? "AND am.pincode LIKE '%$searchTermEscaped%'" : "") . "
    GROUP BY am.pincode
    ORDER BY am.pincode ASC
";

$fetchData = mysqli_query($con, $query);

$data = [];

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = [
        "id" => $row['user_id'],
        "text" => $row['pincode'],
    ];
}

echo json_encode($data);
// exit;
