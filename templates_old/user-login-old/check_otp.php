<?php
include("../db/db.php");
include("../../module_function/whatsapp_notification.php");

$sendData = json_decode($_POST['sendData'], true);
$ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
$otp = mysqli_real_escape_string($con, $sendData['otp']);

$execute = 1;
$new_user = "Yes";  // Default assumption: user is new
$userName = "";
$previousLogin = 'No';

// Get the current timestamp
$timestamp = time(); 

// Check if the user exists in tbl_user_master
$userDataget = mysqli_query($con, "SELECT name, user_id FROM tbl_user_master WHERE ph_num='" . $ph_num . "'");
$userData = mysqli_fetch_row($userDataget);

if ($userData) {
    $new_user = "No"; // User exists
    $userName = $userData[0];
    $user_id = $userData[1];

    // Check if the user has logged in before
    $user_token_dataget = mysqli_query($con, "SELECT * FROM login_token_auth WHERE user_code='" . $user_id . "'");
    $user_token_data = mysqli_fetch_row($user_token_dataget);
    if ($user_token_data) {
        $previousLogin = 'Yes';
    }
}

// Check OTP
if ($execute == 1) {
    $dataget = mysqli_query($con, "SELECT otp, valid_timestamp FROM tbl_otp_details WHERE ph_num='" . $ph_num . "'");
    $data = mysqli_fetch_row($dataget);

    $Valid_otp = $data[0];
    $valid_timestamp = $data[1];

    if ($valid_timestamp < $timestamp) {
        $status = "error";
        $status_text = "Sorry!! OTP Expired";
        $execute = 0;
    }

    if ($execute == 1) {
        if ($otp == $Valid_otp) {
            $status = "success";
            $status_text = "Congrats!! OTP Verified";

            // **Call sendWhatsappMessage() if OTP is verified but user is NOT registered**
            if ($new_user == "Yes") {  
                $phoneNumberGetData = mysqli_query($con, "SELECT DISTINCT(ph_num) FROM tbl_otp_details WHERE ph_num='" . $ph_num . "'");
                $phoneNumberGet = mysqli_fetch_row($phoneNumberGetData);
                $phoneNumber = $phoneNumberGet[0];

                if ($phoneNumber) {
                    $sendPhoneNumber = $phoneNumber;
                    $campaignName = 'drop_off_msg';
                    $fetchUserName = $userName;
                    $params = ["$fetchUserName"];
                    sendWhatsappMessage();
                }
            }
        } else {
            $status = "error";
            $status_text = "OTP entered is incorrect, Please try again";
        }
    }
}

$response = [
    'status' => $status,
    'status_text' => $status_text,
    'new_user' => $new_user,
    'userName' => $userName,
    'previousLogin' => $previousLogin,
];

echo json_encode($response, true);
?>
