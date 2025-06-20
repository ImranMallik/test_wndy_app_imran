<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Sub Category Details";
} else {

	if ($entry_permission == 'Yes') {

		$sendData = json_decode($_POST['sendData'], true);

		$sub_category_id = mysqli_real_escape_string($con, $sendData['sub_category_id']);
		$sub_category_name = mysqli_real_escape_string($con, $sendData['sub_category_name']);
		$active = mysqli_real_escape_string($con, $sendData['active']);

		//==============================IF CODE BLANK THEN INSERT==================================
		if ($sub_category_id == "") {

			$execute = 1;

			// CHECK SUB CATEGORY NAME 
			if ($execute == 1) {
				$dataget = mysqli_query($con, "SELECT * FROM tbl_sub_category_master WHERE sub_category_name='" . $sub_category_name . "' ");
				$data = mysqli_fetch_row($dataget);
				if ($data) {
					$status = "Exist";
					$status_text = "Already Exists Sub-Category Name !!";
					$execute = 0;
				}
			}

			if ($execute == 1) {
				$sub_category_code = "SC_" . uniqid() . time();
				//=========================INSERT IN MENU MASTER=======================
				mysqli_query($con, "INSERT INTO tbl_sub_category_master (
								sub_category_id, 
								sub_category_name,
								active, 
								entry_user_code) values (
								NULL,
								'" . $sub_category_name . "',
								'" . $active . "',
								'" . $session_user_code . "')");

				$status = "Save";
				$status_text = "New Sub-Category Data Added Successfully";
				$activity_details = "You Insert A Record In Manage Product Sub-Category Details";
			} 
			
		}
		//==============================IF CODE DOES NOT BLANK THEN UPDATE==================================
		else {
			
			$execute = 1;

			// CHECK SUB CATEGORY NAME 
			if ($execute == 1) {
				$dataget = mysqli_query($con, "SELECT * FROM tbl_sub_category_master WHERE sub_category_id<>'".$sub_category_id."' and sub_category_name='" . $sub_category_name . "' ");
				$data = mysqli_fetch_row($dataget);
				if ($data) {
					$status = "Exist";
					$status_text = "Already Exists Sub-Category Name !!";
					$execute = 0;
				}
			}

			if ($execute == 1) {
				mysqli_query($con, "UPDATE tbl_sub_category_master SET 
					sub_category_name='" . $sub_category_name . "', 
					active='" . $active . "', 
					entry_user_code='" . $session_user_code . "', 
					update_timestamp='" . $timestamp . "' 
					WHERE sub_category_id='" . $sub_category_id . "' ");

				$status = "Save";
				$status_text = "Product Sub-Category Data Updated Successfully";
				$activity_details = "You Update A Record In Manage Sub-Category Details";
			} else {
				$status = "Exist";
				$status_text = "Already Exists Sub-Category Name !!";
			}
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
