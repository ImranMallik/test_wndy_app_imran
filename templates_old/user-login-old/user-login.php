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

<div class="row">
    <div class="col-md-8 justify-content-center align-items-center d-flex" style="flex-direction: column; min-height: 99vh">

        <img src="frontend_assets/img-icon/pc_wp.png?v=<?php echo $version; ?>" style="max-height: 400px; max-width: 100%;" />

        <div class="container" style="margin-top: 15px;">
            <div class="row justify-content-center align-items-center d-flex">

                <!-- register start -->
                <!--======== 1st Phone Number Div ========-->
                <div class="col-lg-7 col-12 fxt-bg-color" id="ph_num_div" style="display: none;">

                    <label>
                        Welcome, Please enter your Phone number to Register / Login and use our Services
                    </label>
                    <div class="mb-3 icon-group">
                        <input type="text" class="form-control rounded-0" id="ph_num" placeholder="e.g: 7896541230" maxlength="10" required />
                        <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                        <span class="icon-inside">+91</span>
                    </div>
                    <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4 ">
                        <button type="button" onclick="checkPhoneNumber()" class="fxt-btn-fill disabled" id="sendOTPButton">Request OTP</button>
                    </div>

                </div>


                <!--======== 2nd OTP Div ========-->
                <div class="col-lg-7 col-12 fxt-bg-color " id="otp_div" style="display: none;">
                    <label>Enter OTP </label>
                    <div class="mb-3">
                        <input type="text" class="form-control rounded-0" id="otp" placeholder="e.g: 12**" pattern="[0-9]*" minlength="4" maxlength="4" required />
                        <label data-default-mssg="" class="input_alert otp-inp-alert"></label>
                    </div>
                    <p style="text-align: right; font-size: 14px;">
                        <span class="otp_time_span">OTP expires in <span class="otp_valid_time">10:00</span></span>
                        <a class="send_otp_again_a" onclick="checkPhoneNumber()" style="text-decoration: underline; display: none; color: blue;">The OTP has expired. Please try again</a>
                    </p>
                    <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" onclick="toggleScreen('ph_num_div')" class="fxt-btn-fill" style="background: #323232;">
                                    <i class="fa fa-chevron-circle-left"></i>
                                    Back
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" onclick="verifyOtp()" class="fxt-btn-fill">Verify OTP</button>
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
                    <div>
                        <label>Enter Your Name</label>
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-0" id="user_name" placeholder="e.g: John Doe" required />
                            <label data-default-mssg="" class="input_alert user_name-inp-alert"></label>
                        </div>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <input type="checkbox" id="termsCheckbox" class="me-2" required />
                        <label for="termsCheckbox">
                            I Agree To The
                            <a href="<?php echo $baseUrl . "/about-terms-privacy-shipping-returns-refund-policy"; ?>" target="_blank">
                                <u style="color: blue;">About Us, Terms & Conditions, Privacy Policy, Shipping, Returns, and Refund Policy</u>
                            </a>
                        </label>
                    </div>
                    <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                        <div class="row">

                            <div class="col-12">
                                <button type="button" onclick="checkName()" class="fxt-btn-fill">
                                    Next
                                    <i class="fa fa-chevron-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- register end-->


                <!--======== 5th user type ========-->
                <div class="col-lg-7 col-12 fxt-bg-color " id="usertype_div" style="display: none;">
                    <p class="otp_mssg div-alert-mssg" style="display: none;"></p>
                    <div class="text-center">
                        <label class="mb-5">How would you like to use the app ?</label>
                        <br>

                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4" style="margin-bottom: 17px;">
                            <div class="icheck_input">
                                <div class="input-group">
                                    <div class="icheck">
                                        <label>
                                            <input type="radio" name="user_type" value="Buyer" class="icheck" data-radio="iradio_square-blue">
                                            <i class="fas fa-shopping-bag"></i>
                                            I want to buy scrap
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="icheck">
                                        <label>
                                            <input type="radio" name="user_type" value="Seller" class="icheck" data-radio="iradio_square-blue">
                                            <i class="fa fa-store"></i>
                                            I want to sell scrap
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <label style="text-align: left;" data-default-mssg="" class="input_alert user_type-inp-alert"></label>
                        </div>
                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" onclick="toggleScreen('Register_div')" class="fxt-btn-fill" style="background: #323232;">
                                        <i class="fa fa-chevron-circle-left"></i>
                                        Back
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" onclick="checkUserType()" class="fxt-btn-fill">
                                        Next
                                        <i class="fa fa-chevron-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- user type end -->


                <!--======== 6th buyer type ========-->
                <div class="col-lg-7 col-12 fxt-bg-color " id="buyer_type_div" style="display: none;">
                    <p class="otp_mssg div-alert-mssg" style="display: none;"></p>
                    <div class="text-center">
                        <label class="mb-5">
                            Okay !! Please let us know your Buying Type
                        </label>
                        <br>

                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4" style="margin-bottom: 17px;">
                            <div class="icheck_input">
                                <div class="input-group">
                                    <div class="icheck">
                                        <label onclick="showBuyerTypeDetails('scrap_dealer')">
                                            <input type="radio" name="buyer_type" onclick="showBuyerTypeDetails('scrap_dealer')" value="Scrap Dealer" class="icheck" data-radio="iradio_square-blue">
                                            Scrap Dealer
                                            <br />
                                            <span class="icheck-label-span animate__animated animate__fadeInUp" id="scrap_dealer-details">
                                                The shop or business that is closest to the disposer of the waste. They would have associated collectors who will pick scrap from the households
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="icheck">
                                        <label onclick="showBuyerTypeDetails('aggregator')">
                                            <input type="radio" name="buyer_type" onclick="showBuyerTypeDetails('aggregator')" value="Aggregator" class="icheck" data-radio="iradio_square-blue">
                                            Aggregator
                                            <br />
                                            <span class="icheck-label-span animate__animated animate__fadeInUp" id="aggregator-details">
                                                Receives one or more categories of waste from various scrap dealers and may be involved in first line of dismantling
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="icheck">
                                        <label onclick="showBuyerTypeDetails('recycler')">
                                            <input type="radio" name="buyer_type" onclick="showBuyerTypeDetails('recycler')" value="Recycler" class="icheck" data-radio="iradio_square-blue">
                                            Recycler
                                            <br />
                                            <span class="icheck-label-span animate__animated animate__fadeInUp" id="recycler-details">
                                                They receive the various scrap items from Aggregators in bulk quantity and Does the extraction and recovery of materials to supply back into the manufacturing
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <label style="text-align: left;" data-default-mssg="" class="input_alert buyer_type-inp-alert"></label>
                        </div>
                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" onclick="toggleScreen('usertype_div')" class="fxt-btn-fill" style="background: #323232;">
                                        <i class="fa fa-chevron-circle-left"></i>
                                        Back
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" onclick="toggleScreen('referral_div')" class="fxt-btn-fill">
                                        Next
                                        <i class="fa fa-chevron-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- buyer type end -->


                <!--======== 7th seller type ========-->
                <div class="col-lg-7 col-12 fxt-bg-color " id="seller_type_div" style="display: none;">
                    <p class="otp_mssg div-alert-mssg" style="display: none;"></p>
                    <div class="text-center">
                        <label class="mb-5">
                            Okay !! Please let us know your Selling Type
                        </label>
                        <br>

                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4" style="margin-bottom: 17px;">
                            <div class="icheck_input">
                                <div class="input-group">
                                    <div class="icheck">
                                        <label>
                                            <input type="radio" name="seller_type" value="Individual" class="icheck" data-radio="iradio_square-blue">
                                            Individual
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="icheck">
                                        <label>
                                            <input type="radio" name="seller_type" value="Corporate" class="icheck" data-radio="iradio_square-blue">
                                            Corporate
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <label style="text-align: left;" data-default-mssg="" class="input_alert seller_type-inp-alert"></label>
                        </div>
                        <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" onclick="toggleScreen('usertype_div')" class="fxt-btn-fill" style="background: #323232;">
                                        <i class="fa fa-chevron-circle-left"></i>
                                        Back
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" onclick="toggleScreen('referral_div')" class="fxt-btn-fill">
                                        Next
                                        <i class="fa fa-chevron-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- seller type end -->


                <!--======== 8th referral div for all user types ========-->
                <div class="col-lg-7 col-12 fxt-bg-color " id="referral_div" style="display: none;">
                    <div>
                        <label>Enter Your Referral Code (Optional)</label>
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-0" id="referral_code" value="<?php echo $referral_code; ?>" placeholder="e.g: RC1234567890B1" />
                            <label data-default-mssg="" class="input_alert referral_code-inp-alert"></label>
                        </div>
                    </div>
                    <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" onclick="toggleScreen('usertype_div')" class="fxt-btn-fill" style="background: #323232;">
                                    <i class="fa fa-chevron-circle-left"></i>
                                    Back
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" onclick="save_user_details()" class="fxt-btn-fill">
                                    Next
                                    <i class="fa fa-chevron-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- referral div end -->
                <!-- register end-->

            </div>
        </div>

    </div>
    <div class="col-md-4 justify-content-center align-items-center d-flex" style="flex-direction: column; padding-top: 10px; padding-bottom: 20px; background-color: #FFF;">
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