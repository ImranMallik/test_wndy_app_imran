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

$statusArray = ['Active', 'Post Viewed', 'Under Negotiation', 'Offer Accepted', 'Pickup Scheduled', 'Completed'];

for ($i = 0; $i < count($statusArray); $i++) {
    $productStatusDataget = mysqli_query($con, "SELECT COUNT(*) FROM tbl_product_master WHERE active='Yes' AND product_status='" . $statusArray[$i] . "' " . $dateCondition);
    $productStatusData = mysqli_fetch_row($productStatusDataget);
    $countData[] = [
        "product_status" => $statusArray[$i],
        "product_count" => $productStatusData[0] === null ? 0 : $productStatusData[0],
    ];
}

// Return the response as JSON
echo json_encode($countData);