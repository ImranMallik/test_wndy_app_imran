<?php
include("../../templates/db/db.php");

$sendData = json_decode($_POST['sendData'], true);

$newsletter_email = mysqli_real_escape_string($con, $sendData['newsletter_email']);
$customer_code = $session_user_code;

$execute = 1;

if ($execute==1) {
	$dataget = mysqli_query($con,"select * from newsletter where newsletter_email='".$newsletter_email."' ");
	$data = mysqli_fetch_row($dataget);
	if ($data) {
		$status = "Exist";
		$status_text = "This Email Already Exist !";
		$execute = 0;
	}
}

if ($execute==1) {
	$newsletter_code = "NLC_" . uniqid() . time();
	//========================= INSERT IN TABLE =======================
	mysqli_query($con, "INSERT INTO newsletter (
			newsletter_code,
			newsletter_email, 
			customer_code,
			entry_user_code
			) values(
			'" . $newsletter_code . "',
			'" . $newsletter_email . "',
			'" . $customer_code . "',
			'" . $session_user_code . "')");

	$status = "Save";
	$status_text = "Successfully Email Add To Newsletter";
}

$response = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);
