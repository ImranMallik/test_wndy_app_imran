<?php
include("../db/db.php");
?>
<!-- Body Container -->
<div id="page-content" class="pb-5">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>Address Book</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="<?php echo $baseUrl; ?>/home" title="Back to the home page">Home</a><span class="main-title"><i class="icon anm anm-angle-right-l"></i>Address Book</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 mb-lg-0">
                <?php
                include("templates/common_part/user_menu.php");
                ?>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                <!-- Address Book -->
                <div class="tab-pane h-100" id="address">
                    <div class="address-card mt-0 h-100">
                        <div class="top-sec d-flex-justify-center justify-content-between mb-4">
                            <h2 class="mb-0">My Addresses</h2>
                            <button type="button" class="edit btn-sm" data-bs-toggle="modal" data-bs-target="#addNewModal" onclick="clear_input();" style="background-color:#c17f59;">
                                <i class="bi bi-geo-alt" style="font-size:20px; color:#fff;"></i>
                            </button>
                            <!-- New Address Modal -->
                            <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="addNewModalLabel">Address Details</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="address_id" value="" />
                                            <form class="add-address-from" method="post" action="#">
                                                <div class="">
                                                    <div class="form-group">
                                                        <label for="contact_name">Contact Name <span class="required">*</span></label>
                                                        <input name="contact_name" placeholder="e.g: John Doe" value="<?php echo $session_name; ?>" id="contact_name" type="text" required />
                                                        <label data-default-mssg="" class="input_alert contact_name-inp-alert"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="contact_ph_num">Contact Number <span class="required">*</span></label>
                                                        <input name="contact_ph_num" placeholder="e.g: 7896541230" value="<?php echo $session_ph_num; ?>" id="contact_ph_num" maxlength="10" minlength="10" type="text" required />
                                                        <label data-default-mssg="" class="input_alert contact_ph_num-inp-alert"></label>
                                                    </div>
                                                    <div class="form-group d-none">
                                                        <label for="alternative_num">Alternative Number </label>
                                                        <input name="alternative_num" placeholder="e.g: India" value="" id="alternative_num" maxlength="10" type="text" />
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
                                                    <!-- <div class="form-group" style="width: 100%">
                                                        <label for="address_line_1">Address <span class="required">*</span></label>
                                                        <textarea name="address_line_1" id="address_line_1"
                                                            oninput="fetchGoogleAddresses()"
                                                            placeholder="e.g: 38, Sector 1, AB Block, Saltlake, 700125"
                                                            maxlength="100" required></textarea>
                                                        <label data-default-mssg="" class="input_alert address_line_1-inp-alert"></label>
                                                    </div> -->
                                                    <div class="form-group" style="width: 100%">
                                                        <label for="address_line_1">Address <span class="required">*</span></label>
                                                        <textarea name="address_line_1" id="address_line_1"
                                                            placeholder="e.g: 38, Sector 1, AB Block, Saltlake, 700125"
                                                            maxlength="100" required></textarea>
                                                        <label data-default-mssg="" class="input_alert address_line_1-inp-alert"></label>
                                                    </div>
                                                    <div id="suggestions" style="border: 1px solid #ddd; max-height: 200px; overflow-y: auto; display: none;"></div>
                                                    <div class="form-group">
                                                        <label for="landmark">Landmark <span class="required">*</span></label>
                                                        <input name="landmark" id="landmark" placeholder="e.g: Saltlake" type="text" required />
                                                        <label data-default-mssg="" class="input_alert landmark-inp-alert"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="city">City <span class="required">*</span></label>
                                                        <input name="city" id="city" placeholder="e.g: Kolkata" type="text" required />
                                                        <label data-default-mssg="" class="input_alert city-inp-alert"></label>
                                                    </div>
                                                    <div class="form-group" style="width: 100%">
                                                        <label for="pincode">Pincode <span class="required">*</span></label>
                                                        <input name="pincode" id="pincode" placeholder="e.g: 785421" type="text" maxlength="6" required />
                                                        <label data-default-mssg="" class="input_alert pincode-inp-alert"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="state">State <span class="required">*</span></label>
                                                        <input name="state" id="state" placeholder="e.g: WB" type="text" required />
                                                        <label data-default-mssg="" class="input_alert state-inp-alert"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="country">Country <span class="required">*</span></label>
                                                        <input name="country" id="country" placeholder="e.g: India" type="text" required />
                                                        <label data-default-mssg="" class="input_alert country-inp-alert"></label>
                                                    </div>

                                                    <div class="form-group align-items-center d-flex">
                                                        <input type="checkbox" id="default_address" class="me-2" required />
                                                        <label for="default_address" style="margin-top: 11px;">
                                                            Is this your default address ?
                                                        </label>
                                                        <label data-default-mssg="" class="input_alert default_address-inp-alert"></label>
                                                    </div>
                                                    <br>
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
                        </div>


                        <div>
                            <?php
                            $seller_addresses = mysqli_query($con, "SELECT address_id, address_name, contact_name, contact_ph_num, country, state, city, landmark, pincode, address_line_1 FROM tbl_address_master WHERE user_id='" . $session_user_code . "' ORDER BY address_id ASC");


                            if (mysqli_num_rows($seller_addresses) == 0) {
                            ?>
                                <div class="no-products-found">
                                    <center>
                                        <h3>No Address Found</h3>
                                    </center>
                                </div>
                                <?php
                            } else {

                                // check default address or not
                                $dataget = mysqli_query($con, "select address_id from tbl_user_master where user_id='" . $session_user_code . "' ");
                                $data = mysqli_fetch_assoc($dataget);
                                $user_address_id = $data['address_id'];

                                while ($seller_address_rw = mysqli_fetch_array($seller_addresses)) {

                                ?>
                                    <div class="address-select-box active" style="margin-bottom: 7px !important;" id="address-<?php echo $seller_address_rw['address_id']; ?>">
                                        <div class="address-box bg-block" style="margin-bottom:10px; background-color:#ffeedf !important;">
                                            <div class="top d-flex justify-content-between mb-1">
                                              <h5 class="m-0">
    <?php echo $seller_address_rw['address_name']; ?>
    <?php if ($user_address_id == $seller_address_rw['address_id']) { ?>
        <span class="default-text" style="font-weight: bold; color: #b5753e;">(Default)</span>
    <?php } ?>
</h5>

                                                <span class="product-labels start-auto end-0">
                                                    <button type="button" class="bottom-btn btn-sm pb-2" style="background-color:#c17f59 !important; border:none;" data-bs-toggle="modal" onclick="update_data(<?php echo $seller_address_rw['address_id']; ?>);" onclick="clear_input();" data-bs-target="#addNewModal">
                                                        <i class="bi bi-pencil-square" style="font-size:18px; color:#fff; padding-top:15px;"></i>
                                                    </button>
                                                    <button type="button" style="background-color:#c17f59 !important; border:none;" onclick="delete_alert(<?php echo $seller_address_rw['address_id']; ?>);" class="bottom-btn btn btn-gray btn-sm">
                                                        <i class="bi bi-trash" style="font-size:18px; color:#fff;"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="middle">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="address-type">
                                                        </div>
                                                        <div class="address-text">
                                                            <b>Contact:</b> <?php echo htmlspecialchars($seller_address_rw['contact_name']) . " (" . htmlspecialchars($seller_address_rw['contact_ph_num']) . ")"; ?><br>
                                                            <b>Address:</b> <?php echo htmlspecialchars($seller_address_rw['country'] . ", " . $seller_address_rw['state'] . ", " . $seller_address_rw['city'] . ", " . $seller_address_rw['pincode']); ?><br>
                                                            <b>Landmark:</b> <?php echo htmlspecialchars($seller_address_rw['landmark']); ?><br>
                                                            <b>Address Line:</b> <?php echo htmlspecialchars($seller_address_rw['address_line_1']); ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                <?php
                                }
                            }
                                ?>
                                    </div>


                        </div>
                    </div>
                    <!-- End Address Book -->
                </div>
            </div>
        </div>
        <!--End Main Content-->

    </div>
    <!-- End Body Container -->