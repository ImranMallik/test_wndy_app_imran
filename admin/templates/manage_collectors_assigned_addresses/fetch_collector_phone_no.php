<?php
include("../db/db.php");

$search = $_POST['searchTerm'];
$sendData = json_decode($_POST['sendData'], true);

$user_id_collector = mysqli_real_escape_string($con, $sendData['user_id_collector']);

if ($user_id_collector != "") {

    $phone_no_getdata = mysqli_query($con, "SELECT ph_num FROM tbl_user_master WHERE name = '" . $user_id_collector . "'");

    $phone_no_get = mysqli_fetch_row($phone_no_getdata);

    $response = [
        'ph_num' => $phone_no_get[0]
    ];
    echo json_encode($response, true);
}
?>
