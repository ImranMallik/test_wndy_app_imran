<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div style="padding-top: 8px !important; padding-bottom: 8px !important; margin-bottom: 10px;" class="subheader py-2 py-lg-6 subheader-solid page_subheader" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">Your Activities Details</h5>
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
		<div class="page_container" >
			<div class="show_record_div">
				<table class="table table-striped table-bordered table-hover" id="data_table">
					<thead>
						<tr>
							<th>Activity Timestamp </th>
							<th>Activity Details</th>
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