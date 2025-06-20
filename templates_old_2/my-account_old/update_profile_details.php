<?php
include("../db/db.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
} else {

	$sendData = json_decode($_POST['sendData'], true);

	$user_id = $session_user_code;
	$name = mysqli_real_escape_string($con, $sendData['name']);
	$ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
	$email_id = mysqli_real_escape_string($con, $sendData['email_id']);
	$dob = mysqli_real_escape_string($con, $sendData['dob']);
	$pan_num = mysqli_real_escape_string($con, $sendData['pan_num']);
	$aadhar_num	= mysqli_real_escape_string($con, $sendData['aadhar_num']);
	$gst_num = mysqli_real_escape_string($con, $sendData['gst_num']);
	$authorization_certificate_num = mysqli_real_escape_string($con, $sendData['authorization_certificate_num']);

	$user_img = mysqli_real_escape_string($con, $sendData['user_img']);

	$user_img_FileType = pathinfo($user_img, PATHINFO_EXTENSION);
	if (!in_array($user_img_FileType, $allowedImgExt)) {
		$user_img = "";
	}

	$execute = 1;

	// CHECK ph_num 
	if ($execute == 1) {
		$dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE tbl_user_master.ph_num='" . $ph_num . "' and user_id<>'" . $user_id . "' ");
		$data = mysqli_fetch_row($dataget);
		if ($data) {
			$status = "ph_num Exist";
			$status_text = "Already Exists Same Phone Number !!";
			$execute = 0;
		}
	}

	// CHECK email_id 
	if ($execute == 1 && $email_id != "") {
		$dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE tbl_user_master.email_id='" . $email_id . "' and user_id<>'" . $user_id . "' ");
		$data = mysqli_fetch_row($dataget);
		if ($data) {
			$status = "email_id Exist";
			$status_text = "Already Exists Same Email !!";
			$execute = 0;
		}
	}

	if ($execute == 1) {
		mysqli_query($con, "UPDATE tbl_user_master SET 
				name	='" . $name	 . "', 
				ph_num='" . $ph_num . "', 
				email_id='" . $email_id . "',
				dob='" . $dob . "',
				pan_num='" . $pan_num . "', 
				aadhar_num='" . $aadhar_num . "', 
				gst_num	='" . $gst_num	 . "',
				authorization_certificate_num='" . $authorization_certificate_num . "',
				entry_user_code='" . $session_user_code . "', 
				entry_timestamp='" . $timestamp . "',
				update_timestamp='" . $timestamp . "' 
				WHERE user_id='" . $user_id . "' ");

		$dataget = mysqli_query($con, "SELECT user_img FROM tbl_user_master WHERE user_id='" . $user_id . "' ");
		$data = mysqli_fetch_row($dataget);
		$previous_user_img = $data[0];

		if ($user_img != "") { // Changed from $customer_img to $user_img
			mysqli_query($con, "UPDATE tbl_user_master SET user_img='" . $user_img . "' WHERE user_id='" . $user_id . "' ");
			if ($previous_user_img != "") {
				unlink("../../upload_content/upload_img/user_img/" . $previous_user_img);
			}
		}

		$status = "Save";
		$status_text = "Profile Updated Successfully";
	}
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);
