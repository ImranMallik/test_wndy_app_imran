<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage User Details";
} else {

	if ($entry_permission == 'Yes') {

		$sendData = json_decode($_POST['sendData'], true);
		//  GET FILE DATA 
		$profile_img_fl = $_FILES['profile_img_fl'];

		$user_code = mysqli_real_escape_string($con, $sendData['user_code']);
		$user_id = mysqli_real_escape_string($con, $sendData['user_id']);
		$user_password = mysqli_real_escape_string($con, $sendData['user_password']);
		$name = mysqli_real_escape_string($con, $sendData['name']);
		$email = mysqli_real_escape_string($con, $sendData['email']);
		$user_mode_code = mysqli_real_escape_string($con, $sendData['user_mode_code']);
		$active = mysqli_real_escape_string($con, $sendData['active']);
		$entryPermission = mysqli_real_escape_string($con, $sendData['entry_permission']);
		$viewPermission = mysqli_real_escape_string($con, $sendData['view_permission']);
		$editPermission = mysqli_real_escape_string($con, $sendData['edit_permission']);
		$deletePermissioin = mysqli_real_escape_string($con, $sendData['delete_permissioin']);
		$profile_img = mysqli_real_escape_string($con, $sendData['profile_img']);

		$profile_img_FileType = pathinfo($profile_img, PATHINFO_EXTENSION);
		if (!in_array($profile_img_FileType, $allowedImgExt)) {
			$profile_img = "";
		}
		$encodePassword = base64_encode($user_password);

		$execute = 1;

		// Check file extension
		if ($execute == 1) {
			if ($profile_img_fl) {
				//current upload selected file name
				$target_file = basename($profile_img_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				if (!in_array($FileType, $allowedImgExt)) {
					$status = "profile_img error";
					$execute = 0;
					$status_text = "File Type Not Acceptable. Only jpg,jpeg,png,gif,webp,tiff,tif Accepted";
				}
			}
		}

		// Check file size
		if ($execute == 1) {
			if ($profile_img_fl) {

				$fileSize = $profile_img_fl["size"];

				$getMaxFileSizeDataget = mysqli_query($con, "select profile_image_max_kb_size from system_info where 1 ");
				$getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
				$getMaxFileSizeKb = $getMaxFileSizeData[0];
				$getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

				if ($fileSize > $getMaxFileSizeByets) {
					$status = "profile_img error";
					$execute = 0;
					$status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
				}
			}
		}

		// CHECK user_id 
		if ($execute == 1) {
			if ($user_code == "") {
				$dataget = mysqli_query($con, "select * from user_master where user_id='" . $user_id . "' ");
				$data = mysqli_fetch_row($dataget);
			} else {
				$dataget = mysqli_query($con, "select * from user_master where user_code<>'" . $user_code . "' and user_id='" . $user_id . "' ");
				$data = mysqli_fetch_row($dataget);
			}
			if ($data) {
				$status = "user_id error";
				$status_text = "User ID Already Exist !!";
				$execute = 0;
			}
		}

		// CHECK email_id 
		if ($execute == 1) {
			if ($user_code == "") {
				$dataget = mysqli_query($con, "select * from user_master where email_id='" . $email_id . "' ");
				$data = mysqli_fetch_row($dataget);
			} else {
				$dataget = mysqli_query($con, "select * from user_master where user_code<>'" . $user_code . "' and email_id='" . $email_id . "' ");
				$data = mysqli_fetch_row($dataget);
			}
			if ($data) {
				$status = "email_id error";
				$status_text = "Email Already Exist !!";
				$execute = 0;
			}
		}

		//===****** If all conditions check then start the insert, upload, update process ******=====//

		if ($execute == 1) {

			// Upload file 
			if ($profile_img_fl) {
				$target_dir = "../../../upload_content/upload_img/profile_img/";
				//current upload selected file name
				$target_file = basename($profile_img_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				//make a new file name like time+date+extention
				$image_name = $profile_img;
				//uploaded file store into computer temp memory which store into varriable
				$temp_file = $profile_img_fl["tmp_name"];
				//copy uploaded file store into desire path or location
				move_uploaded_file($temp_file, $target_dir . $image_name);
			}

			// Insert and update
			//============================== IF CODE BLANK THEN INSERT ==================================
			if ($user_code == "") {
				$user_code = "UC_" . uniqid() . time();
				//========================= INSERT IN TABLE =======================
				mysqli_query($con, "insert into user_master (
					id, 
					user_code, 
					user_id, 
					user_password, 
					name, 
					email, 
					profile_img, 
					user_mode_code, 
					active, 
					entry_permission, 
					view_permission, 
					edit_permission, 
					delete_permissioin,
					entry_user_code) values(null,
					'" . $user_code . "',
					'" . $user_id . "',
					'" . $encodePassword . "',
					'" . $name . "',
					'" . $email . "',
					'" . $profile_img . "',
					'" . $user_mode_code . "',
					'" . $active . "',
					'" . $entryPermission . "',
					'" . $viewPermission . "',
					'" . $editPermission . "',
					'" . $deletePermissioin . "',
					'" . $session_user_code . "')");

				$status = "Save";
				$status_text = "Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage User Details";
			} else {

				mysqli_query($con, "update user_master 
						set user_id='" . $user_id . "', 
						name='" . $name . "', 
						email='" . $email . "', 
						user_mode_code='" . $user_mode_code . "', 
						active='" . $active . "', 
						entry_permission='" . $entryPermission . "', 
						view_permission='" . $viewPermission . "', 
						edit_permission='" . $editPermission . "', 
						delete_permissioin='" . $deletePermissioin . "',
						entry_user_code='" . $session_user_code . "', 
						update_timestamp='" . $timestamp . "' 
						where 
						user_code='" . $user_code . "' ");

				$dataget = mysqli_query($con, "select profile_img from user_master where user_code='" . $user_code . "' ");
				$data = mysqli_fetch_row($dataget);
				$previous_profile_img = $data[0];

				if ($profile_img != "") {
					mysqli_query($con, "update user_master set profile_img='" . $profile_img . "' where user_code='" . $user_code . "' ");
					if ($previous_profile_img != "") {
						unlink("../../../upload_content/upload_img/profile_img/" . $previous_profile_img);
					}
				}

				if ($user_password != "") {
					mysqli_query($con, "update user_master set user_password='" . $encodePassword . "' where user_code='" . $user_code . "' ");
				}

				$status = "Save";
				$status_text = "Data Updated Successfully";
				$activity_details = "You Update A Record In Manage User Details";
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
