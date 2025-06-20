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

		$sendData = json_decode($_POST['sendData'], true);

		$request_id = mysqli_real_escape_string($con, $sendData['request_id']);
		$buyer_id = mysqli_real_escape_string($con, $sendData['buyer_id']);
		$product_id = mysqli_real_escape_string($con, $sendData['product_id']);
		$seller_id = mysqli_real_escape_string($con, $sendData['seller_id']);
		$note = mysqli_real_escape_string($con, $sendData['note']);
		$seen_status = mysqli_real_escape_string($con, $sendData['seen_status']);

		//==============================IF CODE BLANK THEN INSERT==================================
		if ($request_id == "") {

			$execute = 1;

			//========================= INSERT INTO BUY REQUEST TABLE =======================

				mysqli_query($con,"INSERT INTO tbl_buy_request (
					request_id,
					buyer_id,
                    product_id, 
                    seller_id, 
                    note, 
                    seen_status,
                    entry_user_code) VALUES (
						null,
						'" . $buyer_id	 . "',
						'" . $product_id	 . "',
						'" . $seller_id . "',
						'" . $note . "',
						'" . $seen_status . "',
                    '" . $session_user_code . "')");
					$status = "Save";
					$status_text = "New Order Data Added Successfully";
					$activity_details = "You Insert A Record In Manage Order Details";
			}
		//==============================IF REQUEST ID ISN'T BLANK THEN UPDATE==================================
		else {			
				mysqli_query($con,"UPDATE tbl_buy_request 
						SET
						buyer_id='".$buyer_id."',
						product_id='".$product_id."', 
						seller_id='".$seller_id."', 
						note='".$note."', 
						seen_status='".$seen_status."', 
						entry_user_code='".$session_user_code."', 
						update_timestamp='".$timestamp."' 
						WHERE 
						tbl_buy_request.request_id='".$request_id."' ");


				$status = "Save";
				$status_text = "Order Data Updated Successfully";
				$activity_details = "You Update A Record In Manage Order Details";
			}
		}
	else {
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
