<?php
include("../db/db.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
} else {

	$sendData = json_decode($_POST['sendData'], true);

	$user_id = $session_user_code;
	$type = mysqli_real_escape_string($con, $sendData['type']);
	$value = mysqli_real_escape_string($con, $sendData['value']);

	if ($value != "Skip") {
		switch ($type) {
			case 'waste_cate':
				mysqli_query($con, "UPDATE tbl_user_master SET waste_cate='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'working_days':
				mysqli_query($con, "UPDATE tbl_user_master SET working_days='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'working_method':
				mysqli_query($con, "UPDATE tbl_user_master SET working_method='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'livelihood_source':
				mysqli_query($con, "UPDATE tbl_user_master SET livelihood_source='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'deal_customer':
				mysqli_query($con, "UPDATE tbl_user_master SET deal_customer='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'gst_num':
				mysqli_query($con, "UPDATE tbl_user_master SET gst_num='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'company_name':
				mysqli_query($con, "UPDATE tbl_user_master SET company_name='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'pan_num':
				mysqli_query($con, "UPDATE tbl_user_master SET pan_num='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			

			default:
				# code...
				break;
		}

		$status = "Save";
		$status_text = "Details Updated Successfully 🤩";

	} elseif ($value == "Skip") {
		switch ($type) {
			case 'waste_cate':
				mysqli_query($con, "UPDATE tbl_user_master SET waste_cate='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'working_days':
				mysqli_query($con, "UPDATE tbl_user_master SET working_days='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'working_method':
				mysqli_query($con, "UPDATE tbl_user_master SET working_method='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'livelihood_source':
				mysqli_query($con, "UPDATE tbl_user_master SET livelihood_source='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'deal_customer':
				mysqli_query($con, "UPDATE tbl_user_master SET deal_customer='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'gst_num':
				mysqli_query($con, "UPDATE tbl_user_master SET gst_num='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'company_name':
				mysqli_query($con, "UPDATE tbl_user_master SET company_name='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'pan_num':
				mysqli_query($con, "UPDATE tbl_user_master SET pan_num='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
				
			default:
				# code...
				break;
		}

		$status = "Save";
		$status_text = "You Skipped The Question";
	}
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);
