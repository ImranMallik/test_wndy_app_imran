<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$product_id_direct = isset($_POST['product_id']) ? trim(mysqli_real_escape_string($con, $_POST['product_id'])) : null;
$filter_status = 'all';

$pincode = trim(mysqli_real_escape_string($con, $sendData['pincode']));
$landmark = trim(mysqli_real_escape_string($con, $sendData['landmark']));
$product_status = trim(mysqli_real_escape_string($con, $sendData['product_status']));
$category_id = trim(mysqli_real_escape_string($con, $sendData['category_id']));
$seller_id = trim(mysqli_real_escape_string($con, $sendData['seller_id']));
$city = trim(mysqli_real_escape_string($con, $sendData['city']));

$seller_name = "";

// ✅ Check for product_id and override logic if passed
if (!empty($product_id_direct)) {
    $seller_q = mysqli_query($con, "SELECT user_id FROM tbl_product_master WHERE product_id = '$product_id_direct' LIMIT 1");
    if ($seller_row = mysqli_fetch_assoc($seller_q)) {
        $seller_user_id = $seller_row['user_id'];

        $query = "SELECT 
            tbl_product_master.product_id,
            tbl_product_master.product_name,
            tbl_category_master.category_img,
            tbl_category_master.category_name,
            tbl_product_master.sale_price,
            tbl_product_master.product_status,
            tbl_product_master.quantity,
            tbl_product_master.quantity_unit,
            tbl_address_master.state,
            tbl_address_master.city,
            tbl_address_master.landmark,
            tbl_address_master.pincode
        FROM tbl_product_master
        LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
        LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
        WHERE tbl_product_master.active = 'Yes'
          AND tbl_product_master.user_id = '$seller_user_id'
          AND tbl_product_master.product_status NOT IN ('Completed', 'Pickup Scheduled', 'Third-Party Transaction')
        ORDER BY tbl_product_master.entry_timestamp DESC";

        $seller_name_result = mysqli_query($con, "SELECT name FROM tbl_user_master WHERE user_id = '$seller_user_id'");
        if ($seller_name_row = mysqli_fetch_assoc($seller_name_result)) {
            $seller_name = $seller_name_row['name'];
        }
    }
} else {
    // ✅ Default query logic (unchanged)
$query = "SELECT 
    tbl_product_master.product_id,
    tbl_product_master.product_name,
    tbl_category_master.category_img,
    tbl_category_master.category_name,
    tbl_product_master.sale_price,
    tbl_product_master.product_status,
    tbl_product_master.quantity,
    tbl_product_master.quantity_unit,
    tbl_address_master.state,
    tbl_address_master.city,
    tbl_address_master.landmark,
    tbl_address_master.pincode
FROM tbl_product_master
LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
WHERE tbl_product_master.active = 'Yes' ";

 if ($session_user_type == "Seller") {
    $query .= " AND tbl_product_master.user_id = '" . $session_user_code . "' ";
    if (!empty($product_status)) {
        $query .= " AND tbl_product_master.product_status = '" . $product_status . "' ";
    }
} else {
    $query .= " AND tbl_product_master.product_status NOT IN ('Completed', 'Pickup Scheduled', 'Third-Party Transaction') ";
    if (!empty($seller_id) && $seller_id != "All") {
        $query .= " AND tbl_product_master.user_id = '" . $seller_id . "' ";
    }
}

    if (!empty($category_id)) {
    $query .= " AND tbl_product_master.category_id = '" . $category_id . "' ";
}

if (!empty($pincode) && $pincode != "All") {
    $query .= " AND tbl_address_master.pincode = " . (int)$pincode . " ";
}

if (!empty($landmark) && $landmark != "All") {
    $query .= " AND tbl_address_master.landmark = '" . $landmark . "' ";
}

if (!empty($city) && $city != "All") {
    $query .= " AND tbl_address_master.city = '" . $city . "' ";
}

    $query .= " ORDER BY tbl_product_master.entry_timestamp DESC ";
}

