<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if($login=="No"){
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage User Details";
}
else{
	
	if($entry_permission=='Yes'){

		$sendData = json_decode($_POST['sendData'],true);

		$user_mode_code = mysqli_real_escape_string($con,$sendData['user_mode_code']);
		$all_menu_code = $sendData['all_menu_code'];
		$total_rw = mysqli_real_escape_string($con,$sendData['total_rw']);
		
		$all_menu_code = json_decode($all_menu_code);
		
		mysqli_query($con,"delete from user_permission where user_mode_code='".$user_mode_code."' ");
		
		for($i=1;$i<$total_rw;$i++){
			
			$mc = mysqli_real_escape_string($con,$all_menu_code[$i]);
			
			mysqli_query($con,"insert into user_permission (
					id, 
					user_mode_code, 
					all_menu_code, 
					entry_user_code
					) values(null,
					'".$user_mode_code."',
					'".$mc."',
					'".$session_user_code."')");
				
		}

		$status = "Save";
		$status_text = "Data Saved Successfully";
		$activity_details = "You Insert A Record In Manage User Permission";
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