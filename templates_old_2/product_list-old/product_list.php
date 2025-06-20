<!-- Body Container -->
<?php
$product_status = $arr[2];

?>
<div id="page-content" class="mb-0">

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar sidebar-bg filterbar">
                <div class="closeFilter d-block d-lg-none"><i class="icon anm anm-times-r"></i></div>
                <div class="sidebar-tags sidebar-sticky clearfix">

                    <div class="sidebar-widget clearfix categories filterBox filter-widget">
                        <div class="widget-title" style="background-color: #f8f9fa !important;">
                            <h2>Choose Categories</h2>
                        </div>
                        <div class="widget-content filterDD" style="position: relative;">
                            <div class="category-div gapp-5" style="padding: 0px;">
                                <?php
                                $i = 1;
                                $category_dataget = mysqli_query($con, "select category_id, category_name, category_img from tbl_category_master where active='Yes' order by order_number ASC ");
                                while ($rw = mysqli_fetch_array($category_dataget)) {
                                ?>
                                    <button onclick="selectCategory(<?php echo $i; ?>)"
                                        data-category_id="<?php echo $rw['category_id'] ?>"
                                        data-category_name="<?php echo $rw['category_name'] ?>"
                                        class="cart-btn-width cat-btn cate_btn_<?php echo $i; ?>"
                                        title="<?php echo $rw['category_name']; ?>" style="display: inline-block;">
                                        <img
                                            src="./upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img'] ?>" />
                                        <br />
                                        <?php echo $rw['category_name']; ?>
                                    </button>
                                <?php
                                    $i++;
                                }
                                ?>
                            </div>

                            <div class="catgory-show-div">
                                <span class="category-close-btn" onclick="closeCategory()">
                                    <i class="fa fa-remove"></i>
                                </span>
                                <button class="cat-btn main-cate-btn animate__animated animate__bounceIn"
                                    style="line-height: normal;width: 100%;font-size: 12px;">
                                    <img
                                        src="./upload_content/upload_img/category_img/category_img_3-5-2024-1717401090147.png" />
                                    Category Name With Full
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-10 col-lg-10 text-right filters-toolbar-item order-2 order-sm-2"
                        style="padding:10px;">
                        <?php

                        $buyerPincode = "";
                        $buyerLandmark = "";

                        if ($session_user_type == "Buyer") {
                            $buyerAddressDataget = mysqli_query($con, "select tbl_address_master.landmark, tbl_address_master.pincode from tbl_user_master LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_user_master.address_id where tbl_user_master.user_id='" . $session_user_code . "' ");
                            $buyerAddressData = mysqli_fetch_row($buyerAddressDataget);
                            $buyerPincode = $buyerAddressData[1];
                        }
                        ?>
                        <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                                <select id="pincode" class="filters-toolbar-sort" onchange="getLandmark()">
                                    <option value="All">All Pincode</option>
                                    <?php
                                    if ($session_user_type == "Seller") {
                                        $address_pincode_dataget = mysqli_query($con, "select distinct(pincode) from tbl_address_master where user_id='" . $session_user_code . "' order by pincode ASC ");
                                    } else {
                                        $address_pincode_dataget = mysqli_query($con, "select distinct(pincode) from tbl_address_master where 1 order by pincode ASC ");
                                    }
                                    while ($rw = mysqli_fetch_array($address_pincode_dataget)) {
                                    ?>
                                        <option value="<?php echo $rw['pincode'] ?>" <?php echo $buyerPincode == $rw['pincode'] ? "selected" : ""; ?>><?php echo $rw['pincode'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                                <select id="landmark" class="filters-toolbar-sort" onchange="getProductList()">
                                    <option value="All">All Landmark</option>
                                    <?php
                                    if ($session_user_type == "Seller") {
                                        $address_landmark_dataget = mysqli_query($con, "select distinct(landmark) from tbl_address_master where user_id='" . $session_user_code . "' order by landmark ASC ");
                                    } else {
                                        $address_landmark_dataget = mysqli_query($con, "select distinct(landmark) from tbl_address_master where 1 order by landmark ASC ");
                                    }
                                    while ($rw = mysqli_fetch_array($address_landmark_dataget)) {
                                    ?>
                                        <option value="<?php echo $rw['landmark'] ?>" <?php echo $buyerLandmark == $rw['landmark'] ? "selected" : ""; ?>>
                                            <?php echo $rw['landmark'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>

                        <center>
                            <button style="margin-top: 10px;" class="btn btn_dark filter-btn-clear"
                                onclick="clear_filter()">Clear All
                                Filter</button>
                        </center>

                    </div>

                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-9 main-col">

                <!--Toolbar-->
                <div class="toolbar toolbar-wrapper shop-toolbar">
                    <div class="row align-items-center mt-2">

                        <div
                            class="col-12 col-sm-12 col-md-12 col-lg-12 filters-toolbar-item order-2 order-sm-2 d-flex justify-content-between align-items-center">
                            <div class="row w-100">
                                <div class="col text-left">
                                    <button type="button" class="btn btn-filter d-lg-none me-2">
                                        <img src="frontend_assets/img-icon/filter-2.png">&nbsp; Filter &nbsp;
                                        <img src="frontend_assets/img-icon/caret-down.png"
                                            style="max-height: 11.5px !important;">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Toolbar-->
                <div class="fixed-top bg-white">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-3">
                            <a href="dashboard" class="text-dark">
                                <i class="bi bi-arrow-left fs-5"></i>
                            </a>
                            <h1 class="mb-0 fs-4 fw-bold text-dark">My List</h1>
                        </div>

                        <i class="bi bi-sliders fs-5 btn-filter"></i>

                    </div>

                    <!-- Filter Tabs -->
                    <div class="d-flex gap-2 p-3 overflow-auto">
                        <a class="btn rounded-pill-list filter-btn" data-filter="all">All</a>
                        <a class="btn rounded-pill-list filter-btn" data-filter="Active">Open</a>
                        <a class="btn rounded-pill-list filter-btn" data-filter="in-process"><span>In
                                Process</span></a>
                        <a class="btn rounded-pill-list filter-btn" data-filter="Completed">Closed</a>
                        <?php if ($session_user_type != "Buyer") { ?>
                            <a class="btn rounded-pill-list filter-btn" data-filter="Third-Party Transaction">
                                <span>Not Sold</span>
                            </a>
                        <?php } ?>

                    </div>
                </div>
                <!--Product Infinite-->
                <div class="product-listview-loadmore">


                    <div class="pt-2 mt-5 pb-3 px-3">
                        <div class="list-items" id="product_list">

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>