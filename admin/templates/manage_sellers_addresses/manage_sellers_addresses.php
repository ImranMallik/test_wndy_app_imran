<?php
include_once('../db/db.php');

$userId = urlencode($arr[3]);

$query = "SELECT name, ph_num FROM tbl_user_master WHERE user_id = '$userId'";
$user_data_get = mysqli_query($con, $query);

$user_data = mysqli_fetch_assoc($user_data_get);
$userData = $user_data['name'] . ' [' . $user_data['ph_num'] . ']';
?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;" class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Sellers Addresses Details</h5>
                    <!--end::Page Title-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Actions-->
                <a onclick="reload_table()" class="btn btn-light-warning font-weight-bolder btn-sm mr-5">
                    <i class="fas fa-sync"></i> Refresh Record
                </a>
                <a onclick="clear_input()" class="btn btn-light-danger font-weight-bolder btn-sm mr-5" data-toggle="modal" data-target="#entryModal">
                    <i class="fas fa-plus"></i> Add New Record
                </a>
                <a class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#entryModal">
                    <i class="fas fa-folder-open"></i> Re-Open Modal
                </a>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label"><b>Select Seller</b></label>
                <select id="user_id_search" class="select2 form-control" data-placeholder="Choose Seller" onchange="reload_table()">
                    <option value="<?php echo $userId; ?>" selected><?php echo $userData; ?></option>
                </select>
            </div>
        </div>
    </div>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="page_container">
            <div class="show_record_div">
                <table class="table table-bordered table-hover" id="data_table">
                    <thead>
                        <tr>
                            <th>Action Timestamp</th>
                            <th>Seller</th>
                            <th class="nosort">Default</th>
                            <th>Contact Name</th>
                            <th>Seller Type</th>
                            <th>Contact Phone Number</th>
                            <th>Address Name</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Landmark</th>
                            <th>Pincode</th>
                            <th>Address</th>
                            <th class="nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>


<!-- Modal-->
<div class="modal fade" id="entryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog entry_modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter Seller Address Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
                <div class="input_part">
                    <input type="hidden" id="address_id" value="" />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Seller</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Seller Dropdown">
                                    <i class="fas fa-info"></i>
                                </button>
                                <select id="user_id" class="select2 form-control" data-placeholder="e.g: John Doe [7895412345]" required></select>
                                <label data-default-mssg="" class="input_alert user_id-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Seller Type</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Seller Type">
                                    <i class="fas fa-info"></i>
                                </button>
                                <select id="seller_type" class="select2 form-control"  data-placeholder="individual" required></select>
                                <label data-default-mssg="" class="input_alert user_id-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Contact Name</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Contact Name">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="contact_name" class="form-control" placeholder="e.g: John Doe" required maxlength="50">
                                <label data-default-mssg="" class="input_alert contact_name-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Contact Phone Number</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Contact Phone Number">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="contact_ph_num" class="form-control" placeholder="e.g: 7896541230" maxlength="10" minlength="10" required>
                                <label data-default-mssg="" class="input_alert contact_ph_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Address Name</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Address Name">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="address_name" class="form-control" placeholder="e.g: Home Or, Office Address" required maxlength="50">
                                <label data-default-mssg="" class="input_alert address_name-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Country</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Country Name">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="country" class="form-control" placeholder="e.g: India" required maxlength="50">
                                <label data-default-mssg="" class="input_alert country-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">State</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your State Name">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="state" class="form-control" placeholder="e.g: WB" required maxlength="50">
                                <label data-default-mssg="" class="input_alert state-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your City Name">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="city" class="form-control" placeholder="e.g: Kolkata" maxlength="50" required />
                                <label data-default-mssg="" class="input_alert city-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Landmark</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Landmark Name">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="landmark" class="form-control" placeholder="e.g: Dakshindari" maxlength="50" required />
                                <label data-default-mssg="" class="input_alert landmark-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Pincode</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Pincode Number, Only Accepts 6 Digits Number">
                                    <i class="fas fa-info"></i>
                                </button>
                                <input type="text" id="pincode" class="form-control" placeholder="e.g: 720148" minlength="6" maxlength="6" required />
                                <label data-default-mssg="" class="input_alert pincode-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Primary or, Permanent or, Current Address">
                                    <i class="fas fa-info"></i>
                                </button>
                                <textarea type="text" id="address_line_1" class="form-control" placeholder="e.g: 38 Dakshindari Road, Laketown, Kolkata, West Bengal" rows="5" maxlength="150" required></textarea>
                                <label data-default-mssg="" class="input_alert address_line_1-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Default Address
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Is this user default address?">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="default_address" class="form-control">
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected>No</option>
                                </select>
                                <label data-default-mssg="" class="input_alert default_address-inp-alert"></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer entry_modal_footer">
                <button type="button" onclick="clear_input()" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold save_btn">Save Data</button>
            </div>
        </div>
    </div>
</div>