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
		$searchQuery = " and (tbl_product_master.product_name like '%" . $searchValue . "%' or 
		tbl_category_master.category_name like '%" . $searchValue . "%' or 
		tbl_user_master.name like '%" . $searchValue . "%' or
		tbl_address_master.address_line_1 LIKE '%" . $searchValue . "%' or
		tbl_product_master.product_name LIKE '%" . $searchValue . "%' or
        tbl_product_master.description LIKE '%" . $searchValue . "%' or
		tbl_product_master.brand like'%" . $searchValue . "%' or
		tbl_product_master.quantity like'%" . $searchValue . "%' or
		tbl_product_master.sale_price like'%" . $searchValue . "%' or
		tbl_product_master.product_status like '%" . $searchValue . "%' or
		tbl_product_master.active like'%" . $searchValue . "%' or
		tbl_product_master.entry_timestamp like'%" . $searchValue . "%' ) ";
	}

	$query = "SELECT
				tbl_category_master.category_name, 
				tbl_user_master.name,
				tbl_address_master.address_line_1,
				tbl_address_master.pincode,
				tbl_product_master.product_id,	
				tbl_product_master.product_name, 
				tbl_product_master.description, 
				tbl_product_master.brand, 
				tbl_product_master.quantity,
				tbl_product_master.sale_price,
				tbl_product_master.product_status, 
				tbl_product_master.quantity,
				tbl_product_master.active,
					tbl_product_master.is_draft,
				tbl_product_master.close_reason,
				tbl_product_master.entry_timestamp
			FROM tbl_product_master
			LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id 
			
			LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_product_master.user_id
			LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id 
			WHERE 1 AND tbl_user_master.user_type = 'Seller' ";

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
		case "category_name":
			$orderBy = " order by tbl_category_master." . $columnName;
			break;
		case "name":
			$orderBy = " order by tbl_user_master." . $columnName;
			break;
		case "address_line_1":
			$orderBy = " order by tbl_address_master." . $columnName;
			break;
		default:
			$orderBy = "order by tbl_product_master." . $columnName;
			break;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		$active =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		if ($row['active'] == "Yes") {
			$active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		}

	$product_status = '';

if ($row['is_draft'] == 1) {
    $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #6c757d; color: white;">Draft Post</span>';
} elseif (!empty($row['close_reason'])) {
    $product_status = '<span class="label font-weight-bold label-lg label-inline bg-danger" style="color: white;">Withdrawal</span>';
} else {
    switch ($row['product_status']) {
        case "Active":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #FFD700; color: white;">Active</span>';
            break;
        case "Post Viewed":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: grey; color: white;">Post Viewed</span>';
            break;
        case "Under Negotiation":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: orange; color: white;">Under Negotiation</span>';
            break;
        case "Offer Accepted":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #006400; color: white;">Offer Accepted</span>';
            break;
        case "Pickup Scheduled":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: blue; color: white;">Pickup Scheduled</span>';
            break;
        case "Completed":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: green; color: white;">Completed</span>';
            break;
        case "Third-Party Transaction":
            $product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color:rgb(61, 10, 179); color: white;">Third-Party Transaction</span>';
            $product_id = $row['product_id'];
            $updateQuery = "UPDATE tbl_user_product_view SET deal_status = 'Third-Party Transaction' WHERE product_id='" . $product_id . "'";
            mysqli_query($con, $updateQuery);
            break;
    }
}


		$edit = '';
		if ($edit_permission == "Yes") {
			$edit = 'onclick="update_data(' . "'" . $row['product_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['product_id'] . "'" . ')"';
		}

		$view = '';
		// Check if the user has view permission
		if ($view_permission == "Yes") {
			$view = 'onclick="fetch_buyers(' . "'" . $row['product_id'] . "'" . ')"';
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
							<a ' . $view . ' class="nav-link" ><i class="text-primary nav-icon fas fa-eye"></i><span class="nav-text">Transactional Details</span></a>
						</li>
					</ul>
				</div>
			</div>';


		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"category_name" => $row['category_name'],
			'name' => $row['name'],
			'address_line_1' => $row['address_line_1'],
			"pincode" => $row['pincode'],
			"product_name" => $row['product_name'],
			"description" => $row['description'],
			"brand" => $row['brand'],
			"quantity" => $row['quantity'],
			"sale_price" => $row['sale_price'],
			"product_status" => $product_status,
			  "reason" => $row['close_reason'],
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
