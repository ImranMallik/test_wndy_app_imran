<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);

$deal_status = mysqli_real_escape_string($con, $sendData['deal_status']);

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
WHERE 1";

if ($session_user_type == "Buyer") {
    $query .= " and tbl_user_product_view.buyer_id = '" . $session_user_code . "' ORDER BY tbl_product_master.product_name DESC ";
}
if ($session_user_type == "Collector") {
    $query .= " and tbl_user_product_view.assigned_collecter = '" . $session_user_code . "' ORDER BY tbl_product_master.product_name DESC ";
}

$product_dataget = mysqli_query($con, $query);

?>

<p class="toolbar-product-count">Showing: <?php echo mysqli_num_rows($product_dataget); ?> Items</p>
<?php
if (mysqli_num_rows($product_dataget) == 0) {
?>
    <div class="no-products-found">
        <center>
            <h3>No Items Found</h3>
        </center>
    </div>
<?php
} else {
?>
    <div class="container-fluid">
        <div class="row">
            <?php
            while ($rw = mysqli_fetch_assoc($product_dataget)) {
                $query = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id = '" . $rw['product_id'] . "' LIMIT 1");
                $file_dataget = mysqli_fetch_assoc($query);
                $file_data = $file_dataget['file_name'];
            ?>
                <div class="col-sm-3 col-md-3 col-lg-3 col-3 mb-1">
                    <div class="item col-item" style="border-radius: 15px;">
                        <div class="product-box">
                            <!-- Start Product Image -->
                            <div class="product-image" style="width: 100%; border-radius: 15px;">
                                <!-- Start Product Image -->
                                <a href="<?php echo "./product-details/" . $rw['product_id']; ?>" class="product-img rounded-0" id="business_image">
                                    <img class="rounded-0 blur-up lazyload product-img" src="upload_content/upload_img/product_img/<?php echo $file_data ?>" alt="Product" title="Product" />
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

                                <!-- Start Product Details -->
                                <a style="background-color: #C17533 !important;" class="product-name" id="product_name" href="<?php echo "./product-details/" . $rw['product_id']; ?>">
                                    <?php echo $rw['product_name'] ?>
                                </a>
                                <!-- End product details -->

                                <?php
                                if ($session_user_type == "Seller") {
                                    if ($rw['product_status'] == "Active") {
                                ?>
                                        <a href="<?php echo "./seller-post/" . $rw['product_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:3px;">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- End Product Image -->
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
?>