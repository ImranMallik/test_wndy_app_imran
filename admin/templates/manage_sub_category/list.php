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
		$searchQuery = " and ( tbl_sub_category_master.sub_category_name like '%".$searchValue."%' or
		tbl_sub_category_master.active like'%" . $searchValue . "%') ";
	}

	$query = "SELECT 
		tbl_sub_category_master.sub_category_id,
		tbl_sub_category_master.sub_category_name,
		tbl_sub_category_master.active
		FROM tbl_sub_category_master WHERE 1 ";

	## Total number of records without filtering
	$sel = mysqli_query($con,$query);
	$records = mysqli_num_rows($sel);
	$totalRecords = $records;

	## Total number of records with filtering
	$sel = mysqli_query($con,$query.$searchQuery);
	$records = mysqli_num_rows($sel);
	$totalRecordwithFilter =$records;

	## Fetch records
	$empQuery = $query.$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i=1;
	while ($row = mysqli_fetch_assoc($empRecords)) {
		
		$active =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		if($row['active']=="Yes"){
			$active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		}

		$edit = '';		
		if($edit_permission=="Yes"){
			$edit = 'onclick="update_data('."'".$row['sub_category_id']."'".')"';
		}
		
		$delete = '';
		if($delete_permissioin=="Yes"){
			$delete = 'onclick="show_del_data_confirm_box('."'".$row['sub_category_id']."'".')"';
		}

		$action =
			'<div class="dropdown dropdown-inline">
				<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"> <i class="la la-cog"></i> </a>
				<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
					<ul class="nav nav-hoverable flex-column">
						<li class="nav-item">
							<a '.$edit.' class="nav-link" ><i class="text-success nav-icon fas fa-pen"></i><span class="nav-text">Edit Details</span></a>
						</li>
						<li class="nav-item">
							<a '.$delete.' class="nav-link" ><i class="text-danger nav-icon fas fa-trash"></i><span class="nav-text">Delete Details</span></a>
						</li>
					</ul>
				</div>
			</div>';
		
		$data[] = array(
				"sub_category_name"=>$row['sub_category_name'],
				"active"=>$active,
				"action"=>$action,
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