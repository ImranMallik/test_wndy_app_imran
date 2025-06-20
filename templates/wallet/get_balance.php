
<?php
include("../db/db.php");

if (!isset($session_user_code)) {
    die(json_encode(["status" => "error", "message" => "Error: User ID is missing."]));
}

// Query to calculate total incoming credits (in_credit)
$query_in = "SELECT SUM(in_credit) AS total_in_credit FROM tbl_credit_trans WHERE user_id = ?";
$stmt_in = $con->prepare($query_in);

if (!$stmt_in) {
    echo json_encode(["status" => "error", "message" => "SQL Error: " . $con->error]);
    exit;
}

$stmt_in->bind_param("i", $session_user_code);
$stmt_in->execute();
$result_in = $stmt_in->get_result();
$row_in = $result_in->fetch_assoc();
$total_in_credit = $row_in['total_in_credit'] ?? 0.00;
$stmt_in->close();

// Query to calculate total outgoing credits (out_credit)
$query_out = "SELECT SUM(out_credit) AS total_out_credit FROM tbl_credit_trans WHERE user_id = ?";
$stmt_out = $con->prepare($query_out);

if (!$stmt_out) {
    echo json_encode(["status" => "error", "message" => "SQL Error: " . $con->error]);
    exit;
}

$stmt_out->bind_param("i", $session_user_code);
$stmt_out->execute();
$result_out = $stmt_out->get_result();
$row_out = $result_out->fetch_assoc();
$total_out_credit = $row_out['total_out_credit'] ?? 0.00;
$stmt_out->close();

// Calculate the total wallet balance
$total_balance = $total_in_credit - $total_out_credit;


// Return JSON response
echo number_format($total_balance, 2);
?>

