<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$user_mode_code = mysqli_real_escape_string($con,$sendData['user_mode_code']);

$query = "select 
		user_mode_code,
		user_mode,
		active from user_mode where user_mode_code='".$user_mode_code."' ";
$dataget = mysqli_query($con,$query);
$data = mysqli_fetch_row($dataget);

$response[] = [
	'user_mode_code' => $data[0],
	'user_mode' => $data[1],
	'active' => $data[2],
];
echo json_encode($response,true);
?>