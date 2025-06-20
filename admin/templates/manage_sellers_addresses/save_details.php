<?php
include("../db/db.php");
include("../db/activity.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage User Details";
} else {

	if ($entry_permission == 'Yes') {

		$sendData = json_decode($_POST['sendData'], true);

		$address_id = mysqli_real_escape_string($con, $sendData['address_id']);
		$user_id = mysqli_real_escape_string($con, $sendData['user_id']);
		$contact_name = mysqli_real_escape_string($con, $sendData['contact_name']);
		$contact_ph_num	 = mysqli_real_escape_string($con, $sendData['contact_ph_num']);
		$address_name = mysqli_real_escape_string($con, $sendData['address_name']);
		$country = mysqli_real_escape_string($con, $sendData['country']);
		$state = mysqli_real_escape_string($con, $sendData['state']);
		$city = mysqli_real_escape_string($con, $sendData['city']);
		$landmark = mysqli_real_escape_string($con, $sendData['landmark']);
		$pincode = mysqli_real_escape_string($con, $sendData['pincode']);
		$address_line_1 = mysqli_real_escape_string($con, $sendData['address_line_1']);
		$default_address = mysqli_real_escape_string($con, $sendData['default_address']);
		$seller_type = mysqli_real_escape_string($con, $sendData['seller_type']);


		//==============================IF CODE BLANK THEN INSERT==================================
		if ($address_id == "") {

			//========================= INSERT IN TABLE =======================
			mysqli_query($con, "INSERT INTO tbl_address_master (
					address_id,
					user_id,
					contact_name,
					contact_ph_num,
					address_name,
                    country, 
                    state, 
                    city,
					landmark, 
                    pincode, 
                    address_line_1,
                    entry_user_code,
					entry_timestamp) VALUES (
						null,
						'" . $user_id . "',
						'" . $contact_name . "',
						'" . $contact_ph_num . "',
						'" . $address_name . "',
						'" . $country . "',
						'" . $state . "',
						'" . $city . "',
						'" . $landmark . "',
						'" . $pincode . "',
						'" . $address_line_1 . "',
                    	'" . $session_user_code . "',
						'" . $timestamp . "')");

			// Get the ID of the inserted row
			$address_id = mysqli_insert_id($con);

			$status = "Save";
			$status_text = "New Seller Address Data Added Successfully";
			$activity_details = "You Insert A Record In Manage Buyers Addresses Details";
		}
		//============================== IF CODE DOES NOT BLANK THEN UPDATE ==================================
		else {

			if (!empty($seller_type)) {
	       mysqli_query($con, "UPDATE tbl_user_master SET seller_type = '$seller_type' WHERE user_id = '$user_id'");
}

			mysqli_query($con, "UPDATE tbl_address_master 
						SET
						address_id='" . $address_id . "',
						user_id='" . $user_id . "',
						contact_name='" . $contact_name . "', 
						contact_ph_num='" . $contact_ph_num . "', 
						address_name='" . $address_name . "', 
						country='" . $country . "', 
						state='" . $state . "', 
						city='" . $city . "',
						landmark='" . $landmark . "', 
						pincode='" . $pincode . "', 
						address_line_1='" . $address_line_1 . "',
						entry_user_code='" . $session_user_code . "', 
						entry_timestamp='" . $timestamp . "' 
						WHERE 
						tbl_address_master.address_id='" . $address_id . "' ");


			$status = "Save";
			$status_text = "Seller Address Data Updated Successfully";
			$activity_details = "You Update A Record In Manage Buyers Addressess Details";
		}

		// if default address === yes then update the address id in tbl_user_master
		if ($default_address == "Yes") {
			mysqli_query($con, "update tbl_user_master set address_id='" . $address_id . "' where user_id='" . $user_id . "' ");
		}
	} else {
		$status = "NoPermission";
		$status_text = "You Don't Have Permission To Entry Any Data !!";
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
