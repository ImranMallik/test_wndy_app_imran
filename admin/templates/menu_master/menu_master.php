<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;" class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">Manage Menu Details</h5>
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
		<div class="page_container" >
			<div class="show_record_div">
				<table class="table table-bordered table-hover" id="data_table">
					<thead>
						<tr>
							<th>Menu Name</th>
							<th>Sub Menu Status </th>
							<th>File Name</th>
							<th>Folder Name</th>
							<th>Order Number</th>
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
<div class="modal fade" id="entryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog entry_modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title entry_modal_title" id="exampleModalLabel">Enter Menu Details :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body entry_modal_body">
				<div class="input_part">
					<input type="hidden" id="menu_code" value="" />
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Menu Name</label>
								<input type="text" id="menu_name" class="form-control" placeholder="Enter Menu Name" required maxlength="150">
								<label data-default-mssg="( This is unique field )" class="input_alert menu_name-inp-alert" ></label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Menu Icon </label>
								<input type="text" id="menu_icon" class="form-control" placeholder="Enter Menu Icon" required maxlength="150">
								<label data-default-mssg="" class="input_alert menu_icon-inp-alert" ></label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Sub Menu Status</label>
								<select onchange="chng_sub_menu_status()" id="sub_menu_status" class="form-control">
									<option value="Yes" selected >Yes</option>
									<option value="No">No</option>
								</select>
								<label data-default-mssg="" class="input_alert sub_menu_status-inp-alert" ></label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">File Name </label>
								<input type="text" id="file_name" class="form-control" placeholder="Enter File Name" disabled required maxlength="150">
								<label data-default-mssg="" class="input_alert file_name-inp-alert" ></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Folder Name</label>
								<input type="text" id="folder_name" class="form-control" placeholder="Enter Folder Name" disabled required maxlength="150">
								<label data-default-mssg="" class="input_alert folder_name-inp-alert" ></label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Order Number </label>
								<input type="number" id="order_num" class="form-control" placeholder="Enter Order Number" required min="1">
								<label data-default-mssg="" class="input_alert order_num-inp-alert" ></label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Active</label>
								<select id="active" class="form-control">
									<option value="Yes" selected >Yes</option>
									<option value="No">No</option>
								</select>
								<label data-default-mssg="" class="input_alert active-inp-alert" ></label>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<i style="line-height: revert;" class="fa fa-circle-notch text-primary mr-1"></i> text-primary
						</div>
						<div class="col-md-2">
							<i style="line-height: revert;" class="fa fa-circle-notch text-danger mr-1"></i> text-danger
						</div>
						<div class="col-md-2">
							<i style="line-height: revert;" class="fa fa-circle-notch text-warning mr-1"></i> text-warning
						</div>
						<div class="col-md-2">
							<i style="line-height: revert;" class="fa fa-circle-notch text-info mr-1"></i> text-info
						</div>
						<div class="col-md-2">
							<i style="line-height: revert;" class="fa fa-circle-notch text-dark mr-1"></i> text-dark
						</div>
						<div class="col-md-2">
							<i style="line-height: revert;" class="fa fa-circle-notch text-success mr-1"></i> text-success
						</div>
					</div>

				</div>
            </div>
            <div class="modal-footer entry_modal_footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
				<button type="button" onclick="clear_input()" class="btn btn-light-dark font-weight-bold">Clear</button>
                <button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold save_btn">Save Data</button>
            </div>
        </div>
    </div>
</div>
