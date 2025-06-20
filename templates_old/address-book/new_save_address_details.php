<?php
include("../db/db.php");

// Read raw JSON input
$inputData = file_get_contents("php://input");
$decodedData = json_decode($inputData, true);



// Debugging: Check received data
file_put_contents("debug.log", print_r($decodedData, true), FILE_APPEND);

// Validate request data
if (!isset($decodedData['sendData'])) {
    echo json_encode([["status" => "error", "status_text" => "Invalid request data"]]);
    exit;
}

$sendData = $decodedData['sendData'];



// Extract and sanitize data
$user_id = $session_user_code;
$contact_name = mysqli_real_escape_string($con, $sendData['contact_name']);
$contact_ph_num = mysqli_real_escape_string($con, $sendData['contact_phone']);
$address_name = mysqli_real_escape_string($con, $sendData['address_name']);
$address_id = mysqli_real_escape_string($con, $sendData['address_id']);
$country = mysqli_real_escape_string($con, $sendData['country']);
$state = mysqli_real_escape_string($con, $sendData['state']);
$city = mysqli_real_escape_string($con, $sendData['city']);
$landmark = mysqli_real_escape_string($con, $sendData['landmark']);
$pincode = mysqli_real_escape_string($con, $sendData['pincode']);
$address_line_1 = mysqli_real_escape_string($con, $sendData['address_line']);
$default_address = isset($sendData['default_address']) ? mysqli_real_escape_string($con, $sendData['default_address']) : "No";
$timestamp = date('Y-m-d H:i:s');

$response = [];

// Insert or Update logic
if (empty($address_id)) {
    // Insert new address
    $query = "INSERT INTO tbl_address_master 
              (user_id, contact_name, contact_ph_num, address_name, country, state, city, landmark, pincode, address_line_1, entry_user_code, entry_timestamp) 
              VALUES ('$user_id', '$contact_name', '$contact_ph_num', '$address_name', '$country', '$state', '$city', '$landmark', '$pincode', '$address_line_1', '$user_id', '$timestamp')";

    if (mysqli_query($con, $query)) {
        $get_last_data = mysqli_fetch_row(mysqli_query($con, "SELECT max(address_id) FROM tbl_address_master WHERE user_id='$user_id' "));
        $get_last_data_id = $get_last_data[0];

        if ($default_address == "Yes") {
            mysqli_query($con, "UPDATE tbl_user_master SET address_id='$get_last_data_id' WHERE user_id='$user_id'");
        }

        $response[] = [
            "status" => "success",
            "status_text" => "New Address Added Successfully",
            "address_id" => $get_last_data_id
        ];
    } else {
        error_log("Insert Error: " . mysqli_error($con)); // Log MySQL error
        $response[] = ["status" => "error", "status_text" => "Insert Error: " . mysqli_error($con)];
    }
} else {
    // Update existing address
    $query = "UPDATE tbl_address_master 
              SET contact_name='$contact_name', 
                  contact_ph_num='$contact_ph_num', 
                  address_name='$address_name', 
                  country='$country', 
                  state='$state', 
                  city='$city', 
                  landmark='$landmark', 
                  pincode='$pincode', 
                  address_line_1='$address_line_1', 
                  entry_user_code='$user_id',
                  update_timestamp='$timestamp' 
              WHERE address_id='$address_id'";

    if (mysqli_query($con, $query)) {
        if ($default_address == "Yes") {
            mysqli_query($con, "UPDATE tbl_user_master SET address_id='$address_id' WHERE user_id='$user_id'");
        }

        $response[] = [
            "status" => "success",
            "status_text" => "Address Updated Successfully",
            "address_id" => $address_id
        ];
    } else {
        error_log("Update Error: " . mysqli_error($con)); // Log MySQL error
        $response[] = ["status" => "error", "status_text" => "Update Error: " . mysqli_error($con)];
    }
}

echo json_encode($response);
?>
