<?php
include("../db/db.php");

if($view_permission=="Yes"){
		
	## Read value
	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length']; // Rows display per page
	$columnIndex = $_POST['order'][0]['column']; // Column index
	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

	## Search 
	$searchQuery = " ";
	if($searchValue != ''){
		$searchQuery = " and (user_activity.activity_details like '%".$searchValue."%' or 
		user_activity.activity_timestamp like '%".$searchValue."%' ) ";
	}

	$query = "select 
			user_activity.activity_code,
			user_activity.activity_details,
			user_activity.activity_timestamp
			from user_activity
			WHERE user_activity.user_code='".$session_user_code."' ";

	## Total number of records without filtering
	$sel = mysqli_query($con,$query);
	$records = mysqli_num_rows($sel);
	$totalRecords = $records;

	## Total number of records with filtering
	$sel = mysqli_query($con,$query.$searchQuery);
	$records = mysqli_num_rows($sel);
	$totalRecordwithFilter =$records;

	## Fetch records
	$orderBy = "order by user_activity.".$columnName;
	
	$empQuery = $query.$searchQuery." ".$orderBy." ".$columnSortOrder." limit ".$row.",".$rowperpage;
	
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i=1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		$activity_timestamp = date('d M, Y [ h:i a ]',strtotime($row['activity_timestamp']));
		$data[] = array(
				"activity_details"=>'<input type="hidden" class="activity_code_'.$i.'" value="'.$row['activity_code'].'" />'.$row['activity_details'],
				"activity_timestamp"=>$activity_timestamp,
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
?>