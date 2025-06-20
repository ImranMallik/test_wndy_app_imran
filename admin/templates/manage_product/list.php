<?php
include("../db/db.php");

if ($view_permission == "Yes") {

	## Read value
	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length']; 
	$columnIndex = $_POST['order'][0]['column']; 
	$columnName = $_POST['columns'][$columnIndex]['data']; 
	$columnSortOrder = $_POST['order'][0]['dir']; 
	$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); 
		$from_date = mysqli_real_escape_string($con, $_POST['from_date'] ?? '');
$to_date = mysqli_real_escape_string($con, $_POST['to_date'] ?? '');

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
	tbl_product_file.file_name,
	tbl_product_master.quantity,
	tbl_product_master.sale_price,
	tbl_product_master.closure_remark,
	tbl_product_master.product_status, 
	tbl_product_master.withdrawal_date,
	tbl_product_master.quantity_pcs,
	tbl_product_master.quantity_kg,
	tbl_product_master.active,
	tbl_product_master.is_draft,
	tbl_product_master.close_reason,
	tbl_product_master.entry_timestamp,
	post_counts.no_of_post,
(SELECT COALESCE(
        CASE 
            WHEN purchased_price IS NOT NULL AND purchased_price != '' AND purchased_price != '0' THEN purchased_price 
            ELSE NULL 
        END, 
        '') 
     FROM tbl_user_product_view 
     WHERE product_id = tbl_product_master.product_id 
     ORDER BY entry_timestamp DESC LIMIT 1) AS purchased_price 


FROM tbl_product_master
LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id 
LEFT JOIN tbl_user_product_view ON tbl_user_product_view.product_id = tbl_product_master.product_id 
LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_product_master.user_id
LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id 

-- ✅ Move this JOIN above WHERE
LEFT JOIN (
	SELECT pf.product_id, pf.file_name
	FROM tbl_product_file pf
	INNER JOIN (
		SELECT product_id, MIN(product_file_id) AS min_id
		FROM tbl_product_file
		WHERE file_type = 'Photo' AND active = 'Yes'
		GROUP BY product_id
	) first_photo ON pf.product_id = first_photo.product_id AND pf.product_file_id = first_photo.min_id
) AS tbl_product_file ON tbl_product_file.product_id = tbl_product_master.product_id
LEFT JOIN (
	SELECT user_id, COUNT(*) AS no_of_post
	FROM tbl_product_master
	GROUP BY user_id
) AS post_counts ON post_counts.user_id = tbl_product_master.user_id

WHERE tbl_user_master.user_type = 'Seller'
";


if ($from_date && $to_date) {
    $query .= " AND DATE(tbl_product_master.entry_timestamp) BETWEEN '$from_date' AND '$to_date'";
} elseif ($from_date) {
    $query .= " AND DATE(tbl_product_master.entry_timestamp) >= '$from_date'";
} elseif ($to_date) {
    $query .= " AND DATE(tbl_product_master.entry_timestamp) <= '$to_date'";
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

if ($rowperpage == -1) {
		$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder;
	} else {
		$empQuery = $query . $searchQuery . " " . $orderBy . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	}
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
} else {
    if (!empty($row['close_reason'])) {
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
                break;
            case "Withdraw":
               $product_status = '<span class="label font-weight-bold label-lg label-inline bg-danger" style="color: white;">Withdrawal</span>';
                // Optional update if needed
                $product_id = $row['product_id'];
                $updateQuery = "UPDATE tbl_user_product_view SET deal_status = 'Third-Party Transaction' WHERE product_id='" . $product_id . "'";
                mysqli_query($con, $updateQuery);
                break;
        }
    }
}


$duration_days = '';
$product_id = $row['product_id'];

$duration_sql = mysqli_query($con, "
    SELECT view_date, complete_date 
    FROM tbl_user_product_view 
    WHERE product_id = '$product_id' 
      AND view_date IS NOT NULL AND view_date != '0000-00-00 00:00:00'
      AND complete_date IS NOT NULL AND complete_date != '0000-00-00 00:00:00'
    ORDER BY complete_date DESC LIMIT 1
");

if ($duration_data = mysqli_fetch_assoc($duration_sql)) {
    $viewDate = strtotime($duration_data['view_date']);
    $completeDate = strtotime($duration_data['complete_date']);

    if ($completeDate > $viewDate) {
        $diffInSeconds = $completeDate - $viewDate;

        $days = floor($diffInSeconds / (60 * 60 * 24));
        $hours = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($diffInSeconds % (60 * 60)) / 60);

        if ($days > 0) {
            $duration_days = $days . " days " . $hours . " hrs " . $minutes . " min";
        } elseif ($hours > 0) {
            $duration_days = $hours . " hrs " . $minutes . " min";
        } else {
            $duration_days = $minutes . " min";
        }
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
			"product_image" => !empty($row['file_name']) 
         ? '<img src="../upload_content/upload_img/product_img/' . htmlspecialchars($row['file_name']) . '" style="height:50px;width:auto;" />'
         : 'No Image',
			"description" => $row['description'],
			"brand" => $row['brand'],
			"quantity_kg" => $row['quantity_kg'],
			"quantity_pcs" => $row['quantity_pcs'] == 0 ? ' ' : $row['quantity_pcs'],
			"sale_price" => $row['sale_price'] == 0 ? '' :  $row['sale_price'],
			"product_status" => $product_status,
			"closure_remark"=>$row['closure_remark'],
			 "withdrawal_date" => ($row['withdrawal_date'] == '0000-00-00' || $row['withdrawal_date'] == '0') ? '' : $row['withdrawal_date'],
			  "purchased_price" => $row['purchased_price'],
			  "reason" => $row['close_reason'],
			"no_of_post" => $row['no_of_post'],
			"duration_days" => $duration_days,
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
