<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;;" class="card-header">
        <h3 class="card-title">Change Password</h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
			
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <form class="form">
        <div class="card-body">
            <div class="input_part">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> Old Password 
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Old Password">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="old_password" class="form-control" placeholder="Enter Old Password" required maxlength="50">
                            <label data-default-mssg="" class="input_alert old_password-inp-alert" ></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> New Password 
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your New Password">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="new_password" class="form-control" placeholder="Enter New Password" required maxlength="50">
                            <label data-default-mssg="" class="input_alert new_password-inp-alert" ></label>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
        <div style="padding: 8px 2.25rem;" class="card-footer">
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-7">
					<button type="button" onclick="clear_input()" class="btn btn-light-dark font-weight-bold">Clear</button>
					<button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold">Update Password</button>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
<!--end::Card-->
