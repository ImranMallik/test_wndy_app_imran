<?php
include("../db/db.php");
include("../db/activity.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Customer Details";
} else {

	if ($entry_permission == 'Yes') {

		//  GET FILE DATA 
		$img_fl = $_FILES['img_fl'];

		$sendData = json_decode($_POST['sendData'], true);

		$testimonial_id = mysqli_real_escape_string($con, $sendData['testimonial_id']);
		$name = mysqli_real_escape_string($con, $sendData['name']);
		$designation = mysqli_real_escape_string($con, $sendData['designation']);
		$msg = mysqli_real_escape_string($con, $sendData['msg']);
		$rating = mysqli_real_escape_string($con, $sendData['rating']);
		$img = mysqli_real_escape_string($con, $sendData['img']);

		$img_FileType = pathinfo($img, PATHINFO_EXTENSION);
		if (!in_array($img_FileType, $allowedImgExt)) {
			$img = "";
		}

		$execute = 1;

		// Check file extension
		if ($execute == 1) {
			if ($img_fl) {
				//current upload selected file name
				$target_file = basename($img_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				if (!in_array($FileType, $allowedImgExt)) {
					$status = "img error";
					$execute = 0;
					$status_text = "File Type is Not Acceptable. Only jpg, jpeg, png, gif, webp, tiff, tif Accepted";
				}
			}
		}

		// Check file size
		if ($execute == 1) {
			if ($img_fl) {

				$fileSize = $img_fl["size"];

				$getMaxFileSizeDataget = mysqli_query($con, "SELECT profile_image_max_kb_size FROM system_info WHERE 1 ");
				$getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
				$getMaxFileSizeKb = $getMaxFileSizeData[0];
				$getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

				if ($fileSize > $getMaxFileSizeByets) {
					$status = "img error";
					$execute = 0;
					$status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
				}
			}
		}

		// Upload file 
		if ($execute == 1) {
			if ($img_fl) {

				$target_dir = "../../../upload_content/upload_img/testimonial_img/";
				//current upload selected file name
				$target_file = basename($img_fl["name"]);
				//current upload selected file extension like .jpg/.png/.tif/.bmp etc
				$FileType = pathinfo($target_file, PATHINFO_EXTENSION);
				//make a new file name like time+date+extention
				$image_name = $img;
				//uploaded file store into computer temp memory which store into varriable
				$temp_file = $img_fl["tmp_name"];
				//copy uploaded file store into desire path or location
				move_uploaded_file($temp_file, $target_dir . $image_name);
			}
		}

		//==============================IF CODE BLANK THEN INSERT==================================
		if ($execute == 1) {

			if ($testimonial_id == "") {

					// INSERT IN TABLE
					mysqli_query($con, "INSERT INTO tbl_testimonial ( 
						testimonial_id, 
						name, 
						designation, 
						msg, 
						img, 
						rating,
						entry_user_code) VALUES (
							NULL,
							'" . $name	 . "',
							'" . $designation . "',
							'" . $msg . "',
							'" . $img . "',
							'" . $rating . "',
							'" . $session_user_code . "')");
					$status = "Save";
					$status_text = "New Testimonial Data Saved Successfully";
					$activity_details = "You Insert A Record In Manage Testimonials Details";
		//==============================IF CODE DOES NOT BLANK THEN UPDATE==================================
			} else {

					mysqli_query($con, "UPDATE tbl_testimonial SET  
						name='" . $name . "', 
						designation='" . $designation . "', 
						msg='" . $msg . "', 
						rating='" . $rating . "',
						entry_user_code='" . $session_user_code . "', 
						update_timestamp='" . $timestamp . "'  
						WHERE testimonial_id='" . $testimonial_id . "' ");


					$dataget = mysqli_query($con, "SELECT img FROM tbl_testimonial WHERE testimonial_id='" . $testimonial_id . "' ");
					$data = mysqli_fetch_row($dataget);
					$previous_img = $data[0];

					if ($img != "") {
						mysqli_query($con, "UPDATE tbl_testimonial SET img='" . $img . "' WHERE testimonial_id='" . $testimonial_id . "' ");
						if ($previous_img != "") {
							unlink("../../../upload_content/upload_img/testimonial_img/" . $previous_img);
						}
					}

					$status = "Save";
					$status_text = "Testimonial Data Updated Successfully";
					$activity_details = "You Update A Record In Manage Testimonials Details";
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
