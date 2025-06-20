<?php
include("../db/db.php");

// Read the incoming data
$sendData = json_decode($_POST['sendData'], true);

// Extract the data
$user_id = $session_user_code;
$contact_name = mysqli_real_escape_string($con, $sendData['contact_name']);
$contact_ph_num = mysqli_real_escape_string($con, $sendData['contact_ph_num']);
$address_name = mysqli_real_escape_string($con, $sendData['address_name']);
$address_id = mysqli_real_escape_string($con, $sendData['address_id']);
$country = mysqli_real_escape_string($con, $sendData['country']);
$state = mysqli_real_escape_string($con, $sendData['state']);
$city = mysqli_real_escape_string($con, $sendData['city']);
$landmark = mysqli_real_escape_string($con, $sendData['landmark']);
$pincode = mysqli_real_escape_string($con, $sendData['pincode']);
$address_line_1 = mysqli_real_escape_string($con, $sendData['address_line_1']);
$default_address = mysqli_real_escape_string($con, $sendData['default_address']);
$timestamp = date('Y-m-d H:i:s'); // Ensure timestamp is defined

$response = array();

if (empty($address_id)) {
    // Insert data into the database
    $query = "INSERT INTO tbl_address_master (user_id, contact_name, contact_ph_num, address_name, country, state, city, landmark, pincode, address_line_1, entry_user_code, entry_timestamp) 
              VALUES ('$user_id', '$contact_name', '$contact_ph_num', '$address_name', '$country', '$state', '$city', '$landmark', '$pincode', '$address_line_1', '$user_id', '$timestamp')";

    if (mysqli_query($con, $query)) {
        $get_last_dataget = mysqli_query($con, "SELECT max(address_id) FROM tbl_address_master WHERE user_id='" . $session_user_code . "' ");
        $get_last_data = mysqli_fetch_row($get_last_dataget);
        $get_last_data_id = $get_last_data[0];

        if ($default_address == "Yes") {
            // update user default address
            mysqli_query($con, "update tbl_user_master set address_id='" . $get_last_data_id . "' where user_id='" . $session_user_code . "' ");
        }

        $response[] = array(
            "status" => "success",
            "status_text" => "New Address Added Successfully",
            "address_id" => $get_last_data_id,
        );
    } else {
        $response[] = array(
            "status" => "error",
            "status_text" => "Error: " . mysqli_error($con)
        );
    }
} else {
    // Update existing data in the database
    $query = "UPDATE tbl_address_master 
              SET contact_name='$contact_name', contact_ph_num='$contact_ph_num', address_name='$address_name', country='$country', state='$state', city='$city', landmark='$landmark', pincode='$pincode', address_line_1='$address_line_1', entry_user_code='$user_id', update_timestamp='$timestamp' 
              WHERE address_id='$address_id'";

    if (mysqli_query($con, $query)) {

        if ($default_address == "Yes") {
            // update user default address
            mysqli_query($con, "update tbl_user_master set address_id='" . $address_id . "' where user_id='" . $session_user_code . "' ");
        }

        $response[] = array(
            "status" => "success",
            "status_text" => "Address Updated Successfully",
            "address_id" => $address_id,
        );
    } else {
        $response[] = array(
            "status" => "error",
            "status_text" => "Error: " . mysqli_error($con)
        );
    }
}

echo json_encode($response);
