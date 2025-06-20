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

$totalItem = 8;
$completItem = 0;

$pan_num = false;
$gst_num = false;
$waste_cate = false;
$working_days = false;
$working_method = false;
$livelihood_source = false;
$deal_customer = false;
$company_name = false;

$inputName = '';

if ($user_details['pan_num'] != "") {
    $completItem++;
}
if ($user_details['gst_num'] != "") {
    $completItem++;
}
if ($user_details['waste_cate'] != "") {
    $completItem++;
}
if ($user_details['working_days'] != "") {
    $completItem++;
}
if ($user_details['working_method'] != "") {
    $completItem++;
}
if ($user_details['livelihood_source'] != "") {
    $completItem++;
}
if ($user_details['deal_customer'] != "") {
    $completItem++;
}
if ($user_details['company_name'] != "") {
    $completItem++;
}



if ($user_details['waste_cate'] == "" && $inputName == "") {
    $waste_cate = true;
    $inputName = "waste_cate";
}
if ($user_details['working_days'] == "" && $inputName == "") {
    $working_days = true;
    $inputName = "working_days";
}
if ($user_details['working_method'] == "" && $inputName == "") {
    $working_method = true;
    $inputName = "working_method";
}
if ($user_details['livelihood_source'] == "" && $inputName == "") {
    $livelihood_source = true;
    $inputName = "livelihood_source";
}
if ($user_details['deal_customer'] == "" && $inputName == "") {
    $deal_customer = true;
    $inputName = "deal_customer";
}
if ($user_details['gst_num'] == "" && $inputName == "") {
    $gst_num = true;
    $inputName = "gst_num";
}
if ($user_details['company_name'] == "" && $inputName == "") {
    $company_name = true;
    $inputName = "company_name";
}
if ($user_details['pan_num'] == "" && $inputName == "") {
    $pan_num = true;
    $inputName = "pan_num";
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
                                    Update Your Profile Details
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
                                    Congratulations on successfully completing your profile! Your account is now fully
                                    verified, and you can continue to enjoy our services. If you have any questions or need
                                    further assistance, please feel free to reach out to our support team.
                                </h5>

                                <center>
                                    <button type="button" class="kyc-verified-btn btn btn-primary"
                                        style="margin-bottom: 45px; background-color: #ff3030;">
                                        <span>
                                            <img src="frontend_assets/img-icon/verified.png" />
                                            Profile Details Verified
                                        </span>
                                    </button>
                                </center>
                                <?php
                            } else {
                                ?>
                                <h5 style="color: #4a4a4a; margin-bottom: 25px; margin-top: 5px;">You have completed
                                    <?php echo $completePercentage; ?>% of your profile.</h5>

                                <?php
                                if ($waste_cate == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Which type of waste category do you accept?
                                        </label>
                                        <div class="icheck-list">
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate"
                                                    data-value="All except clothes, Rubber & Furniture"
                                                    data-checkbox="icheckbox_flat-green">
                                                All except clothes, Rubber & Furniture
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="E-Waste"
                                                    data-checkbox="icheckbox_flat-green">
                                                E-Waste
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Metals"
                                                    data-checkbox="icheckbox_flat-green">
                                                Metals
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Rubber"
                                                    data-checkbox="icheckbox_flat-green">
                                                Rubber
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Plastics"
                                                    data-checkbox="icheckbox_flat-green">
                                                Plastics
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Batteries"
                                                    data-checkbox="icheckbox_flat-green">
                                                Batteries
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Paper"
                                                    data-checkbox="icheckbox_flat-green">
                                                Paper
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Clothes & Textiles"
                                                    data-checkbox="icheckbox_flat-green">
                                                Clothes & Textiles
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Glass"
                                                    data-checkbox="icheckbox_flat-green">
                                                Glass
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Furniture"
                                                    data-checkbox="icheckbox_flat-green">
                                                Furniture
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck waste_cate" data-value="Other"
                                                    data-checkbox="icheckbox_flat-green">
                                                Other
                                            </label>
                                        </div>
                                        <label data-default-mssg="" class="input_alert waste_cate-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($working_days == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Working Days
                                        </label>
                                        <div class="icheck-list">
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="All"
                                                    data-checkbox="icheckbox_flat-green">
                                                All
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Sunday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Sunday
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Monday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Monday
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Tuesday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Tuesday
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Wednesday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Wednesday
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Thursday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Thursday
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Friday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Friday
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_days" data-value="Saturday"
                                                    data-checkbox="icheckbox_flat-green">
                                                Saturday
                                            </label>
                                        </div>
                                        <label data-default-mssg="" class="input_alert working_days-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($working_method == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Type of business / working method
                                        </label>
                                        <div class="icheck-list">
                                            <label>
                                                <input type="checkbox" class="icheck working_method"
                                                    data-value="Waste collection on foot" data-checkbox="icheckbox_flat-green">
                                                Waste collection on foot
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_method"
                                                    data-value="Waste Collection on Cycle" data-checkbox="icheckbox_flat-green">
                                                Waste Collection on Cycle
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_method"
                                                    data-value="Waste collection by self" data-checkbox="icheckbox_flat-green">
                                                Waste collection by self
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_method"
                                                    data-value="Waste Collection Shop" data-checkbox="icheckbox_flat-green">
                                                Waste Collection Shop
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_method"
                                                    data-value="Waste Aggregator" data-checkbox="icheckbox_flat-green">
                                                Waste Aggregator
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck working_method" data-value="Waste Recycler"
                                                    data-checkbox="icheckbox_flat-green">
                                                Waste Recycler
                                            </label>
                                        </div>
                                        <label data-default-mssg="" class="input_alert working_method-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($livelihood_source == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            What is your main source of livelihood?
                                        </label>
                                        <div class="icheck-list">
                                            <label>
                                                <input type="checkbox" class="icheck livelihood_source"
                                                    data-value="Waste Picking" data-checkbox="icheckbox_flat-green">
                                                Waste Picking
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck livelihood_source"
                                                    data-value="Waste Segregation" data-checkbox="icheckbox_flat-green">
                                                Waste Segregation
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck livelihood_source" data-value="Scrap shop"
                                                    data-checkbox="icheckbox_flat-green">
                                                Scrap shop
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck livelihood_source"
                                                    data-value="Small Godown" data-checkbox="icheckbox_flat-green">
                                                Small Godown
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck livelihood_source"
                                                    data-value="Large Godown" data-checkbox="icheckbox_flat-green">
                                                Large Godown
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck livelihood_source" data-value="Other"
                                                    data-checkbox="icheckbox_flat-green">
                                                Other
                                            </label>
                                        </div>
                                        <label data-default-mssg="" class="input_alert livelihood_source-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($deal_customer == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Which type of customers
                                            do you deal with?
                                        </label>
                                        <div class="icheck-list">
                                            <label>
                                                <input type="checkbox" class="icheck deal_customer" data-value="Household"
                                                    data-checkbox="icheckbox_flat-green">
                                                Household
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck deal_customer" data-value="Company"
                                                    data-checkbox="icheckbox_flat-green">
                                                Company
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck deal_customer"
                                                    data-value="Manufacturers/industry" data-checkbox="icheckbox_flat-green">
                                                Manufacturers/industry
                                            </label>
                                            <label>
                                                <input type="checkbox" class="icheck deal_customer" data-value="Scrap Buyers"
                                                    data-checkbox="icheckbox_flat-green">
                                                Scrap Buyers
                                            </label>
                                        </div>
                                        <label data-default-mssg="" class="input_alert deal_customer-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($gst_num == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            GST Number
                                        </label>
                                        <input id="gst_num" type="text" placeholder="e.g: ABCDE1234F" required maxlength="50" />
                                        <a onclick="noGstNum('<?php echo $inputName ?>')"
                                            style="display: block; text-align: right; margin: 8px 0px; text-decoration: underline;">I
                                            don't have gst number</a>
                                        <label data-default-mssg="" class="input_alert gst_num-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($company_name == true) {
                                    ?>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label class="control-label">
                                            Company Name
                                        </label>
                                        <input id="company_name" type="text" placeholder="e.g: Tcs, Waste, Wipro" required
                                            maxlength="100" />
                                        <a onclick="noCompany('<?php echo $inputName ?>')"
                                            style="display: block; text-align: right; margin: 8px 0px; text-decoration: underline;">I
                                            don't have company</a>
                                        <label data-default-mssg="" class="input_alert company_name-inp-alert"></label>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($pan_num == true) {
                                    ?>

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

                                <button onclick="skipProfileDetails('<?php echo $inputName ?>');" type="button"
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