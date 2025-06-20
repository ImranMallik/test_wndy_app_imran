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

	## Search 
	$searchQuery = " ";
	if ($searchValue != '') {
		$searchQuery = " and (tbl_category_master.category_name like '%" . $searchValue . "%' or
		tbl_category_rate_list.product_name like '%" . $searchValue . "%' or
		tbl_category_rate_list.lowest_price like'%" . $searchValue . "%' or
		tbl_category_rate_list.highest_price like '%" . $searchValue . "%' or 
		tbl_category_rate_list.active like'%" . $searchValue . "%' or
		tbl_category_rate_list.action_timestamp like '%" . $searchValue . "%' ) ";
	}

	$query = "SELECT 
				tbl_category_rate_list.category_rate_list_id,
				tbl_category_master.category_name,
				tbl_category_rate_list.product_name,
				tbl_category_rate_list.lowest_price,
				tbl_category_rate_list.highest_price,
				tbl_category_rate_list.active,
				tbl_category_rate_list.action_timestamp
			FROM tbl_category_rate_list 
			LEFT JOIN tbl_category_master ON  tbl_category_master.category_id = tbl_category_rate_list.category_id
			WHERE 1";

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
		case "category_name":
			$orderBy = "order by tbl_category_master." . $columnName;
			break;
		default:
			$orderBy = "order by tbl_category_rate_list." . $columnName;
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
			$edit = 'onclick="update_data(' . "'" . $row['category_rate_list_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['category_rate_list_id'] . "'" . ')"';
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

		$data[] = array(
			"action_timestamp" => $row['action_timestamp'],
			"category_name" => $row['category_name'],
			"product_name" => $row['product_name'],
			"lowest_price" => $row['lowest_price'],
			"highest_price" => $row['highest_price'],
			"active" => $active,
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
