<?php
include("module_function/date_time_format.php");

$user_dataget = mysqli_query($con, "SELECT 
    tbl_user_master.name
    FROM tbl_user_master WHERE user_id = '" . $session_user_code . "'");
$user_data = mysqli_fetch_assoc($user_dataget);
?>

<script>
    const session_user_type = "<?php echo $session_user_type; ?>";
</script>

<!-- Body Container -->
<div id="page-content" class="pb-5">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>My Dashboard</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="<?php echo $baseUrl; ?>/home"
                            title="Back to the home page">Home</a><span class="main-title">
                            <i class="icon anm anm-angle-right-l"></i>My Dashboard</span>
                    </div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 mb-4 mb-lg-0">
                <?php
                include("templates/common_part/user_menu.php");
                ?>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-9">

                <?php
                $dataget = mysqli_query($con, "select 
                                            tbl_product_master.product_name,    
                                            tbl_user_product_view.product_id,    
                                            tbl_user_product_view.pickup_date,    
                                            tbl_user_product_view.pickup_time 
                                            from tbl_user_product_view 
                                            LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
                                            where tbl_user_product_view.buyer_id='" . $session_user_code . "' and 
                                            tbl_user_product_view.pickup_date >= '" . $date . "' and tbl_user_product_view.deal_status='Pickup Scheduled' ");
                if (mysqli_num_rows($dataget) > 0) {
                ?>
                    <h2>Upcoming Pickups : </h2>
                    <div class="row g-3 row-cols-lg-3 row-cols-md-3 row-cols-sm-3 row-cols-1 mb-4">
                        <?php
                        while ($rw = mysqli_fetch_array($dataget)) {
                        ?>
                            <a href="<?php echo $baseUrl . "/product-details/" . $rw['product_id']; ?>">
                                <div class="counter-box">
                                    <div class="bg-block d-flex-center flex-wrap" style="background-color:#ffeedf !important;">
                                        <div class="content">
                                            <h3 class="fs-5 mb-1 text-primary address" style="margin-left: 0px;"><?php echo $rw['product_name'] ?></h3>
                                            <p class="address" style="margin-bottom: 5px; margin-left: 0px;">
                                                Pickup Date : <?php echo dateFormat($rw['pickup_date']); ?>
                                            </p>
                                            <p class="address" style="margin-left: 0px;">
                                                Pickup Time : <?php echo timeFormat($rw['pickup_time']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                        ?>

                    </div>
                <?php
                } else {
                ?>
                    <h2 style="text-align: center; margin-top: 50px; font-size: 26px; color: #a1a1a1;">You have no upcoming pickups.</h2>
                <?php
                }
                ?>

            </div>

        </div>
    </div>
    <!--End Main Content-->

</div>
<!-- End Body Container -->