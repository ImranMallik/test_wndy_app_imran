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
		$searchQuery = " and (tbl_buyer_master.buyer_name like '%" . $searchValue . "%' or 
		tbl_buyer_master.ph_num like '%" . $searchValue . "%' or 
		tbl_buyer_master.buyer_id like'%" . $searchValue . "%' or
		tbl_product_master.product_name like'%" . $searchValue . "%' ) ";
	}

	$query = " SELECT tbl_buyer_wishlist.wishlist_id,
					tbl_buyer_master.buyer_id,
					tbl_buyer_master.buyer_name, 
					tbl_buyer_master.ph_num,
					tbl_product_master.product_id,
					tbl_product_master.product_name
				FROM
				tbl_buyer_wishlist
				LEFT JOIN tbl_buyer_master ON tbl_buyer_wishlist.buyer_id  = tbl_buyer_master.buyer_id
				LEFT JOIN tbl_product_master ON tbl_buyer_wishlist.product_id = tbl_product_master.product_id
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
		case "buyer_details":
			$orderBy = " order by tbl_buyer_master.buyer_id " . $columnSortOrder.", tbl_buyer_master.buyer_name ".$columnSortOrder;
			// select * from table order by customer_master.customer_name ASC, customer_master.user_id ASC
			// select * from table order by customer_master.customer_name DESC, customer_master.user_id DESC
			break;
		case "product_name":
			$orderBy = " order by tbl_product_master." . $columnName." ".$columnSortOrder;
			break;
		default:
			$orderBy = "order by tbl_buyer_wishlist." . $columnName." ".$columnSortOrder;
	}

	$empQuery = $query . $searchQuery . " " . $orderBy . " limit " . $row . "," . $rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {
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
		$data[] = array(
			"action" => $action,
			"buyer_details" => '<input type="hidden" class="wishlist_id_' . $i . '" value="' . $row['wishlist_id'] . '" />' . $row['buyer_name'] .' ['. $row['ph_num'] .']',
			"product_name" => $row['product_name'],
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
