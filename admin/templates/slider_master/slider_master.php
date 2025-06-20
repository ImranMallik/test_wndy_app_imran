<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;" class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Home Slider Details</h5>
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
                            <th class="nosort">Action</th>
                            <th>Timestamp</th>
                            <th>Slider Image</th>
                            <th>Slider Heading</th>
                            <th>Slider Sub-Text</th>
                            <th>Button Text</th>
                            <th>Button Link</th>
                            <th>Order Number</th>
                            <th>Active</th>
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
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter Slider Image Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
                <div class="input_part">
                    <input type="hidden" id="slider_id" value="" />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Slider Heading
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Home Slider Heading">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="heading" class="form-control" placeholder="e.g: It is a home slider heading..." maxlength="50" required>
                                <label data-default-mssg="" class="input_alert heading-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Slider Paragraph Text
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Home Slider Paragraph Text">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="sub_text" class="form-control" placeholder="e.g: It is a home slider paragraph text...">
                                <label data-default-mssg="" class="input_alert sub_text-inp-alert"></label>
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
                                <label class="control-label">Button Text
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Home Slider Button Text">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="button_text" class="form-control" placeholder="e.g: Home slider button text..." maxlength="50" required>
                                <label data-default-mssg="" class="input_alert button_text-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Button Link
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Home Slider Button Link">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="text" id="link" class="form-control" placeholder="e.g: https://www.testlink.com">
                                <label data-default-mssg="" class="input_alert link-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Slider Order
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Your Home Slider Order No">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="number" id="order_num" class="form-control" placeholder="e.g: 1 or, 2 or,..." maxlength="50" required>
                                <label data-default-mssg="" class="input_alert order_num-inp-alert"></label>
                            </div>
                        </div>
                        <?php
                        $getMaxFileSizeDataget = mysqli_query($con, "SELECT home_slider_max_kb_size FROM system_info WHERE 1 ");
                        $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
                        $getMaxFileSizeKb = $getMaxFileSizeData[0];
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Slider Image
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Max <?php echo $getMaxFileSizeKb; ?> kb size allowed and allowed extension <?php echo $inputAllowedImage; ?>">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <div class="custom-file">
                                    <input type="file" onchange="loadFile(this,'slider_img')" class="custom-file-input" id="slider_img" accept="<?php echo $inputAllowedImage; ?>" required>
                                    <label class="custom-file-label slider_img_label">Choose file</label>
                                </div>
                                <center>
                                    <div class="image-input image-input-outline">
                                        <div style="width: auto; height:auto; margin-top:10px;" class="image-input-wrapper">
                                            <img style="max-width: 150px;" class="slider_img" data-blank-image="../upload_content/upload_img/slider_img/no_image.png" src="../upload_content/upload_img/slider_img/no_image.png" />
                                        </div>
                                    </div>
                                </center>
                                <label data-default-mssg="(Please Use 1600 x 700 PX Image)" class="input_alert slider_img-inp-alert"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer entry_modal_footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" onclick="clear_input()" class="btn btn-light-dark font-weight-bold">Clear</button>
                <button type="button" onclick="checkSliderImage()" class="btn btn-primary font-weight-bold save_btn">Save
                    Data</button>
            </div>
        </div>
    </div>
</div>