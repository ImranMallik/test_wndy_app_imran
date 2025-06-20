<?php
include("../db/db.php");

// Disable foreign key checks (useful for debugging)
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

// Check if user is logged in
if ($login == "No") {
    echo json_encode(["status" => "SessionDestroy", "message" => "User session expired"]);
    exit;
}

// Check if the amount is provided
if (!isset($_POST['amount']) || empty($_POST['amount'])) {
    echo json_encode(["status" => "error", "message" => "Credit amount is missing in POST request"]);
    exit;
}

$credit = trim($_POST['amount']);
$amount = 0;
$execute = 1;

// Check if user session is set
if (!isset($session_user_code) || empty($session_user_code)) {
    echo json_encode(["status" => "error", "message" => "User session is missing"]);
    exit;
}

// Set timestamp if not provided
if (!isset($timestamp)) {
    $timestamp = date('Y-m-d H:i:s');
}

$user_id = $session_user_code;
$in_credit = $credit;
$purchase_amount = $amount;
$trans_date = date("Y-m-d");
$trans_type = "Credit Purchase";
$status = "In";

// ✅ Prepare Insert Query
$insert_sql = "INSERT INTO tbl_credit_trans (
    user_id, in_credit, purchase_amount, trans_date, trans_type, status, entry_user_code, entry_timestamp
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($insert_sql);
$stmt->bind_param("iidsssss", $user_id, $in_credit, $purchase_amount, $trans_date, $trans_type, $status, $session_user_code, $timestamp);

// ✅ Execute the Query
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "🤩 Thank You For Purchasing"]);
} else {
    echo json_encode(["status" => "error", "message" => "Insert Error: " . $stmt->error]);
}

// ✅ Close the Statement
$stmt->close();
?>
