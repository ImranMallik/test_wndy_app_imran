<?php
include("../db/db.php");
include("../../module_function/whatsapp_notification.php");
$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);

$user_name = mysqli_real_escape_string($con, $sendData['user_name']);
$ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
$user_type = mysqli_real_escape_string($con, $sendData['user_type']);
$buyer_type = mysqli_real_escape_string($con, $sendData['buyer_type']);
$seller_type = mysqli_real_escape_string($con, $sendData['seller_type']);
$referral_code = mysqli_real_escape_string($con, $sendData['referral_code']);

if ($user_type == "Seller") {
	$buyer_type = "";
}
if ($user_type == "Buyer") {
	$seller_type = "";
}

$save = 1;

//=============================== Referral Code Generator ============================
$generator = "0123456789";
$refferalCode = "";

for ($i = 1; $i <= 10; $i++) {
	$refferalCode .= substr($generator, rand() % strlen($generator), 1);
}

//========================= CHECK SAME DATA EXIST OR NOT =======================
if ($save == 1) {
	$datagett = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE tbl_user_master.ph_num = '" . $ph_num . "' ");
	$rw = mysqli_num_rows($datagett);
	if ($rw > 0) {
		$status = "ph_num Exist";
		$status_text = "Phone Number Already Exists!";
		$save = 0;
	}
}

if ($save == 1) {

	//========================= INSERT IN TABLE =======================
	mysqli_query($con, "INSERT INTO tbl_user_master (
						name,
						ph_num,
						user_type,
						buyer_type,
						seller_type,
						referral_id) 
						VALUES (
						'" . $user_name . "',
						'" . $ph_num . "',
						'" . $user_type . "',
						'" . $buyer_type . "',
						'" . $seller_type . "',
						'')");

	$user_id = mysqli_insert_id($con);

	// Generate the referral code
	$rc = "RC" . $refferalCode . "B" . $user_id;

	// Update the user with the referral code
	mysqli_query($con, "UPDATE tbl_user_master SET referral_id = '$rc' WHERE user_id = '$user_id'");

	// Handle referral code, if provided
	if (!empty($referral_code)) {
		$referral_query = mysqli_query($con, "SELECT user_id FROM tbl_user_master WHERE referral_id = '$referral_code'");
		if (mysqli_num_rows($referral_query) > 0) {
			$referral_by_user = mysqli_fetch_row($referral_query)[0];
			mysqli_query($con, "UPDATE tbl_user_master SET under_referral_by = '$referral_by_user' WHERE user_id = '$user_id'");
		} else {
			$response[] = [
				'status' => 'referral_code Not Exists',
				'status_text' => 'Referral Code Doesn\'t Exist!',
			];
			echo json_encode($response, true);
			exit;
		}
	}

	$fetchUserDetails = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE ph_num = '" . $ph_num . "' ");
	$fetchUser = mysqli_fetch_row($fetchUserDetails);
	$fetchUserPhnNo = $fetchUser[0];
	$fetchUserName = $fetchUser[1];


	if ($fetchUserPhnNo) {
		## Send whatsapp notification if user registered successfully
		$sendPhoneNumber = $fetchUserPhnNo;
		$fetchUserName = $fetchUserName;
		if ($user_type == "Buyer") {
			$campaignName = "welcome_buyer_msg";
		} else if ($user_type == "Seller") {
			$campaignName = "welcome_seller_msg";
		} else {
			$campaignName = "welcome_user_msg";
		}

		$params = [$fetchUserName];
		sendWhatsappMessage();
	}

	$status = "Save";
	$status_text = "New User Registered Successfully";
	$activity_details = "You Insert A Record In Manage User Details";
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
	'message' => 'Message sent successfully'
];
echo json_encode($response, true);
