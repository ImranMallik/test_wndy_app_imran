<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if($login=="No"){
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Menu Details";
}
else{
	
	if($entry_permission=='Yes'){

		$sendData = json_decode($_POST['sendData'],true);

		$menu_code = mysqli_real_escape_string($con,$sendData['menu_code']);
		$menu_name = mysqli_real_escape_string($con,$sendData['menu_name']);
		$menu_icon = mysqli_real_escape_string($con,$sendData['menu_icon']);
		$sub_menu_status = mysqli_real_escape_string($con,$sendData['sub_menu_status']);
		$file_name = mysqli_real_escape_string($con,$sendData['file_name']);
		$folder_name = mysqli_real_escape_string($con,$sendData['folder_name']);
		$order_num = mysqli_real_escape_string($con,$sendData['order_num']);
		$active = mysqli_real_escape_string($con,$sendData['active']);
		
		//==============================IF MENU CODE BLANK THEN INSERT==================================
		if($menu_code==""){
			
			//=========================CHECK MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT=======================
			if($sub_menu_status=='Yes'){
				$dataget = mysqli_query($con,"select * from menu_master where menu_name='".$menu_name."' ");
				$data_num_row = mysqli_num_rows($dataget);
			}
			else{
				$dataget = mysqli_query($con,"select * from menu_master where menu_name='".$menu_name."' OR file_name='".$file_name."' OR folder_name='".$folder_name."' ");
				$data_num_row = mysqli_num_rows($dataget);
			}
			
			if($data_num_row==0){
				$menu_code = "MC_".uniqid().time();
				//=========================INSERT IN MENU MASTER=======================
				mysqli_query($con,"insert into menu_master (
								id, 
								menu_code, 
								menu_name, 
								menu_icon, 
								sub_menu_status, 
								file_name, 
								folder_name, 
								order_num, 
								active, 
								entry_user_code) values(null,
								'".$menu_code."',
								'".$menu_name."',
								'".$menu_icon."',
								'".$sub_menu_status."',
								'".$file_name."',
								'".$folder_name."',
								'".$order_num."',
								'".$active."',
								'".$session_user_code."')");
				
				$status = "Save";
				$status_text = "Data Saved Successfully";
				$activity_details = "You Insert A Record In Manage Menu Details";
			}
			else{
				$status = "Exist";
				$status_text = "Already Exist Same Data !!";
			}
		}
		//==============================IF MENU CODE DOES NOT BLANK THEN UPDATE==================================
		else{
			//=========================CHECK MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT=======================
			if($sub_menu_status=='Yes'){
				$dataget = mysqli_query($con,"select * from menu_master where  menu_code<>'".$menu_code."' and menu_name='".$menu_name."' ");
				$data_num_row = mysqli_num_rows($dataget);
			}
			else{
				$dataget = mysqli_query($con,"select * from menu_master where  menu_code<>'".$menu_code."' and (menu_name='".$menu_name."' OR file_name='".$file_name."' OR folder_name='".$folder_name."') ");
				$data_num_row = mysqli_num_rows($dataget);
			}
			
			if($data_num_row==0){				
				mysqli_query($con,"update menu_master set 
					menu_name='".$menu_name."', 
					menu_icon='".$menu_icon."', 
					sub_menu_status='".$sub_menu_status."', 
					file_name='".$file_name."', 
					folder_name='".$folder_name."', 
					order_num='".$order_num."', 
					active='".$active."', 
					entry_user_code='".$session_user_code."', 
					update_timestamp='".$timestamp."' 
					where menu_code='".$menu_code."' ");
				
				$status = "Save";
				$status_text = "Data Updated Successfully";
				$activity_details = "You Update A Record In Manage Menu Details";
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