<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$address_id = trim(mysqli_real_escape_string($con, $sendData['address_id']));

$dataget = mysqli_query($con, "select contact_name, contact_ph_num, address_name, country, state, city, landmark, pincode, address_line_1 from tbl_address_master where address_id='" . $address_id . "' ");
$data = mysqli_fetch_row($dataget);

$contact_name = $data[0];
$contact_ph_num = $data[1];
$address_name = $data[2];
$country = $data[3];
$state = $data[4];
$city = $data[5];
$landmark = $data[6];
$pincode = $data[7];
$address_line_1 = $data[8];

?>

<div class="address-select-box active">
    <div class="address-box bg-block">
        <div class="top d-flex-justify-center justify-content-between mb-3">
            <h5 class="m-0"><?php echo $address_name; ?></h5>
        </div>
        <div class="middle">
            <div class="address mb-2 text-muted">
                <address class="m-0">Contact Name: <b><?php echo $contact_name ?></b></address>
                <address class="m-0">Contact Phone Number: <b><?php echo $contact_ph_num ?></b></address>
                <address class="m-0">Address: <b><?php echo $country . ", " . $state . ", " . $city . ", " . $pincode; ?></b></address>
                <address class="m-0">Landmark: <b><?php echo $landmark ?></b></address>
                <address class="m-0">Address Line: <b><?php echo $address_line_1 ?></b></address>
            </div>
        </div>
        <div class="bottom d-flex-justify-center justify-flex-end">
            <button type="button" class="bottom-btn btn btn-info btn-sm" onclick="update_data(<?php echo $address_id; ?>)">
                <i class="fa fa-edit" style="margin-right: 6px;"></i>
                Edit Address
            </button>
        </div>
    </div>
</div>