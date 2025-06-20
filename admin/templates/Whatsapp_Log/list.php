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
            campaign_name LIKE '%" . $searchValue . "%' OR
            phone_number LIKE '%" . $searchValue . "%' OR
            user_name LIKE '%" . $searchValue . "%' OR
            message_status LIKE '%" . $searchValue . "%' OR
            response_data LIKE '%" . $searchValue . "%' OR
            request_data LIKE '%" . $searchValue . "%' OR
            created_at LIKE '%" . $searchValue . "%'
        ) ";
	}

	if (!empty($filter_from_date)) {
		$searchQuery .= " AND created_at >= '" . $filter_from_date . "'";
	}
	if (!empty($filter_to_date)) {
		$searchQuery .= " AND created_at <= '" . $filter_to_date . "'";
	}
	if (!empty($filter_type)) {
		$searchQuery .= " AND message_status = '" . $filter_type . "'";
	}

	$query = "SELECT 
        created_at,
        campaign_name, 
        phone_number, 
        user_name, 
        message_status, 
        response_data, 
        request_data 
    FROM whatsapp_logs 
    WHERE 1 " . $searchQuery;

	## Total number of records without filtering
	$sel = mysqli_query($con, $query);
	$records = mysqli_num_rows($sel);
	$totalRecords = $records;

	## Total number of records with filtering
	$sel = mysqli_query($con, $query . $searchQuery);
	$records = mysqli_num_rows($sel);
	$totalRecordwithFilter = $records;

	## Fetch records and apply sorting
	switch ($columnName) {
		case 'campaign_name':
			$orderBy = "ORDER BY campaign_name";
			break;
		case 'phone_number':
			$orderBy = "ORDER BY phone_number";
			break;
		default:
			$orderBy = "ORDER BY created_at";
			break;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder;
	if ($rowperpage != -1) {
		$empQuery .= " LIMIT " . $row . "," . $rowperpage;
	}

	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {
		$data[] = array(
			"entry_timestamp" => $row['created_at'],
			"ph_num" => $row['phone_number'],
			"user_name" => $row['user_name'],
			"campaign_name" => $row['campaign_name'],
			"response_data" => $row['response_data'],
			"request_data" => $row['request_data'],
			"message_status" => $row['message_status'],
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
