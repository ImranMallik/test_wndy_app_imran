<?php
include("../db/db.php");

if ($login == "Yes" && $session_user_type == "Seller") {
?>
    <div class="menubar-mobile d-flex align-items-center justify-content-between d-lg-none" style="display: none;">
        <div class="menubar-shop menubar-item">
            <a href="<?php echo $baseUrl; ?>/dashboard"><i class="menubar-icon anm anm-dashboard"></i><span
                    class="menubar-label">Dashboard</span></a>
        </div>
        <div class="menubar-shop menubar-item">
            <a href="<?php echo $baseUrl; ?>/seller-post"><i class="menubar-icon anm anm-upload-l"></i><span
                    class="menubar-label">Create Post</span></a>
        </div>
        <div class="menubar-search menubar-item">
            <a href="<?php echo $baseUrl; ?>/post-details"><span class="menubar-icon fas fa-luggage-cart"></span><span
                    class="menubar-label">Products</span></a>
        </div>
        <div class="menubar-cart menubar-item">
            <a onclick="log_out()" class="btn-minicart">
                <span class="span-count position-relative text-center"><i class="icon anm anm-sign-out-al"></i>
                    <span class="menubar-label">Sign Out</span>
            </a>
        </div>
    </div>
<?php } else if ($login == "Yes" && $session_user_type == "Buyer") { ?>
    <div class="menubar-mobile d-flex align-items-center justify-content-between d-lg-none" style="display: none;">
        <?php
        $cartlist_details_query = mysqli_query($con, "SELECT * FROM customer_cart WHERE  customer_code = '" . $session_user_code . "'
                            ");
        // Fetch the results
        $cart_details = mysqli_num_rows($cartlist_details_query);
        ?>
        <div class="menubar-cart menubar-item">
            <a href="<?php echo $baseUrl; ?>/cart" class="btn-minicart" data-bs-toggle="offcanvas" data-bs-target="#minicart-drawer">
                <span class="span-count position-relative text-center"><i
                        class="menubar-icon icon anm anm-cart-l"></i><span
                        class="cart-count counter menubar-count"><?php echo $cart_details ?></span></span>
                <span class="menubar-label">My Cart</span>
            </a>
        </div>
        <div class="menubar-search menubar-item">
            <a href="<?php echo $baseUrl; ?>/post-details"><span class="menubar-icon anm anm-home-l"></span><span
                    class="menubar-label">Products</span></a>
        </div>
        <div class="menubar-cart menubar-item">
            <a onclick="log_out()" class="btn-minicart">
                <span class="span-count position-relative text-center"><i class="icon anm anm-sign-out-al"></i>
                    <span class="menubar-label">Sign Out</span>
            </a>
        </div>
    </div>
<?php } else if ($login == "No") { ?>
<?php } ?>