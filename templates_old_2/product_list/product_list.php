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
                                               <?php if ($session_user_type == "Buyer") { ?>
                            <div class="row">
                                <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                                    <div class="custom-select-wrapper">
                                        <div class="custom-select" onclick="toggleOptions()">Select Seller</div>
                                        <span class="dropdown-icon"><i class="bi bi-chevron-down f-500"></i></span>
                                        <!-- ▼ -->
                                        <div class="custom-options" id="customOptions">

                                            <!-- 🔍 Search Box -->
                                            <input type="text" class="custom-search" placeholder="Search..."
                                                onkeyup="filterOptions(this.value)">
                                            <div onclick="selectOption(this, 'All')">All Sellers</div>
                                            <?php
                                $seller_query = mysqli_query($con, "
                                SELECT user_id, name 
                                FROM tbl_user_master 
                                WHERE user_type = 'Seller' 
                                  AND user_id IN (
                                      SELECT DISTINCT user_id 
                                      FROM tbl_product_master 
                                      WHERE product_status IN ('Active', 'Post Viewed', 'Under Negotiation')
                                        AND is_draft = 0
                                  )
                                ORDER BY name ASC
                            ");
                            

                                            while ($seller = mysqli_fetch_array($seller_query)) {
                                                $id = $seller['user_id'];
                                                $name = htmlspecialchars($seller['name']);
                                                echo "<div onclick=\"selectOption(this, '$id')\">$name</div>";
                                            }
                                            ?>

                                            <!-- ❗ No Results Message -->
                                            <div id="noResult"
                                                style="display: none; padding: 10px; color: #999; font-style: italic;">
                                                No results found
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Hidden select to trigger original logic (optional if needed) -->
                                    <select id="seller_id" style="display:none;" onchange="getProductList()">
                                        <option value="All">All Sellers</option>
                                        <?php
                                        mysqli_data_seek($seller_query, 0); // reset result pointer if needed
                                        while ($seller = mysqli_fetch_array($seller_query)) {
                                            $selected = $selectedSellerId == $seller['user_id'] ? "selected" : "";
                                            echo "<option value=\"{$seller['user_id']}\" $selected>{$seller['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                        <br>
                          <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                                <select id="pincode" class="filters-toolbar-sort" onchange="getProductList()">
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
                                <select id="city" class="filters-toolbar-sort" onchange="getProductList()">
                                    <option value="All">All city</option>
                                    <?php
                                    if ($session_user_type == "Seller") {
                                        $address_city_dataget = mysqli_query($con, "select distinct(city) from tbl_address_master where user_id='" . $session_user_code . "' order by city ASC ");
                                    } else {
                                        $address_city_dataget = mysqli_query($con, "select distinct(city) from tbl_address_master where 1 order by city ASC ");
                                    }
                                    while ($rw = mysqli_fetch_array($address_city_dataget)) {
                                    ?>
                                        <option value="<?php echo $rw['city'] ?>" <?php echo $buyerLandmark == $rw['city'] ? "selected" : ""; ?>>
                                            <?php echo $rw['city'] ?>
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
                         <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                                <select id="product_status" class="filters-toolbar-sort" onchange="getProductList()" <?php if ($session_user_type != "Seller") { ?> style="display: none;" <?php } ?>>
                                    <?php
                                    if ($session_user_type == "Seller") {
                                    ?>
                                        <option value="">All Product</option>
                                        <option value="Active" <?php echo $product_status == "active" ? "selected" : ""; ?>>Active</option>
                                        <option value="Post viewed" <?php echo $product_status == "post_viewed" ? "selected" : ""; ?>>Post Viewed</option>
                                        <option value="Under Negotiation" <?php echo $product_status == "under_negotiation" ? "selected" : ""; ?>>Under Negotiation</option>
                                        <option value="Offer Accepted" <?php echo $product_status == "offer_accepted" ? "selected" : ""; ?>>Offer Accepted</option>
                                        <option value="Pickup Scheduled" <?php echo $product_status == "pickup_scheduled" ? "selected" : ""; ?>>Pickup Scheduled</option>
                                        <option value="Completed" <?php echo $product_status == "completed" ? "selected" : ""; ?>>Completed</option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="">All Product</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <center>
                            <button style="margin-top: 30px !important; background-color:#C17533 !important; border:none !important;" class="btn btn_dark filter-btn-clear"
                                onclick="clear_filter()">Clear All
                                Filter</button>
                                
<button 
  style="margin-top: 30px !important; background-color:#C17533 !important; border:none !important;" 
  class="btn btn_dark filter-btn-clear filter-btn-clear-done"
>
  Done
</button>




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

                        <?php 
if($session_user_type != "Seller") {
    echo '<i class="bi bi-sliders fs-5 btn-filter"></i>';
}
?>

                    </div>

                    <!-- Filter Tabs -->
                    <div class="d-flex gap-2 p-3 overflow-auto">
                        <a class="btn rounded-pill-list filter-btn active" data-filter="all">All</a>
                        <a class="btn rounded-pill-list filter-btn" data-filter="Active">Open</a>
                        <a class="btn rounded-pill-list filter-btn" data-filter="in-process"><span>In
                                Process</span></a>
                        <a class="btn rounded-pill-list filter-btn" data-filter="Completed">Closed</a>
                        <!--<a class="btn rounded-pill-list filter-btn" data-filter="Completed"><span>Not Solde</span></a>-->
                        <?php if ($session_user_type != "Buyer") { ?>
                        <a class="btn rounded-pill-list filter-btn" data-filter="Third-Party Transaction">
                        <span>Not Sold</span>
                        </a>
                        <?php } ?>
                        <?php if ($session_user_type != "Buyer") { ?>
                        <a class="btn rounded-pill-list filter-btn" data-filter="draft-post">
                        <span>Draft Post</span>
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
                <div class="text-center loder-button">
               <i id="loadMore" class="bi bi-chevron-down load-more-arrow" style="display: none;"></i>
              </div>

                </div>

            </div>

        </div>

    </div>