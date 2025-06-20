<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$response = [];

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {
    $sendData = json_decode($_POST['sendData'], true);

    $address_id = mysqli_real_escape_string($con, $sendData['address_id']);
    $name = mysqli_real_escape_string($con, $sendData['name']);
    $ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
    $user_type = "Collector";

    //=============================== Referral Code Generator ============================
    $generator = "0123456789";
    $refferal_code = "";

    for ($i = 1; $i <= 10; $i++) {
        $refferal_code .= substr($generator, rand() % strlen($generator), 1);
    }

    $save = 1;
    if ($save == 1) {
        $datagett = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE tbl_user_master.ph_num = '" . $ph_num . "' ");
        if ($datagett) {
            $rw = mysqli_num_rows($datagett);
            if ($rw > 0) {
                $status = "ph_num Exist";
                $status_text = "Phone Number Already Exists!";
                $save = 0;
            }
        } else {
            $status = "Error";
            $status_text = "Database query failed: " . mysqli_error($con);
            $save = 0;
        }
    }

    if ($save == 1) {
        // Insert the new user
        mysqli_query($con, "INSERT INTO tbl_user_master (
                    user_id, 
                    name,
                    ph_num,
                    address_id,
                    referral_id,
                    under_buyer_id,
                    user_type,              
                    entry_user_code,
                    entry_timestamp
                ) VALUES (
                    NULL,
                    '$name',
                    '$ph_num',
                    '$address_id',
                    '',
                    '$session_user_code',
                    '$user_type',
                    '$session_user_code',
                    '$timestamp'
                )");

        $user_id = mysqli_insert_id($con);

        // Generate the referral code
        $rc = "RC" . $refferal_code . "C" . $user_id;

        // Update the user with the referral code
        mysqli_query($con, "UPDATE tbl_user_master SET referral_id = '$rc' WHERE user_id = '$user_id'");

        $status = "Save";
        $status_text = "New Collector Added Successfully!";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];

echo json_encode($response, true);
?>
