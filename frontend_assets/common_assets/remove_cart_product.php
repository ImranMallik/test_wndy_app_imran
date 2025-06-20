<?php
include("../../templates/db/db.php");

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
} else {

	$sendData = json_decode($_POST['sendData'], true);

	$product_code = mysqli_real_escape_string($con, $sendData['product_code']);
	$customer_code = $session_user_code;

	mysqli_query($con,"delete from customer_cart where customer_code='" . $customer_code . "' and product_code='" . $product_code . "' ");

	$status = "Save";
	$status_text = "Product Remove From Cart";
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);
