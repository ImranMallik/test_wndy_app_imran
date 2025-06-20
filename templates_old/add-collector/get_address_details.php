<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$address_id = trim(mysqli_real_escape_string($con, $sendData['address_id']));

$dataget = mysqli_query($con, "SELECT address_name, address_line_1 FROM tbl_address_master WHERE address_id='" . $address_id . "' ");
$data = mysqli_fetch_row($dataget);

$address_name = $data[0];
$address_line_1 = $data[1];

?>

<div class="address-select-box active">
    <div class="address-box bg-block">
        <div class="top d-flex-justify-center justify-content-between mb-3">
            <h5 class="m-0"><?php echo $address_name; ?></h5>
        </div>
        <div class="middle">
            <div class="address mb-2 text-muted" id="address_id">
                <address class="m-0" style="white-space: wrap; word-wrap: break-word;">Address Line: <b><?php echo $address_line_1 ?></b></address>
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