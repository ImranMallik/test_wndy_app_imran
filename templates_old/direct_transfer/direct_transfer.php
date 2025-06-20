<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

$user_type_data_get = mysqli_query($con, "SELECT buyer_type FROM tbl_user_master WHERE user_id=$session_user_code");
$user_type_data = mysqli_fetch_row($user_type_data_get);
$user_type = $user_type_data[0];

// get buyer id
$buyer_id = $session_user_code;

?>


<div id="page-content">
	<div class="container">
		<!-- purchased products and transferred products button -->
		<div class="toolbar toolbar-wrapper shop-toolbar mt-2 credit-addon">
			<div class="row align-items-center">
				<div class="col-12 text-left filters-toolbar-item d-flex justify-content-start">
					<div class="filters-item d-flex align-items-center">
						<div class="grid-options view-mode d-flex flex-wrap justify-content-between">
							<a class="icon-mode credit-add-on grid-2 d-block active" href="<?php echo $baseUrl . '/direct_transfer'; ?>" data-col="1">
								<img src="frontend_assets/img-icon/purchased_products.png" height="15px" width="15px">
								<span class="purchased-products"> Material Received</span>
							</a>
							<a class="icon-mode credit-history d-block" href="<?php echo $baseUrl . '/transferred_products'; ?>" data-col="2">
								<img src="frontend_assets/img-icon/transferred_products.png" height="15px" width="15px">
								<span class="transferred-products">Material Sold</span>
							</a>
							<!-- <a class="icon-mode credit-history d-block" href="<?php echo $baseUrl . '/transferred_items_for_you'; ?>" data-col="3">
								<img src="frontend_assets/img-icon/transfer_product_for_you.png" height="15px" width="15px">
								<span class="transferred-products">Transferred Items For You</span>
							</a> -->
						</div>
					</div>
				</div>
			</div>
		</div>




		<div class="row">
			<!--Products-->
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
				<!--Product Infinite-->
				<div class="product-listview-loadmore" id="product-listview-loadmore">
					<div class="row">
						<div id="purchasedSection" class="col-md-5 purchased">
							<div style="display: flex; align-items: center; justify-content: space-between;">
								<h2 style="margin: 0;">
									<strong>Purchased Products</strong>
								</h2>
								<button style="background-color: #4eaf52; padding: 4px 8px; align-items:center" class="btn">
									<a href="<?php echo $baseUrl ?>/transfer_products_for_you" style="color: #FFF;">
										<!-- <i class="fa fa-plus"></i> -->
										For You
									</a>
							</div>

							<div>
								<div class="form-group">
									<label class="control-label"><strong>Filter Category</strong></label>
									<select class="form-control" id="category_id" onchange="getPurchasedProductList();" required>
										<option value="">Choose Category</option>
										<?php
										$fetchData = mysqli_query($con, "SELECT DISTINCT 
    cm.category_id, 
    cm.category_name
FROM 
    tbl_user_product_view AS upv
INNER JOIN 
    tbl_product_master AS pm ON upv.product_id = pm.product_id
INNER JOIN 
    tbl_category_master AS cm ON pm.category_id = cm.category_id
WHERE 
    upv.buyer_id = $buyer_id
    AND upv.deal_status = 'Completed' 
    AND upv.create_post_item_status = 'No' 
    AND upv.transferred_items_status = 'No'
    AND cm.active = 'Yes'");

										while ($row = mysqli_fetch_array($fetchData)) {
											$selected = $row['category_id'] == $category_id ? "selected" : "";
											echo "<option value='" . $row['category_id'] . "' " . $selected . " >" . $row['category_name'] . "</option>";
										}
										?>
									</select>
									<div id="errorToast" style="color: red; font-size: 12px; display: none; padding:3px;">Please select a category.</div>
								</div>
								<div class="grid-products grid-view-items mt-5 " style="height: 500px; overflow-y: auto; overflow-x: hidden;">
									<div class="product-options row-cols-2" id="purchased_product_list">

									</div>
								</div>
							</div>
							<div class="grid-products grid-view-items mt-5 " style="height: 500px; overflow-y: auto; overflow-x: hidden;">
								<div class="product-options row-cols-2" id="purchased_product_list">

								</div>
							</div>
						</div>
					</div>
				</div>
				<br><br>




				<!--Product Grid-->


			</div>
			<!-- Filter Buyer list-->
			<div class="product-listview-loadmore" id="buyer-listview-loadmore" style="display: none;">
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label class="control-label"><strong>Filter Buyer</strong></label>
							<select class="form-control" id="user_id" required>
								<option value="" selected disabled>Choose Buyer</option>
							</select>
							</select>
							<div id="doneErrorToast" style="color: red; font-size: 12px; display: none;">Please Select a buyer.</div>
						</div>
					</div>
					<div class="form-group mt-3">
						<label for="price" style="font-size: 14px; font-weight: 600; color: #333;">
							<img src="./frontend_assets/img-icon/Quan.png" alt="Referral" style="height: 14px; width: 14px; vertical-align: middle; margin-right: 10px; text-align:center" />
							Enter Quantity
						</label>
						<input type="text" class="form-control font-bold" id="quantity" name="quantity" placeholder="Enter Quantity "
							style="width: 100%; height: 35px; border-radius: 8px; border: 1px solid #d1d1d1; padding: 8px; font-size: 14px; transition: all 0.3s ease;">
						<div id="quantityError" style="color: red; font-size: 12px; display: none;">Please enter Quantity.</div>
					</div>
					<div class="form-group mt-3">
						<label for="price" style="font-size: 14px; font-weight: 600; color: #333;">
							<img src="./frontend_assets/img-icon/price-icon2.png" alt="Referral" style="height: 14px; width: 14px; vertical-align: middle; margin-right: 10px; text-align:center" />
							Enter Expected Price
						</label>
						<input type="number" class="form-control font-bold" id="price" name="price" placeholder="Enter Total Price "
							style="width: 100%; height: 35px; border-radius: 8px; border: 1px solid #d1d1d1; padding: 8px; font-size: 14px; transition: all 0.3s ease;">
						<div id="priceError" style="color: red; font-size: 12px; display: none;">Please enter the price.</div>
					</div>

				</div>


				<!--Product Grid-->
				<div class="grid-products grid-view-items mt-5">
					<div class="product-options row-cols-2" id="purchased_buyer_list">

					</div>
				</div>
				<!--End Product Grid-->
				<!--Load More Button-->
				<div class="infinitpaginOuter text-center mt-5">
					<!-- <div class="infiniteload"><a href="#" class="btn btn-xl loadMoreList">Load More</a></div>      -->
				</div>
				<!--End Load More Button-->
				<div id="actionButtonDiv"
					style="display: none; position: fixed; bottom: 0; left: 0; width: 100%; background-color: #cdd3dd; padding: 10px; box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); z-index: 99; display: flex; justify-content: space-between;">
					<!-- Previous Button -->
					<button id="prevButton"
						style="background-color: #171717; color: white; border: none; border-radius: 5px; padding: 10px 30px; cursor: pointer;"
						onclick="previousAction()">
						<i class="fa fa-chevron-circle-left"></i>
						Previous
					</button>
					<!-- Done Button -->
					<button id="doneButton"
						style="background-color: #0571ae; color: white; border: none; border-radius: 5px; padding: 10px 30px; cursor: pointer;"
						onclick="DirectButton()">
						Direct Transfer
						<i class="fa fa-solid fa-check"></i>
					</button>
				</div>

			</div>
			<!--End Product Infinite-->
		</div>
		<!--End Products-->
	</div>
</div>

</div>


</div>
</div>