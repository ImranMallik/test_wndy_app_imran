<?php
include("./module_function/date_time_format.php");

$user_details_dataget = mysqli_query($con, "SELECT 
    tbl_user_master.name,
    tbl_user_master.country_code,
    tbl_user_master.ph_num,
    tbl_user_master.email_id,
    tbl_user_master.pan_num,
    tbl_user_master.aadhar_num,
    tbl_user_master.gst_num,
    tbl_user_master.authorization_certificate_num,
    tbl_user_master.address_id,
    tbl_user_master.referral_id,
    tbl_user_master.under_buyer_id,
    tbl_user_master.user_img,
    tbl_user_master.user_type,
    tbl_user_master.buyer_type,
    tbl_user_master.seller_type,

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

$email_id = "visible";
$pan_num = "visible";
$aadhar_num = "visible";
$gst_num = "visible";
$authorization_certificate_num = "visible";
$buyer_type = "visible";
$seller_type = "visible";

switch ($user_details['user_type']) {
    case 'Seller':
        $aadhar_num = "hide";
        $authorization_certificate_num = "hide";
        $buyer_type = "hide";
        break;
    case 'Buyer':
        $seller_type = "hide";
        break;
    case 'Collector':
        $email_id = "hide";
        $pan_num = "hide";
        $aadhar_num = "hide";
        $gst_num = "hide";
        $authorization_certificate_num = "hide";
        $buyer_type = "hide";
        $seller_type = "hide";
        break;
}

// profile item

$totalProfileItem = 8;
$completProfileItem = 0;

if ($user_details['pan_num'] != "") {
    $completProfileItem++;
}
if ($user_details['gst_num'] != "") {
    $completProfileItem++;
}
if ($user_details['waste_cate'] != "") {
    $completProfileItem++;
}
if ($user_details['working_days'] != "") {
    $completProfileItem++;
}
if ($user_details['working_method'] != "") {
    $completProfileItem++;
}
if ($user_details['livelihood_source'] != "") {
    $completProfileItem++;
}
if ($user_details['deal_customer'] != "") {
    $completProfileItem++;
}
if ($user_details['company_name'] != "") {
    $completProfileItem++;
}

$completeProfilePercentage = round(($completProfileItem / $totalProfileItem) * 100);


// price item

$totalPriceItem = 12;
$completPriceItem = 0;

if ($user_details['ac_price'] != "") {
    $completPriceItem++;
}
if ($user_details['washing_machine_price'] != "") {
    $completPriceItem++;
}
if ($user_details['fridge_price'] != "") {
    $completPriceItem++;
}
if ($user_details['tv_price'] != "") {
    $completPriceItem++;
}
if ($user_details['microwave_price'] != "") {
    $completPriceItem++;
}
if ($user_details['laptop_price'] != "") {
    $completPriceItem++;
}
if ($user_details['geyser_price'] != "") {
    $completPriceItem++;
}
if ($user_details['paper_price'] != "") {
    $completPriceItem++;
}
if ($user_details['iron_price'] != "") {
    $completPriceItem++;
}
if ($user_details['furniture_price'] != "") {
    $completPriceItem++;
}
if ($user_details['battery_price'] != "") {
    $completPriceItem++;
}
if ($user_details['cardboard_price'] != "") {
    $completPriceItem++;
}

$completePricePercentage = round(($completPriceItem / $totalPriceItem) * 100);

?>

<script>
    const user_name = "<?php echo $user_details['name']; ?>";
    const referral_id = "<?php echo $user_details['referral_id']; ?>";
</script>

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
                    <div class="breadcrumbs"><a href="<?php echo $baseUrl; ?>/home" title="Back to the home page">Home</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>My Account</span>
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
                                <h2 class="mb-0"><?php echo $user_details['user_type'] ?> Account Details:</h2>
                                <button type="button" class="add btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="border-radius: 5px; padding: 4px 8px;">
                                    <img src="frontend_assets/img-icon/edit.png" style="margin-left: 4px; width: 25px;" />
                                </button>
                            </div>

                            <?php
                            if ($session_user_type == "Buyer") {
                            ?>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <?php if ($completeProfilePercentage >= 100 && $completePricePercentage >= 100) { ?>
                                            <h5 style="color: #4a4a4a;">
                                                Congratulations on successfully completing your profile! Your account is now fully verified, and you can continue to enjoy our services. If you have any questions or need further assistance, please feel free to reach out to our support team.
                                            </h5>
                                            <center>
                                                <button type="button" class="kyc-verified-btn btn btn-primary" style="margin-bottom: 45px; background-color: #ff3030;">
                                                    <span>
                                                        <img src="frontend_assets/img-icon/verified.png" />
                                                        Verified
                                                    </span>
                                                </button>
                                            </center>
                                        <?php } else { ?>
                                            <?php if ($completeProfilePercentage < 100) { ?>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $completeProfilePercentage . "%"; ?>;" aria-valuenow="<?php echo $completeProfilePercentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $completeProfilePercentage . "%"; ?></div>
                                                </div>
                                                <h5 style="color: #4a4a4a; margin-bottom: 5px; margin-top: 5px;">You have completed <?php echo $completeProfilePercentage; ?>% of your profile.</h5>
                                                <center>
                                                    <a href="<?php echo $baseUrl . "/buyer-profile-updation" ?>">
                                                        <button type="button" class="btn btn-primary" style="margin-bottom: 45px; background-color: #ff3030;">
                                                            <span>Complete Your Profile</span>
                                                        </button>
                                                    </a>
                                                </center>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <?php if ($completePricePercentage < 100) { ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $completePricePercentage . "%"; ?>;" aria-valuenow="<?php echo $completePricePercentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $completePricePercentage . "%"; ?></div>
                                            </div>
                                            <h5 style="color: #4a4a4a; margin-bottom: 5px; margin-top: 5px;">
                                                <?php if ($completePricePercentage == 0) {
                                                    echo "Please let us know your Rate List";
                                                } else {
                                                    echo "You have completed " . $completePricePercentage . "% of your rate list.";
                                                } ?>
                                            </h5>
                                            <center>
                                                <a href="<?php echo $baseUrl . "/buyer-ratelist-updation" ?>">
                                                    <button type="button" class="btn btn-primary" style="margin-bottom: 45px; background-color: #ff3030;">
                                                        <span>Complete Your Rate List</span>
                                                    </button>
                                                </a>
                                            </center>
                                        <?php } ?>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                            <!-- List showing start -->
                            <div class="profile-login-section mb-4">
                                <div class="details d-flex align-items-center mb-2">
                                    <div class="left">
                                        <h6 class="mb-0 body-font fw-500">Full Name:</h6>
                                    </div>
                                    <div class="right">
                                        <p style="white-space: wrap; word-wrap: break-word; width: 80%;"><?php echo $user_details['name'] ?></p>
                                    </div>
                                </div>
                                <div class="details d-flex align-items-center mb-2">
                                    <div class="left">
                                        <h6 class="mb-0 body-font fw-500">Phone Number:</h6>
                                    </div>
                                    <div class="right">
                                        <p><?php echo $user_details['country_code'] . " " . $user_details['ph_num'] ?></p>
                                    </div>
                                </div>

                                <?php
                                if ($email_id == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">Email Address:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['email_id']; ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($seller_type == "visible" && $pan_num == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">PAN Number:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['pan_num']; ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($aadhar_num == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2 d-none">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">Aadhaar Number:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['aadhar_num']; ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($authorization_certificate_num == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2 d-none">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">Authorization Certificate Number:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['authorization_certificate_num']; ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($seller_type == "visible" && $gst_num == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">GST Number:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['gst_num']; ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($seller_type == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">Seller Type:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['seller_type'] ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($buyer_type == "visible") {
                                ?>
                                    <div class="details d-flex align-items-center mb-2">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">Buyer Type:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['buyer_type'] ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($user_details['referral_id'] != "") {
                                ?>
                                    <div class="details d-flex align-items-center">
                                        <div class="left">
                                            <h6 class="mb-0 body-font fw-500">Referral Code:</h6>
                                        </div>
                                        <div class="right">
                                            <p><?php echo $user_details['referral_id'] ?></p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="shareReferLink()" class="btn btn-sm mt-2" style="text-transform: capitalize; background: #0f3b99; border-color: #00236d;">
                                        <i class="fa fa-share-alt" style="margin-right: 5px;"></i>
                                        Share Your Referral Link
                                    </button>
                                <?php
                                }
                                ?>

                                <!-- Under Buyer Details -->
                                <?php
                                if ($user_details['user_type'] == "Collector") {
                                    $underBuyerDataget = mysqli_query($con, "select name, country_code, ph_num from tbl_user_master where user_id='" . $user_details['referral_id'] . "' ");
                                    $underBuyerData = mysqli_fetch_assoc($underBuyerDataget);

                                    if ($underBuyerData) {
                                ?>
                                        <h2 style="margin-top: 35px;">Your Buyer Details </h2>
                                        <div class="details d-flex align-items-center mb-2">
                                            <div class="left">
                                                <h6 class="mb-0 body-font fw-500">Buyer Name:</h6>
                                            </div>
                                            <div class="right">
                                                <p><?php echo $underBuyerData['name']; ?></p>
                                            </div>
                                        </div>

                                        <div class="details d-flex align-items-center">
                                            <div class="left">
                                                <h6 class="mb-0 body-font fw-500">Phone Number:</h6>
                                            </div>
                                            <div class="right">
                                                <a
                                                    style="color: #377cff; text-decoration: underline;"
                                                    href="tel:<?php echo $underBuyerData['country_code'] . $underBuyerData['ph_num']; ?>">
                                                    <?php echo $underBuyerData['country_code'] . " " . $underBuyerData['ph_num']; ?>
                                                </a>
                                            </div>
                                        </div>
                                        <span style="font-size: 9px;">(Click on number for contact to buyer)</span>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- List showing end -->

                            <!-- Modal for edit profile details  -->
                            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="editProfileModalLabel">

                                            </h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
                                                    <div class="profileImg img-thumbnail shadow bg-white rounded-circle d-flex-justify-center position-relative mx-auto">
                                                        <img id="blah" style="width:150px;height:120px;" data-default="upload_content/upload_img/user_img/<?php echo $user_details['user_img'] == "" ? "default.png" : $user_details['user_img']; ?>" src="upload_content/upload_img/user_img/<?php echo $user_details['user_img'] == "" ? "default.png" : $user_details['user_img']; ?>" class="rounded-circle" alt="profile" />
                                                        <div class="thumb-edit">
                                                            <label for="user_img" class="d-flex-center justify-content-center position-absolute top-0 start-100 translate-middle p-2 rounded-circle shadow btn btn-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="icon anm anm-pencil-ar an-1x"></i></label>
                                                            <input type="file" onchange="showFile()" id="user_img" class="image-upload d-none" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="name">
                                                        Full Name
                                                        <!-- Required hover content -->
                                                        <span class="req-label-btn" title="This Field is Required"> * </span>
                                                    </label>
                                                    <input id="name" type="text" placeholder="e.g: John Doe" value="<?php echo $user_details['name'] ?>" required maxlength="200" />
                                                    <label data-default-mssg="" class="input_alert name-inp-alert"></label>
                                                </div>

                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="ph_num">
                                                        Phone Number
                                                        <!-- Required hover content -->
                                                        <span class="req-label-btn" title="This Field is Required">*</span>
                                                    </label>
                                                    <input id="ph_num" type="text" placeholder="e.g: 7896541230" minlength="10" maxlength="10" value="<?php echo $user_details['ph_num'] ?>" required />
                                                    <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                                                </div>

                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 <?php echo $email_id == "hide" ? "d-none" : ""; ?>">
                                                    <label for="email_id">
                                                        Email Id
                                                    </label>
                                                    <input id="email_id" type="email" placeholder="e.g: example@gmail.com" <?php if ($email_id == "visible") { ?> value="<?php echo $user_details['email_id'] ?>" <?php } ?> />
                                                    <label data-default-mssg="" class="input_alert email_id-inp-alert"></label>
                                                </div>

                                                <!-- Not Need This Right Now -->
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 d-none">
                                                    <label for="dob">
                                                        DOB
                                                    </label>
                                                    <input id="dob" type="date" placeholder="e.g: 1999-01-01" />
                                                    <label data-default-mssg="" class="input_alert dob-inp-alert"></label>
                                                </div>

                                                <?php
                                                if ($seller_type == "visible") {
                                                ?>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 <?php echo $pan_num == "hide" ? "d-none" : ""; ?>">
                                                        <label for="pan_num">
                                                            PAN Number
                                                            <!-- Required hover content -->
                                                            <span class="req-label-btn" title="This Field is Required">*</span>
                                                        </label>
                                                        <input id="pan_num" type="text" placeholder="e.g: SBINT4521E" <?php if ($pan_num == "visible") { ?> minlength="10" maxlength="11" value="<?php echo $user_details['pan_num'] ?>" required <?php } ?> />
                                                        <label data-default-mssg="" class="input_alert pan_num-inp-alert"></label>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 d-none <?php echo $aadhar_num == "hide" ? "d-none" : ""; ?>">
                                                    <label for="aadhar_num">
                                                        Aadhaar Number
                                                        <!-- Required hover content -->
                                                        <span class="req-label-btn" title="This Field is Required">*</span>
                                                    </label>
                                                    <input id="aadhar_num" type="text" placeholder="e.g: 1234 5678 0123" <?php if ($aadhar_num == "visible") { ?> minlength="12" maxlength="12" value="<?php echo $user_details['aadhar_num'] ?>" required <?php } ?> />
                                                    <label data-default-mssg="" class="input_alert aadhar_num-inp-alert"></label>
                                                </div>

                                                <?php
                                                if ($seller_type == "visible") {
                                                ?>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 <?php echo $gst_num == "hide" ? "d-none" : ""; ?>">
                                                        <label for="gst_num">
                                                            GST Number
                                                            <!-- Required hover content -->
                                                            <span class="req-label-btn" title="This Field is Required">*</span>
                                                        </label>
                                                        <input id="gst_num" type="text" placeholder="e.g: 29GGGGG1314R9Z6" <?php if ($gst_num == "visible") { ?> minlength="15" maxlength="15" value="<?php echo $user_details['gst_num'] ?>" required <?php } ?> />
                                                        <label data-default-mssg="" class="input_alert gst_num-inp-alert"></label>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 d-none <?php echo $authorization_certificate_num == "hide" ? "d-none" : ""; ?>">
                                                    <label for="authorization_certificate_num">
                                                        Authorization Certificate Number
                                                        <!-- Required hover content -->
                                                        <span class="req-label-btn" title="This Field is Required">*</span>
                                                    </label>
                                                    <input id="authorization_certificate_num" type="text" placeholder="e.g: 29GGGGG1314R9Z6" <?php if ($authorization_certificate_num == "visible") { ?> maxlength="100" value="<?php echo $user_details['authorization_certificate_num']; ?>" required <?php } ?> />
                                                    <label data-default-mssg="" class="input_alert authorization_certificate_num-inp-alert"></label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button onclick="updateProfileDetails();" type="button" class="btn btn-primary m-0">
                                                <span>Update Profile</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--End Main Content-->
</div>

<script>
    user_img.onchange = evt => {
        const [file] = user_img.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>