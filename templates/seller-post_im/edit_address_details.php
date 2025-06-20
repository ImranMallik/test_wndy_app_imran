<?php
include("../db/db.php");

if (isset($_POST['address_id'])) {
    $address_id = intval($_POST['address_id']);

    $query = mysqli_query($con, "SELECT * FROM tbl_address_master WHERE address_id='$address_id'");
    $address = mysqli_fetch_assoc($query);

    if ($address) {
        echo json_encode($address);
    } else {
        echo json_encode(["error" => "Address not found"]);
    }
}
?>
