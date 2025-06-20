<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Social Link Info";
} else {

	if ($entry_permission == 'Yes') {

		$sendData = json_decode($_POST['sendData'], true);

		//  GET FILE DATA 
		$logo_fl = $_FILES['logo_fl'];
		$favicon_fl = $_FILES['favicon_fl'];

		$facebook = mysqli_real_escape_string($con, $sendData['facebook']);
		$twitter = mysqli_real_escape_string($con, $sendData['twitter']);
		$pinterest = mysqli_real_escape_string($con, $sendData['pinterest']);
		$linkedin = mysqli_real_escape_string($con, $sendData['linkedin']);
		$instagram = mysqli_real_escape_string($con, $sendData['instagram']);
		$youtube = mysqli_real_escape_string($con, $sendData['youtube']);


		$execute = 1;


		if ($execute == 1) {

			$dataget = mysqli_query($con, "select * from  tbl_social_link_details ");
			$data = mysqli_fetch_row($dataget);

			if (!$data) {
				//========================= INSERT IN  TABLE =======================
				mysqli_query($con, "INSERT INTO  tbl_social_link_details (
				id, 
				facebook, 
				twitter, 
				pinterest, 
				linkedin, 
				instagram,
				youtube,
				entry_user_code) VALUES (
					null,
				'" . $facebook . "',
				'" . $twitter . "',
				'" . $pinterest . "',
				'" . $linkedin . "',
				'" . $instagram . "',
				'" . $youtube . "',
				'" . $session_user_code . "')");

				$status = "Save";
				$status_text = "Social Link Info Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage Social Link Details";
			} else {
				mysqli_query($con, "update  tbl_social_link_details 
						set facebook='" . $facebook . "', 
						twitter='" . $twitter . "', 
						pinterest='" . $pinterest . "', 
						linkedin='" . $linkedin . "', 
						instagram='" . $instagram . "', 
						youtube='" . $youtube . "', 
						entry_user_code='" . $session_user_code . "', 
						update_timestamp='" . $timestamp . "' 
						where 1 ");

				$status = "Save";
				$status_text = "Social Link Info Data Updated Successfully";
				$activity_details = "You Update A Record In Manage Social Link Details";
			}
		}
	} else {
		$status = "NoPermission";
		$status_text = "You Don't Have Permission To Entry Any Data !!";
	}
}

$response[] = [
	'status' => $status,
	'status_text' => "INSERT INTO  tbl_social_link_details (
				id, 
				facebook, 
				twitter, 
				pinterest, 
				linkedin, 
				instagram,
				youtube,
				entry_user_code) VALUES (
					null,
				'" . $facebook . "',
				'" . $twitter . "',
				'" . $pinterest . "',
				'" . $linkedin . "',
				'" . $instagram . "',
				'" . $youtube . "',
				'" . $session_user_code . "')",
];
echo json_encode($response, true);

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
