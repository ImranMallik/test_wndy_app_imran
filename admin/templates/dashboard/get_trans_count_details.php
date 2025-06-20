<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize the input to prevent SQL injection
$state = mysqli_real_escape_string($con, $sendData['state']);
$city = mysqli_real_escape_string($con, $sendData['city']);
$pincode = mysqli_real_escape_string($con, $sendData['pincode']);

// from date & to date filtration
$from_date = mysqli_real_escape_string($con, $sendData['from_date']);
$to_date = mysqli_real_escape_string($con, $sendData['to_date']);


// address query
$addressQuery = "";

if ($state != "") {
    $addressQuery .= " and tbl_address_master.state='" . $state . "' ";
}
if ($city != "") {
    $addressQuery .= " and tbl_address_master.city='" . $city . "' ";
}
if ($pincode != "") {
    $addressQuery .= " and tbl_address_master.pincode='" . $pincode . "' ";
}

$dateCondition = "";
if ($from_date != "") {
    $dateCondition .= " AND DATE(tbl_product_master.entry_timestamp) >= '$from_date'";
}
if ($to_date != "") {
    $dateCondition .= " AND DATE(tbl_product_master.entry_timestamp) <= '$to_date'";
}

$countData = [];

$categoryDataget = mysqli_query($con, "select category_id, category_name from tbl_category_master where active='Yes' ");
while ($rw = mysqli_fetch_array($categoryDataget)) {

    $productDataget = mysqli_query($con, "select count(*), sum(sale_price) from tbl_product_master
                                    LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
                                    where tbl_product_master.category_id = '" . $rw['category_id'] . "' " . $addressQuery . $dateCondition);
    $productData = mysqli_fetch_row($productDataget);

    $countData[] = [
        "category_name" => $rw['category_name'],
        "trans_count" => $productData[0],
        "trans_valuation" => $productData[1],
    ];
}

// Return the response as JSON
echo json_encode($countData);
