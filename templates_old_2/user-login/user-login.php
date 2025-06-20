<?php
include("../db/db.php");

if (isset($arr[2])) {
    $referral_code = $arr[2];
} else {
    $referral_code = null;
}
?>

<?php
$user_dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE user_id='" . $session_user_code . "' ");
$user_data = mysqli_fetch_assoc($user_dataget);
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 justify-content-center align-items-center d-flex" style="flex-direction: column;">

            <div class="container">
                <div class="row justify-content-center align-items-center d-flex" style="overflow: hidden;">

                    <!-- register start New -->
                    <!--======== 1st Phone Number Div ========-->
                    <div class="col-lg-7 col-12 fxt-bg-color" id="ph_num_div" style="display: none;">
                        <div class="illustration">
                            <img src="frontend_assets/img-icon/newlogo.png?v=<?php echo $version; ?>"
                                alt="Illustration of a person with megaphone">
                        </div>

                        <h1 class="h1text">Congrats!</h1>
                        <p class="subtitle">You have taken the first step<br> towards a more sustainable future</p>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input  type="text" id="ph_num" placeholder="xxxxx-xxxxx" 
                            >
                        </div>
                        <button type="button" onclick="checkPhoneNumber()" id="sendOTPButton">Request OTP</button>
                    </div>


                    <!--======== 2nd OTP Div ========-->
                    <div class="col-lg-7 col-12 fxt-bg-color " id="otp_div" style="display: none;">
                        <div class="bg-body">
                            <div class="min-vh-95 bg-light">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-7 col-lg-7">
                                            <!-- Illustration -->
                                            <div class="text-center mb-4">
                                                <img src="frontend_assets/img-icon/newlogo.png?v=<?php echo $version; ?>"
                                                    alt="Announcement illustration"
                                                    class="img-fluid illustration img-logo">

                                            </div>

                                            <!-- Content -->
                                            <div class="mb-4">
                                                <h1 class="display-6 fw-bold mb-3">Congrats!</h1>
                                                <p class="subtitle">You have taken the first step <br>towards a
                                                    more
                                                    sustainable
                                                    future</p>
                                            </div>


                                            <!-- OTP Input -->
                                            <div class="otp-inputs d-flex justify-content-between gap-2 mb-4">
                                                <input type="text" class="form-control otp-input" id="otp-0" maxlength="1" required oninput="updateHiddenOtp()">
                                                <input type="text" class="form-control otp-input" id="otp-1" maxlength="1" required oninput="updateHiddenOtp()">
                                                <input type="text" class="form-control otp-input" id="otp-2" maxlength="1" required oninput="updateHiddenOtp()">
                                                <input type="text" class="form-control otp-input" id="otp-3" maxlength="1" required oninput="updateHiddenOtp()">
                                                <input type="text" class="form-control otp-input" id="otp-4" maxlength="1" required oninput="updateHiddenOtp()">
                                                <input type="text" class="form-control otp-input" id="otp-5" maxlength="1" required oninput="updateHiddenOtp()">
                                            </div>

                                            <!-- ✅ Hidden field to store full OTP -->
                                            <input type="hidden" class="form-control rounded-0" id="otp" pattern="[0-9]*" minlength="6" maxlength="6" required />

                                            <label data-default-mssg="" class="input_alert otp-inp-alert"></label>

 <button id="SubmitOTP" name="SubmitOTP" class="btn btn-primary button-login w-100 mb-4" onclick="verifyOtp()">NEXT</button>


                                            <!-- Footer -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button class="btn btn-link text-dark text-decoration-none p-0 back-btn"
                                                    onclick="toggleScreen('ph_num_div')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-arrow-left"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                                    </svg>
                                                    BACK
                                                </button>
                                                <span class="otp_time_span">OTP expires in <span
                                                        class="otp_valid_time">10:00</span></span>
                                                <a class="send_otp_again_a" onclick="checkPhoneNumber()"
                                                    style="text-decoration: underline; display: none; color: blue;">The
                                                    OTP
                                                    has expired. Please try again</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- OTP section end -->

                    <!--======== 3 welcome back start ========-->
                    <div class="col-lg-7 col-12 fxt-bg-color" id="welcomeback_div" style="display: none;">
                        <div class="mt-1">
                            <center>
                                <label class="welcome-f-title">
                                    Welcome Back! <br> <a id="loginUserName"></a>
                                </label>
                            </center>
                            <br>
                        </div>
                    </div>
                    <!-- welcome back end-->


                    <!--======== 4 Register ========-->
                    <div class="col-lg-7 col-12 fxt-bg-color " id="Register_div" style="display: none;">
                        <div class="illustration">
                            <img src="frontend_assets/img-icon/newlogo.png?v=<?php echo $version; ?>"
                                alt="Illustration of a person with megaphone">
                        </div>
                        <!-- <div>
                        <label>Enter Your Name</label>
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-0" id="user_name" placeholder="e.g: John Doe" required />
                            <label data-default-mssg="" class="input_alert user_name-inp-alert"></label>
                        </div>
                    </div> -->
                        <div class="form-group">
                            <label for="phone">Your Name</label>
                            <input type="text" id="user_name" placeholder="Enter your name here" required>
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <input type="checkbox" id="termsCheckbox" class="me-2" required />
                            <label for="termsCheckbox">
                                I Agree To The
                                <a href="<?php echo $baseUrl . "/about-terms-privacy-shipping-returns-refund-policy"; ?>"
                                    target="_blank">
                                    <u style="color: blue; text-decoration:none;color:#b5753e;">Terms & Conditions, </u>
                                </a>
                            </label>
                        </div>
                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                            <div class="row">
                                <div class="col-12">
                                    <!-- <button type="button" onclick="checkName()" class="fxt-btn-fill">
                                    Next
                                    <i class="fa fa-chevron-circle-right"></i>
                                </button> -->
                                    <button type="button" onclick="checkName()" id="sendOTPButton">Next</button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--======== 5th user type ========-->
                    <!-- value set -->
                    <input type="hidden" id="selectedSellerType" name="seller_type" value="">
                    <input type="hidden" id="selectedUserType" name="user_type" value="">
                    <input type="hidden" id="selectedBuyerType" name="buyer_type" value="">

                    <div class="col-lg-7 col-12 fxt-bg-color " id="usertype_div" style="display: none;">
                        <div class="container" style="background-color:transparent !important;">
                            <p class="otp_mssg div-alert-mssg" style="display: none;"></p>

                            <h1 class="display-4 mb-5 user_heading">Who are you?</h1>
                            <div class="row justify-content-center">
                                <!-- Seller Option -->
