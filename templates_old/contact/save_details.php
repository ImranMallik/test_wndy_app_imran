<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";


		$sendData = json_decode($_POST['sendData'], true);

		$name = mysqli_real_escape_string($con, $sendData['name']);
		$email = mysqli_real_escape_string($con, $sendData['email']);
		$phone = mysqli_real_escape_string($con, $sendData['phone']);
		$subject = mysqli_real_escape_string($con, $sendData['subject']);
		$message = mysqli_real_escape_string($con, $sendData['message']);

		$category_img_FileType = pathinfo($category_img, PATHINFO_EXTENSION);
		if (!in_array($category_img_FileType, $allowedImgExt)) {
			$category_img = "";
		}


			$execute = 1;

			if ($execute == 1) {
				$contact_code = "CC_" . uniqid() . time();
				//=========================INSERT IN MENU MASTER=======================
				mysqli_query($con, "insert into contact_form_details (
								contact_code, 
								name,
								ph_num, 
								email,
								subject,
								message,
								entry_user_code) values(
								'" . $contact_code . "',
								'" . $name . "',
								'" . $ph_num . "',
								'" . $email . "',
								'" . $subject . "',
								'" . $message . "',
								'" . $session_user_code . "')");

				$status = "Save";
				$status_text = "Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage Category Details";
			}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
