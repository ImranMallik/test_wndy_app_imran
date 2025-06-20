<?php
// Improved error handling for debugging purposes
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    include("../db/db.php");
    include("../db/activity.php");

    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

    $activity_details = "";

    if ($login == "No") {
        $status = "SessionDestroy";
        $status_text = "";
        $activity_details = "Your Session Was Destroy In Manage Buyers Details";
    } else {
        if ($entry_permission == 'Yes') {
            $sendData = json_decode($_POST['sendData'], true);

            //  GET FILE DATA 
            $user_img_fl = $_FILES['user_img_fl'];

            $user_id = trim(mysqli_real_escape_string($con, $sendData['user_id']));
            $name = trim(mysqli_real_escape_string($con, $sendData['name']));
            $country_code = mysqli_real_escape_string($con, $sendData['country_code']);
            $ph_num = trim(mysqli_real_escape_string($con, $sendData['ph_num']));
            $email_id = strtolower(trim(mysqli_real_escape_string($con, $sendData['email_id'])));
            $dob = mysqli_real_escape_string($con, $sendData['dob']);
            $pan_num = mysqli_real_escape_string($con, $sendData['pan_num']);
            $aadhar_num = mysqli_real_escape_string($con, $sendData['aadhar_num']);
            $gst_num = mysqli_real_escape_string($con, $sendData['gst_num']);
            $authorization_certificate_num = mysqli_real_escape_string($con, $sendData['authorization_certificate_num']);
            $buyer_type = mysqli_real_escape_string($con, $sendData['buyer_type']);
            $active = mysqli_real_escape_string($con, $sendData['active']);
            $user_img = mysqli_real_escape_string($con, $sendData['user_img']);
            $pincode = mysqli_real_escape_string($con, $sendData['pin_code']);

            $user_type = "Buyer";

            $user_img_FileType = pathinfo($user_img, PATHINFO_EXTENSION);
            if (!in_array($user_img_FileType, $allowedImgExt)) {
                $user_img = "";
            }

            $execute = 1;

            // Check file extension
            if ($execute == 1) {
                if ($user_img_fl) {
                    $target_file = basename($user_img_fl["name"]);
                    $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    if (!in_array($FileType, $allowedImgExt)) {
                        $status = "user_img error";
                        $execute = 0;
                        $status_text = "File Type Not Acceptable. Only jpg, jpeg, png, gif, webp, tiff, tif Accepted";
                    }
                }
            }

            // Check file size
            if ($execute == 1) {
                if ($user_img_fl) {
                    $fileSize = $user_img_fl["size"];

                    $getMaxFileSizeDataget = mysqli_query($con, "SELECT profile_image_max_kb_size FROM system_info WHERE 1 ");
                    $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
                    $getMaxFileSizeKb = $getMaxFileSizeData[0];
                    $getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

                    if ($fileSize > $getMaxFileSizeByets) {
                        $status = "user_img error";
                        $execute = 0;
                        $status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
                    }
                }
            }

            // CHECK ph_num 
            if ($execute == 1) {
                if ($user_id == "") {
                    $dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE ph_num='" . $ph_num . "'");
                    $data = mysqli_fetch_row($dataget);
                } else {
                    $dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE user_id<>'" . $user_id . "' and ph_num='" . $ph_num . "' ");
                    $data = mysqli_fetch_row($dataget);
                }
                if ($data) {
                    $status = "ph_num error";
                    $status_text = "Phone Number Already Exists !!";
                    $execute = 0;
                }
            }

            // CHECK email_id 
            if ($execute == 1 && $email_id != "") {
                if ($user_id == "") {
                    $dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE email_id='" . $email_id . "' ");
                    $data = mysqli_fetch_row($dataget);
                } else {
                    $dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE user_id<>'" . $user_id . "' and email_id='" . $email_id . "' ");
                    $data = mysqli_fetch_row($dataget);
                }

                if ($data) {
                    $status = "email_id error";
                    $status_text = "Email Id Already Exists !!";
                    $execute = 0;
                }
            }

            //===****** If all conditions check then start the insert, upload, update process ******=====//

            // Upload file 
            if ($execute == 1) {
                if ($user_img_fl) {
                    $target_dir = "../../../upload_content/upload_img/user_img/";
                    $target_file = basename($user_img_fl["name"]);
                    $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $image_name = $user_img;
                    $temp_file = $user_img_fl["tmp_name"];
                    move_uploaded_file($temp_file, $target_dir . $image_name);
                }
            }

            // Insert and update
            if ($execute == 1) {
                if ($user_id == "") {
                    mysqli_query($con, "INSERT INTO tbl_user_master (
                            name, country_code, ph_num, email_id, dob, pan_num, aadhar_num, gst_num, authorization_certificate_num, buyer_type, active, user_img, user_type, entry_user_code) 
                        VALUES ('$name', '$country_code', '$ph_num', '$email_id', '$dob', '$pan_num', '$aadhar_num', '$gst_num', '$authorization_certificate_num', '$buyer_type', '$active', '$user_img', '$user_type', '$session_user_code')");

                    $status = "success";
                    $status_text = "New Buyer Added Successfully";
                    $activity_details = "You Insert A Record In Manage Buyers Details";
                } else {
                    mysqli_query($con, "UPDATE tbl_user_master SET  
                        name='$name', country_code='$country_code', ph_num='$ph_num', email_id='$email_id', dob='$dob', pan_num='$pan_num', aadhar_num='$aadhar_num', gst_num='$gst_num', authorization_certificate_num='$authorization_certificate_num', buyer_type='$buyer_type', active='$active', entry_user_code='$session_user_code', update_timestamp='$timestamp' 
                        WHERE user_id='$user_id'");

                        	$addr_query = mysqli_query($con, "SELECT address_id FROM tbl_user_master WHERE user_id = '$user_id'");
                $addr_data = mysqli_fetch_assoc($addr_query);
                $address_id = $addr_data['address_id'];
				if (!empty($address_id)) {
	            mysqli_query($con, "UPDATE tbl_address_master SET 
		        pincode = '$pincode' 
		        WHERE address_id = '$address_id'");
                }

                    $dataget = mysqli_query($con, "SELECT user_img FROM tbl_user_master WHERE user_id='$user_id'");
                    $data = mysqli_fetch_row($dataget);
                    $previous_user_img = $data[0];

                    if ($user_img != "") {
                        mysqli_query($con, "UPDATE tbl_user_master SET user_img='$user_img' WHERE user_id='$user_id'");
                        if ($previous_user_img != "") {
                            unlink("../../../upload_content/upload_img/user_img/" . $previous_user_img);
                        }
                    }

                    $status = "Save";
                    $status_text = "Buyer Details Updated Successfully";
                    $activity_details = "You Update A Record In Manage Buyers Details";
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
} catch (Exception $e) {
    error_log($e->getMessage());
    $response[] = [
        'status' => 'error',
        'status_text' => $e->getMessage(),
    ];
    echo json_encode($response, true);
}
