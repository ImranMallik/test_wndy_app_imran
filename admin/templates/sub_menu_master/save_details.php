<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if($login=="No"){
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Sub Menu";
}
else{
	
	if($entry_permission=='Yes'){

		$sendData = json_decode($_POST['sendData'],true);

		$sub_menu_code = mysqli_real_escape_string($con,$sendData['sub_menu_code']);
		$sub_menu_name = mysqli_real_escape_string($con,$sendData['sub_menu_name']);
		$menu_icon = mysqli_real_escape_string($con,$sendData['menu_icon']);
		$menu_code = mysqli_real_escape_string($con,$sendData['menu_code']);
		$file_name = mysqli_real_escape_string($con,$sendData['file_name']);
		$folder_name = mysqli_real_escape_string($con,$sendData['folder_name']);
		$order_num = mysqli_real_escape_string($con,$sendData['order_num']);
		$active = mysqli_real_escape_string($con,$sendData['active']);
		
		//==============================IF SUB MENU CODE BLANK THEN INSERT==================================
		if($sub_menu_code==""){
			
			//=========================CHECK SUB MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT=======================
			$dataget = mysqli_query($con,"select * from sub_menu_master where sub_menu_name='".$sub_menu_name."' OR file_name='".$file_name."' OR folder_name='".$folder_name."' ");
			$data_num_row = mysqli_num_rows($dataget);
			
			if($data_num_row==0){
				$sub_menu_code = "SMC_".uniqid().time();
				//=========================INSERT IN SUB MENU MASTER=======================
				mysqli_query($con,"insert into sub_menu_master (
						id, 
						sub_menu_code, 
						sub_menu_name, 
						menu_icon, 
						menu_code, 
						file_name, 
						folder_name, 
						order_num, 
						active, 
						entry_user_code) values(null,
						'".$sub_menu_code."',
						'".$sub_menu_name."',
						'".$menu_icon."',
						'".$menu_code."',
						'".$file_name."',
						'".$folder_name."',
						'".$order_num."',
						'".$active."',
						'".$session_user_code."')");
				
				$status = "Save";
				$status_text = "Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage Sub Menu";
			}
			else{
				$status = "Exist";
				$status_text = "Already Exist Same Data !!";
			}
		}
		//==============================IF SUB MENU CODE DOES NOT BLANK THEN UPDATE==================================
		else{
			//=========================CHECK MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT=======================
			$dataget = mysqli_query($con,"select * from sub_menu_master where  sub_menu_code<>'".$sub_menu_code."' and (sub_menu_name='".$sub_menu_name."' OR file_name='".$file_name."' OR folder_name='".$folder_name."') ");
			$data_num_row = mysqli_num_rows($dataget);
			
			if($data_num_row==0){				
				mysqli_query($con,"update sub_menu_master set 
					sub_menu_name='".$sub_menu_name."', 
					menu_icon='".$menu_icon."', 
					menu_code='".$menu_code."', 
					file_name='".$file_name."', 
					folder_name='".$folder_name."', 
					order_num='".$order_num."', 
					active='".$active."', 
					entry_user_code='".$session_user_code."', 
					update_timestamp='".$timestamp."' 
					where sub_menu_code='".$sub_menu_code."' ");
				
				$status = "Save";
				$status_text = "Data Updated Successfully";
				$activity_details = "You Update A Record In Manage Sub Menu";
			}
			else{
				$status = "Exist";
				$status_text = "Already Exist Same Data !!";
			}
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