<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// from date & to date filtration
$from_date = mysqli_real_escape_string($con, $sendData['from_date']);
$to_date = mysqli_real_escape_string($con, $sendData['to_date']);

$dateCondition = "";
if ($from_date != "") {
    $dateCondition .= " AND DATE(entry_timestamp) >= '$from_date'";
}
if ($to_date != "") {
    $dateCondition .= " AND DATE(entry_timestamp) <= '$to_date'";
}


$countData = [];

$statusArray = ['Credit Used', 'Under Negotiation', 'Offer Accepted', 'Pickup Scheduled', 'Offer Rejected', 'Completed'];

for ($i = 0; $i < count($statusArray); $i++) {
    $transactionStatusDataget = mysqli_query($con, "SELECT COUNT(*) FROM tbl_user_product_view WHERE deal_status='" . $statusArray[$i] . "' " . $dateCondition);
    $transactionStatusData = mysqli_fetch_row($transactionStatusDataget);
    $countData[] = [
        "deal_status" => $statusArray[$i],
        "product_transaction_count" => $transactionStatusData[0] === null ? 0 : $transactionStatusData[0],
    ];
}

// Return the response as JSON
echo json_encode($countData);