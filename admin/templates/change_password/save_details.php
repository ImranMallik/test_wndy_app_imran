<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if($login=="No"){
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Change Password";
}
else{
	
	if($entry_permission=='Yes'){

		$sendData = json_decode($_POST['sendData'],true);

		$old_password = mysqli_real_escape_string($con,$sendData['old_password']);
		$new_password = mysqli_real_escape_string($con,$sendData['new_password']);

		$old_password = base64_encode($old_password);
		$new_password = base64_encode($new_password);

		//========================= CHECK USER OLD PASSWORD =======================
		$dataget = mysqli_query($con,"select * from user_master where user_code='".$session_user_code."' and user_password='".$old_password."' ");
		$data_num_row = mysqli_num_rows($dataget);

		if($data_num_row!=0){				
			mysqli_query($con,"update user_master 
					set user_password='".$new_password."', 
					entry_user_code='".$session_user_code."', 
					update_timestamp='".$timestamp."' 
					where 
					user_code='".$session_user_code."' ");

			$status = "Save";
			$status_text = "Password Updated Successfully";
			$activity_details = "You Update A Record In Change Password";
		}
		else{
			$status = "Not_Match";
			$status_text = "Password Not Match !!";
		}

	}
	else{
		$status = "NoPermission";
		$status_text = "You Don't Have Permission To Entry Any Data !!";
	}
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response,true);

if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}
?>