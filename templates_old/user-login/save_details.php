<?php
include("../db/db.php");
include("../../module_function/whatsapp_notification.php");
include("../db/router.php");
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

//========================= CHECK IF PHONE EXISTS =======================
$datagett = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE tbl_user_master.ph_num = '" . $ph_num . "' ");
$rw = mysqli_num_rows($datagett);
if ($rw > 0) {
	$status = "ph_num Exist";
	$status_text = "Phone Number Already Exists!";
	$save = 0;
}

if ($save == 1) {

	//========================= INSERT USER TEMPORARILY =======================
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

//========================= Generate Referral Code =======================

// Step 1: Get the new user's prefix from name
$prefix = strtoupper(substr(preg_replace("/[^A-Za-z]/", '', $user_name), 0, 3));
if (strlen($prefix) < 3) {
    $prefix = str_pad($prefix, 3, 'X'); // Fallback for short names
}

// Step 2: Get the referral_id of the latest user (highest user_id)
$getLastUser = mysqli_query($con, "
    SELECT referral_id 
    FROM tbl_user_master 
    WHERE referral_id IS NOT NULL AND referral_id != '' 
    ORDER BY user_id DESC 
    LIMIT 1
");

$referral_number = 1;

if (mysqli_num_rows($getLastUser) > 0) {
    $last_referral = mysqli_fetch_assoc($getLastUser)['referral_id'];
    
    // Step 3: Extract numeric part (last 4 digits assumed)
    preg_match('/(\d{4,})$/', $last_referral, $matches);
    
    if (isset($matches[1])) {
        $referral_number = intval($matches[1]) + 1;
    }
}

// Step 4: Format number and combine
$referral_number = str_pad($referral_number, 4, '0', STR_PAD_LEFT);
$rc = $prefix . $referral_number;

// Step 5: Update user record
mysqli_query($con, "UPDATE tbl_user_master SET referral_id = '$rc' WHERE user_id = '$user_id'");


	//========================= Handle Referral Link =======================
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

	//========================= WhatsApp Notification =======================
	$fetchUserDetails = mysqli_query($con, "SELECT ph_num, name FROM tbl_user_master WHERE ph_num = '" . $ph_num . "' ");
	$fetchUser = mysqli_fetch_row($fetchUserDetails);
	$fetchUserPhnNo = $fetchUser[0];
	$fetchUserName = $fetchUser[1];

	if ($fetchUserPhnNo) {
		$sendPhoneNumber = $fetchUserPhnNo;

		if ($user_type == "Buyer") {
			$campaignName = "welcome_buyer_msg";
			$params = [$fetchUserName];
			$media = [
				"url" => $baseUrl . "/upload_content/whtasapp_assets/welcome_buyer.jpg",
				"filename" => "sample_media"
			];
		} else if ($user_type == "Seller") {
			$campaignName = "last_welcome_seller_video03";
			$params = [
				$fetchUserName,
				$baseUrl
			];
			$media = [
				"url" => $baseUrl . "/upload_content/whtasapp_assets/welcome_video.mp4",
				"filename" => "sample_media"
			];
		} else {
			$media = [
				"url" => "https://tpecom.tpddt.shop/wndyapp-local/upload_content/upload_img/product_img/product_image_1_4-2-2025-1741097838345.jpg",
				"filename" => "sample_media"
			];
		}
		sendWhatsappMessage(); // Make sure this function uses $sendPhoneNumber, $params, $media, $campaignName
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
?>
