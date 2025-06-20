<script>
    const baseUrl = '<?php echo $baseUrl; ?>';
</script>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;"
        class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Seller Item Details</h5>
                </div>
            </div>
           
            <div class="d-flex align-items-center">
                <a onclick="reload_table()" class="btn btn-light-warning font-weight-bolder btn-sm mr-5">
                    <i class="fas fa-sync"></i> Refresh Record
                </a>
                <a onclick="clear_input()" class="btn btn-light-danger font-weight-bolder btn-sm mr-5"
                    data-toggle="modal" data-target="#entryModal">
                    <i class="fas fa-plus"></i> Add New Record
                </a>
                <a class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal"
                    data-target="#entryModal">
                    <i class="fas fa-folder-open"></i> Re-Open Modal
                </a>
            </div>
        </div>
        </div>
        <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="page_container">
            <div class="row">
       <div class="col-md-3">
        <label><strong>Date Range:</strong></label>
        <div style="display: flex; gap: 5px; align-items: center;">
        <input type="date" id="start_date" class="form-control" onchange="onStartDateChange()" />
        <span id="to_label" style="display: none;">to</span>
        <input type="date" id="end_date" class="form-control" style="display: none;" onchange="onEndDateChange()" />
       </div>
       <input type="hidden" id="custom_date_range" />  
       </div>





            </div>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="page_container">
            <div class="show_record_div">
                <table class="table table-bordered table-hover" id="data_table">
                    <thead>
                        <tr>
                            <th>Action Timestamp</th>
                            <th>Category</th>
                            <th>Seller</th>
                            <th>Location Name </th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Pincode</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Quantity(in kgs)</th>
                            <th>Quantity(in pieces)</th>
                            <th>Price</th>
                            <th>Product Status</th>
                            <th>Closure Remark</th>
                            <th>withdrawn date</th>
                            <th>Pruchase Price</th>
                            <th>No Of Post</th>
                            <th>Duration for post completion </th>
                            <th>Closure Reason</th>
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
<div class="modal fade" id="entryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog entry_modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter Product Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
                <div class="input_part">
                    <input type="hidden" id="product_id" value="" />

                    <div class="input_group_div">
                        <div style="width: 226px;" class="input_group_heading">
                            <h3>Product Info :</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Category
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Tap on Category Name Dropdown">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <select id="category_id" class="select2 form-control" data-placeholder="e.g: Waste"
                                        required></select>
                                    <label data-default-mssg="" class="input_alert category_id-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Phone
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Tap on Category Name Dropdown">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <select id="seller_num" class="select2 form-control" data-placeholder="e.g: Waste"
                                        required></select>
                                    <label data-default-mssg="" class="input_alert category_id-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Seller
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Tap on Seller Name Dropdown">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <select id="user_id" class="select2 form-control" data-placeholder="e.g: Waste"
                                        required onchange="clear_location();"></select>
                                    <label data-default-mssg="" class="input_alert user_id-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Location
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Tap on Location, Per Every Seller">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <select id="address_id" class="select2 form-control" data-placeholder="e.g: 38 Dakshindari Road, Saltlake, Kolkata, West Bengal"
                                        required></select>
                                    <label data-default-mssg="" class="input_alert address_id-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Product Name
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Your Product Name">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <input type="text" id="product_name" class="form-control" placeholder="e.g: Waste"
                                        required maxlength="100">
                                    <label data-default-mssg="" class="input_alert product_name-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Your Product Description">
                                        <i class="fas fa-info"></i>
                                    </button>
                                    <input id="description" class="form-control" placeholder="e.g: it is brand new premium product..." />
                                    <label data-default-mssg="" class="input_alert description-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3 d-none">
                                <div class="form-group">
                                    <label class="control-label">Unit</label>
                                    <select id="unit_code" class="select2 form-control" data-placeholder="Choose Unit"
                                        required></select>
                                    <label data-default-mssg="" class="input_alert unit_code-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Brand
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Your Product Brand">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <input type="text" id="brand" class="form-control" placeholder="e.g: WM" />
                                    <label data-default-mssg="" class="input_alert brand-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Quantity(in kgs)
                                                                            <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Your Product Quantity(in kgs)">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <input type="number" id="quantity_kg" class="form-control" placeholder="e.g: 0.5, 1,1.5,..." />
                                    <label data-default-mssg="" class="input_alert quantity-inp-alert"></label>
                                </div>
                            </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Quantity(in pieces)
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="Your Product Quantity(in pieces)">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <input type="number" id="quantity_pcs" class="form-control" placeholder="e.g: 1, 2,..." />
                                    <label data-default-mssg="" class="input_alert quantity-inp-alert"></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Price
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            *
                                        </span>
                                        <!-- Info hover content -->
                                        <button type="button" class="info-label-btn btn btn-secondary"
                                            data-container="body" data-toggle="tooltip" data-placement="top"
                                            title="This Should be a Number, (.) Decimal Accepted">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </label>
                                    <input type="number" id="sale_price" class="form-control"
                                        placeholder="e.g: 10, 20.50,...." required step="any" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Product Status</label>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Default It Will Open">
                                        <i class="fas fa-info"></i>
                                    </button>
                                    <select id="product_status" class="form-control">
                                        <option value="" selected>Choose Product Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Post Viewed">Post Viewed</option>
                                        <option value="Under Negotiation">Under Negotiation</option>
                                        <option value="Offer Accepted">Offer Accepted</option>
                                        <option value="Pickup Scheduled">Pickup Scheduled</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Third-Party Transaction">Third-Party Transaction</option>
                                        <option value="Withdraw">Withdrawal</option>
                                    </select>
                                    <label data-default-mssg="" class="input_alert product_status-inp-alert"></label>
                                </div>
                            </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Withdrawal Reason
                                        <!-- Required hover content -->
                                        <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                            data-placement="top" title="This Field is Required">
                                            
                                        </span>
                                        <!-- Info hover content -->
                                      
                                    </label>
                                    <input type="text" id="whithdrawl_reson" class="form-control" required step="any" />
                                </div>
                            </div>
              <div id="closure_remark_container" class="col-md-3 d-none">
	          <div class="form-group">
		      <label class="control-label">Closure Remark</label>
		      <textarea id="closure_remark" class="form-control" rows="3" placeholder="Enter remark..."></textarea>
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
                            <div id="photo_section" class="col-md-3 ">
                                <div class="form-group">
                                    <label class="control-label">Product Image</label>
                                    <div class="custom-file">
                                        <input type="file" onchange="loadFile(this,'product_image_1')"
                                            class="custom-file-input" id="product_image_1"
                                            accept="<?php echo $inputAllowedImage; ?>">
                                        <label class="custom-file-label product_image_1_label">Choose file</label>
                                    </div>
                                    <center>
                                        <div class="image-input image-input-outline">
                                            <div style="width: auto; height:auto; margin-top:10px;"
                                                class="image-input-wrapper">
                                                <img style="max-width: 150px;" class="product_image_1"
                                                    data-blank-image="../upload_content/upload_img/product_img/no_image.png"
                                                    src="../upload_content/upload_img/product_img/no_image.png" />
                                            </div>
                                        </div>
                                    </center>
                                    <label data-default-mssg="" class="input_alert product_image_1-inp-alert"></label>
                                </div>
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

<!-- Transactional Buyers List Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Transactional View By Buyers</h5>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body" style="max-height: 515px; overflow-y: auto;">
                <!-- dynamically populated address data will go here -->
            </div>
        </div>
    </div>
</div>