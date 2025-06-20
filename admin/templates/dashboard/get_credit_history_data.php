<?php
include("../db/db.php");
include("../../../module_function/month_date.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize the input to prevent SQL injection
$filter_year = mysqli_real_escape_string($con, $sendData['filter_year']);
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
    $dateCondition .= " AND DATE(tbl_credit_trans.entry_timestamp) >= '$from_date'";
}
if ($to_date != "") {
    $dateCondition .= " AND DATE(tbl_credit_trans.entry_timestamp) <= '$to_date'";
}

$countData = [];

$monthsArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

for ($i = 0; $i < count($monthsArray); $i++) {
    $month = $monthsArray[$i];
    $dataget = mysqli_query($con, "select 
                                            sum(tbl_credit_trans.in_credit), 
                                            sum(tbl_credit_trans.out_credit) 
                                            from tbl_credit_trans 
                                            LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_credit_trans.user_id
                                            LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_user_master.address_id
                                            where tbl_credit_trans.trans_date BETWEEN '" . getFirstDateofMonth($month, $filter_year) . "' AND '" . getLastDateofMonth($month, $filter_year) . "'  " . $addressQuery . $dateCondition);
    $data = mysqli_fetch_row($dataget);
    $countData[] = [
        "month" => $month,
        "in_credit" => $data[0],
        "out_credit" => $data[1],
    ];
}

// Return the response as JSON
echo json_encode($countData);
