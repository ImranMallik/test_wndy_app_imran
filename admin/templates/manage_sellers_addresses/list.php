<?php
include("../db/db.php");

if ($view_permission == "Yes") {

	## Read value
	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length']; // Rows display per page
	$columnIndex = $_POST['order'][0]['column']; // Column index
	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search 

	$user_id = mysqli_real_escape_string($con, $_POST['user_id']);

	## Search 
	$searchQuery = " ";
	if ($searchValue != '') {
		$searchQuery = " and (tbl_user_master.name like '%" . $searchValue . "%' or 
		tbl_user_master.ph_num like '%" . $searchValue . "%' or 
		tbl_address_master.contact_name like '%" . $searchValue . "%' or
		tbl_address_master.contact_ph_num like'%" . $searchValue . "%' or
		tbl_address_master.address_name like '%" . $searchValue . "%' or 
		tbl_address_master.country like'%" . $searchValue . "%' or
		tbl_address_master.state like'%" . $searchValue . "%' or
		tbl_address_master.city like'%" . $searchValue . "%' or
		tbl_address_master.landmark like'%" . $searchValue . "%' or 
		tbl_address_master.pincode like'%" . $searchValue . "%' or
		tbl_address_master.address_line_1 like '%" . $searchValue . "%' or
		tbl_address_master.entry_timestamp like '%" . $searchValue . "%' ) ";
	}

	$query = "SELECT 
		tbl_address_master.user_id,
		tbl_user_master.name,
		tbl_user_master.ph_num,
		tbl_user_master.seller_type,
		tbl_address_master.address_id,
		tbl_address_master.contact_name,
        tbl_address_master.contact_ph_num,
        tbl_address_master.address_name,
        tbl_address_master.country,
		tbl_address_master.state,
        tbl_address_master.city,
		tbl_address_master.landmark,
        tbl_address_master.pincode,
        tbl_address_master.address_line_1,
		tbl_address_master.entry_timestamp
        FROM tbl_address_master 
		LEFT JOIN tbl_user_master ON tbl_address_master.user_id = tbl_user_master.user_id
		WHERE tbl_user_master.user_type='Seller' AND 1";

	// Date filters
	if ($user_id != "") {
		$query .= " AND tbl_address_master.user_id = '" . $user_id . "'";
	}

	## Total number of records without filtering
	$sel = mysqli_query($con, $query);
	$records = mysqli_num_rows($sel);
	$totalRecords = $records;

	## Total number of records with filtering
	$sel = mysqli_query($con, $query . $searchQuery);
	$records = mysqli_num_rows($sel);
	$totalRecordwithFilter = $records;

	## Fetch records
	switch ($columnName) {
		case "name":
			$orderBy = "order by tbl_user_master." . $columnName;
			break;
		default:
			$orderBy = "order by tbl_address_master." . $columnName;
			break;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder;
	if ($rowperpage != -1) {
		$empQuery .= " limit " . $row . "," . $rowperpage;
	}

	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {


		$active =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		if ($row['active'] == "Yes") {
			$active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		}

		$edit = '';
		if ($edit_permission == "Yes") {
			$edit = 'onclick="update_data(' . "'" . $row['address_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['address_id'] . "'" . ')"';
		}

		$action =
			'<div class="dropdown dropdown-inline">
				<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"> <i class="la la-cog"></i> </a>
				<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
					<ul class="nav nav-hoverable flex-column">
						<li class="nav-item">
							<a ' . $edit . ' class="nav-link" ><i class="text-success nav-icon fas fa-pen"></i><span class="nav-text">Edit Details</span></a>
						</li>
						<li class="nav-item">
							<a ' . $delete . ' class="nav-link" ><i class="text-danger nav-icon fas fa-trash"></i><span class="nav-text">Delete Details</span></a>
						</li>
					</ul>
				</div>
			</div>';

		$defaultAddressDataget = mysqli_query($con, "select * from tbl_user_master where user_id='" . $row['user_id'] . "' and address_id='" . $row['address_id'] . "' ");
		$defaultAddressData = mysqli_fetch_row($defaultAddressDataget);

		$default =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		if ($defaultAddressData) {
			$default = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		}

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"name" => $row['name'] . ' [' . $row['ph_num'] . ']',
			"default" => $default,
			"contact_name" => $row['contact_name'],
			"contact_ph_num" => $row['contact_ph_num'],
			"address_name" => $row['address_name'],
			"country" => $row['country'],
			"state" => $row['state'],
			"city" => $row['city'],
			"landmark" => $row['landmark'],
			"seller_type" => $row['seller_type'],
			"pincode" => $row['pincode'],
			"address_line_1" => $row['address_line_1'],
			"action" => $action,
		);
		$i++;
	}

	## Response
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data
	);
	echo json_encode($response);
}
