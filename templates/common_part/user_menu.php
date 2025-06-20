<?php 
    include("../db/db.php");

    $user_data_get = mysqli_query($con, "SELECT
    tbl_user_master.user_id,
    tbl_user_master.ph_num,
    tbl_user_master.name,
    tbl_user_master.user_img
    FROM tbl_user_master
    WHERE tbl_user_master.user_id = '".$session_user_code."' ");
    $user_data = mysqli_fetch_assoc($user_data_get);

?>
<!-- Dashboard sidebar -->
<div class="dashboard-sidebar bg-block">
    <div class="profile-top text-center mb-4 px-3">
        <div class="profile-image mb-3">
            <img 
                style="width: 100px; height: 100px; border: 2px solid #eeeeee; margin-top: 10px;" 
                class="rounded-circle blur-up lazyload" 
                data-src="upload_content/upload_img/user_img/<?php echo isset($session_user_img['user_img']) && $session_user_img['user_img'] != "" ? $session_user_img['user_img'] : 'default.png'; ?>" 
                src="upload_content/upload_img/user_img/<?php echo isset($session_user_img['user_img']) && $session_user_img['user_img'] != "" ? $session_user_img['user_img'] : 'default.png'; ?>" 
                alt="<?php echo $session_name; ?>" 
            />
        </div>
        <div class="profile-detail">
            <h3 class="mb-1"><?php echo $user_data['seller_name'] ?></h3>
            <p class="user-type"><?php echo $session_user_type ?></p>
            <p><?php echo $user_data['name'] ?><br>
            <?php echo $user_data['ph_num'] ?></p><hr>
        </div>
    </div>
    <div class="dashboard-tab">
        <ul class="nav nav-tabs flex-lg-column border-bottom-0" id="top-tab" role="tablist">
            <li class="nav-item">
                <a href="<?php echo $baseUrl; ?>/dashboard"
                    class="nav-link <?php echo $pg_nm == "dashboard" ? "active" : ""; ?>"><i
                        class="anm anm-dashboard"></i>&nbsp;&nbsp;
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $baseUrl; ?>/my-account"
                    class="nav-link <?php echo $pg_nm == "my-account" ? "active" : ""; ?>"><i
                        class="fas fa-user-alt"></i>&nbsp;&nbsp;
                    My Profile
                </a>
            </li>
            <?php
            if ($session_user_type == "Buyer" || $session_user_type == "Seller") {
            ?>
            <li class="nav-item">
                <a href="<?php echo $baseUrl; ?>/address-book"
                    class="nav-link <?php echo $pg_nm == "address-book" ? "active" : ""; ?>"><i class="anm anm-map-marker-ar"></i>&nbsp;&nbsp; Address Book
                </a>
            </li>
            <?php 
            } 
            ?>
            <?php
            if ($session_user_type == "Seller") {
            ?>
            <li class="nav-item">
                <a href="<?php echo $baseUrl . "/seller-post"; ?>" class="nav-link <?php echo $pg_nm == "seller-post" ? "active" : ""; ?>">
                <img src="./frontend_assets/img-icon/post.png" height="20px;" width="20px;" style="margin-left:-2px;">&nbsp;
                    Create Post
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $baseUrl; ?>/product_list"
                    class="nav-link <?php echo $pg_nm == "product_list" ? "active" : ""; ?>"><i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;My Items
                </a>
            </li>
            <?php
            }
            ?>
            <?php 
            if ($session_user_type == "Buyer") {
            ?>
            <li class="nav-item">
                <a href="<?php echo $baseUrl; ?>/product_list"
                    class="nav-link <?php echo $pg_nm == "product_list" ? "active" : ""; ?>"><i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;Items
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $baseUrl . "/deal-items"; ?>" class="nav-link <?php echo $pg_nm == "deal-items" ? "active" : ""; ?>">
                    <i class="anm anm-unlock-ar"></i>&nbsp;&nbsp;
                    Deal Items
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $baseUrl; ?>/collector"
                    class="nav-link <?php echo $pg_nm == "collector" ? "active" : ""; ?>"><img src="./frontend_assets/img-icon/collector.png" height="18px;" width="18px;">&nbsp;
                    Assign Collector
                </a>
            </li>
            <?php 
            }
            ?>
            <?php
                if ($session_user_type == "Collector") {
            ?>
                <li class="nav-item">
                    <a href="<?php echo $baseUrl . "/assigned_product_list"; ?>" class="nav-link <?php echo $pg_nm == "assigned_product_list" ? "active" : ""; ?>">
                        <img src="frontend_assets/img-icon/assign-logo.png" height="22" width="22"/>
                            Assigned Items
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $baseUrl . "/deal-items"; ?>" class="nav-link <?php echo $pg_nm == "deal-items" ? "active" : ""; ?>">
                        <i class="anm anm-lock"></i>&nbsp;&nbsp;
                        Deal Items
                    </a>
                </li>
            <?php
            }
            ?>
            <li class="nav-item">
                <a onclick="log_out()" class="nav-link"><i class="anm anm-sign-out-al"></i>&nbsp;&nbsp;Sign Out
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End Dashboard sidebar -->