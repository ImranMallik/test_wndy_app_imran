<?php
include("../db/db.php");
// $product_id = $arr[2];
$address_dataget = mysqli_query($con, "SELECT 
tbl_user_master.name, 
tbl_user_master.ph_num,
tbl_address_master.address_id, 
tbl_address_master.address_line_1
FROM tbl_user_master
LEFT JOIN tbl_address_master ON tbl_address_master.user_id = tbl_user_master.user_id
WHERE tbl_user_master.user_id='" . $session_user_code . "' and tbl_user_master.active='Yes' ");
$address_data = mysqli_fetch_row($address_dataget);

$name = $address_data[0];
$ph_num = $address_data[1];
$address_id = $address_data[2];
$address_line_1 = $address_data[3];

?>

<script>
    let product_update_address_id = "";
</script>
<?php
if ($address_data) {
?>
    <script>
        product_update_address_id = <?php echo $address_id ?>;
    </script>
<?php
}
?>
<section class="fxt-template-animation fxt-template-layout2 lg-mt-5 lg-mb-5 collector-form">
    <div class="container">
        <div class="row justify-content-center align-self-center d-flex">
            <div class="col-lg-6 col-md-7 col-12 bg-form-color">

                <div class="row justify-content-space-around d-flex pt-3" style="border-bottom: 1px solid #dee2e6;">
                    <div class="col-6">
                        <p class="title-text f-w-550" style="margin-left:10px;">Collector Details</p>
                        <style>
                            .title-text {
                                white-space: nowrap;
                            }
                        </style>
                    </div>
                    <?php
                    // check collector previous data exists or not
                    $dataget = mysqli_query($con, "SELECT * FROM tbl_address_master WHERE user_id='" . $session_user_code . "' limit 1 ");
                    $data = mysqli_fetch_row($dataget);
                    if ($data) {
                    ?>
                        <div class="col-6 text-end">
                            <a style="background-color:#b5753e !important;" href="<?php echo $baseUrl . "/collector"; ?>" class="btn btn-primary btn-sm" style="border-radius: 3px; padding: 7px 9px !important;">
                                <i class="icon anm anm-eye-r me-1"></i>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Seller post details start -->

                <div class="fxt-form">
                    <p class="title-text"> Name <span class="text-danger">*</span></p>
                    <div class="col-12 icon-group">
                        <input type="text" value="" class="form-control rounded-0" id="name" required placeholder="e.g: Christian Bale" maxlength="200" />
                        <label data-default-mssg="" class="input_alert name-inp-alert"></label>
                    </div>
                </div>

                <div class="fxt-form">
                    <p class="title-text">Phone Number <span class="text-danger">*</span></p>
                    <div class="col-12 icon-group">
                        <input type="text" value="" class="form-control rounded-0" id="ph_num" required placeholder="e.g: 7896541230" maxlength="10" minlength="10" />
                        <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                    </div>
                </div>

                <!-- Confirm Your Location start -->
                <p class="title-text f-w-550 pt-4">Confirm Your Location</p>

                <p class="title-text">
                    Address
                    <span class="text-danger">*</span>
                    <a data-bs-toggle="modal" data-bs-target="#addressModal" onclick="clear_address_input()" class="btn btn-primary btn-sm create-new" style="border-radius:3px; padding: 2px 9px !important; background-color:#b5753e;">
                        <img src="frontend_assets/img-icon/add-location.png" height="24" width="24" />
                    </a>
                </p>
                <select class="form-control select2" id="address_id" onchange="showAddressDetails()" required>
                    <option value="">Choose Address</option>
                    <?php
                    $address_dataget = mysqli_query($con, "SELECT address_id, address_name FROM tbl_address_master WHERE user_id='" . $session_user_code . "' ORDER BY address_name ASC ");
                    while ($rw = mysqli_fetch_assoc($address_dataget)) {
                        echo '<option value="' . $rw['address_id'] . '">' . $rw['address_name'] . '</option>';
                    }
                    ?>
                </select>
                <label data-default-mssg="" class="input_alert address_id-inp-alert"></label>

                <div class="address_details">
                    <!-- Here show address details of choose address -->
                </div>
                <!-- Confirm Your Location end -->

                <!-- Seller post details end -->
                <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                    <button style="background-color: #b5753e !important;" type="button" class="fxt-btn-fill disabled" onclick="save_collector_details()">Continue <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- New Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="addNewModalLabel">Address Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="address_id" />
                <form class="add-address-from" method="post" action="#">
                    <div class="form-row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1">
                        <div class="form-group">
                            <label for="contact_name">Contact Name <span class="required">*</span></label>
                            <input name="contact_name" placeholder="e.g: John Doe" value="<?php echo $session_name; ?>" id="contact_name" type="text" required />
                            <label data-default-mssg="" class="input_alert contact_name-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="contact_ph_num">Contact Number <span class="required">*</span></label>
                            <input name="contact_ph_num" placeholder="e.g: 9988774455" value="<?php echo $session_ph_num; ?>" id="contact_ph_num" maxlength="10" minlength="10" type="text" required />
                            <label data-default-mssg="" class="input_alert contact_ph_num-inp-alert"></label>
                        </div>
                        <div class="form-group d-none">
                            <label for="alternative_num">Alternative Number </label>
                            <input name="alternative_num" placeholder="e.g: 9988774455" value="" id="alternative_num" maxlength="10" minlength="10" type="text" />
                            <label data-default-mssg="" class="input_alert alternative_num-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="address_name">Address Name <span class="required">*</span></label>
                            <input name="address_name" placeholder="e.g: Home Address Or, Office Address" value="" id="address_name" type="text" required />
                            <label data-default-mssg="" class="input_alert address_name-inp-alert"></label>
                        </div>
                        <div class="form-group d-none">
                            <label for="address_tag">Address Tag <span class="required">*</span></label>
                            <select name="address_tag" id="address_tag">
                                <option value="">Address Tag</option>
                                <option value="home">Home</option>
                                <option value="office">Office</option>
                                <option value="other">Other</option>
                            </select>
                            <label data-default-mssg="" class="input_alert address_tag-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="country">Country <span class="required">*</span></label>
                            <input name="country" placeholder="e.g: India" value="" id="country" type="text" required />
                            <label data-default-mssg="" class="input_alert country-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="state">State <span class="required">*</span></label>
                            <input name="state" placeholder="e.g: WB" value="" id="state" type="text" required />
                            <label data-default-mssg="" class="input_alert state-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input name="city" placeholder="e.g: Kolkata" value="" id="city" type="text" required />
                            <label data-default-mssg="" class="input_alert city-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="landmark">Landmark <span class="required">*</span></label>
                            <input name="landmark" placeholder="e.g: Saltlake" value="" id="landmark" type="text" required />
                            <label data-default-mssg="" class="input_alert landmark-inp-alert"></label>
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label for="pincode">Pincode <span class="required">*</span></label>
                            <input name="pincode" placeholder="e.g: 785421" value="" id="pincode" type="text" minlength="6" maxlength="6" required />
                            <label data-default-mssg="" class="input_alert pincode-inp-alert"></label>
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label for="address_line_1">Address <span class="required">*</span></label>
                            <textarea name="address_line_1" placeholder="e.g: 38, Sector 1, AB Block, Saltlake, 700125" value="" id="address_line_1" type="text" required></textarea>
                            <label data-default-mssg="" class="input_alert address_line_1-inp-alert"></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" onclick="save_details();" class="btn btn-primary m-0">
                    <span>Save Address</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End New Address Modal -->