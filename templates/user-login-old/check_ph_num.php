<?php
include("../db/db.php");
include("../../module_function/sms_gateway_api.php");

$sendData = json_decode($_POST['sendData'], true);
$ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);

$execute = 1;

// process for generate & send otp
if ($execute == 1) {

	// Generate otp
	$generator = "123456789";
	$otp = "";

	for ($i = 1; $i <= 4; $i++) {
		$otp .= substr($generator, rand() % strlen($generator), 1);
	}

	$calDate = new DateTime($timestamp);
	$calDate->modify('+10 minutes');
	$valid_timestamp = $calDate->format('Y-m-d H:i:s');

	mysqli_query($con, "delete from tbl_otp_details where ph_num='" . $ph_num . "' ");

	mysqli_query($con, "insert into tbl_otp_details (ph_num, otp, valid_timestamp) values('" . $ph_num . "','" . $otp . "','" . $valid_timestamp . "')");

	$sendMssg = "Your OTP for Registration / Login is " . $otp . ". The OTP is valid for 10 Minutes - ZAG Tech Solutions";

	$sendPhNum = $ph_num;
	// $mssgSendResponse = sendSms();
	$mssgSendResponse = "success";

	// if otp not send
	if ($mssgSendResponse != "success") {
		$status = "error";
		$status_text = "Sorry! we are getting some errors in sending OTP. Please try after some time";
		$execute = 0;
	}
}

if ($execute == 1) {
	$userDataget = mysqli_query($con, "select name from tbl_user_master where ph_num='" . $ph_num . "' ");
	$userData = mysqli_fetch_row($userDataget);

	if ($userData) {
		$name = $userData[0];
		$status = "valid_user";
		$status_text = "Hi, " . $name . ", Welcome Back . Please verify it's you by giving otp";
	} else {
		$status = "new_user";
		$status_text = "Wow it's look like you are new to our platform. Please verify your phone number for next step";
	}
}

$response = [
	'status' => $status,
	'status_text' => $status_text,
	'otp' => $otp,
	'valid_timestamp' => $valid_timestamp,
];
echo json_encode($response, true);
