<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader" style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Whatsapp Log List</h5>
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

            <!-- Filter Form -->
            <div class="row">
                <!-- From Date Filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label"><b>Filter By :</b> From Date</label>
                        <input type="date" id="filter_from_date" onchange="reload_table()" oninput="reload_table()" class="form-control" />
                    </div>
                </div>

                <!-- To Date Filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">To Date</label>
                        <input type="date" id="filter_to_date" onchange="reload_table()" oninput="reload_table()" class="form-control" />
                    </div>
                </div>

                <!-- Message Status Filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Message Status</label>
                        <select id="filter_type" onchange="reload_table()" class="form-control">
                            <option value="">Choose Type</option>
                            <option value="0">Success</option>
                            <option value="1">Failure</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table to Display Records -->
            <div class="show_record_div">
                <table class="table table-bordered table-hover" id="data_table">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Phone Number</th>
                            <th>Username</th>
                            <th>Campaign Name</th>
                            <th>Response Data</th>
                            <th>Request Data</th>
                            <th>Message Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data rows will be inserted here by DataTables or AJAX -->
                    </tbody>
                </table>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>