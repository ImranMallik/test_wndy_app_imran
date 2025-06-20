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
	$from_date = mysqli_real_escape_string($con, $_POST['from_date']);
	$to_date = mysqli_real_escape_string($con, $_POST['to_date']);

	## Search 
	$searchQuery = " ";
	if ($searchValue != '') {
		$searchQuery = " and (tbl_user_master.name like '%" . $searchValue . "%' or 
		tbl_user_master.country_code like '%" . $searchValue . "%' or 
		tbl_user_master.ph_num like '%" . $searchValue . "%' or 
		tbl_user_master.email_id like'%" . $searchValue . "%' or
		tbl_user_master.dob like'%" . $searchValue . "%' or
		tbl_user_master.pan_num like '%" . $searchValue . "%' or
		tbl_user_master.gst_num like '%" . $searchValue . "%' or
		tbl_user_master.seller_type like '%" . $searchValue . "%' or
		tbl_user_master.active like'%" . $searchValue . "%' or
		tbl_user_master.entry_timestamp like'%" . $searchValue . "%' or
		tbl_address_master.state like'%" . $searchValue . "%' or
		tbl_address_master.city like'%" . $searchValue . "%' or
		tbl_address_master.landmark like'%" . $searchValue . "%' or
		tbl_user_master.referral_id like'%" . $searchValue . "%' or
		tbl_user_master.under_referral_by like'%" . $searchValue . "%') ";
	}

	$query = "SELECT 
        tbl_user_master.user_id,
        tbl_user_master.name,
        tbl_user_master.country_code,
        tbl_user_master.ph_num,
        tbl_user_master.email_id,
        tbl_user_master.dob,
        tbl_user_master.pan_num,
        tbl_user_master.gst_num,
        tbl_user_master.seller_type,
        tbl_user_master.user_img,
		tbl_user_master.user_type,
        tbl_user_master.active,
		tbl_user_master.entry_timestamp,
        tbl_address_master.state,
        tbl_address_master.city,
        tbl_address_master.landmark,
        tbl_address_master.pincode,
		tbl_user_master.referral_id,
		tbl_user_master.under_referral_by
        FROM tbl_user_master
		LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_user_master.address_id
		WHERE tbl_user_master.user_type = 'Seller'";

	## Date filters
	if ($from_date != "") {
		$query .= " AND DATE(tbl_user_master.entry_timestamp) >= '" . $from_date . "'";
	}
	if ($to_date != "") {
		$query .= " AND DATE(tbl_user_master.entry_timestamp) <= '" . $to_date . "'";
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
		case 'city':
		case 'state':
		case 'landmark':
			$orderBy = "ORDER BY tbl_address_master." . $columnName;
			break;

		default:
			$orderBy = "ORDER BY tbl_user_master." . $columnName;
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
			$edit = 'onclick="update_data(' . "'" . $row['user_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['user_id'] . "'" . ')"';
		}

		$view = '';
		// Check if the user has view permission
		if ($view_permission == "Yes") {
			$view = 'onclick="view_addresses(' . "'" . $row['user_id'] . "'" . ')"';
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
						<li class="nav-item">
							<a ' . $view . ' class="nav-link" ><i class="text-primary nav-icon fas fa-eye"></i><span class="nav-text">View Addressess</span></a>
						</li>
					</ul>
				</div>
			</div>';

		$user_img = $row['user_img'] == "" ? "default.png" : $row['user_img'];
		$user_img_Str = '<center>
							<div class="image-input image-input-outline">
								<div style="width: auto; height:auto;" class="image-input-wrapper">
									<img style="max-width: 80px;" src="../upload_content/upload_img/user_img/' . $user_img . '">
								</div>
							</div>
						</center>';

		$dob = "";
		if ($row['dob'] != "0000-00-00") {
			$dob = $row['dob'];
		}

		$address_details = '';
		$ad = 1;
		$addressDataget = mysqli_query($con, "select address_name, country, state, city, landmark, pincode from tbl_address_master where user_id='" . $row['user_id'] . "' ");
		while ($addressRw = mysqli_fetch_array($addressDataget)) {
			$address_details .= "Address " . $ad . " : " . $addressRw['address_name'] . ", " . $addressRw['country'] . ", " . $addressRw['state'] . ", " . $addressRw['city'] . ", " . $addressRw['landmark'] . ", " . $addressRw['pincode'] . "<br/>";
			$ad++;
		}
		if ($ad == 1) {
			$address_details = 'No Address Found';
		}

		if ($row['referral_id'] != NULL) {
			$self_referral_code = '<span class="label font-weight-bold label-lg label-info label-inline">' . $row['referral_id'] . '</span>';
		} else {
			$self_referral_code = '<span style="font-size: 1.5em; display: inline-block; text-align: center; width: 100%;">-</span>';
		}

		if ($row['under_referral_by'] != NULL) {
			$referred_by_dataget = mysqli_query($con, "SELECT name, ph_num FROM tbl_user_master WHERE user_id = '" . $row['under_referral_by'] . "'");
			$referred_by_data = mysqli_fetch_assoc($referred_by_dataget);
			$referred_by = $referred_by_data['name'] . ' [' . $referred_by_data['ph_num'] . ']';
		} else {
			$referred_by = '<span style="font-size: 1.5em; display: inline-block; text-align: center; width: 100%;">-</span>';
		}

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"user_img" => $user_img_Str,
			"user_type" => $row['user_type'],
			"name" => $row['name'],
			"ph_num" => $row['ph_num'],
			"email_id" => $row['email_id'],
			"dob" => $dob,
			"landmark" => $row['landmark'],
			"pincode" => $row['pincode'],
			"city" => $row['city'],
			"state" => $row['state'],
			"pan_num" => $row['pan_num'],
			"gst_num" => $row['gst_num'],
			"seller_type" => $row['seller_type'],
			"address_details" => $address_details,
			"referral_id" => $self_referral_code,
			"under_referral_by" => $referred_by,
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
