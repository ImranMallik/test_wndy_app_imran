<?php
include("../db/db.php");
include("../db/activity.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$activity_details = "";

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroyed In Manage User Details";
} else {

    if ($entry_permission == 'Yes') {

        $sendData = json_decode($_POST['sendData'], true);

        $address_id = mysqli_real_escape_string($con, $sendData['address_id']);
        $user_id = mysqli_real_escape_string($con, $sendData['user_id']);
        $under_buyer_id = mysqli_real_escape_string($con, $sendData['under_buyer_id']);
        $user_id_collector = mysqli_real_escape_string($con, $sendData['user_id_collector']);
        $ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
        $country = mysqli_real_escape_string($con, $sendData['country']);
        $state = mysqli_real_escape_string($con, $sendData['state']);
        $city = mysqli_real_escape_string($con, $sendData['city']);
        $landmark = mysqli_real_escape_string($con, $sendData['landmark']);
        $pincode = mysqli_real_escape_string($con, $sendData['pincode']);
        $address_line_1 = mysqli_real_escape_string($con, $sendData['address_line_1']);
        $user_type = "Collector";

        //==============================IF CODE BLANK THEN INSERT==================================
        if ($user_id == "") {

            //========================= INSERT IN TABLE =======================
            mysqli_query($con, "INSERT INTO tbl_user_master (
                user_id,
                name,
                ph_num,
                address_id,
                under_buyer_id,
                user_type,
                entry_user_code,
                entry_timestamp) VALUES (
                    null,
                    '" . $user_id_collector . "',
                    '" . $ph_num . "',
                    '" . $address_id . "',
                    '" . $under_buyer_id . "',
                    '" . $user_type . "',
                    '" . $session_user_code . "',
                    '" . $timestamp . "')");

            $status = "Save";
            $status_text = "New Collector Address Data Added Successfully";
            $activity_details = "You Inserted A Record In Manage Collectors Addresses Details";
        }
        //============================== IF CODE DOES NOT BLANK THEN UPDATE ==================================
        else {
            mysqli_query($con, "UPDATE tbl_user_master 
                SET
                under_buyer_id='" . $under_buyer_id . "',
                address_id='" . $address_id . "',
                entry_user_code='" . $session_user_code . "', 
                update_timestamp='" . $timestamp . "' 
                WHERE 
                user_id='" . $user_id . "'");

            $status = "Save";
            $status_text = "Collector Address Data Updated Successfully";
            $activity_details = "You Updated A Record In Manage Collectors Addresses Details";
        }
    } else {
        $status = "NoPermission";
        $status_text = "You Don't Have Permission To Enter Any Data !!";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);

if ($activity_details != "") {
    insertActivity($activity_details, $con, $session_user_code);
}
