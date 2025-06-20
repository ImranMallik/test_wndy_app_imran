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

		$description = mysqli_real_escape_string($con, $sendData['description']);
		$keywords = mysqli_real_escape_string($con, $sendData['keywords']);
		$author = mysqli_real_escape_string($con, $sendData['author']);

		$execute = 1;

		if ($execute == 1) {

			$seo_dataget = mysqli_query($con, "SELECT * FROM tbl_seo_details");
			$seo_data = mysqli_fetch_row($seo_dataget);

			if (!$seo_data) {
				//========================= INSERT IN  TABLE =======================
				mysqli_query($con, "INSERT INTO tbl_seo_details (
				tbl_seo_details.id, 
				tbl_seo_details.description, 
				tbl_seo_details.keywords, 
				tbl_seo_details.author,
				tbl_seo_details.entry_user_code) VALUES (
					NULL,
				'" . $description . "',
				'" . $keywords . "',
				'" . $author . "',
				'" . $session_user_code . "')");

				$status = "Save";
				$status_text = "SEO Details Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage SEO Details";
			} else {
				mysqli_query($con, "UPDATE tbl_seo_details 
						SET tbl_seo_details.description='" . $description . "', 
						tbl_seo_details.keywords='" . $keywords . "', 
						tbl_seo_details.author='" . $author . "',
						tbl_seo_details.entry_user_code='" . $session_user_code . "', 
						tbl_seo_details.update_timestamp='" . $timestamp . "' 
						WHERE 1 ");

				$status = "Save";
				$status_text = "SEO Deatils Data Updated Successfully";
				$activity_details = "You Update A Record In Manage SEO Details";
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
