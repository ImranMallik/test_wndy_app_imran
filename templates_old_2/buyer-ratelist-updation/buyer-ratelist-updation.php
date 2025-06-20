<?php
include("./module_function/date_time_format.php");

$user_details_dataget = mysqli_query($con, "SELECT 
    tbl_user_master.pan_num,
    tbl_user_master.gst_num,
    tbl_user_master.waste_cate,
    tbl_user_master.working_days,
    tbl_user_master.working_method,
    tbl_user_master.livelihood_source,
    tbl_user_master.deal_customer,
    tbl_user_master.ac_price,
    tbl_user_master.washing_machine_price,
    tbl_user_master.fridge_price,
    tbl_user_master.tv_price,
    tbl_user_master.microwave_price,
    tbl_user_master.laptop_price,
    tbl_user_master.geyser_price,
    tbl_user_master.paper_price,
    tbl_user_master.iron_price,
    tbl_user_master.furniture_price,
    tbl_user_master.battery_price ,
    tbl_user_master.cardboard_price,
    tbl_user_master.company_name
    FROM tbl_user_master
    WHERE tbl_user_master.user_id = '" . $session_user_code . "' ");
$user_details = mysqli_fetch_assoc($user_details_dataget);

$totalItem = 12;
$completItem = 0;

$ac_price = false;
$washing_machine_price = false;
$fridge_price = false;
$tv_price = false;
$microwave_price = false;
$laptop_price = false;
$geyser_price = false;
$paper_price = false;
$iron_price = false;
$furniture_price = false;
$battery_price = false;
$cardboard_price = false;

$inputName = '';

if ($user_details['ac_price'] != "") {
    $completItem++;
}
if ($user_details['washing_machine_price'] != "") {
    $completItem++;
}
if ($user_details['fridge_price'] != "") {
    $completItem++;
}
if ($user_details['tv_price'] != "") {
    $completItem++;
}
if ($user_details['microwave_price'] != "") {
    $completItem++;
}
if ($user_details['laptop_price'] != "") {
    $completItem++;
}
if ($user_details['geyser_price'] != "") {
    $completItem++;
}
if ($user_details['paper_price'] != "") {
    $completItem++;
}
if ($user_details['iron_price'] != "") {
    $completItem++;
}
if ($user_details['furniture_price'] != "") {
    $completItem++;
}
if ($user_details['battery_price'] != "") {
    $completItem++;
}
if ($user_details['cardboard_price'] != "") {
    $completItem++;
}



if ($user_details['ac_price'] == "" && $inputName == "") {
    $ac_price = true;
    $inputName = "ac_price";
}
if ($user_details['washing_machine_price'] == "" && $inputName == "") {
    $washing_machine_price = true;
    $inputName = "washing_machine_price";
}
if ($user_details['fridge_price'] == "" && $inputName == "") {
    $fridge_price = true;
    $inputName = "fridge_price";
}
if ($user_details['tv_price'] == "" && $inputName == "") {
    $tv_price = true;
    $inputName = "tv_price";
}
if ($user_details['microwave_price'] == "" && $inputName == "") {
    $microwave_price = true;
    $inputName = "microwave_price";
}
if ($user_details['laptop_price'] == "" && $inputName == "") {
    $laptop_price = true;
    $inputName = "laptop_price";
}
if ($user_details['geyser_price'] == "" && $inputName == "") {
    $geyser_price = true;
    $inputName = "geyser_price";
}
if ($user_details['paper_price'] == "" && $inputName == "") {
    $paper_price = true;
    $inputName = "paper_price";
}
if ($user_details['iron_price'] == "" && $inputName == "") {
    $iron_price = true;
    $inputName = "iron_price";
}
if ($user_details['furniture_price'] == "" && $inputName == "") {
    $furniture_price = true;
    $inputName = "furniture_price";
}
if ($user_details['battery_price'] == "" && $inputName == "") {
    $battery_price = true;
    $inputName = "battery_price";
}
if ($user_details['cardboard_price'] == "" && $inputName == "") {
    $cardboard_price = true;
    $inputName = "cardboard_price";
}

$completePercentage = round(($completItem / $totalItem) * 100);
?>

<div id="page-content" class="pb-5">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>My Account</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="<?php echo $baseUrl; ?>/home"
                            title="Back to the home page">Home</a><span class="main-title fw-bold"><i
                                class="icon anm anm-angle-right-l"></i>My Account</span>
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 mb-4 mb-lg-0">
                <?php
                include("templates/common_part/user_menu.php");
                ?>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                <div class="dashboard-content tab-content h-100" id="top-tabContent">
                    <div class="tab-pane fade h-100 show active" id="info">
                        <div class="profile-card mt-0 h-100">

                            <!--Start Account Details -->
                            <div class="top-sec d-flex-justify-center justify-content-between mb-4">
                                <h2 class="mb-0">
                                    Update Your Rate List Details
                                </h2>
                            </div>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: <?php echo $completePercentage . "%"; ?>;"
                                    aria-valuenow="<?php echo $completePercentage; ?>" aria-valuemin="0"
                                    aria-valuemax="100"><?php echo $completePercentage . "%"; ?></div>
                            </div>
                            <?php
                            if ($completePercentage >= 100) {
                                ?>
                                <h5 class="mt-3" style="color: #4a4a4a;">
                                    Congratulations on successfully completing your Ratelist update! Your account is now
                                    fully verified, and you can continue to enjoy our services. If you have any questions or
                                    need further assistance, please feel free to reach out to our support team. Thank you
                                    for choosing us!
                                </h5>

                                <center>
                                    <button type="button" class="kyc-verified-btn btn btn-primary"
                                        style="margin-bottom: 45px; background-color: #ff3030;">
                                        <span>
                                            <img src="frontend_assets/img-icon/verified.png" />
                                            Rate List Updated
                                        </span>
                                    </button>
                                </center>
                                <?php
                            } else {
                                ?>
                                <h5 style="color: #4a4a4a; margin-bottom: 25px; margin-top: 5px;">You have completed
                                    <?php echo $completePercentage; ?>% of your Rate List. Please complete these remaining
                                    steps to finish the process
                                </h5>

                                <?php
                                if ($ac_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of AC
                                        </label>
                                        <input id="ac_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert ac_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($washing_machine_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Washing Machine
                                        </label>
                                        <input id="washing_machine_price" type="number" placeholder="e.g: 5000" required
                                            min="1" />
                                        <label data-default-mssg="" class="input_alert washing_machine_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($fridge_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Fridge
                                        </label>
                                        <input id="fridge_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert fridge_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($tv_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of TV
                                        </label>
                                        <input id="tv_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert tv_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($microwave_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Microwave
                                        </label>
                                        <input id="microwave_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert microwave_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($laptop_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Laptop
                                        </label>
                                        <input id="laptop_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert laptop_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($geyser_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Geyser
                                        </label>
                                        <input id="geyser_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert geyser_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($paper_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Paper
                                        </label>
                                        <input id="paper_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert paper_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($iron_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Iron
                                        </label>
                                        <input id="iron_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert iron_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($furniture_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Furniture
                                        </label>
                                        <input id="furniture_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert furniture_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($battery_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Battery
                                        </label>
                                        <input id="battery_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert battery_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($cardboard_price == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Price Range of Cardboard
                                        </label>
                                        <input id="cardboard_price" type="number" placeholder="e.g: 5000" required min="1" />
                                        <label data-default-mssg="" class="input_alert cardboard_price-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <button onclick="updateProfileDetails('<?php echo $inputName ?>');" type="button"
                                    class="btn btn-primary mb-4" style="float: right;">
                                    <span>
                                        Update &
                                        <?php
                                        echo $totalItem == ($completItem + 1) ? "Complete" : "Next";
                                        ?>
                                    </span>
                                </button>

                                <button onclick="skipProfileRateListDetails('<?php echo $inputName ?>');" type="button"
                                    class="btn btn-primary mb-4" style="float: right;">
                                    <span>
                                        Skip
                                    </span>
                                </button>

                                <?php
                            }
                            ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--End Main Content-->
</div>