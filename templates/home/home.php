<!-- Body Container -->

<div id="page-content" class="mb-0">

    <!--Home Slideshow-->
    <section class="slideshow slideshow-wrapper">
        <div class="home-slideshow slick-arrow-dots">
            <?php
            $slider_daataget = mysqli_query($con, "SELECT * FROM tbl_home_slider WHERE active='Yes' ORDER BY order_num");
            while ($rw = mysqli_fetch_array($slider_daataget)) {
                ?>
            <div class="slide">
                <div class="slideshow-wrap">
                    <picture>
                        <img class="blur-up lazyload slider-img"
                            src="upload_content/upload_img/slider_img/<?php echo $rw['slider_img']; ?>" alt=" slideshow"
                            title="waste-management-marketplace" />
                    </picture>
                    <div class="container">
                        <div class="slideshow-content slideshow-overlay middle-left">
                            <div class="slideshow-content-in">
                                <div class="wrap-caption animation style1">
                                    <!-- <p class="ss-small-title">Elegant design</p> -->
                                    <h2 class="ss-mega-title" style="color:#fff">
                                        <?php echo $rw['heading']; ?>
                                    </h2>
                                    <p class="ss-sub-title xs-hide" style="color:#fff">
                                        <?php echo $rw['sub_text']; ?>
                                    </p>
                                    <div class="ss-btnWrap">
                                        <a class="btn btn-secondary" style="border-radius:5px;"
                                            href="<?php echo $rw['link']; ?>"><?php echo $rw['button_text']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
    <!--End Home Slideshow-->
    <!--Popular Categories-->
    <section class="section collection-slider pb-0">
        <div class="container">
            <div class="section-header">
                <h2>All Categories</h2>
            </div>

            <div class="collection-slider-5items gp15 arwOut5 hov-arrow">

                <?php
                $category_daataget = mysqli_query($con, "SELECT * FROM tbl_category_master WHERE active='Yes'");
                while ($rw = mysqli_fetch_array($category_daataget)) {
                    ?>
                <div class="category-item zoomscal-hov">
                    <a href="<?php echo $baseUrl; ?>/product-list/<?php echo $rw['category_id'] ?>"
                        class="category-link clr-none">
                        <div class="zoom-scal zoom-scal-nopb rounded-3" style="height:120px; ">
                            <img class="blur-up lazyload"
                                data-src="upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img']; ?>"
                                src="upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img']; ?>"
                                alt="Men's Jakets" title="Men's Jakets" width="165" height="165"
                                style="height: 150px !important; width: 120px !important;" />
                        </div>
                        <div class="details mt-3 text-center">
                            <h4 class="category-title mb-0"><?php echo $rw['category_name']; ?></h4>
                        </div>
                    </a>
                </div>

                <?php
                }
                ?>

            </div>
        </div>
    </section>
    <!--End Popular Categories-->
    <section class="collection-slider pb-0">
        <div class="container">
            <!-- <div class="section-header">
                <h2 class="mb-0">Popular Categories</h2>
                <p>Here’s some of most people are in love with this categories.</p>
            </div> -->

            <div class="collection-slider-6items gp15 arwOut5 hov-arrow">

                <?php
                $category_dataget = mysqli_query($con, "select 
                    tbl_category_master.category_id,
                    tbl_category_master.category,
                    tbl_category_master.category_img,
                    (select count(*) from tbl_product_master where tbl_product_master.category_id = tbl_category_master.category_id and tbl_product_master.active='Yes' ) AS total_product_count
                    from tbl_category_master 
                    where tbl_category_master.active='Yes' ");
                while ($rw = mysqli_fetch_array($category_dataget)) {
                    ?>
                <div class="category-item category-slider-box-sec-main zoomscal-hov">
                    <a href="<?php echo $baseUrl; ?>/product-list/<?php echo $rw['category_id'] ?>"
                        class="category-link clr-none">
                        <div class="zoom-scal category-slider-box-sec zoom-scal-nopb rounded-circle bg-dark">
                            <img class="blur-up lazyload"
                                data-src="upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img']; ?>"
                                src="upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img']; ?>"
                                alt="<?php echo $rw['category']; ?>" title="<?php echo $rw['category']; ?>" />
                        </div>
                        <div class="details mt-3 text-center">
                            <h4 class="category-title mb-0"><?php echo $rw['category']; ?></h4>
                            <!-- <p class="counts"><?php echo $rw['total_product_count']; ?> Products</p> -->
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>

            </div>
        </div>
    </section>




    <div class="container mb-5">
        <div class="section-header pt-5 pb-3">
            <h2>All Products</h2>
        </div>


        <div class="grid-products grid-view-items">
            <div class="row">


                <?php
                $all_products_dataget = mysqli_query($con, "SELECT tbl_product_master.product_id, tbl_product_file.file_name,tbl_product_master.product_name,tbl_product_master.mrp,tbl_product_master.sale_price,tbl_product_master.discount_percentage 
                FROM tbl_product_master
                LEFT JOIN tbl_product_file ON tbl_product_file.product_id = tbl_product_master.product_id
                where tbl_product_master.active='Yes'");
                while ($all_products = mysqli_fetch_array($all_products_dataget)) {
                    ?>
                <div class="col-lg-3">
                    <div class="item col-item">
                        <div class="product-box">
                            <!-- Start Product Image -->
                            <div class="product-image">
                                <!-- Start Product Image -->
                                <a href="<?php echo $baseUrl; ?>/product-details/<?php echo $all_products['product_id'] ?>"
                                    class="product-img rounded-3"><img class="blur-up lazyloaded"
                                        src="upload_content/upload_img/product_img/<?php echo $all_products['file_name'] ?>"
                                        alt="Product" title="Product" width="625" height="808"
                                        style="height:350px; object-fit:cover;"></a>
                                <!-- End Product Image -->
                                <!-- Product label -->

                                <!-- End Product label -->

                                <!--Product Button-->
                                <div class="button-set style1">


                                    <!--Wishlist Button-->
                                    <!-- <a href="#" class="btn-icon wishlist" data-bs-toggle="tooltip"
                                        data-bs-placement="left" title="" data-bs-original-title="Add To Wishlist"><i
                                            class="icon anm anm-heart-l"></i><span class="text">Add To
                                            Wishlist</span></a> -->
                                    <!--End Wishlist Button-->

                                </div>
                                <!--End Product Button-->
                            </div>
                            <!-- End Product Image -->
                            <!-- Start Product Details -->
                            <div class="product-details">
                                <!-- Product Name -->
                                <div class="product-name">
                                    <a
                                        href="<?php echo $baseUrl; ?>/product-details/<?php echo $all_products['product_id'] ?>"><?php echo $all_products['product_name'] ?></a>
                                </div>
                                <!-- End Product Name -->
                                <!-- Product Price -->
                                <div class="product-price">
                                    <span class="price old-price"><?php echo $all_products['mrp'] ?></span><span
                                        class="price"><?php echo $all_products['sale_price'] ?></span>
                                </div>
                                <!-- End Product Price -->


                            </div>
                            <!-- End product details -->
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="view-collection text-center mt-4 mt-md-5">
                    <a href="product-list" class="btn btn-secondary btn-lg">View Collection</a>
                </div>
            </div>
        </div>


    </div>
    <!-- End Body Container -->


    <!--Service Section-->
    <section class="section service-section pb-5 ">
        <div class="container">
            <div class="service-info row col-row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-2 text-center">
                <div class="service-wrap col-item">
                    <div class="service-icon mb-3">
                        <i class="icon anm anm-phone-call-l"></i>
                    </div>
                    <div class="service-content">
                        <h3 class="title mb-2">Call us any time</h3>
                        <span class="text-muted">Contact us 24/7 hours a day</span>
                    </div>
                </div>
                <div class="service-wrap col-item">
                    <div class="service-icon mb-3">
                        <i class="icon anm anm-truck-l"></i>
                    </div>
                    <div class="service-content">
                        <h3 class="title mb-2">Pickup At Any Store</h3>
                        <span class="text-muted">Free shipping on orders over $65</span>
                    </div>
                </div>
                <div class="service-wrap col-item">
                    <div class="service-icon mb-3">
                        <i class="icon anm anm-credit-card-l"></i>
                    </div>
                    <div class="service-content">
                        <h3 class="title mb-2">Secured Payment</h3>
                        <span class="text-muted">We accept all major credit cards</span>
                    </div>
                </div>
                <div class="service-wrap col-item">
                    <div class="service-icon mb-3">
                        <i class="icon anm anm-redo-l"></i>
                    </div>
                    <div class="service-content">
                        <h3 class="title mb-2">Free Returns</h3>
                        <span class="text-muted">30-days free return policy</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Service Section-->