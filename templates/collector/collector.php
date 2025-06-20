<div id="page-content" class="mb-0">
    <!--Main Content-->
    <div class="container">
        <div class="row">
            <!--Sidebar-->
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar sidebar-bg filterbar">
                <div class="closeFilter d-block d-lg-none"><i class="icon anm anm-times-r"></i></div>
                <div class="sidebar-tags sidebar-sticky clearfix">

                    <div class="col-10 col-sm-10 col-md-10 col-lg-10 text-right filters-toolbar-item order-2 order-sm-2">
                        <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 col-lg-12" style="padding-left:15px !important;">
                                <div class="widget-title">
                                    <h2 style="text-align: left; padding-bottom: 20px;">Choose Addresses</h2>
                                </div>
                                <select id="address_line_1" class="filters-toolbar-sort" onchange="getCollectorList()">
                                    <option value="All">All Address</option>
                                    <?php
                                    if ($session_user_type == "Buyer" || $session_user_type == "Collector") {
                                        $address_dataget = mysqli_query($con, "SELECT DISTINCT(address_line_1) FROM tbl_address_master WHERE user_id='" . $session_user_code . "' order by address_line_1 ASC ");
                                    } else {
                                        $address_dataget = mysqli_query($con, "SELECT DISTINCT(address_line_1) FROM tbl_address_master WHERE 1 ORDER BY address_line_1 ASC ");
                                    }
                                    while ($rw = mysqli_fetch_array($address_dataget)) {
                                    ?>
                                        <option value="<?php echo $rw['address_line_1'] ?>"><?php echo $rw['address_line_1'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!--End Sidebar-->

            <!--Products-->
            <div class="col-12 col-sm-12 col-md-12 col-lg-9 main-col">

                <!--Toolbar-->
                <div class="toolbar toolbar-wrapper shop-toolbar">
                    <div class="row align-items-center mt-2">
                        <!-- <div class="col-2 col-sm-2 col-md-2 col-lg-2 text-left filters-toolbar-item d-flex order-1 order-sm-0">
                            <button type="button" class="btn btn-filter icon anm anm-sliders-hr  d-lg-none me-2"><span class="d-none">Filter</span></button>
                        </div> -->

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 filters-toolbar-item order-2 order-sm-2">
                            <div class="row">
                                <div class="col text-left" style="margin-left: 20px;">
                                    <button style="background-color:#b5753e !important; color:#fff !important;" type="button" class="btn btn-filter d-lg-none me-2"><img src="frontend_assets/img-icon/filter-2.png">&nbsp; Filter &nbsp; <img src="frontend_assets/img-icon/caret-down.png" style="max-height: 11.5px !important;"></button>
                                </div>
                                <div class="col text-right">
                                    <button type="button" style="padding: 2px;" onclick="clear_filter();">&nbsp;<img src="frontend_assets/img-icon/filter.png" height="32" width="32" /></button>
                                    <a href="<?php echo $baseUrl ?>/add-collector"><button type="button" class="btn btn-primary edit btn-sm"><img src="frontend_assets/img-icon/add-collector.png" style="margin-left: 4px; width: 30px;" /></button></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!--End Toolbar-->

                <!--Product Infinite-->
                <div class="product-listview-loadmore">
                    <!--Product Grid-->
                    <div class="grid-products grid-view-items mt-5">
                        <div class="col-row product-options row-cols-2" id="address_list">

                        </div>
                    </div>
                    <!--End Product Grid-->
                    <!--Load More Button-->
                    <div class="infinitpaginOuter text-center mt-5">
                        <!-- <div class="infiniteload"><a href="#" class="btn btn-xl loadMoreList">Load More</a></div>      -->
                    </div>
                    <!--End Load More Button-->
                </div>
                <!--End Product Infinite-->
            </div>
            <!--End Products-->
        </div>
    </div>
    <!--End Main Content-->