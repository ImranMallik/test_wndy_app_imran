<?php
include("../db/db.php");
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



        <!--  Transferred Product List -->
        <div class="row">
            <div class="col-12 main-col">
                <div class="col-md-5 transfer_products_for_you" id="transferredProductsContent" class="collapse">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h2 style="margin: 0;">
                            <strong>Transfer Products For You</strong>
                        </h2>
                    </div>
                    <div>
                        <div class="form-group">
                            <label class="control-label"><strong>Filter Category</strong></label>
                            <select class="form-control" id="trans_category_id" onchange="getTransProductList();" required>
                                <option value="">Choose Category</option>
                                <?php
                                $fetchData = mysqli_query($con, "SELECT 
    dt.transferred_to_id, 
    cm.category_id, 
    cm.category_name
FROM 
    tbl_direct_transfer dt 
LEFT JOIN 
    tbl_product_master pm 
    ON dt.product_id = pm.product_id 
LEFT JOIN 
    tbl_category_master cm 
    ON pm.category_id = cm.category_id
WHERE 
    dt.transferred_to_id = '$session_user_code' 
    AND dt.transferred_status = 'Direct Transfer' 
    AND cm.active = 'Yes'
GROUP BY 
    cm.category_id, 
    cm.category_name, 
    dt.transferred_to_id
");

                                while ($row = mysqli_fetch_array($fetchData)) {
                                    $selected = $row['category_id'] == $category_id ? "selected" : "";
                                    echo "<option value='" . $row['category_id'] . "' " . $selected . " >" . $row['category_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <div id="errorToast" style="color: red; font-size: 12px; display: none; padding:3px;">
                                Please select a category.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--Product Grid-->

    <div class="grid-products grid-view-items mt-5 " style="overflow-y: auto; overflow-x: hidden;">
        <div class="product-options row-cols-2 px-3" id="transfer_products_for_you_list">

        </div>
    </div>
</div>
</div>