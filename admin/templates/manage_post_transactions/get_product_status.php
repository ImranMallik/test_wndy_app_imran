<?php
include("../db/db.php"); // adjust path to your DB connection file

header('Content-Type: application/json');

// Optional search term for filtering
$searchTerm = $_POST['searchTerm'] ?? '';
$searchTermEscaped = mysqli_real_escape_string($con, $searchTerm);

// SQL query with optional filtering
$query = "
    SELECT DISTINCT deal_status 
    FROM tbl_user_product_view 
    WHERE deal_status IS NOT NULL
    " . ($searchTerm ? "AND deal_status LIKE '%$searchTermEscaped%'" : "") . "
    ORDER BY deal_status ASC
";

$result = mysqli_query($con, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['deal_status'];
    $data[] = [
        "id" => $status,
        "text" => $status
    ];
}

echo json_encode($data);
exit;
