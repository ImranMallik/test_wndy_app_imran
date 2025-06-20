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
			case 'ac_price':
				mysqli_query($con, "UPDATE tbl_user_master SET ac_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'washing_machine_price':
				mysqli_query($con, "UPDATE tbl_user_master SET washing_machine_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'fridge_price':
				mysqli_query($con, "UPDATE tbl_user_master SET fridge_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'tv_price':
				mysqli_query($con, "UPDATE tbl_user_master SET tv_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'microwave_price':
				mysqli_query($con, "UPDATE tbl_user_master SET microwave_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'laptop_price':
				mysqli_query($con, "UPDATE tbl_user_master SET laptop_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'geyser_price':
				mysqli_query($con, "UPDATE tbl_user_master SET geyser_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'paper_price':
				mysqli_query($con, "UPDATE tbl_user_master SET paper_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'iron_price':
				mysqli_query($con, "UPDATE tbl_user_master SET iron_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'furniture_price':
				mysqli_query($con, "UPDATE tbl_user_master SET furniture_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'battery_price':
				mysqli_query($con, "UPDATE tbl_user_master SET battery_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'cardboard_price':
				mysqli_query($con, "UPDATE tbl_user_master SET cardboard_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;

			default:
				# code...
				break;
		}

		$status = "Save";
		$status_text = "Price Updated Successfully 🤩";

	} elseif ($value == "Skip") {
		switch ($type) {
			case 'ac_price':
				mysqli_query($con, "UPDATE tbl_user_master SET ac_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'washing_machine_price':
				mysqli_query($con, "UPDATE tbl_user_master SET washing_machine_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'fridge_price':
				mysqli_query($con, "UPDATE tbl_user_master SET fridge_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'tv_price':
				mysqli_query($con, "UPDATE tbl_user_master SET tv_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'microwave_price':
				mysqli_query($con, "UPDATE tbl_user_master SET microwave_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'laptop_price':
				mysqli_query($con, "UPDATE tbl_user_master SET laptop_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'geyser_price':
				mysqli_query($con, "UPDATE tbl_user_master SET geyser_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'paper_price':
				mysqli_query($con, "UPDATE tbl_user_master SET paper_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'iron_price':
				mysqli_query($con, "UPDATE tbl_user_master SET iron_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'furniture_price':
				mysqli_query($con, "UPDATE tbl_user_master SET furniture_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'battery_price':
				mysqli_query($con, "UPDATE tbl_user_master SET battery_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
				break;
			case 'cardboard_price':
				mysqli_query($con, "UPDATE tbl_user_master SET cardboard_price='" . $value . "' WHERE user_id='" . $user_id . "' ");
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
