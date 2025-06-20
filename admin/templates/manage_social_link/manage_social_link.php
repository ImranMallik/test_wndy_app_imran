<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;;" class="card-header">
        <h3 class="card-title">Manage Social Link Info</h3>
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
                $link_dataget = mysqli_query($con, "SELECT 
                                    facebook,
                                    twitter,
                                    pinterest,
                                    linkedin,
                                    instagram,
                                    youtube
                                    FROM  tbl_social_link_details");
                $link_data = mysqli_fetch_row($link_dataget);

                $facebook = $link_data[0];
                $twitter = $link_data[1];
                $pinterest = $link_data[2];
                $linkedin = $link_data[3];
                $instagram = $link_data[4];
                $youtube = $link_data[5];
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                               Facebook
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This facebook show in your contact information. Any user can contact by this facebook.">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="facebook" value="<?php echo $facebook; ?>" class="form-control" placeholder="Enter your facebook Account" required maxlength="100">
                            <label data-default-mssg="" class="input_alert facebook-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Twitter
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This twitter show in your contact information. Any user can contact by this twitter">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="twitter" id="twitter" value="<?php echo $twitter; ?>" class="form-control" placeholder="Enter your twitter Account" required maxlength="150">
                            <label data-default-mssg="" class="input_alert twitter-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Pinterest
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This pinterest show in your contact information. Any user can contact by this pinterest id.">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="pinterest" value="<?php echo $pinterest; ?>" class="form-control" placeholder="Enter your pinterest Account" required >
                            <label data-default-mssg="" class="input_alert pinterest-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                               Linkedin
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This linkedin show in your contact information. Any user can contact by this linkedin id.">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="linkedin" value="<?php echo $linkedin; ?>" class="form-control" placeholder="Enter your linkedin Account" required />
                            <label data-default-mssg="" class="input_alert linkedin-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                               Instagram
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This instagram show in your contact information. Any user can contact by this instagram id.">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="instagram" value="<?php echo $instagram; ?>" class="form-control" placeholder="Enter your instagram Account" required />
                            <label data-default-mssg="" class="input_alert instagram-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                               Youtube
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="This youtube Link show in your contact information. Any user can Vist  by this youtube link .">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <input type="text" id="youtube" value="<?php echo $youtube; ?>" class="form-control" placeholder="Enter your youtube Account" required />
                            <label data-default-mssg="" class="input_alert youtube-inp-alert"></label>
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