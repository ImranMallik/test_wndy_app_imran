<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$user_code = mysqli_real_escape_string($con,$sendData['user_code']);

$query = "select 
		user_master.user_code,
		user_master.user_id, 
		user_master.name, 
		user_master.email, 
		user_master.profile_img, 
		user_master.user_mode_code, 
		user_mode.user_mode, 
		user_master.active, 
		user_master.entry_permission, 
		user_master.view_permission,
		user_master.edit_permission,
		user_master.delete_permissioin
		from user_master
		LEFT JOIN user_mode ON user_mode.user_mode_code = user_master.user_mode_code 
		WHERE user_code='".$user_code."' ";

$dataget = mysqli_query($con,$query);
$data = mysqli_fetch_row($dataget);

$profile_img = $data[4]=="" ? "user_icon.png" : $data[4];

$response[] = [
	'user_code' => $data[0],
	'user_id' => $data[1],
	'name' => $data[2],
	'email' => $data[3],
	'profile_img' => $profile_img,
	'user_mode_code' => $data[5],
	'user_mode' => $data[6],
	'active' => $data[7],
	'entry_permission' => $data[8],
	'view_permission' => $data[9],
	'edit_permission' => $data[10],
	'delete_permissioin' => $data[11],
];
echo json_encode($response,true);
?>