<?php if (!$referral_code): ?>
<div class="col-md-6 col-lg-5 text-center">
    <button name="Become a Seller" style="background-color:transparent !important; border:none !important;">
        <div class="role-card" data-user-type="Seller">
            <img src="frontend_assets/img-icon/sellae_type.png?v=<?php echo $version; ?>"
                alt="Garbage truck illustration" class="img-fluid">
            <!-- <p>I want to sell scrap</p> -->
        </div>
    </button>
</div>
<?php endif; ?>



                                <div class="col-md-6 col-lg-5 text-center">
                                    <button name="Become a Buyer" style="background-color:transparent !important; border:none !important;">
                                    <div class="role-card" data-user-type="Buyer">
                                        <img src="frontend_assets/img-icon/saller_type_2.png?v=<?php echo $version; ?>"
                                            alt="Electronic devices illustration" class="img-fluid">

                                    </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- user type end -->


                    <!--======== 6th buyer type ========-->
                    <!-- Buyer Type Modal -->
                    <div class="modal fade" id="buyerTypeModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">What kind of buyer are you?</h5>
                                </div>
                                <div class="modal-body" id="what-kind">

                                    <button class="selection-button" value="Individual" data-type="Scrap Dealer">Scrap
                                        Dealer
                                        <p class="buyer-text"> The shop or business that is closest to the disposer of
                                            the
                                            waste. They would
                                            have
                                            associated collectors who will pick scrap from the households</p>
                                    </button>


                                    <button class="selection-button" value="Individual"
                                        data-type="Aggregator">Aggregator
                                        <p class="buyer-text">Receives one or more categories of waste from various
                                            scrap
                                            dealers and may be
                                            involved in first line of dismantling</p>
                                    </button>


                                    <button class="selection-button" value="Individual" data-type="Recycler">Recycler
                                        <p class="buyer-text">They receive the various scrap items from Aggregators in
                                            bulk
                                            quantity and Does the
                                            extraction and recovery of materials to supply back into the manufacturing
                                        </p>
                                    </button>


                                    <button class="next-button" disabled>NEXT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- buyer type end -->
                <!--========New Buyer Type Modal ========= -->


                <!--========End  New Buyer Type Modal ========= -->


                <!--======== New Modal For Seller ========-->
                <div class="modal fade" id="sellerTypeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">What kind of seller are you?</h5>

                            </div>
                            <div class="modal-body">
                                <button class="selection-button" value="Individual"
                                    data-type="individual">Individual</button>
                                <button class="selection-button" value="Corporate"
                                    data-type="corporate">Corporate</button>
                                <button class="next-button"disabled onclick="save_user_details()">NEXT</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <!-- seller type end -->


                <!--======== 8th referral div for all user types ========-->
                <!-- Referral Div -->
                <div class="col-lg-7 col-12 fxt-bg-color" id="referral_div">


                    <!-- Referral Modal -->
                    <div class="modal fade" id="referralModal" tabindex="-1" aria-labelledby="referralModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="referralModalLabel">Enter Your Referral Code</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="referral_code">Referral Code (Optional)</label>
                                    <input type="text" class="form-control" id="referral_code"
                                        placeholder="e.g: JON0001">
                                    <label class="input_alert referral_code-inp-alert"></label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal" style="background-color: #b5753e; border:none;">Back</button>
                                    <button type="button" class="btn btn-success"
                                        onclick="save_user_details()">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- referral div end -->
                <!-- register end-->

            </div>
        </div>

    </div>
    <div class="col-md-4 justify-content-center align-items-center d-flex d-none"
        style="flex-direction: column; padding-top: 10px; padding-bottom: 20px; background-color: #FFF;">
        <h2>Welcome to <?php echo $system_name ?></h2>
        <div class="row">
            <div class="col-md-4 col-lg-12" style="padding-left: 30%;">
                <a href="<?php echo $baseUrl . "/about-us" ?>">
                    <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                    About Us
                </a>
            </div>
            <div class="col-md-4 col-lg-12" style="padding-left: 30%;">
                <a href="<?php echo $baseUrl . "/terms-conditions" ?>">
                    <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                    Terms & Conditions
                </a>
            </div>
            <div class="col-md-4 col-lg-12" style="padding-left: 30%;">
                <a href="<?php echo $baseUrl . "/privacy-policy" ?>">
                    <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                    Privacy Policy
                </a>
            </div>
            <div class="col-md-4 col-lg-12" style="padding-left: 30%;">
                <a href="<?php echo $baseUrl . "/shipping-returns-refund-policy" ?>">
                    <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                    Shipping, Returns, and Refund Policy
                </a>
            </div>
        </div>
    </div>
</div>
<div class="header-install-bar" style="<?php echo $isIOS ? 'display:none;' : 'display:block; background-color:#b5753e !important;'; ?>">
    Try Our App -> <button class="app-install-btn">Install</button>
</div>