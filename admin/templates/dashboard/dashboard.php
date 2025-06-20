<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;;" class="card-header">
        <h3 class="card-title">Dashboard</h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">

            </div>
        </div>
    </div>
    <!--begin::Form-->
    <form class="form">
        <div class="card-body">

            <div class="row">

                <div class="col-md-12">
                    <h3>Seller & Buyer Data : </h3>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">From Date</label>
                                <input type="date" onchange="getBuyerSellerCountDetails();" class="form-control" id="from_date" placeholder="Choose From Date" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">To Date</label>
                                <input type="date" onchange="getBuyerSellerCountDetails();" class="form-control" id="to_date" placeholder="Choose To Date" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">State</label>
                                <select id="state" onchange="$('#city').val('').trigger('change'); make_select2_ajx('city'); getBuyerSellerCountDetails()" class="select2 form-control" data-placeholder="Choose State"></select>
                                <label data-default-mssg="" class="input_alert state-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <select id="city" onchange="$('#pincode').val('').trigger('change');make_select2_ajx('pincode'); getBuyerSellerCountDetails()" class="select2 form-control" data-placeholder="Choose City"></select>
                                <label data-default-mssg="" class="input_alert city-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Pincode</label>
                                <select id="pincode" onchange="getBuyerSellerCountDetails()" class="select2 form-control" data-placeholder="Choose Pincode"></select>
                                <label data-default-mssg="" class="input_alert pincode-inp-alert"></label>
                            </div>
                        </div>
                    </div>

                    <div class="sellerBuyerCountChart"></div>

                    <div style="overflow-x: auto;" class="mb-15">
                        <table class="table table-bordered table-hover no-footer sellerBuyerCountTable"></table>
                    </div>

                </div>

                <div class="col-md-12">
                    <h3>Transaction Count & Valuation : </h3>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">From Date</label>
                                <input type="date" onchange="getTransactionCountDetails();" class="form-control" id="from_date_trans" placeholder="Choose From Date" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">To Date</label>
                                <input type="date" onchange="getTransactionCountDetails();" class="form-control" id="to_date_trans" placeholder="Choose To Date" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">State</label>
                                <select id="transaction_count_state" onchange="$('#transaction_count_city').val('').trigger('change');make_select2_ajx('transaction_count_city');getTransactionCountDetails()" class="select2 form-control" data-placeholder="Choose State"></select>
                                <label data-default-mssg="" class="input_alert transaction_count_state-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <select id="transaction_count_city" onchange="$('#transaction_count_pincode').val('').trigger('change');make_select2_ajx('transaction_count_pincode');getTransactionCountDetails()" class="select2 form-control" data-placeholder="Choose City"></select>
                                <label data-default-mssg="" class="input_alert transaction_count_city-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Pincode</label>
                                <select id="transaction_count_pincode" onchange="getTransactionCountDetails()" class="select2 form-control" data-placeholder="Choose Pincode"></select>
                                <label data-default-mssg="" class="input_alert transaction_count_pincode-inp-alert"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="transactionCountChart"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="transactionCountPieChart"></div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover no-footer transactionCountTable mb-15"></table>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="transactionValuationChart"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="transactionValuationPieChart"></div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover no-footer transactionValuationTable mb-15"></table>

                </div>

                <div class="col-md-12">
                    <h3>Buyer Credit History : </h3>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">From Date</label>
                                <input type="date" onchange="getCreditHistoryData();" class="form-control" id="from_date_credit" placeholder="Choose From Date" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">To Date</label>
                                <input type="date" onchange="getCreditHistoryData();" class="form-control" id="to_date_credit" placeholder="Choose To Date" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Filter Year</label>
                                <select class="form-control" onchange="getCreditHistoryData()" id="credit_history_filter_year">
                                    <option value="<?php echo $year; ?>" selected><?php echo $year; ?></option>
                                    <?php
                                    for ($i = 1; $i < 15; $i++) {
                                    ?>
                                        <option value="<?php echo $year - $i; ?>"><?php echo $year - $i; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label data-default-mssg="" class="input_alert credit_history_filter_year-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">State</label>
                                <select id="credit_history_state" onchange="$('#credit_history_city').val('').trigger('change');make_select2_ajx('credit_history_city');getCreditHistoryData()" class="select2 form-control" data-placeholder="Choose State"></select>
                                <label data-default-mssg="" class="input_alert credit_history_state-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <select id="credit_history_city" onchange="$('#credit_history_pincode').val('').trigger('change');make_select2_ajx('credit_history_pincode');getCreditHistoryData()" class="select2 form-control" data-placeholder="Choose City"></select>
                                <label data-default-mssg="" class="input_alert credit_history_city-inp-alert"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Pincode</label>
                                <select id="credit_history_pincode" onchange="getCreditHistoryData()" class="select2 form-control" data-placeholder="Choose Pincode"></select>
                                <label data-default-mssg="" class="input_alert transaction_count_pincode-inp-alert"></label>
                            </div>
                        </div>
                    </div>

                    <div class="creditHistoryChart"></div>

                </div>

                <div class="col-md-12" style="padding-top: 15px !important;">
                    <div class="row">

                        <!-- Post Count By Status Section -->
                        <div class="col-md-12">
                            <h3>Post Count By Status:</h3>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">From Date</label>
                                        <input type="date" onchange="getPostStatusCountDetails();" class="form-control" id="from_date_post_status" placeholder="Choose From Date" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">To Date</label>
                                        <input type="date" onchange="getPostStatusCountDetails();" class="form-control" id="to_date_post_status" placeholder="Choose To Date" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="postStatusCountChart"></div>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover no-footer postStatusCountTable mb-15"></table>
                        </div>

                        <!-- Transaction Count By Status Section -->
                        <!-- <div class="col-md-6">
                            <h3>Transaction Count By Status:</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">From Date</label>
                                        <input type="date" onchange="getTransactionStatusCountDetails();" class="form-control" id="from_date_transaction_status" placeholder="Choose From Date" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">To Date</label>
                                        <input type="date" onchange="getTransactionStatusCountDetails();" class="form-control" id="to_date_transaction_status" placeholder="Choose To Date" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="transactionStatusCountChart"></div>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover no-footer transactionStatusCountTable mb-15"></table>
                        </div> -->
                    </div>
                </div>

            </div>

        </div>

    </form>
    <!--end::Form-->
</div>
<!--end::Card-->