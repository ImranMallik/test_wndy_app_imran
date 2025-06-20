<?php
include("../db/db.php");
?>

<div id="page-content">
    <div class="container">
        <!-- toolbar -->
        <div class="toolbar toolbar-wrapper shop-toolbar mt-2 credit-addon">
            <div class="row align-items-center">
                <div class="col-12 text-left filters-toolbar-item d-flex justify-content-start">
                    <div class="filters-item d-flex align-items-center">
                        <div class="grid-options view-mode d-flex flex-wrap justify-content-between">
                            <a class="icon-mode credit-add-on d-block" href="<?php echo $baseUrl . '/direct_transfer'; ?>" data-col="">
                                <img src="frontend_assets/img-icon/purchased_products.png" height="15px" width="15px">
                                <span class="purchased-products">Material Received</span>
                            </a>
                            <a class="icon-mode credit-add-on grid-2 d-block active" href="<?php echo $baseUrl . "/transferred_products"; ?>" data-col="2">
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



        <!--  Transferred Product List -->
        <div class="row">
            <div class="col-12 main-col">
                <div class="product-listview-loadmore" id="product-listview-loadmore" style="overflow-y: auto; height: 500px; overflow-x: hidden;">
                    <div class="grid-products grid-view-items mt-5">
                        <div class="form-group">
                            <label class="control-label"><strong>Filter Transferred Category</strong></label>
                            <select class="form-control" id="category_id" onchange="getTransferredProductList()" required>
                                <option value="">Choose Category</option>
                                <?php

                                $fetchData = mysqli_query($con, "SELECT DISTINCT cm.category_id, cm.category_name FROM tbl_category_master cm JOIN tbl_direct_transfer dt ON cm.category_id = dt.category_id WHERE dt.transferred_by_id = '$session_user_code' AND dt.transferred_status = 'Direct Transfer' AND cm.active = 'Yes'
");
                                while ($row = mysqli_fetch_array($fetchData)) {
                                    $selected = $row['category_id'] == $category_id ? "selected" : "";
                                    echo "<option value='" . $row['category_id'] . "' " . $selected . " >" . $row['category_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row row-cols-4 row-cols-md-4  " id="transferred_products_list">
                            <!-- Dynamic content will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>