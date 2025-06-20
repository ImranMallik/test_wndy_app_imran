<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;" class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Manage User Details</h5>
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
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="page_container">
            <div class="show_record_div">
                <table class="table table-bordered table-hover" id="data_table">
                    <thead>
                        <tr>
                            <th>Action Timestamp</th>
                            <th>User Image</th>
                            <th>Name</th>
                            <th>User Id </th>
                            <th>Email</th>
                            <th>User Role</th>
                            <th>Entry Permission</th>
                            <th>View Permission</th>
                            <th>Edit Permission</th>
                            <th>Delete Permission</th>
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
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter User Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
                <div class="input_part">
                    <input type="hidden" id="user_code" value="" />

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Name 
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Admin User Display Name">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="name" class="form-control" placeholder="e.g John Doe" required maxlength="150">
                                <label data-default-mssg="" class="input_alert name-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    User Id
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Admin User can login with this user id, Duplicate not allowed">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="user_id" class="form-control" placeholder="e.g admin" required maxlength="50">
                                <label data-default-mssg="" class="input_alert user_id-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Password
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required when user insert new record">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="In Update Mode If You Want To Change Password Then Type Or Leave Blank">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="user_password" class="form-control" placeholder="e.g 12345***" required maxlength="50">
                                <label data-default-mssg="" class="input_alert user_password-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Email 
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Duplicate Email Id Not Allowed. User can also login with this Email Id">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="email" id="email" class="form-control" placeholder="e.g example@gmail.com" maxlength="150" required />
                                <label data-default-mssg="" class="input_alert email-inp-alert"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    User Role
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Choose User Role then user get user role wise permission">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="user_mode_code" class="select2 form-control" data-placeholder="Choose User Role" required></select>
                                <label data-default-mssg="" class="input_alert user_mode_code-inp-alert"></label>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Insert Permission
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="If Insert Permission Yes then user can insert any data">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="entry_permission" class="form-control">
                                    <option value="Yes" selected>Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <label data-default-mssg="" class="input_alert entry_permission-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    View Permission
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="If View Permission Yes then user can view list data">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="view_permission" class="form-control">
                                    <option value="Yes" selected>Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <label data-default-mssg="" class="input_alert view_permission-inp-alert"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Edit Permission
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="If Edit Permission Yes then user can edit any data">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="edit_permission" class="form-control">
                                    <option value="Yes" selected>Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <label data-default-mssg="" class="input_alert edit_permission-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Delete Permission</label>
                                <select id="delete_permissioin" class="form-control">
                                    <option value="Yes" selected>Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <label data-default-mssg="" class="input_alert delete_permissioin-inp-alert"></label>
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
                                    Profile Image
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Max <?php echo $getMaxFileSizeKb; ?> kb size allowed and allowed extension <?php echo $inputAllowedImage; ?>">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <div class="custom-file">
                                    <input type="file" onchange="loadFile(this,'profile_img')" class="custom-file-input" id="profile_img" accept="<?php echo $inputAllowedImage; ?>">
                                    <label class="custom-file-label profile_img_label">Choose file</label>
                                </div>
                                <center>
                                    <div class="image-input image-input-outline">
                                        <div style="width: auto; height:auto; margin-top:10px;" class="image-input-wrapper">
                                            <img style="max-width: 150px;" class="profile_img" data-blank-image="../upload_content/upload_img/profile_img/user_icon.png" src="../upload_content/upload_img/profile_img/user_icon.png" />
                                        </div>
                                    </div>
                                </center>
                                <label data-default-mssg="" class="input_alert profile_img-inp-alert"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer entry_modal_footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" onclick="clear_input()" class="btn btn-light-dark font-weight-bold">Clear</button>
                <button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold save_btn">Save
                    Data</button>
            </div>
        </div>
    </div>
</div>