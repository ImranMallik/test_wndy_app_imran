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
		$searchQuery = " and (tbl_home_slider.heading like '%" . $searchValue . "%' or
		tbl_home_slider.sub_text like '%" . $searchValue . "%' or
		tbl_home_slider.button_text like '%" . $searchValue . "%' or
		tbl_home_slider.order_num like '%" . $searchValue . "%' or
		tbl_home_slider.active like '%" . $searchValue . "%' ) ";
	}

	$query = "SELECT 
			tbl_home_slider.slider_id,
			tbl_home_slider.slider_img	, 
			tbl_home_slider.heading, 
			tbl_home_slider.sub_text,
			tbl_home_slider.button_text, 
			tbl_home_slider.link,
			tbl_home_slider.active, 
			tbl_home_slider.order_num,
			tbl_home_slider.entry_timestamp
			FROM tbl_home_slider 
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
		case "tbl_home_slider":
			$orderBy = " order by tbl_home_slider." . $columnName;
			break;
		default:
			$orderBy = "order by tbl_home_slider." . $columnName;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		if ($row['active'] == "Yes") {
			$active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		} else {
			$active = '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}

		$edit = '';
		if ($edit_permission == "Yes") {
			$edit = 'onclick="update_data(' . "'" . $row['slider_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['slider_id'] . "'" . ')"';
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
		$slderImage = $row['slider_img'] == "" ? "no_image.png" : $row['slider_img'];
		$sliderImageStr = '<center>
							<div class="image-input image-input-outline">
								<div style="width: auto; height:auto;" class="image-input-wrapper">
									<img style="max-width: 80px;" src="../upload_content/upload_img/slider_img/' . $slderImage . '">
								</div>
							</div>
						</center>';

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"slider_img" => '<input type="hidden" class="slider_id_' . $i . '" value="' . $row['slider_id'] . '" />' . $sliderImageStr,
			"heading" => $row['heading'],
			"sub_text" => $row['sub_text'],
			"button_text" => $row['button_text'],
			"link" => $row['link'],
			"active" => $active,
			"order_num" => $row['order_num'],
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
?>