<?php
include("../db/db.php");

$search = $_POST['searchTerm'];
$sendData = json_decode($_POST['sendData'], true);

$address_id = mysqli_real_escape_string($con, $sendData['address_id']);

if ($address_id != "") {
    // Fetching per month interest amount
    $address_details_getdata = mysqli_query($con, "SELECT country, state, city, landmark, pincode, address_line_1 FROM tbl_address_master WHERE address_id = '" . $address_id . "'");

    $address_details_get = mysqli_fetch_row($address_details_getdata);

    $response = [
        'country' => $address_details_get[0],
        'state' => $address_details_get[1],
        'city' => $address_details_get[2],
        'landmark' => $address_details_get[3],
        'pincode' => $address_details_get[4],
        'address_line_1' => $address_details_get[5]
    ];
    echo json_encode($response, true);
}
?>
