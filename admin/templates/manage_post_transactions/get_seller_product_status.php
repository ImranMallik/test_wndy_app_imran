<?php
include("../db/db.php"); // adjust path to your DB connection file

header('Content-Type: application/json');

// Optional search term for filtering
$searchTerm = $_POST['searchTerm'] ?? '';
$searchTermEscaped = mysqli_real_escape_string($con, $searchTerm);

// SQL query with optional filtering
$query = "
    SELECT DISTINCT product_status 
    FROM tbl_product_master 
    WHERE product_status IS NOT NULL
    " . ($searchTerm ? "AND product_status LIKE '%$searchTermEscaped%'" : "") . "
    ORDER BY product_status ASC
";

$result = mysqli_query($con, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['product_status'];
    $data[] = [
        "id" => $status,
        "text" => $status
    ];
}

echo json_encode($data);
exit;
