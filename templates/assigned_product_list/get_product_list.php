<?php
include("../db/db.php");

$query = "SELECT 
        tbl_product_master.product_id,
        tbl_product_master.product_name,
        tbl_category_master.category_img,
        tbl_category_master.category_name,
        tbl_product_master.sale_price,
        tbl_product_master.product_status,
        tbl_address_master.state,
        tbl_address_master.city,
        tbl_address_master.landmark,
        tbl_address_master.pincode
        FROM tbl_user_product_view
        LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
        LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
        LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
        WHERE tbl_user_product_view.assigned_collecter = '" . $session_user_code . "' and tbl_user_product_view.deal_status<>'Completed' 
        and tbl_user_product_view.deal_status<>'offer Rejected' ";

$product_dataget = mysqli_query($con, $query);

?>

<p class="toolbar-product-count">Showing: <?php echo mysqli_num_rows($product_dataget); ?> Items</p>

<?php
if (mysqli_num_rows($product_dataget) == 0) {
?>
    <div class="no-products-found">
        <center>
            <h3>No Assigned <br>Items Found</h3>
        </center>
    </div>
    <?php
} else {
    while ($rw = mysqli_fetch_assoc($product_dataget)) {
        $query = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id = '" . $rw['product_id'] . "' LIMIT 1");
        $file_dataget = mysqli_fetch_assoc($query);
        $file_data = $file_dataget['file_name'];
    ?>
        <div class="item col-item">
            <div class="product-box d-flex">
                <!-- Start Product Image -->
                <div class="product-image" style="width: 35%; padding: 5px;">
                    <!-- Start Product Image -->
                    <a href="<?php echo "./product-details/" . $rw['product_id']; ?>" class="product-img rounded-0" id="business_image">
                        <img class="rounded-0 blur-up lazyload" src="upload_content/upload_img/product_img/<?php echo $file_data ?>" alt="Product" title="Product" style="height: 120px; width:auto; object-fit:contain; max-width:100%; " />
                        <?php
                        if ($session_user_type == "Seller") {
                            if ($rw['product_status'] == "Active") {
                        ?>
                                <img src="frontend_assets/img-icon/status-open.png" class="product-status-img" />
                            <?php
                            } else {
                            ?>
                                <img src="frontend_assets/img-icon/status-close.png" class="product-status-img" />
                        <?php
                            }
                        }
                        ?>
                    </a>
                    <!-- End Product Image -->
                </div>
                <!-- End Product Image -->
                <!-- Start Product Details -->
                <div class="product-details text-left" style="width: 65%; padding-left: 5px; padding-top: 8px;">
                    <!-- Product Name -->
                    <div class="product-name" id="product_name">
                        <a id="product_name" href="<?php echo "./product-details/" . $rw['product_id']; ?>">
                            <?php echo $rw['product_name'] ?>
                        </a>

                    </div>
                    <div class="product-price">
                        <span class="price" id="sale_price" style="font-size: 16px;">
                            <img src="frontend_assets/img-icon/price.png" style="width: 20px;" />
                            <?php echo $rw['sale_price'] ?>
                        </span>
                    </div>
                    <div class="product-price product-list-category">
                        <span class="price" id="sale_price">
                            <img src="./upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img'] ?>" style="width: 20px;" />
                            <?php echo $rw['category_name'] ?>
                        </span>
                    </div>
                    <div class="product-price">
                        <span class="price" id="sale_price">
                            <img src="frontend_assets/img-icon/location.png" style="width: 20px;" />
                            <?php echo $rw['state'] . ", " . $rw['city'] . ", " . $rw['landmark'] . ", " . $rw['pincode']; ?>
                        </span>
                    </div>

                </div>
                <!-- End product details -->
            </div>
        </div>
<?php
    }
}
?>