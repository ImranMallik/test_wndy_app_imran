<script>
	let selectedCredit = "";
	let order_id = "some thing";
</script>
<?php
if (isset($_POST['code']) && !empty($_POST['code'])) {
	// echo "Txn id: " . $_POST['transactionId'] . " Status : " . $_POST['code'];
	// echo "asdasd";

	$transactionId = $_POST['transactionId'];
	$amount = $_POST['amount'] / 100;
	$providerReferenceId = $_POST['providerReferenceId'];
	$checksum = $_POST['checksum'];

	if ($_POST['code'] == "PAYMENT_SUCCESS") {

		$paymentDetailsDataget = mysqli_query($con, "select order_id, total_amount, user_id, credit from payment_details where merchantTransactionId='" . $transactionId . "' ");
		$paymentDetailsData = mysqli_fetch_row($paymentDetailsDataget);

		$order_id = $paymentDetailsData[0];
		$total_amount = $paymentDetailsData[1];
		$user_id = $paymentDetailsData[2];
		$credit = $paymentDetailsData[3];

		if ($total_amount == $amount) {
?>
			<script>
				selectedCredit = '<?php echo $credit; ?>';
				order_id = '<?php echo $order_id; ?>';
			</script>
<?php
			mysqli_query($con, "update payment_details set status='Complete', status_details='" . $_POST['code'] . "', providerReferenceId='" . $providerReferenceId . "', checksum='" . $checksum . "' where order_id='" . $order_id . "' ");
		} else {
			mysqli_query($con, "update payment_details set status='Reject', status_details='Amount Tamper', providerReferenceId='" . $providerReferenceId . "', checksum='" . $checksum . "' where order_id='" . $order_id . "' ");
		}
	} else {
		mysqli_query($con, "update payment_details set status='Reject', status_details='" . $_POST['code'] . "', providerReferenceId='" . $providerReferenceId . "', checksum='" . $checksum . "' where merchantTransactionId='" . $transactionId . "' ");
	}
}

?>

<div id="page-content">
	<div class="container">
		<!-- credit add-on and history button -->
		<div class="toolbar toolbar-wrapper shop-toolbar mt-2 credit-addon">
			<div class="row align-items-center">
				<div class="col-4 col-sm-2 col-md-4 col-lg-4 text-left filters-toolbar-item d-flex order-1 order-sm-0">
					<div class="filters-item d-flex align-items-center">
						<div class="grid-options view-mode d-flex">
							<a class="icon-mode credit-add-on grid-2 d-block active" data-col="2">
								<img src="frontend_assets/img-icon/credit.png" height="25px;" width="25px;">
								<span class="credit-add-on">Add Credit</span>
							</a>
							<a class="icon-mode credit-history d-block" href="<?php echo $baseUrl . "/credit_history"; ?>" data-col="1">
								<img src="frontend_assets/img-icon/check.png" height="25px;" width="25px;">
								<span class="credit-history">Credit History</span>
							</a>
						</div>
					</div>
				</div>
				<!--End Main Content-->
			</div>
			<!-- End Body Container -->
		</div>

		<div class="form-group">
			<label class="control-label">
				Please Choose Credit Option
				<span class="req-label-btn"> * </span>
			</label>

			<div class="option-main-div">
				<button class="slick-prev slick-arrow d-none" onclick="scrollSlotPart('left')" aria-label="Previous" type="button" aria-disabled="true">Previous</button>
				<div class="option-div">
					<?php
					$credit_option_dataget = mysqli_query($con, "select credit, purchase_amount from tbl_credit_option where active='Yes' order by credit ASC ");
					while ($rw = mysqli_fetch_array($credit_option_dataget)) {
					?>
						<button onclick="showConfirmOption(<?php echo $rw['credit']; ?>,<?php echo $rw['purchase_amount']; ?>)" class="credit-btn">
							<img class="img" src="frontend_assets/img-icon/cash.png" alt="Credit Icon">
							<?php echo $rw['credit'] ?>
						</button>
					<?php
					}
					?>
				</div>
				<button class="slick-next slick-arrow d-none" onclick="scrollSlotPart('right')" aria-label="Next" type="button" aria-disabled="false">Next</button>
			</div>
			<label data-default-mssg="" class="input_alert credit_option-inp-alert"></label>
		</div>

		<div class="confirm-option-div animate__animated animate__backInUp" style="display: none;">
			<h2>Are you sure ??</h2>
			<p style="font-weight: 600;" class="confirm-text">To purchase 5000 credit of amount 50000 /-</p>
			<button type="button" onclick="closeConfirmation()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #e87621; border-color: #853f0b; margin-right: 5px;">
				<img class="img" src="frontend_assets/img-icon/no.png" />
				No
			</button>
			<button type="button" onclick="purchaseCredit()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #60ff36;">
				<img class="img" src="frontend_assets/img-icon/yes.png" />
				Yes
			</button>
		</div>
	</div>
</div>


</div>
</div>