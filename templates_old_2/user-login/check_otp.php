<?php
include("../db/db.php");
include("../../module_function/whatsapp_notification.php");

$sendData = json_decode($_POST['sendData'], true);
$ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
$otp = mysqli_real_escape_string($con, $sendData['otp']);

$execute = 1;
$new_user = "Yes";
$userName = "";
$previousLogin = 'No';

// Check if the user exists
$userDataget = mysqli_query($con, "SELECT name, user_id FROM tbl_user_master WHERE ph_num='" . $ph_num . "' ");
$userData = mysqli_fetch_row($userDataget);

if ($userData) {
	$new_user = "No";
	$userName = $userData[0];
	$user_id = $userData[1];

	// Check if the user has previously logged in
	$user_token_dataget = mysqli_query($con, "SELECT * FROM login_token_auth WHERE user_code='" . $user_id . "' ");
	$user_token_data = mysqli_fetch_row($user_token_dataget);
	if ($user_token_data) {
		$previousLogin = 'Yes';
	}
}

// Check OTP
if ($execute == 1) {
	$dataget = mysqli_query($con, "SELECT otp, valid_timestamp FROM tbl_otp_details WHERE ph_num='" . $ph_num . "' ");
	$data = mysqli_fetch_row($dataget);

	if ($data) {
		$Valid_otp = $data[0];
		$valid_timestamp = $data[1];

		if ($valid_timestamp < time()) {
			$status = "error";
			$status_text = "Sorry!! OTP Expired";
			$execute = 0;
		}

		if ($execute == 1) {
			if ($otp == $Valid_otp) {
				$status = "success";
				$status_text = "Congrats!! OTP Verified";

				// ✅ Update is_verified to 1
				mysqli_query($con, "UPDATE tbl_otp_details SET is_verified = 1 WHERE ph_num = '$ph_num'");

				// Send WhatsApp notification only if the user is not logged in
				if ($previousLogin == 'No') {
					$phoneNumberGetData = mysqli_query($con, "SELECT DISTINCT(ph_num) FROM tbl_otp_details WHERE ph_num='" . $ph_num . "' ");
					$phoneNumberGet = mysqli_fetch_row($phoneNumberGetData);
					$phoneNumber = $phoneNumberGet[0];
					$timestamp = date('Y-m-d H:i:s');
					if ($phoneNumber) {
						// Send WhatsApp notification if user is not registered
						$sendPhoneNumber = $phoneNumber;
						mysqli_query($con, "INSERT INTO tbl_whatsapp_drop_off_noti  
						(phone_number, entry_time)  
						VALUES  
						('$sendPhoneNumber', '$timestamp')");
					}
				}
			} else {
				$status = "error";
				$status_text = "OTP entered is incorrect, Please try again";
			}
		}
	} else {
		$status = "error";
		$status_text = "No OTP record found for this number";
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
