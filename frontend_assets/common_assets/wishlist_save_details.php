<?php
include("../../templates/db/db.php");

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
} else {

	$sendData = json_decode($_POST['sendData'], true);

	$product_code = mysqli_real_escape_string($con, $sendData['product_code']);
	$customer_code = $session_user_code;

	//========================= CHECK SAME DATA EXIST OR NOT =======================
	$dataget = mysqli_query($con, "select * from customer_wishlist where customer_code='" . $customer_code . "' and product_code='" . $product_code . "' ");
	$data_num_row = mysqli_num_rows($dataget);

	if ($data_num_row == 0) {
		$whishlist_code = "CWLC_" . uniqid() . time();
		//========================= INSERT IN TABLE =======================
		mysqli_query($con, "INSERT INTO customer_wishlist (
				whishlist_code,
				customer_code, 
				product_code,
				entry_user_code
				) values('" . $whishlist_code . "',
				'" . $customer_code . "',
				'" . $product_code . "',
				'" . $session_user_code . "')");
	}
	$status = "Save";
	$status_text = "Product Add in Whishlist";
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);
