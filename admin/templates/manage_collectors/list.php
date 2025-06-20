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
        $searchQuery = " and (tbl_user_master.name like '%" . $searchValue . "%' or 
        tbl_user_master.ph_num like '%" . $searchValue . "%' or 
        tbl_user_master.referral_id like '%" . $searchValue . "%' or
        tbl_user_master.active like'%" . $searchValue . "%' or
        tbl_user_master.entry_timestamp like'%" . $searchValue . "%' or
        u2.name like'%" . $searchValue . "%' or
        u2.ph_num like'%" . $searchValue . "%' or
        tbl_user_master.referral_id like'%" . $searchValue . "%' or
		tbl_user_master.under_referral_by like'%" . $searchValue . "%') ";
    }

    $query = "SELECT 
            tbl_user_master.user_id,
            tbl_user_master.name, 
            tbl_user_master.ph_num,
            tbl_user_master.referral_id,
            tbl_user_master.under_buyer_id,
			tbl_user_master.user_img,
            tbl_user_master.user_type,
            tbl_user_master.entry_timestamp, 
            tbl_user_master.active,
            u2.name AS buyer_name,
            u2.ph_num AS buyer_ph_num,
            tbl_user_master.referral_id,
		    tbl_user_master.under_referral_by
            FROM tbl_user_master
            LEFT JOIN tbl_user_master AS u2 ON tbl_user_master.under_buyer_id = u2.user_id
            WHERE tbl_user_master.user_type='Collector' ";

    ## Total number of records without filtering
    $sel = mysqli_query($con, $query);
    $totalRecords = mysqli_num_rows($sel);

    ## Total number of records with filtering
    $sel = mysqli_query($con, $query . $searchQuery);
    $totalRecordwithFilter = mysqli_num_rows($sel);

    ## Fetch records
    switch ($columnName) {
        case "buyer_details":
            $orderBy = " order by u2.name " . $columnSortOrder . ", u2.ph_num " . $columnSortOrder;
            break;
        default:
            $orderBy = "order by tbl_user_master." . $columnName . " " . $columnSortOrder;
    }

    $empQuery = $query . $searchQuery . " " . $orderBy . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
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

        $buyer_details = '';
        if ($row['under_buyer_id'] != NULL && $row['buyer_name'] != NULL && $row['buyer_ph_num'] != NULL) {
            $buyer_details = $row['buyer_name'] . " [" . $row['buyer_ph_num'] . "]";
        } else {
            $buyer_details = '<span style="font-size: 1.5em; display: inline-block; text-align: center; width: 100%;">-</span>';
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
            "buyer_details" => $buyer_details,
            "referral_id" => $self_referral_code,
            "under_referral_by" => $referred_by,
            "active" => $active,
            "action" => $action,

        );
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
