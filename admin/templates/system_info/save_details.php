<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage System Info";
} else {

	if ($entry_permission == 'Yes') {

		$sendData = json_decode($_POST['sendData'], true);

		//  GET FILE DATA 
		$logo_fl = $_FILES['logo_fl'];
		$favicon_fl = $_FILES['favicon_fl'];

		$system_name = mysqli_real_escape_string($con, $sendData['system_name']);
		$email = mysqli_real_escape_string($con, $sendData['email']);
		$address = mysqli_real_escape_string($con, $sendData['address']);
		$ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
		$product_view_credit = mysqli_real_escape_string($con, $sendData['product_view_credit']);
		// $profile_image_max_kb_size = mysqli_real_escape_string($con, $sendData['profile_image_max_kb_size']);
		// $category_image_max_kb_size = mysqli_real_escape_string($con, $sendData['category_image_max_kb_size']);
		// $product_image_max_kb_size = mysqli_real_escape_string($con, $sendData['product_image_max_kb_size']);
		// $product_file_max_kb_size = mysqli_real_escape_string($con, $sendData['product_file_max_kb_size']);
		// $home_slider_max_kb_size = mysqli_real_escape_string($con, $sendData['home_slider_max_kb_size']);

		$logo = mysqli_real_escape_string($con, $sendData['logo']);
		$favicon = mysqli_real_escape_string($con, $sendData['favicon']);

		$logo_FileType = pathinfo($logo, PATHINFO_EXTENSION);
		if (!in_array($logo_FileType, $allowedImgExt)) {
			$logo = "";
		}

		$favicon_FileType = pathinfo($favicon, PATHINFO_EXTENSION);
		if (!in_array($favicon_FileType, $allowedImgExt)) {
			$favicon = "";
		}

		$execute = 1;

		// Check logo file extension
		if ($execute == 1) {
			if ($logo_fl) {
				//current upload selected file name
				$target_file = basename($logo_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				if (!in_array($FileType, $allowedImgExt)) {
					$status = "logo error";
					$execute = 0;
					$status_text = "File Type Not Acceptable. Only jpg,jpeg,png,gif,webp,tiff,tif Accepted";
				}
			}
		}

		// Check favicon file extension
		if ($execute == 1) { 
			if ($favicon_fl) {
				//current upload selected file name
				$target_file = basename($favicon_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				if (!in_array($FileType, $allowedImgExt)) {
					$status = "favicon error";
					$execute = 0;
					$status_text = "File Type Not Acceptable. Only jpg,jpeg,png,gif,webp,tiff,tif Accepted";
				}
			}
		}

		// Check logo file size
		if ($execute == 1) {
			if ($logo_fl) {

				$fileSize = $logo_fl["size"];

				$getMaxFileSizeByets = 10 * 1024;

				if ($fileSize > $getMaxFileSizeByets) {
					$status = "logo error";
					$execute = 0;
					$status_text = "File size exceeded. Please keep under 10 kb";
				}
			}
		}

		// Check logo file size
		if ($execute == 1) {
			if ($favicon_fl) {

				$fileSize = $favicon_fl["size"];

				$getMaxFileSizeByets = 10 * 1024;

				if ($fileSize > $getMaxFileSizeByets) {
					$status = "favicon error";
					$execute = 0;
					$status_text = "File size exceeded. Please keep under 10 kb";
				}
			}
		}


		//===****** If all conditions check then start the insert, upload, update process ******=====//

		// Upload file 
		if ($execute == 1) {
			if ($logo_fl) {
				$target_dir = "../../../upload_content/upload_img/system_img/";
				//current upload selected file name
				$target_file = basename($logo_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				//make a new file name like time+date+extention
				$image_name = $logo;
				//uploaded file store into computer temp memory which store into varriable
				$temp_file = $logo_fl["tmp_name"];
				//copy uploaded file store into desire path or location
				move_uploaded_file($temp_file, $target_dir . $image_name);
			}
			if ($favicon_fl) {
				$target_dir = "../../../upload_content/upload_img/system_img/";
				//current upload selected file name
				$target_file = basename($favicon_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				//make a new file name like time+date+extention
				$image_name = $favicon;
				//uploaded file store into computer temp memory which store into varriable
				$temp_file = $favicon_fl["tmp_name"];
				//copy uploaded file store into desire path or location
				move_uploaded_file($temp_file, $target_dir . $image_name);
			}
		}

		if ($execute == 1) {

			$dataget = mysqli_query($con, "select * from system_info ");
			$data = mysqli_fetch_row($dataget);

			if (!$data) {
				//========================= INSERT IN  TABLE =======================
				mysqli_query($con, "INSERT INTO system_info (
				id, 
				system_name, 
				logo, 
				favicon, 
				email, 
				address, 
				ph_num,
				product_view_credit
				entry_user_code) VALUES (
					null,
				'" . $system_name . "',
				'" . $logo . "',
				'" . $favicon . "',
				'" . $email . "',
				'" . $address . "',
				'" . $ph_num . "',
				'" . $product_view_credit . "',
				'" . $session_user_code . "')");

				$status = "Save";
				$status_text = "System Info Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage System Info";
			} else {
				mysqli_query($con, "UPDATE system_info 
						SET system_name='" . $system_name . "', 
						email='" . $email . "', 
						address='" . $address . "', 
						ph_num='" . $ph_num . "',
						product_view_credit='" . $product_view_credit . "', 
						entry_user_code='" . $session_user_code . "', 
						update_timestamp='" . $timestamp . "' 
						WHERE 1 ");

				$dataget = mysqli_query($con, "SELECT logo, favicon FROM system_info WHERE 1 ");
				$data = mysqli_fetch_row($dataget);
				$previous_logo = $data[0];
				$previous_favicon = $data[1];

				if ($logo != "") {
					mysqli_query($con, "UPDATE system_info SET logo='" . $logo . "' WHERE 1 ");
					if ($previous_logo != "") {
						unlink("../../../upload_content/upload_img/system_img/" . $previous_logo);
					}
				}
				if ($favicon != "") {
					mysqli_query($con, "UPDATE system_info SET favicon='" . $favicon . "' WHERE 1 ");
					if ($previous_favicon != "") {
						unlink("../../../upload_content/upload_img/system_img/" . $previous_favicon);
					}
				}

				$status = "Save";
				$status_text = "System Info Data Updated Successfully";
				$activity_details = "You Update A Record In Manage System Info";
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
