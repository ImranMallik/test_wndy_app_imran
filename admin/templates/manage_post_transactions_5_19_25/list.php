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

	$seller_id = mysqli_real_escape_string($con, $_POST['seller_id']);
	$category_id = mysqli_real_escape_string($con, $_POST['category_id']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);

	$searchQuery = "";
	if ($searchValue != '') {
		$searchQuery = " AND (
			tbl_user_product_view.trans_id LIKE '%" . $searchValue . "%' OR
			buyer_table.name LIKE '%" . $searchValue . "%' OR
			buyer_table.ph_num LIKE '%" . $searchValue . "%' OR
			collector_table.name LIKE '%" . $searchValue . "%' OR
			collector_table.ph_num LIKE '%" . $searchValue . "%' OR
			tbl_product_master.product_name LIKE '%" . $searchValue . "%' OR
			tbl_product_master.post_id LIKE '%" . $searchValue . "%' OR
			tbl_category_master.category_name LIKE '%" . $searchValue . "%' OR
			seller_table.name LIKE '%" . $searchValue . "%' OR
			seller_table.ph_num LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.view_date LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.deal_status LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.purchased_price LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.negotiation_amount LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.negotiation_by LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.mssg LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.negotiation_date LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.accept_date LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.pickup_date LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.pickup_time LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.complete_date LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.used_credits LIKE '%" . $searchValue . "%' OR
			tbl_user_product_view.entry_timestamp LIKE '%" . $searchValue . "%' 
		) ";
	}


	$query = "SELECT 
				tbl_user_product_view.view_id,
				tbl_user_product_view.trans_id,
				buyer_table.name AS buyer_name,
				buyer_table.ph_num AS buyer_ph_num,
				collector_table.name AS collector_name,
				collector_table.ph_num AS collector_ph_num,
				tbl_product_master.product_name,
				tbl_product_master.close_reason,
				tbl_product_master.post_id,
				tbl_category_master.category_name,
				tbl_product_master.description,
				tbl_product_master.brand,
				tbl_product_master.quantity,
				tbl_product_master.quantity_unit,
				seller_table.name AS seller_name,
				seller_table.ph_num AS seller_ph_num,
				tbl_user_product_view.view_date,
				tbl_user_product_view.deal_status,
				tbl_user_product_view.purchased_price,
				tbl_user_product_view.negotiation_amount,
				tbl_user_product_view.negotiation_by,
				tbl_user_product_view.mssg,
				tbl_user_product_view.negotiation_date,
				tbl_user_product_view.accept_date,
				tbl_user_product_view.pickup_date,
				tbl_user_product_view.pickup_time,
				tbl_user_product_view.complete_date,
				tbl_user_product_view.used_credits,
				tbl_user_product_view.product_id,
				tbl_user_product_view.entry_timestamp,
				buyer_rating.rating AS buyer_rating_for_seller,
				seller_rating.rating AS seller_rating_for_buyer
			FROM tbl_user_product_view
			LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
			LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
			LEFT JOIN tbl_user_master AS buyer_table ON buyer_table.user_id = tbl_user_product_view.buyer_id
			LEFT JOIN tbl_user_master AS collector_table ON collector_table.user_id = tbl_user_product_view.assigned_collecter
			LEFT JOIN tbl_user_master AS seller_table ON seller_table.user_id = tbl_user_product_view.seller_id
			LEFT JOIN tbl_ratings AS buyer_rating 
			ON buyer_rating.view_id = tbl_user_product_view.view_id 
			AND buyer_rating.rating_from = 'Buyer'
			LEFT JOIN tbl_ratings AS seller_rating 
				ON seller_rating.view_id = tbl_user_product_view.view_id 
				AND seller_rating.rating_from = 'Seller'
			WHERE 1";

	// Date filters
	if ($seller_id != "") {
		$query .= " AND tbl_user_product_view.seller_id = '" . $seller_id . "'";
	}
	if ($category_id != "") {
		$query .= " AND tbl_category_master.category_id = '" . $category_id . "'";
	}
	if ($product_id != "") {
		$query .= " AND tbl_user_product_view.product_id = '" . $product_id . "'";
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
		case "seller_details":
			$orderBy = "order by seller_table.name " . $columnSortOrder . ", seller_table.ph_num " . $columnSortOrder;
			break;
		case "product_name":
			$orderBy = "order by tbl_product_master." . $columnName . " " . $columnSortOrder;
			break;
		case "category_name":
			$orderBy = "order by tbl_category_master." . $columnName . " " . $columnSortOrder;
			break;
		case "buyer_details":
			$orderBy = "order by buyer_table.name " . $columnSortOrder . ", buyer_table.ph_num " . $columnSortOrder;
			break;
		case "collector_details":
			$orderBy = "order by collector_table.name " . $columnSortOrder . ", collector_table.ph_num " . $columnSortOrder;
			break;

		default:
			$orderBy = "order by tbl_user_product_view." . $columnName . " " . $columnSortOrder;
			break;
	}


	$empQuery = $query . $searchQuery . " " . $orderBy;
	if ($rowperpage != -1) {
		$empQuery .= " limit " . $row . "," . $rowperpage;
	}

	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		$edit = '';
		if ($edit_permission == "Yes") {
			$edit = 'onclick="update_data(' . "'" . $row['view_id'] . "'" . ')"';
		}

		$delete = '';
		if ($delete_permissioin == "Yes") {
			$delete = 'onclick="show_del_data_confirm_box(' . "'" . $row['view_id'] . "'" . ')"';
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

	if (!empty($row['close_reason'])) {
	$deal_status = '<span class="label font-weight-bold label-lg label-inline bg-danger" style="color: white;">Withdrawal</span>';
} else {
	switch ($row['deal_status']) {
		case 'Credit Used':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: purple; color: white;">Credit Used</span>';
			break;
		case 'Under Negotiation':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: orange; color: white;">Under Negotiation</span>';
			break;
		case 'Offer Accepted':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #006400; color: white;">Offer Accepted</span>';
			break;
		case 'Pickup Scheduled':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: blue; color: white;">Pickup Scheduled</span>';
			break;
		case 'Offer Rejected':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: red; color: white;">Offer Rejected</span>';
			break;
		case 'Completed':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: green; color: white;">Completed</span>';
			break;
		case 'Third-Party Transaction':
			$deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: rgb(43, 39, 177); color:white;">Third-Party Transaction</span>';
			break;
		default:
			$deal_status = '';
			break;
	}
}


		$post_id = '';
		if ($row['post_id'] != "") {
			$post_id = '<span class="label font-weight-bold label-lg  label-primary label-inline">' . $row['post_id'] . '</span>';
		}


		$seller_details = !empty($row['seller_name']) ? $row['seller_name'] . "<br /> [" . $row['seller_ph_num'] . "]" : '-';
		$buyer_details = !empty($row['buyer_name']) ? $row['buyer_name'] . "<br /> [" . $row['buyer_ph_num'] . "] " : '-';
		$collector_details = !empty($row['collector_name']) ? $row['collector_name'] . "<br /> [" . $row['collector_ph_num'] . "] " : '-';

		$data[] = array(
			"entry_timestamp" => $row['entry_timestamp'],
			"trans_id" => $row['trans_id'],
			"seller_details" => $seller_details,
			"product_name" => $row['product_name'],
			"post_id" => $post_id,
			"category_name" => $row['category_name'],
			"buyer_details" => $buyer_details,
			"collector_details" => $collector_details,
			"view_date" => $row['view_date'],
			"deal_status" => $deal_status,
			"purchased_price" => $row['purchased_price'],
			"negotiation_amount" => $row['negotiation_amount'],
			"negotiation_by" => $row['negotiation_by'],
			"mssg" => $row['mssg'],
			"negotiation_date" => $row['negotiation_date'],
			"accept_date" => $row['accept_date'],
			"pickup_date" => $row['pickup_date'],
			"pickup_time" => $row['pickup_time'],
			"complete_date" => $row['complete_date'],
			"used_credits" => $row['used_credits'],
			"description"=>$row['description'],
			"brand"=>$row['brand'],
			"quantity"=>$row['quantity'],
			"quantity_unit"=>$row['quantity_unit'],
			"buyer_rating_for_seller" => $row['buyer_rating_for_seller'],
			"seller_rating_for_buyer" => $row['seller_rating_for_buyer'],
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
