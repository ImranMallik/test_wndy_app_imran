<?php
include("module_function/date_time_format.php");
?>
<div id="page-content">
	<div class="container">
		<!-- credit add-on and history button -->
		<div class="toolbar toolbar-wrapper shop-toolbar mt-2 credit-addon">
			<div class="row align-items-center">
				<div class="col-4 col-sm-2 col-md-4 col-lg-4 text-left filters-toolbar-item d-flex order-1 order-sm-0">
					<div class="filters-item d-flex align-items-center">
						<div class="grid-options view-mode d-flex">
							<a class="icon-mode credit-add-on d-block" href="<?php echo $baseUrl . "/credit_addon"; ?>">
								<img src="frontend_assets/img-icon/credit.png" height="25px;" width="25px;">
								<span class="credit-add-on">Add Credit</span>
							</a>
							<a class="icon-mode credit-history d-block active" data-col="1">
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

		<?php
		$dataget = mysqli_query($con, "select in_credit, out_credit, purchase_amount, trans_date, trans_type, status from tbl_credit_trans where user_id='" . $session_user_code . "' order by entry_timestamp DESC ");
		while ($rw = mysqli_fetch_array($dataget)) {
		?>
			<div class="address-select-box active mb-1">
				<div class="address-box bg-block">
					<div class="top d-flex-justify-center justify-content-between mb-1">
						<h5 class="m-0" style="color: <?php echo $rw['status'] == "In" ? "#069906" : "#e30303"; ?>">
							<?php echo $rw['status'] == "In" ? "+ " . $rw['in_credit'] : "-" . $rw['out_credit']; ?>
						</h5>
						<span class="product-labels start-auto end-0">
							<p class="m-0">Date: <?php echo dateFormat($rw['trans_date']); ?></p>
						</span>
					</div>
					<div class="middle">
						<div class="address mb-1 text-muted">
							<?php
							if ($rw['trans_type'] == "Credit Purchase") {
							?>
								<p class="m-0">purchased Amount: <?php echo $rw['purchase_amount'] ?></p>
							<?php
							}
							?>

							<p class="m-0">By: <?php echo $rw['trans_type']; ?></p>
						</div>
					</div>

				</div>
			</div>
		<?php
		}
		?>


	</div>
</div>


</div>
</div>