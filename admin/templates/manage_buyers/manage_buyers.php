<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;" class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Buyers Details</h5>
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
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">From Date</label>
                <input type="date" onchange="reload_table()" class="form-control" id="from_date" placeholder="Choose From Date" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">To Date</label>
                <input type="date" onchange="reload_table()" class="form-control" id="to_date" placeholder="Choose To Date" />
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
                            <th class="nosort">Image</th>
                            <th>Type</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Landmark</th>
                            <th>Pincode</th>
                            <th>City</th>
                            <th>State</th>
                            <th>PAN Number</th>
                            <th>Aadhar Number</th>
                            <th>Authorization Certificate Number</th>
                            <th>GST Number</th>
                            <th>Buyer Type</th>
                            <th class="nosort">Address Details</th>
                            <th>Waste Category</th>
                            <th>Working Days</th>
                            <th>Working Method</th>
                            <th>Livelihood Source</th>
                            <th>Deal Customer</th>
                            <th>Ac Price</th>
                            <th>Washing Machine Price</th>
                            <th>Fridge Price</th>
                            <th>TV Price</th>
                            <th>Microwave Price</th>
                            <th>Laptop Price</th>
                            <th>Geyser Price</th>
                            <th>Paper Price</th>
                            <th>Iron Price</th>
                            <th>Furniture Price</th>
                            <th>Battery Price</th>
                            <th>Cardboard Price</th>
                            <th>Company Name</th>
                            <th>Self Referral Code</th>
                            <th>Referred BY</th>
                            <th>Active</th>
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
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter Buyer Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
                <div class="input_part">
                    <input type="hidden" id="user_id" value="" />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Full Name
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Buyer Display Name">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="name" class="form-control" placeholder="e.g: John Doe" required maxlength="200">
                                <label data-default-mssg="" class="input_alert name-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Country Code
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                </label>
                                <select id="country_code" class="form-control" required>
                                    <option value="+91" selected>+91</option>
                                </select>
                                <label data-default-mssg="" class="input_alert country_code-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Phone Number
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Duplicate Phone Number Not Allowed. User can login with this phone number">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="ph_num" class="form-control" placeholder="e.g: 7896541230" required maxlength="10" />
                                <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Pincode
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Pincode">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="pin_code" class="form-control" placeholder="e.g: 789654" required maxlength="10" />
                                <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group">
                               
                                <input type="hidden" id="address_id" class="form-control" placeholder="e.g: 7896541230" required minlength="10" maxlength="10" />
                                <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Email Id
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Duplicate Email Id Not Allowed">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="email" id="email_id" class="form-control" placeholder="e.g: example@gmail.com" maxlength="100" />
                                <label data-default-mssg="" class="input_alert email_id-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">DOB
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Buyer Date of Birth">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="dob" class="form-control" placeholder="e.g: 1999-05-25" />
                                <label data-default-mssg="" class="input_alert dob-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    PAN Number
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Buyer PAN Number">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="pan_num" class="form-control" placeholder="e.g: SBINT7854E" maxlength="10" minlength="10" />
                                <label data-default-mssg="" class="input_alert pan_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Aadhar Number
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Buyer Aadhar Number">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="aadhar_num" class="form-control" placeholder="e.g: 1234 5698 7696" maxlength="12" minlength="12" />
                                <label data-default-mssg="" class="input_alert aadhar_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    GST Number
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Buyer GST Number">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="gst_num" class="form-control" placeholder="e.g: 12354 56898 76896" maxlength="15" minlength="15" />
                                <label data-default-mssg="" class="input_alert gst_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Authorization Certificate Number
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Buyer Authorization Certificate Number">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="authorization_certificate_num" class="form-control" placeholder="e.g: 12354 56898 76896" maxlength="100" />
                                <label data-default-mssg="" class="input_alert authorization_certificate_num-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Buyer Type
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Choose Buyer Type">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="buyer_type" class="form-control" required>
                                    <option value="">Choose Buyer Type</option>
                                    <option value="Scrap Dealer">Scrap Dealer</option>
                                    <option value="Aggregator">Aggregator</option>
                                    <option value="Recycler">Recycler</option>
                                </select>
                                <label data-default-mssg="" class="input_alert buyer_type-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Active</label>
                                <select id="active" class="form-control">
                                    <option value="Yes" selected>Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <label data-default-mssg="" class="input_alert active-inp-alert"></label>
                            </div>
                        </div>
                        <?php
                        $getMaxFileSizeDataget = mysqli_query($con, "select profile_image_max_kb_size from system_info where 1 ");
                        $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
                        $getMaxFileSizeKb = $getMaxFileSizeData[0];
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Image
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Max <?php echo $getMaxFileSizeKb; ?> kb size allowed and allowed extension <?php echo $inputAllowedImage; ?>">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <div class="custom-file">
                                    <input type="file" onchange="loadFile(this,'user_img')" class="custom-file-input" id="user_img" accept="<?php echo $inputAllowedImage; ?>">
                                    <label class="custom-file-label user_img_label">Choose file</label>
                                </div>
                                <center>
                                    <div class="image-input image-input-outline">
                                        <div style="width: auto; height:auto; margin-top:10px;" class="image-input-wrapper">
                                            <img style="max-width: 150px;" class="user_img" data-blank-image="../upload_content/upload_img/user_img/default.png" src="../upload_content/upload_img/user_img/default.png" />
                                        </div>
                                    </div>
                                </center>
                                <label data-default-mssg="" class="input_alert user_img-inp-alert"></label>
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

<!-- for view all the addresses start -->
<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">All Addresses Details: </h5>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body">
                <!-- here dynamically address data will get -->
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>