<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$address_line_1 = trim(mysqli_real_escape_string($con, $sendData['address_line_1']));

$query = "SELECT
    tbl_user_master.user_id,
    tbl_user_master.name,
    tbl_user_master.ph_num,
    tbl_user_master.referral_id,
    tbl_address_master.address_id,
    tbl_address_master.address_line_1,
    tbl_user_master.user_img
FROM 
    tbl_user_master
    LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_user_master.address_id
WHERE 
    tbl_user_master.active = 'Yes' 
    AND tbl_user_master.user_type = 'Collector'";

if ($session_user_type == "Buyer" || $session_user_type == "Collector") {
    $query .= " AND tbl_user_master.under_buyer_id = '" . $session_user_code . "' ";
}

if ($address_line_1 != "All") {
    $query .= " AND tbl_address_master.address_line_1='" . $address_line_1 . "' ";
}

$address_dataget = mysqli_query($con, $query);
?>

<p class="toolbar-product-count">Showing: <?php echo mysqli_num_rows($address_dataget); ?> Collectors</p>
<?php
if (mysqli_num_rows($address_dataget) == 0) {
?>
    <div class="no-products-found">
        <center>
            <h3>No Collectors Found</h3>
        </center>
    </div>
<?php
} else {
?>
    <?php
    while ($rw = mysqli_fetch_assoc($address_dataget)) {
    ?>
        <div class="item col-item">
            <div class="product-box d-flex" style="background-color: #ffeedf !important;">
                <!-- Start Product Image -->
                <div class="product-image" style="width: 35%; padding: 5px;">
                    <a class="product-img rounded-0" id="business_image">
                        <img class="blur-up lazyload"
                            src="upload_content/upload_img/user_img/<?php echo $rw['user_img'] === '' ? 'default.png' : $rw['user_img']; ?>"
                            alt="Collector"
                            title="Collector"
                            style="width: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #ffffff;" />
                    </a>

                    <!-- <?php if ($session_user_type == "Buyer" || $session_user_type == "Collector") { ?>
                    <a href="<?php echo "./add-collector/" . $rw['user_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:3px;">
                        <i class="fa fa-edit"></i>
                        Edit
                    </a>
                <?php } ?> -->
                </div>
                <!-- End Product Image -->
                <!-- Start Product Details -->
                <div class="product-details text-left" style="width: 65%; padding-left: 5px; padding-top: 8px; position: relative;">
                    <button type="button" onclick="delete_alert(<?php echo $rw['user_id']; ?>);" style="padding: 1px; position: absolute; top: 10px; right: 10px;" class="bottom-btn btn btn-gray btn-sm">
                        <img src="frontend_assets/img-icon/bin.png" style="margin-left: 4px; width: 25px;" />
                    </button>
                    <div class="product-price">
                        <span class="price" id="referral_id">
                            <img src="./frontend_assets/img-icon/referral.png" height="22px;" width="22px;" />
                            <?php echo $rw['referral_id']; ?>
                        </span>
                    </div>
                    <div class="product-name">
                        <a id="contact_name">
                            <img src="./frontend_assets/img-icon/name.png" height="22px;" width="22px;" />
                            <?php echo $rw['name']; ?>
                        </a>
                    </div>
                    <div class="product-price">
                        <span class="price" id="contact_ph_num">
                            <img src="./frontend_assets/img-icon/phone.png" height="22px;" width="22px;" />
                            <a href="tel:<?php echo $rw['ph_num']; ?>"><?php echo $rw['ph_num']; ?></a>
                        </span>
                    </div>
                    <div class="product-price">
                        <span class="price" id="address_line_1">
                            <img src="./frontend_assets/img-icon/loc.png" height="22px;" width="22px;" />
                            <span style="white-space: wrap; word-wrap: break-word;"><?php echo $rw['address_line_1']; ?></span>
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