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

	$filter_from_date = mysqli_real_escape_string($con, $_POST['filter_from_date']);
	$filter_to_date = mysqli_real_escape_string($con, $_POST['filter_to_date']);
	$filter_type = mysqli_real_escape_string($con, $_POST['filter_type']);

	$searchQuery = "";
	if ($searchValue != '') {
		$searchQuery = " AND (
			tbl_otp_details.ph_num LIKE '%" . $searchValue . "%' OR
			tbl_otp_details.entry_timestamp LIKE '%" . $searchValue . "%'
		) ";
	}

// 	$query = "SELECT 
// 				tbl_otp_details.ph_num,
// 				tbl_otp_details.entry_timestamp,
// 				(select count(*) from tbl_user_master where tbl_user_master.ph_num = tbl_otp_details.ph_num) AS type
// 			FROM tbl_otp_details
// 			WHERE 1";

$query = "SELECT 
			tbl_otp_details.ph_num,
			tbl_otp_details.entry_timestamp,
			(SELECT COUNT(*) FROM tbl_user_master WHERE tbl_user_master.ph_num = tbl_otp_details.ph_num) AS type
		FROM tbl_otp_details
		WHERE is_verified = 1"; 


	if ($filter_from_date != "") {
		$query .= " AND tbl_otp_details.entry_timestamp >= '" . $filter_from_date . " 00:00:00' ";
	}
	if ($filter_to_date != "") {
		$query .= " AND tbl_otp_details.entry_timestamp <= '" . $filter_to_date . " 23:59:59' ";
	}
	if ($filter_type != "") {
		$query .= " HAVING type='" . $filter_type . "' ";
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

		default:
			$orderBy = "order by tbl_otp_details." . $columnName;
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

		$type =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">Unverified User</span>';
		if ($row['type'] == 1) {
			$type = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Verified User</span>';
		}

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"ph_num" => $row['ph_num'],
			"type" => $type,
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
