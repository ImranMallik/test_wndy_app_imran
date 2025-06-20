<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;;" class="card-header">
        <h3 class="card-title">Manage System Info</h3>
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
                $system_dataget = mysqli_query($con, "SELECT 
                                    system_name,
                                    logo,
                                    favicon,
                                    email,
                                    address,
                                    ph_num,
                                    product_view_credit
                                    FROM system_info");
                $system_data = mysqli_fetch_row($system_dataget);

                $system_name = $system_data[0];
                $logo = $system_data[1];
                $favicon = $system_data[2];
                $email = $system_data[3];
                $address = $system_data[4];
                $ph_num = $system_data[5];
                // $profile_image_max_kb_size = $system_data[6];
                // $category_image_max_kb_size = $system_data[7];
                // $product_image_max_kb_size = $system_data[8];
                // $product_file_max_kb_size = $system_data[9];
                // $home_slider_max_kb_size = $system_data[10];
                $product_view_credit = $system_data[6];
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                System Name
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="System Name is your app name or project name. It will be show in website title and admin.">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="system_name" value="<?php echo $system_name; ?>" class="form-control" placeholder="e.g Waste Marketplace" required maxlength="100">
                            <label data-default-mssg="" class="input_alert system_name-inp-alert"></label>
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
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This email show in your contact information. Any user can contact by this mail">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="email" id="email" value="<?php echo $email; ?>" class="form-control" placeholder="e.g example@gmail.com" required maxlength="150">
                            <label data-default-mssg="" class="input_alert email-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Address
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This Data show in your contact information.">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="address" value="<?php echo $address; ?>" class="form-control" placeholder="e.g 132, My Street, Kingston, New York 12401." required maxlength="200">
                            <label data-default-mssg="" class="input_alert address-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Phone Number
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This phone number show in your contact information. Any user can contact by this phone number">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="ph_num" value="<?php echo $ph_num; ?>" class="form-control" placeholder="e.g 7896541230" required maxlength="10" minlength="10" />
                            <label data-default-mssg="" class="input_alert ph_num-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Product View Credit
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="To View The Seller Information & Purchase The Product : 'Recharge It' ">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="product_view_credit" value="<?php echo $product_view_credit; ?>" class="form-control" placeholder="e.g 100" maxlength="50" required />
                            <label data-default-mssg="" class="input_alert product_view_credit-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label class="control-label">
                                Profile Image Max Size
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Size should be in kb">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="number" id="profile_image_max_kb_size" value="<?php echo $profile_image_max_kb_size; ?>" class="form-control" placeholder="e.g 10" required step="any" min="1" />
                            <label data-default-mssg="" class="input_alert profile_image_max_kb_size-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label class="control-label">
                                Category Image Max Size
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Size should be in kb">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="number" id="product_view_credit" value="<?php echo $product_view_credit; ?>" class="form-control" placeholder="e.g 10" required step="any" min="1" />
                            <label data-default-mssg="" class="input_alert product_view_credit-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label class="control-label">
                                Product Image Max Size
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Size should be in kb">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="number" id="product_image_max_kb_size" value="<?php echo $product_image_max_kb_size; ?>" class="form-control" placeholder="e.g 10" required step="any" min="1" />
                            <label data-default-mssg="" class="input_alert product_image_max_kb_size-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label class="control-label">
                                Product File Max Size
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Size should be in kb">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="number" id="product_file_max_kb_size" value="<?php echo $product_file_max_kb_size; ?>" class="form-control" placeholder="e.g 10" required step="any" min="1" />
                            <label data-default-mssg="" class="input_alert product_file_max_kb_size-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label class="control-label">
                                Home Slider Max Size
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Size should be in kb">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="number" id="home_slider_max_kb_size" value="<?php echo $home_slider_max_kb_size; ?>" class="form-control" placeholder="e.g 10" required step="any" min="1" />
                            <label data-default-mssg="" class="input_alert home_slider_max_kb_size-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Company Logo
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Max 10 kb size allowed and allowed extension <?php echo $inputAllowedImage; ?>">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <div class="custom-file">
                                <input type="file" onchange="loadFile(this,'logo')" class="custom-file-input" id="logo" accept="<?php echo $inputAllowedImage; ?>">
                                <label class="custom-file-label logo_label" for="logo">Choose file</label>
                            </div>
                            <center>
                                <div class="image-input image-input-outline" id="kt_image_1">
                                    <div style="width: auto; height:auto; margin-top:10px;" class="image-input-wrapper">
                                        <img style="max-width: 150px;" class="logo" data-blank-image="../upload_content/upload_img/no_image.png" src="../upload_content/upload_img/<?php echo $logo == "" ? "no_image.png" : "system_img/" . $logo; ?>" />
                                    </div>
                                </div>
                            </center>
                            <label data-default-mssg="" class="input_alert logo-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Company Favicon
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required">
                                    *
                                </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Max 10 kb size allowed and allowed extension <?php echo $inputAllowedImage; ?>">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <div class="custom-file">
                                <input type="file" onchange="loadFile(this,'favicon')" class="custom-file-input" id="favicon" accept="<?php echo $inputAllowedImage; ?>">
                                <label class="custom-file-label favicon_label" for="favicon">Choose file</label>
                            </div>
                            <center>
                                <div class="image-input image-input-outline" id="kt_image_1">
                                    <div style="width: auto; height:auto; margin-top:10px;" class="image-input-wrapper">
                                        <img style="max-width: 150px;" class="favicon" data-blank-image="../upload_content/upload_img/no_image.png" src="../upload_content/upload_img/<?php echo $favicon == "" ? "no_image.png" : "system_img/" . $favicon; ?>" />
                                    </div>
                                </div>
                            </center>
                            <label data-default-mssg="" class="input_alert favicon-inp-alert"></label>
                        </div>
                    </div>

                </div>

                <!-- <div class="row">
                </div> -->
            </div>

        </div>
        <div style="padding: 8px 2.25rem;" class="card-footer">
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-7">
                    <button type="button" onclick="clear_input()" class="btn btn-light-dark font-weight-bold">Clear</button>
                    <button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold">Save Data</button>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
<!--end::Card-->