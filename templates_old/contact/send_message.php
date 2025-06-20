<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'],true);

$name = mysqli_real_escape_string($con,$sendData['name']);
$email = mysqli_real_escape_string($con,$sendData['email']);
$message = mysqli_real_escape_string($con,$sendData['message']);

$message_code = "UMC_".uniqid().time();
//========================= INSERT IN TABLE =======================
mysqli_query($con,"insert into user_message (
	id, 
	message_code, 
	name, 
	email, 
	message,
	entry_user_code) values(null,
	'".$message_code."',
	'".$name."',
	'".$email."',
	'".$message."',
	'".$session_user_code."')");

$status = "Save";
$status_text = "Message Submitted Successfully";

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response,true);
?>