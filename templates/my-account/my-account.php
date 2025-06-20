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



<div class="container px-0" style="max-width: 480px;">
    <!-- Header with pattern -->
    <div class="header-bg mb-4">
        <div class="header-pattern"></div>
        <a href="dashboard" class="header-icon back-icon">
            <i class="bi bi-arrow-left"></i>
        </a>
        <a href="#" class="header-icon edit-icon" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil-square"></i>
        </a>


        <!-- Profile Avatar -->
        <div class="d-flex flex-column align-items-center pt-5">
            <div class="profile-avatar">
                <img id="blah" style="width:150px;height:120px;"
                    data-default="upload_content/upload_img/user_img/<?php echo empty($user_details['user_img']) ? 'default.png' : htmlspecialchars($user_details['user_img']); ?>"
                    src="upload_content/upload_img/user_img/<?php echo empty($user_details['user_img']) ? 'default.png' : htmlspecialchars($user_details['user_img']); ?>" />

                <div class="seller-badge"><?php echo htmlspecialchars($user_details['user_type']); ?></div>
            </div>
            <h1 class="text-white h4 mt-3 mb-1"><?php echo $user_details['name'] ?></h1>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="container px-4">
        <div class="info-section">
            <?php if (!empty($user_details['ph_num'])) { ?>
                <div class="info-label">Phone Number</div>
                <div class="info-value"><?php echo htmlspecialchars($user_details['country_code']) . " " . htmlspecialchars($user_details['ph_num']); ?></div>
            <?php } ?>

            <?php if (!empty($user_details['email_id'])) { ?>
                <div class="info-label">Email Address</div>
                <div class="info-value"><?php echo htmlspecialchars($user_details['email_id']); ?></div>
            <?php } ?>

            <?php if (!empty($user_details['seller_type'])) { ?>
                <div class="info-label">Seller Type</div>
                <div class="info-value"><?php echo htmlspecialchars($user_details['seller_type']); ?></div>
            <?php } ?>

            <?php if (!empty($user_details['referral_id'])) { ?>
                <div class="info-label">Referral Code</div>
                <div class="info-value"><?php echo htmlspecialchars($user_details['referral_id']); ?></div>
            <?php } ?>

            <?php
            if ($session_user_type == "Buyer") {
            ?><div class="container">
                    <div class="row" style="overflow: hidden;">
                        <div class="col-md-6 col-12">
                            <?php if ($completeProfilePercentage >= 100 && $completePricePercentage >= 100) { ?>
                                <h5 style="color: #4a4a4a;">
                                    Congratulations on successfully completing your profile! Your account is now fully verified, and you can continue to enjoy our services. If you have any questions or need further assistance, please feel free to reach out to our support team.
                                </h5>
                                <center>
                                    <button type="button" class="kyc-verified-btn btn btn-primary" style="margin-bottom: 45px!important; background-color: #b5753e; padding: 3px 40px;">
                                        <span>
                                            <img style="width: 35px;" src="frontend_assets/img-icon/verified.png" />
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
                                            <button type="button" class="btn btn-primary" style="margin-bottom: 5px !important; background-color: #b5753e; border:none;">
                                                <span>Complete Your Profile</span>
                                            </button>
                                        </a>
                                    </center>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 20px !important;">
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
                                        <button type="button" class="btn btn-primary" style="margin-bottom:45px; background-color: #b5753e; border:none;">
                                            <span>Complete Your Rate List</span>
                                        </button>
                                    </a>
                                </center>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>


        </div>

        <button onclick="shareReferLink()" class="share-button mb-5">
            <i class="bi bi-share"></i>
            Share Your Referral Link
        </button>
    </div>

    <!-- Modal for edit profile details  -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editProfileModalLabel">

                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 74vh;
overflow-y: auto;  
overflow-x: hidden;
  overflow: auto;">
                    <div class="form-row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
                            <div class="profileImg img-thumbnail shadow bg-white  d-flex-justify-center position-relative mx-auto">
                                <img id="blah" style="width:150px;height:120px;" data-default="upload_content/upload_img/user_img/<?php echo $user_details['user_img'] == "" ? "default.png" : $user_details['user_img']; ?>" src="upload_content/upload_img/user_img/<?php echo $user_details['user_img'] == "" ? "default.png" : $user_details['user_img']; ?>" class="rounded-circle" alt="profile" />
                                <div class="thumb-edit mt-2">
                                    <label for="user_img" class="d-flex-center justify-content-center position-absolute top-0 start-100 translate-middle p-2  shadow btn btn-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="icon anm anm-pencil-ar an-1x"></i></label>
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
                            <div class="d-none form-group col-lg-12 col-md-12 col-sm-12 col-12 <?php echo $pan_num == "hide" ? "d-none" : ""; ?>">
                                <label for="pan_num">
                                    PAN Number
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" title="This Field is Required">*</span>
                                </label>
                                <input id="pan_num" type="text" placeholder="e.g: SBINT4521E" <?php if ($pan_num == "visible") { ?> minlength="10" maxlength="11" value="<?php echo $user_details['pan_num'] ?>" <?php } ?> />
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
                            <div class="d-none form-group col-lg-12 col-md-12 col-sm-12 col-12 <?php echo $gst_num == "hide" ? "d-none" : ""; ?>">
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
                            <input id="authorization_certificate_num" type="text" placeholder="e.g: 29GGGGG1314R9Z6" <?php if ($authorization_certificate_num == "visible") { ?> maxlength="100" value="<?php echo $user_details['authorization_certificate_num']; ?>"  <?php } ?> />
                            <label data-default-mssg="" class="input_alert authorization_certificate_num-inp-alert"></label>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button onclick="updateProfileDetails();" type="button" class="btn btn-primary m-0" style="padding: 6px 40px;
    border-radius: 6px;
    background-color: #b5753e !important;
    border-color: #a34600;
    color: #fff !important;">
                        <span>Update Profile</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->


</div>
<script>
    user_img.onchange = evt => {
        const [file] = user_img.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>