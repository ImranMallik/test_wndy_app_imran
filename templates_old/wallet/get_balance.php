
<?php
include("../db/db.php");

if (!isset($session_user_code)) {
    die(json_encode(["status" => "error", "message" => "Error: User ID is missing."]));
}

$query = "SELECT SUM(in_credit) AS total FROM tbl_credit_trans WHERE user_id = ? AND status = 'In'";
$stmt = $con->prepare($query);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "SQL Error: " . $con->error]);
    exit;
}

$stmt->bind_param("i", $session_user_code);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
$total_balance = $row['total'] ?? 0.00;

// Return JSON response
echo number_format($total_balance, 2);
?>

