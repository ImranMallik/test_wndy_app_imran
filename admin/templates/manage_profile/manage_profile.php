<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;;" class="card-header">
        <h3 class="card-title">Manage Profile Details</h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">

            </div>
        </div>
    </div>
    <!--begin::Form-->
    <form class="form">
        <div class="card-body">
            <div class="input_part">
                <?php
                $user_dataget = mysqli_query($con, "select 
                                    user_id,
                                    name,
                                    email,
                                    profile_img
                                    from user_master where user_code='" . $session_user_code . "' ");
                $user_data = mysqli_fetch_row($user_dataget);

                $user_id = $user_data[0];
                $name = $user_data[1];
                $email = $user_data[2];
                $profile_img = $user_data[3];
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Name
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Display Name">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" value="<?php echo $name; ?>" id="name" class="form-control" placeholder="e.g John Doe" required maxlength="150">
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
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="You can login with this user id, Duplicate not allowed">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" value="<?php echo $user_id; ?>" id="user_id" class="form-control" placeholder="e.g admin" required maxlength="50">
                            <label data-default-mssg="" class="input_alert user_id-inp-alert"></label>
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
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Duplicate Email Id Not Allowed. You can also login with this Email Id">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="email" value="<?php echo $email; ?>" id="email" class="form-control" placeholder="e.g example@gmail.com" maxlength="150" required />
                            <label data-default-mssg="" class="input_alert email-inp-alert"></label>
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
                                        <img style="max-width: 150px;" class="profile_img" data-blank-image="../upload_content/upload_img/profile_img/<?php echo $profile_img == "" ? "user_icon.png" : $profile_img; ?>" src="../upload_content/upload_img/profile_img/<?php echo $profile_img == "" ? "user_icon.png" : $profile_img; ?>" />
                                    </div>
                                </div>
                            </center>
                            <label data-default-mssg="" class="input_alert profile_img-inp-alert"></label>
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
                    <button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold">Update Profile Data</button>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
<!--end::Card-->