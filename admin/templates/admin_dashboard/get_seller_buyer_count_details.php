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

$dateCondition = "";
if ($from_date != "") {
    $dateCondition .= " AND DATE(tbl_user_master.entry_timestamp) >= '$from_date'";
}
if ($to_date != "") {
    $dateCondition .= " AND DATE(tbl_user_master.entry_timestamp) <= '$to_date'";
}

$countData = [];

if ($state == "" && $city == "" && $pincode == "") {

    $dataget = mysqli_query($con, "select distinct(state) from tbl_address_master ");
    while ($rw = mysqli_fetch_array($dataget)) {

        $buyerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as buyer_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $rw['state'] . "' and tbl_user_master.user_type='Buyer' $dateCondition ");
        $buyerData = mysqli_num_rows($buyerDataget);

        $sellerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as seller_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $rw['state'] . "' and tbl_user_master.user_type='Seller' $dateCondition ");
        $sellerData = mysqli_num_rows($sellerDataget);

        $countData[] = [
            "data" => $rw['state'],
            "buyer_count" => $buyerData,
            "seller_count" => $sellerData,
        ];
    }
}

if ($state != "" && $city == "" && $pincode == "") {
    $dataget = mysqli_query($con, "select distinct(city) from tbl_address_master where state='" . $state . "' ");
    while ($rw = mysqli_fetch_array($dataget)) {

        $buyerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as buyer_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $state . "' and tbl_address_master.city='" . $rw['city'] . "' and tbl_user_master.user_type='Buyer' $dateCondition ");
        $buyerData = mysqli_num_rows($buyerDataget);

        $sellerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as seller_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $state . "' and tbl_address_master.city='" . $rw['city'] . "' and tbl_user_master.user_type='Seller' $dateCondition ");
        $sellerData = mysqli_num_rows($sellerDataget);

        $countData[] = [
            "data" => $rw['city'],
            "buyer_count" => $buyerData,
            "seller_count" => $sellerData,
        ];
    }
}

if ($state != "" && $city != "" && $pincode == "") {
    $dataget = mysqli_query($con, "select distinct(pincode) from tbl_address_master where state='" . $state . "' and city='" . $city . "' ");
    while ($rw = mysqli_fetch_array($dataget)) {

        $buyerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as buyer_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $state . "' and tbl_address_master.city='" . $city . "' and tbl_address_master.pincode='" . $rw['pincode'] . "' and tbl_user_master.user_type='Buyer' $dateCondition ");
        $buyerData = mysqli_num_rows($buyerDataget);

        $sellerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as seller_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $state . "' and tbl_address_master.city='" . $city . "' and tbl_address_master.pincode='" . $rw['pincode'] . "' and tbl_user_master.user_type='Seller' $dateCondition ");
        $sellerData = mysqli_num_rows($sellerDataget);

        $countData[] = [
            "data" => $rw['pincode'],
            "buyer_count" => $buyerData,
            "seller_count" => $sellerData,
        ];
    }
}

if ($state != "" && $city != "" && $pincode != "") {
    $dataget = mysqli_query($con, "select distinct(pincode) from tbl_address_master where state='" . $state . "' and city='" . $city . "' and pincode='" . $pincode . "' ");
    while ($rw = mysqli_fetch_array($dataget)) {

        $buyerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as buyer_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $state . "' and tbl_address_master.city='" . $city . "' and tbl_address_master.pincode='" . $pincode . "' and tbl_user_master.user_type='Buyer' $dateCondition ");
        $buyerData = mysqli_num_rows($buyerDataget);

        $sellerDataget = mysqli_query($con, "select distinct(tbl_address_master.user_id) as seller_id from tbl_address_master LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_address_master.user_id where tbl_address_master.state='" . $state . "' and tbl_address_master.city='" . $city . "' and tbl_address_master.pincode='" . $pincode . "' and tbl_user_master.user_type='Seller' $dateCondition ");
        $sellerData = mysqli_num_rows($sellerDataget);

        $countData[] = [
            "data" => $rw['pincode'],
            "buyer_count" => $buyerData,
            "seller_count" => $sellerData,
        ];
    }
}

// Return the response as JSON
echo json_encode($countData);
