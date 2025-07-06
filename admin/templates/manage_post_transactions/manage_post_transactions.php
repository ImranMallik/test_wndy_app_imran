<?php

$productId = $arr[3];

$product_data_get = mysqli_query($con, "SELECT product_id, product_name, user_id FROM tbl_product_master WHERE product_id = '$productId' ");
$product_data = mysqli_fetch_assoc($product_data_get);
$product_id = $product_data['product_id'];
$product_name = $product_data['product_name'];
$user_id = $product_data['user_id'];

//seller dataget
$seller_dataget = mysqli_query($con, "select user_id, name, ph_num from tbl_user_master where user_id='" . $user_id . "' ");
$seller_data = mysqli_fetch_assoc($seller_dataget);
// All Buyer Data 
$buyer_name_list = mysqli_query($con, "
    SELECT user_id, user_type, name
    FROM tbl_user_master 
    WHERE LOWER(TRIM(user_type)) = 'buyer'
");

// Pin Code 

$seller_pin_list = mysqli_query($con, "
    SELECT 
        um.user_id, 
        am.pincode 
    FROM tbl_user_master AS um
    INNER JOIN tbl_address_master AS am ON um.user_id = am.user_id
    WHERE LOWER(TRIM(um.user_type)) = 'seller'
    ORDER BY am.pincode ASC
");
$buyer_pin_list = mysqli_query($con, "
    SELECT 
        um.user_id, 
        am.pincode 
    FROM tbl_user_master AS um
    INNER JOIN tbl_address_master AS am ON um.user_id = am.user_id
    WHERE LOWER(TRIM(um.user_type)) = 'Buyer'
    ORDER BY am.pincode ASC
");

// $product_status = mysqli_query($con,"SELECT deal_status FROM tbl_user_product_view");
$product_status_list = mysqli_query($con, "
    SELECT DISTINCT deal_status 
    FROM tbl_user_product_view 
    WHERE deal_status IS NOT NULL 
    ORDER BY deal_status ASC
");
// Seller Product Status
$seller_product_status_list = mysqli_query($con, "
    SELECT DISTINCT product_status 
    FROM tbl_product_master 
    WHERE product_status IS NOT NULL 
    ORDER BY product_status ASC
");


$seller_id = $seller_data['user_id'];
$seller_name = $seller_data['name'];
$seller_ph_num = $seller_data['ph_num'];

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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Post Transactions</h5>
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
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Filter Seller:</strong></label>
                        <!-- <select id="filter_seller_id" class="select2 form-control" data-placeholder="Choose Seller" onchange="$('#filter_product_id').val('').trigger('change');make_select2_ajx('filter_product_id');reload_table()"> -->
                        <select id="filter_seller_id" class="select2 form-control" data-placeholder="Choose Seller" onchange="reload_table()">
                            <?php
                            if ($seller_id != "") {
                            ?>
                                <option value="<?php echo $seller_id; ?>" selected><?php echo $seller_name . " [ " . $seller_ph_num . " ] "; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Filter Category:</strong></label>
                        <select id="filter_category_id" class="select2 form-control" data-placeholder="Choose Category" onchange="$('#filter_product_id').val('').trigger('change'); make_select2_ajx('filter_product_id'); reload_table()"></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Filter Product:</strong></label>
                        <select id="filter_product_id" class="select2 form-control" data-placeholder="Choose Product" onchange="reload_table()">
                            <?php
                            if ($product_id != "") {
                            ?>
                                <option value="<?php echo $product_id; ?>" selected><?php echo $product_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Buyer Name:</strong></label>
                        <select id="buyer_id" class="select2 form-control" data-placeholder="Choose Buyer" onchange="reload_table()">
                            <option value="">-- Select Buyer --</option>
                            <?php
                            while ($buyer_data = mysqli_fetch_assoc($buyer_name_list)) {
                            ?>
                                <option value="<?php echo $buyer_data['user_id']; ?>">
                                    <?php echo htmlspecialchars($buyer_data['name']); ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Seller PinCode:</strong></label>
                        <select id="filter_seller_pincode" class="select2 form-control" data-placeholder="Choose Pincode" onchange="reload_table()">
                            <option value="">-- Select Seller Pincode --</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($seller_pin_list)) {
                                echo '<option value="' . $row['user_id'] . '">' . htmlspecialchars($row['pincode']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Buyer PinCode:</strong></label>
                        <select id="filter_buyer_pincode" class="select2 form-control" data-placeholder="Choose Pincode" onchange="reload_table()">
                            <option value="">-- Select Buyer Pincode --</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($buyer_pin_list)) {
                                echo '<option value="' . $row['user_id'] . '">' . htmlspecialchars($row['pincode']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Product Status:</strong></label>
                        <select id="seller_post_status" class="select2 form-control" data-placeholder="Choose Product Status" onchange="reload_table()">
                            <option value="">-- Select Product Status --</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($seller_product_status_list)) {
                                echo '<option value="' . htmlspecialchars($row['product_status']) . '">' . htmlspecialchars($row['product_status']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><strong>Deal Status:</strong></label>
                        <select id="product_status" class="select2 form-control" data-placeholder="Choose Product Status" onchange="reload_table()">
                            <option value="">-- Select Deal Status --</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($product_status_list)) {
                                echo '<option value="' . htmlspecialchars($row['deal_status']) . '">' . htmlspecialchars($row['deal_status']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>



                <div class="col-md-3 mb-3">
                    <label><strong>Date Range:</strong></label>
                    <div style="display: flex; gap: 5px; align-items: center;">
                        <input type="date" id="start_date" class="form-control" onchange="onStartDateChange()" />
                        <span id="to_label" style="display: none;">to</span>
                        <input type="date" id="end_date" class="form-control" style="display: none;" onchange="onEndDateChange()" />
                    </div>
                    <input type="hidden" id="custom_date_range" />
                </div>





            </div>

            <div class="show_record_div">
                <table class="table table-bordered table-hover" id="data_table">
                    <thead>
                        <tr>
                            <th>Action Timestamp</th>
                            <th>Post ID</th>
                            <th>Seller</th>
                            <th>Seller Number</th>
                            <th>Seller Address</th>
                            <th>Seller Pincode</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Quantity(kgs)</th>
                            <th>Quantity(pieces)</th>
                            <th>Expected Price</th>
                            <th>Product Status</th>
                            <th>Closer Remark</th>
                            <th>Withdrawn Date</th>
                            <th>Withdrawn Reason</th>
                            <th>No Of Post</th>
                            <th>Buyer Action Time</th>
                            <th>Status Update Date</th>
                            <th>Buyer</th>
                            <th>Buyer Number</th>
                            <th>Buyer Address</th>
                            <th>Buyer Pincode</th>
                            <th>Transaction ID</th>
                            <th>Deal Status</th>
                            <th>Used Credits</th>
                            <th>Purchased Price</th>
                            <th>Negotiation Price</th>
                            <th>Message</th>
                            <th>Message History</th>
                            <th>Negotiation Price History</th>
                            <th>Negotiation By</th>
                            <th>Negotiation Date</th>
                            <th>Accepted Date</th>
                            <th>Pickup Date</th>
                            <th>Completed Date</th>
                            <th>Duration for post completion </th>
                            <th>Collector</th>
                            <th>Assigned date for collector</th>
                            <th>View Date</th>
                            <th>Seller Rating For Buyer</th>
                            <th>Buyer Rating For Seller</th>
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
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter Post Transactions Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
                <div class="input_part">
                    <input type="hidden" id="view_id" value="" />

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Seller
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Tap on Seller Name Dropdown & Select Seller">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="seller_id" onchange="$('#product_id').val('').trigger('change');make_select2_ajx('product_id')" class="select2 form-control" data-placeholder="Choose Seller Details" required></select>
                                <label data-default-mssg="" class="input_alert seller_id-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Seller's Item
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Tap on Seller's Item Name Dropdown & Select Seller's Item">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="product_id" class="select2 form-control" data-placeholder="Choose Seller's Item" required></select>
                                <label data-default-mssg="" class="input_alert product_id-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Buyer
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Tap on Buyer Name Dropdown & Select Buyer">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="buyer_id" onchange="$('#assigned_collecter').val('').trigger('change');make_select2_ajx('assigned_collecter')" class="select2 form-control" data-placeholder="Choose Buyer Details" required></select>
                                <label data-default-mssg="" class="input_alert buyer_id-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Collector
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Tap on Collector Name Dropdown & Select Collector">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="assigned_collecter" class="select2 form-control" data-placeholder="Choose Collector Details"></select>
                                <label data-default-mssg="" class="input_alert assigned_collecter-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    View Date
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="When buyer viewed the item">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="view_date" class="form-control" placeholder="Enter View Date" required />
                                <label data-default-mssg="" class="input_alert view_date-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Deal Status
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="When buyer viewed the item">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="deal_status" class="form-control" required>
                                    <option value="">Choose Deal Status</option>
                                    <option value="Credit Used">Credit Used</option>
                                    <option value="Under Negotiation">Under Negotiation</option>
                                    <option value="Offer Accepted">Offer Accepted</option>
                                    <option value="Pickup Scheduled">Pickup Scheduled</option>
                                    <option value="Offer Rejected">Offer Rejected</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Withdraw">Withdraw</option>
                                </select>
                                <label data-default-mssg="" class="input_alert deal_status-inp-alert"></label>
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
                                <label class="control-label">
                                    Purchased Price
                                    <!-- Required hover content -->
                                    <span class="req-label-btn" data-container="body" data-toggle="tooltip"
                                        data-placement="top" title="This Field is Required When Deal Status is Waiting For Pickup & Complete">
                                        *
                                    </span>
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Purchased Price">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="number" id="purchased_price" class="form-control" placeholder="e.g: 1005.20" required step="any" />
                                <label data-default-mssg="" class="input_alert purchased_price-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Negotiation Amount
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Negotiation Amount">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="number" id="negotiation_amount" class="form-control" placeholder="e.g: 1005.20" step="any" />
                                <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Negotiation By
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Negotiation By">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <select id="negotiation_by" class="form-control">
                                    <option value="">Choose Negotiation By</option>
                                    <option value="Seller">Seller</option>
                                    <option value="Buyer">Buyer</option>
                                    <option value="Collector">Collector</option>
                                </select>
                                <label data-default-mssg="" class="input_alert negotiation_by-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Message
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Negotiation Message">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <textarea id="mssg" class="form-control" placeholder="Enter Negotiation Message ..."></textarea>
                                <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Withdrawn Reason
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Widthdrawn Reason">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <textarea id="widthdrawn_reason" class="form-control" placeholder="Widthdrawn Reason ..."></textarea>
                                <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Negotiation Date
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Negotiation Date">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="negotiation_date" class="form-control" placeholder="Enter Negotiation Date" />
                                <label data-default-mssg="" class="input_alert negotiation_date-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Withdrawn Date
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="withdrawn_date">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="withdrawn_date" class="form-control" placeholder="Enter Negotiation Date" />
                                <label data-default-mssg="" class="input_alert negotiation_date-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Accept Date
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Accept Date">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="accept_date" class="form-control" placeholder="Enter Accept Date" />
                                <label data-default-mssg="" class="input_alert accept_date-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Pickup Date
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Pickup Date">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="pickup_date" class="form-control" placeholder="Enter Pickup Date" />
                                <label data-default-mssg="" class="input_alert pickup_date-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Pickup Time
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Pickup Time">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="time" id="pickup_time" class="form-control" placeholder="Enter Pickup Time" />
                                <label data-default-mssg="" class="input_alert pickup_time-inp-alert"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Complete Date
                                    <!-- Info hover content -->
                                    <button type="button" class="info-label-btn btn btn-secondary"
                                        data-container="body" data-toggle="tooltip" data-placement="top"
                                        title="Complete Date">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </label>
                                <input type="date" id="complete_date" class="form-control" placeholder="Enter Complete Date" />
                                <label data-default-mssg="" class="input_alert complete_date-inp-alert"></label>
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