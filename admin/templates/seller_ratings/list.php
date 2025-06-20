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
		$searchQuery = " and (buyer_details.name like '%" . $searchValue . "%' or 
		buyer_details.ph_num like '%" . $searchValue . "%' or 
		seller_details.name like '%" . $searchValue . "%' or 
		seller_details.ph_num like '%" . $searchValue . "%' or 
		tbl_ratings.rating like'%" . $searchValue . "%' or
		tbl_ratings.review like'%" . $searchValue . "%' or
		tbl_ratings.entry_timestamp like '%" . $searchValue . "%' ) ";
	}

	$query = "SELECT 
        tbl_ratings.rating_id,
		buyer_details.name AS buyer_name,
		buyer_details.ph_num AS buyer_ph_num,
		seller_details.name AS seller_name,
		seller_details.ph_num AS seller_ph_num,
		tbl_ratings.rating,
		tbl_ratings.review,
        tbl_ratings.entry_timestamp
        FROM tbl_ratings
		LEFT JOIN tbl_user_master AS buyer_details ON buyer_details.user_id = tbl_ratings.to_user_id
		LEFT JOIN tbl_user_master AS seller_details ON seller_details.user_id = tbl_ratings.give_user_id
		WHERE tbl_ratings.rating_from = 'Seller' ";


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
		case 'buyer_details':
			$orderBy = "ORDER BY buyer_details.name " . $columnSortOrder . ", buyer_details.ph_num " . $columnSortOrder;
			break;
		case 'seller_details':
			$orderBy = "ORDER BY seller_details.name " . $columnSortOrder . ", seller_details.ph_num " . $columnSortOrder;
			break;

		default:
			$orderBy = "ORDER BY tbl_ratings." . $columnName . " " . $columnSortOrder;
			break;
	}


	$empQuery = $query . $searchQuery . " " . $orderBy;
	if ($rowperpage != -1) {
		$empQuery .= " limit " . $row . "," . $rowperpage;
	}
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['rating_id'] . "'" . ')"';
		}

		$action =
			'<div class="dropdown dropdown-inline">
				<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"> <i class="la la-cog"></i> </a>
				<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
					<ul class="nav nav-hoverable flex-column">
						<li class="nav-item">
							<a ' . $delete . ' class="nav-link" ><i class="text-danger nav-icon fas fa-trash"></i><span class="nav-text">Delete Details</span></a>
						</li>
					</ul>
				</div>
			</div>';

		$buyer_details = $row['buyer_name'] . " [ " . $row['buyer_ph_num'] . " ] ";
		$seller_details = $row['seller_name'] . " [ " . $row['seller_ph_num'] . " ] ";

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"seller_details" => $seller_details,
			"buyer_details" => $buyer_details,
			"rating" => $row['rating'],
			"review" => $row['review'],
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
