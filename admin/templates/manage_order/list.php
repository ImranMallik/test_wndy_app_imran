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
	$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

	## Search 
	$searchQuery = " ";
	if ($searchValue != '') {
		$searchQuery = " and (tbl_buyer_master.buyer_name like '%" . $searchValue . "%' or 
		tbl_product_master.product_name like '%" . $searchValue . "%' or 
		tbl_seller_master.seller_name like'%" . $searchValue . "%' or
		tbl_buy_request.note like '%" . $searchValue . "%' or
		tbl_buy_request.seen_status like'%" . $searchValue . "%' ) ";
	}

	$query = "SELECT 
	tbl_buy_request.request_id,
	tbl_buy_request.buyer_id,
	tbl_buyer_master.buyer_name, 
	tbl_buy_request.product_id, 
	tbl_product_master.product_name,
	tbl_buy_request.seller_id,
	tbl_seller_master.seller_name,
	tbl_buy_request.note,
	tbl_buy_request.seen_status
	FROM tbl_buy_request
	LEFT JOIN tbl_buyer_master ON tbl_buyer_master.buyer_id = tbl_buy_request.buyer_id 
	LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_buy_request.product_id 
	LEFT JOIN tbl_seller_master ON tbl_seller_master.seller_id = tbl_buy_request.seller_id
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
		case "buyer_name":
			$orderBy = "order by tbl_buyer_master." . $columnName;
			break;
		case "product_name":
			$orderBy = " order by tbl_product_master." . $columnName;
			break;
		case "seller_name":
			$orderBy = " order by tbl_seller_master." . $columnName;
			break;
		default:
			$orderBy = "order by tbl_buy_request." . $columnName;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {


		$seen_status =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		if ($row['seen_status'] == "Yes") {
			$seen_status = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		}

		$edit = '';
		if ($edit_permission == "Yes") {
			$edit = 'onclick="update_data(' . "'" . $row['request_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['request_id'] . "'" . ')"';
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
			"buyer_name" => $row['buyer_name'],
			"product_name" => $row['product_name'],
			'seller_name' => $row['seller_name'],
			"note" => $row['note'],
			"seen_status" => $seen_status,
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
