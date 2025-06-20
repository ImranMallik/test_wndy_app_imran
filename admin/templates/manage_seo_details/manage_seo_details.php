<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;" class="card-header">
        <h3 class="card-title">Manage SEO Details</h3>
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
                $seo_details = mysqli_query($con, "SELECT 
                                    tbl_seo_details.description,
                                    tbl_seo_details.keywords,
                                    tbl_seo_details.author
                                    FROM tbl_seo_details");
                $seo_data = mysqli_fetch_row($seo_details);

                $seo_description = $seo_data[0];
                $seo_keywords = $seo_data[1];
                $seo_author = $seo_data[2];
                ?>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="control-label">Description 
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="System SEO Description">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <textarea id="description" class="form-control" placeholder="e.g: 'It is a brand new premium product...'"><?php echo htmlspecialchars($seo_description); ?></textarea>
                            <label data-default-mssg="" class="input_alert description-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="control-label">Keywords 
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="System SEO Keywords">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <textarea id="keywords" class="form-control" placeholder="e.g: Waste, WM"><?php echo htmlspecialchars($seo_keywords); ?></textarea>
                            <label data-default-mssg="" class="input_alert keywords-inp-alert"></label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="control-label">Author 
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="System SEO Author">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <textarea id="author" class="form-control" placeholder="e.g: John Doe"><?php echo htmlspecialchars($seo_author); ?></textarea>
                            <label data-default-mssg="" class="input_alert author-inp-alert"></label>
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
