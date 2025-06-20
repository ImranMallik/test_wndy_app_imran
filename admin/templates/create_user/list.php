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
		$searchQuery = " and (user_master.user_id like '%" . $searchValue . "%' or 
		user_master.name like '%" . $searchValue . "%' or 
		user_master.email like'%" . $searchValue . "%' or
		user_mode.user_mode like'%" . $searchValue . "%' ) ";
	}

	$query = "SELECT 
				user_master.user_code,
				user_master.user_id, 
				user_master.name, 
				user_master.email, 
				user_master.profile_img, 
				user_mode.user_mode, 
				user_master.active, 
				user_master.entry_permission, 
				user_master.view_permission,
				user_master.edit_permission,
				user_master.delete_permissioin,
				user_master.entry_timestamp
				FROM user_master
				LEFT JOIN user_mode ON user_mode.user_mode_code = user_master.user_mode_code 
				WHERE user_master.user_mode_code<>'Project Admin' AND user_master.user_code<>'" . $session_user_code . "' ";

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
		case "user_mode":
			$orderBy = " order by user_mode." . $columnName;
			break;
		default:
			$orderBy = "order by user_master." . $columnName;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		if ($row['active'] == "Yes") {
			$active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$active =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}
		if ($row['entry_permission'] == "Yes") {
			$entryPermission = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$entryPermission =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}
		if ($row['view_permission'] == "Yes") {
			$viewPermission = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$viewPermission =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}
		if ($row['edit_permission'] == "Yes") {
			$editPermission = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$editPermission =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}
		if ($row['delete_permissioin'] == "Yes") {
			$deletePermissioin = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$deletePermissioin =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}
		if ($row['special_permission'] == "Yes") {
			$specialPermissioin = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$specialPermissioin =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}

		$edit = '';
		if ($edit_permission == "Yes") {
			$edit = 'onclick="update_data(' . $i . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . $i . ')"';
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
		$profileImage = $row['profile_img'] == "" ? "user_icon.png" : $row['profile_img'];
		$profileImageStr = '<center>
							<div class="image-input image-input-outline">
								<div style="width: auto; height:auto;" class="image-input-wrapper">
									<img style="max-width: 80px;" src="../upload_content/upload_img/profile_img/' . $profileImage . '">
								</div>
							</div>
						</center>';

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"profile_img" => '<input type="hidden" class="user_code_' . $i . '" value="' . $row['user_code'] . '" />' . $profileImageStr,
			"name" => $row['name'],
			"user_id" => $row['user_id'],
			"email" => $row['email'],
			"user_mode" => $row['user_mode'],
			"entry_permission" => $entryPermission,
			"view_permission" => $viewPermission,
			"edit_permission" => $editPermission,
			"delete_permissioin" => $deletePermissioin,
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