// echo $query;
// exit();

$product_dataget = mysqli_query($con, $query);

// ✅ Category filter display
if ($category_id != "") {
    $category_dataget = mysqli_query($con, "SELECT category_name FROM tbl_category_master WHERE category_id='" . $category_id . "' ");
    $category_data = mysqli_fetch_row($category_dataget);
    $category_name = $category_data[0];
    ?>
    <p class="filter-result-text-content" title="Click For Clear Filter" onclick="closeCategory()">
        <i class="fa fa-times-circle" style="margin-right: 5px;"></i>
        Filter Result For : <?php echo $category_name; ?>
    </p>
<?php } ?>

<?php
// ✅ Seller name logic (only if not already set from direct product_id case)
if (empty($seller_name) && !empty($seller_id)) {
    $seller_result = mysqli_query($con, "SELECT name FROM tbl_user_master WHERE user_id = '$seller_id'");
    if ($seller_row = mysqli_fetch_assoc($seller_result)) {
        $seller_name = $seller_row['name'];
    }
}
?>

<p class="toolbar-product-count mt-3">
    <?php if (!empty($seller_name)) { ?>
        <strong><?php echo $seller_name; ?></strong> has <?php echo mysqli_num_rows($product_dataget); ?> items.<br>
    <?php } else { ?>
        Showing: <?php echo mysqli_num_rows($product_dataget); ?> Items<br>
    <?php } ?>
    <?php if (empty($product_id_direct)) { ?>
        For Pincode: <strong>"<?php echo $pincode; ?>"</strong> and Landmark: <strong>"<?php echo $landmark; ?>"</strong>, City: <strong>"<?php echo $city; ?>"</strong>
        <?php if ($product_status != "") { ?>
            and Status: <strong>"<?php echo $product_status; ?>"</strong>
        <?php } ?>
    <?php } ?>
</p>

<?php
if (mysqli_num_rows($product_dataget) == 0) {
    ?>
    <div class="no-products-found">
        <center><h3>No Items <br>Found</h3></center>
    </div>
<?php
} else {
    ?>
    <div class="container-fluid" style="margin-top:5px !important; margin-bottom:50px;">
        <div class="row">
            <?php
            while ($rw = mysqli_fetch_assoc($product_dataget)) {
                $file_q = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id = '" . $rw['product_id'] . "' LIMIT 1");
                $file_data = mysqli_fetch_assoc($file_q)['file_name'];
                ?>
                <div class="list-item d-flex gap-3">
                    <a href="./product-details/<?php echo $rw['product_id']; ?>" class="product-img rounded-0" id="business_image">
                        <img src="upload_content/upload_img/product_img/<?php echo $file_data ?>" alt="product_img" class="flex-shrink-0 lazyload">
                    </a>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="product-name h5 mb-1" id="product_name" href="./product-details/<?php echo $rw['product_id']; ?>">
                                <h3 class="h5 mb-1"><?php echo $rw['product_name'] ?></h3>
                            </a>
                            <span class="fw-bold mb-0" style="text-align: end !important;"><?php
                                if ($session_user_type == "Buyer") {
                                    if (in_array($rw['product_status'], ["Active", "Post Viewed", "Offer Accepted", "Under Negotiation", "Pickup Scheduled"])) {
                                        echo '<span class="status">Open</span>';
                                    } elseif ($rw['product_status'] == "Completed") {
                                        echo '<span class="status">Closed</span>';
                                    }
                                }
                            ?><br><br>
                                ₹<?php echo $rw['sale_price'] ?>
                            </span>
                        </div>
                        <span class="text-secondary"><?php echo $rw['category_name'] ?></span><br>
                        <span class="text-secondary">
                            <?= htmlspecialchars($rw['quantity']) . (!empty($rw['quantity_unit']) ? ' (' . htmlspecialchars($rw['quantity_unit']) . ')' : '') ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
