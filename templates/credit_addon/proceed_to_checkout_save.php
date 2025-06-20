<?php
include("../db/db.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
	$status = "SessionDestroy";
	$status_text = "";
} else {

	$sendData = json_decode($_POST['sendData'], true);

	$base_url = mysqli_real_escape_string($con, $sendData['base_url']);
	$credit = mysqli_real_escape_string($con, $sendData['credit']);
	$amount = 0;

	$execute = 1;

	if ($execute == 1) {
		$dataget = mysqli_query($con, "select purchase_amount from tbl_credit_option where credit='" . $credit . "' and active='Yes' ");
		$data = mysqli_fetch_row($dataget);

		if (!$data) {
			$status = "error";
			$status_text = "Credit Option Not Found";
			$execute = 0;
		} else {
			$amount = $data[0];
		}
	}

	if ($execute == 1) {

		// PRODUCTION KEY
		$merchantId = 'M226TKWIACO7W'; // sandbox or test merchantId
		$apiKey = "7bff5396-4bb5-4db2-a56e-aba080dd63af"; // sandbox or test APIKEY
		$apiUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';

		// TEST KEY
		// $merchantId = 'PGTESTPAYUAT'; // sandbox or test merchantId
		// $apiKey = "099eb0cd-02cf-4e2a-8aca-3e6c6aff0399"; // sandbox or test APIKEY
		// $apiUrl = 'https://api-preprod.phonepe.com/apis/hermes/pg/v1/pay';

		$redirectUrl = $base_url . '/credit_addon';

		$merchantTransactionId = "MTI_" . uniqid() . time();
		$order_id = "OD_" . uniqid() . time();

		//========================= INSERT IN payment_Details TABLE =======================
		mysqli_query($con, "insert into payment_details (
			order_id, 
			merchantTransactionId,
			user_id, 
			credit,
			total_amount,
			entry_user_code) values(
			'" . $order_id . "',
			'" . $merchantTransactionId . "',
			'" . $session_user_code . "',
			'" . $credit . "',
			'" . $amount . "',
			'" . $session_user_code . "')");


		$customerDataget = mysqli_query($con, "select customer_name, email_id, ph_num from customer_master where customer_code='" . $customer_code . "' ");
		$customerData = mysqli_fetch_row($customerDataget);

		// Set transaction details
		$name = $session_name;
		$email = $session_email_id;
		$mobile = $session_ph_num;
		$description = 'Payment for Credit Purchase';

		$paymentData = array(
			'merchantId' => $merchantId,
			'merchantTransactionId' => $merchantTransactionId, // test transactionID
			"merchantUserId" => 'MUID' . substr(uniqid(), -6),
			'amount' => $amount * 100,
			'redirectUrl' => $redirectUrl,
			'redirectMode' => "POST",
			'callbackUrl' => $redirectUrl,
			"merchantOrderId" => $order_id,
			"mobileNumber" => $mobile,
			"message" => $description,
			"email" => $email,
			"shortName" => $name,
			"paymentInstrument" => array(
				"type" => "PAY_PAGE",
			)
		);

		$jsonencode = json_encode($paymentData);
		$payloadMain = base64_encode($jsonencode);
		$salt_index = 1; //key index 1
		$payload = $payloadMain . "/pg/v1/pay" . $apiKey;
		$sha256 = hash("sha256", $payload);
		$final_x_header = $sha256 . '###' . $salt_index;
		$request = json_encode(array('request' => $payloadMain));

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $apiUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $request,
			CURLOPT_HTTPHEADER => [
				"Content-Type: application/json",
				"X-VERIFY: " . $final_x_header,
				"accept: application/json"
			],
		]);

		$curlResponse = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$paymentExecute = 0;

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$res = json_decode($curlResponse);

			if (isset($res->success) && $res->success == '1') {
				$paymentCode = $res->code;
				$paymentMsg = $res->message;
				$payUrl = $res->data->instrumentResponse->redirectInfo->url;
				$paymentExecute = 1;
				// header('Location:' . $payUrl);
			}
		}

		if ($paymentExecute == 1) {
			$status = "success";
			$status_text = $payUrl;
		} else {
			$status = "error";
			$status_text = "Some Error Occurred Please Try Again After Some Time";
			mysqli_query($con, "delete from payment_details where order_id='" . $order_id . "' ");
		}
	}
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response, true);
