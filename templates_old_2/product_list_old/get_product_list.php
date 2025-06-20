<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$pincode = trim(mysqli_real_escape_string($con, $sendData['pincode']));
$landmark = trim(mysqli_real_escape_string($con, $sendData['landmark']));
$product_status = trim(mysqli_real_escape_string($con, $sendData['product_status']));
$category_id = trim(mysqli_real_escape_string($con, $sendData['category_id']));


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
        FROM tbl_product_master
        LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
        LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
        WHERE tbl_product_master.active = 'Yes' ";

if ($session_user_type == "Seller") {
    $query .= " and tbl_product_master.user_id = '" . $session_user_code . "' ";

    if ($product_status != "") {
        $query .= " and tbl_product_master.product_status = '" . $product_status . "' ";
    }
} else {
    $query .= " and (tbl_product_master.product_status <> 'Completed' and tbl_product_master.product_status <> 'Pickup Scheduled') ";
}

if ($category_id != "") {
    $query .= " and tbl_product_master.category_id='" . $category_id . "' ";
}

if ($pincode != "All") {
    $query .= " and tbl_address_master.pincode='" . $pincode . "' ";
}

if ($landmark != "All") {
    $query .= " and tbl_address_master.landmark='" . $landmark . "' ";
}

$query .= " order by tbl_product_master.entry_timestamp DESC ";

$product_dataget = mysqli_query($con, $query);


if ($category_id != "") {
    $category_dataget = mysqli_query($con, "select category_name from tbl_category_master where category_id='" . $category_id . "' ");
    $category_data = mysqli_fetch_row($category_dataget);
    $category_name = $category_data[0];
?>
    <p class="filter-result-text-content" title="Click For Clear Filter" onclick="closeCategory()">
        <i class="fa fa-times-circle" style="margin-right: 5px;"></i>
        Filter Result For : <?php echo $category_name; ?>
    </p>
<?php
}
?>

<p class="toolbar-product-count">
    Showing: <?php echo mysqli_num_rows($product_dataget); ?> Items<br>
    For Pincode: <strong>"<?php echo $pincode; ?>"</strong> and Landmark: <strong>"<?php echo $landmark; ?>"</strong>
    <?php
    if ($product_status != "") {
    ?>
        and Status: <strong>"<?php echo $product_status; ?>"</strong>
    <?php
    }
    ?>
</p>
<?php
if (mysqli_num_rows($product_dataget) == 0) {
?>
    <div class="no-products-found">
        <center>
            <h3>No Items <br>Found</h3>
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
                <div class="col-sm-3 col-md-3 col-lg-3 col-3">
                    <div class="item col-item" style="border-radius: 15px;">
                        <div class="product-box">
                            <!-- Start Product Image -->
                            <div class="product-image" style="width: 100%; height: 100%; border-radius: 15px;">
                                <!-- Start Product Image -->
                                <a href="<?php echo "./product-details/" . $rw['product_id']; ?>" class="product-img rounded-0"
                                    id="business_image">
                                    <img class="rounded-0 blur-up lazyload product-img"
                                        src="upload_content/upload_img/product_img/<?php echo $file_data ?>" alt="Product"
                                        title="Product" />

                                    <?php
                                    if ($session_user_type == "Seller") {
                                        if ($rw['product_status'] == "Active") {
                                    ?>
                                            <img src="frontend_assets/img-icon/status-open.png" class="product-status-img" />
                                        <?php
                                        } else if ($rw['product_status'] == "Completed") {
                                        ?>
                                            <img src="frontend_assets/img-icon/status-close.png" class="product-status-img" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="frontend_assets/img-icon/unlocked.png" class="product-status-img open_deal" />
                                    <?php
                                        }
                                    }
                                    ?>
                                </a>
                                <!-- End Product Image -->

                                <!-- Start Product Details -->
                                <a class="product-name" id="product_name"
                                    href="<?php echo "./product-details/" . $rw['product_id']; ?>">
                                    <?php echo $rw['product_name'] ?>
                                </a>
                                <!-- End product details -->
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