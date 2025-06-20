<?php
include("../db/db.php");
include("../db/activity.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$activity_details = "";

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Category Rate List Details";
} else {

	if ($entry_permission == 'Yes') {

		$sendData = json_decode($_POST['sendData'], true);

		$category_rate_list_id = mysqli_real_escape_string($con, $sendData['category_rate_list_id']);
		$category_id = mysqli_real_escape_string($con, $sendData['category_id']);
		$product_name = mysqli_real_escape_string($con, $sendData['product_name']);
		$lowest_price	 = mysqli_real_escape_string($con, $sendData['lowest_price']);
		$highest_price = mysqli_real_escape_string($con, $sendData['highest_price']);
		$active = mysqli_real_escape_string($con, $sendData['active']);

		//==============================IF CODE BLANK THEN INSERT==================================
		if ($category_rate_list_id == "") {

			//========================= INSERT IN TABLE =======================
			mysqli_query($con, "INSERT INTO tbl_category_rate_list (
					category_rate_list_id,
					category_id,
					product_name,
					lowest_price,
					highest_price,
                    active, 
                    entry_user_code,
					action_timestamp) VALUES (
						NULL,
						'" . $category_id . "',
						'" . $product_name . "',
						'" . $lowest_price . "',
						'" . $highest_price . "',
						'" . $active . "',
                    	'" . $session_user_code . "',
						'" . $timestamp . "')");

			$status = "Save";
			$status_text = "New Rate List Data Added Successfully";
			$activity_details = "You Insert A Record In Manage Category Rate List Details";
		}
		//============================== IF CODE DOES NOT BLANK THEN UPDATE ==================================
		else {
			mysqli_query($con, "UPDATE tbl_category_rate_list 
						SET
						category_rate_list_id='" . $category_rate_list_id . "',
						category_id='" . $category_id . "',
						product_name='" . $product_name . "', 
						lowest_price='" . $lowest_price . "', 
						highest_price='" . $highest_price . "', 
						active='" . $active . "', 
						entry_user_code='" . $session_user_code . "', 
						action_timestamp='" . $timestamp . "' 
						WHERE 
						category_rate_list_id='" . $category_rate_list_id . "' ");

			$status = "Save";
			$status_text = "Seller Address Data Updated Successfully";
			$activity_details = "You Update A Record In Manage Category Rate List Details";
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
