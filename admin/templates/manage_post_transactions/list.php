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
	$seller_id = mysqli_real_escape_string($con, $_POST['seller_id']);
	$category_id = mysqli_real_escape_string($con, $_POST['category_id']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
	$buyer_id = mysqli_real_escape_string($con, $_POST['buyer_id']);
	$seller_pincode = mysqli_real_escape_string($con, $_POST['seller_pincode']);
	$buyer_pincode = mysqli_real_escape_string($con, $_POST['buyer_pincode']);
	$product_status = mysqli_real_escape_string($con, $_POST['product_status']);
	$seller_product_status = mysqli_real_escape_string($con, $_POST['seller_post_status']);
	$from_date = mysqli_real_escape_string($con, $_POST['from_date'] ?? '');
$to_date = mysqli_real_escape_string($con, $_POST['to_date'] ?? '');

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
	tbl_product_master.sale_price,
	tbl_product_master.close_reason,
	tbl_product_master.closure_remark,
	tbl_product_master.withdrawal_date,
	post_counts.no_of_post, 
	tbl_product_master.address_id,
	tbl_product_master.post_id,
	tbl_category_master.category_name,
	tbl_product_master.description,
	tbl_product_master.brand,
	tbl_product_master.product_status,
	tbl_product_master.quantity_pcs,
	tbl_product_master.quantity_kg,
	seller_table.name AS seller_name,
	seller_table.ph_num AS seller_ph_num,
	tbl_user_product_view.view_date,
	tbl_user_product_view.deal_status,
	tbl_user_product_view.purchased_price,
	tbl_user_product_view.negotiation_amount,
	SUBSTRING_INDEX(tbl_user_product_view.negotiation_amount, ',', -1) AS last_negotiation_amount,
    tbl_user_product_view.negotiation_by,
	tbl_user_product_view.negotiation_by,
	tbl_user_product_view.mssg,
	tbl_user_product_view.negotiation_date,
	tbl_user_product_view.accept_date,
	tbl_user_product_view.buyer_action_time,
	tbl_user_product_view.pickup_date,
	tbl_product_file.file_name,
	tbl_user_product_view.pickup_time,
	tbl_user_product_view.complete_date,
	tbl_user_product_view.deal_status_history,
	tbl_user_product_view.assigned_date_for_collector,
	-- status_updates.product_status_history AS product_status_history,

	-- Latest messages
	seller_msg_hist.brid_message AS seller_message,
	buyer_msg_hist.message AS buyer_message,

	-- Product address
	product_address.country AS product_country,
	product_address.state AS product_state,
	product_address.city AS product_city,
	product_address.landmark AS product_landmark,
	product_address.pincode AS product_pincode,

	-- Buyer address
	buyer_address.country AS buyer_country,
	buyer_address.state AS buyer_state,
	buyer_address.city AS buyer_city,
	buyer_address.landmark AS buyer_landmark,
	buyer_address.pincode AS buyer_pincode,

	tbl_user_product_view.used_credits,
	tbl_user_product_view.product_id,
	tbl_user_product_view.entry_timestamp,
	buyer_rating.rating AS buyer_rating_for_seller,
	seller_rating.rating AS seller_rating_for_buyer

FROM tbl_user_product_view

LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
LEFT JOIN tbl_address_master AS product_address ON tbl_product_master.address_id = product_address.address_id
LEFT JOIN tbl_address_master AS buyer_address ON tbl_user_product_view.buyer_id = buyer_address.user_id
LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
LEFT JOIN tbl_user_master AS buyer_table ON buyer_table.user_id = tbl_user_product_view.buyer_id
LEFT JOIN tbl_user_master AS collector_table ON collector_table.user_id = tbl_user_product_view.assigned_collecter
LEFT JOIN tbl_user_master AS seller_table ON seller_table.user_id = tbl_user_product_view.seller_id

LEFT JOIN (
	SELECT 
		user_id, 
		COUNT(*) AS no_of_post
	FROM tbl_product_master
	GROUP BY user_id
) AS post_counts ON post_counts.user_id = seller_table.user_id

LEFT JOIN tbl_ratings AS buyer_rating 
	ON buyer_rating.view_id = tbl_user_product_view.view_id 
	AND buyer_rating.rating_from = 'Buyer'

LEFT JOIN tbl_ratings AS seller_rating 
	ON seller_rating.view_id = tbl_user_product_view.view_id 
	AND seller_rating.rating_from = 'Seller'


	-- GEt image

-- LEFT JOIN (
--     SELECT pf.product_id, pf.file_name
--     FROM tbl_product_file pf
--     INNER JOIN (
--         SELECT product_id, MIN(product_file_id) AS min_id
--         FROM tbl_product_file
--         WHERE file_type = 'Photo' AND active = 'Yes'
--         GROUP BY product_id
--     ) AS first_files ON pf.product_id = first_files.product_id AND pf.product_file_id = first_files.min_id
-- ) AS tbl_product_file ON tbl_product_file.product_id = tbl_user_product_view.product_id

LEFT JOIN (
    SELECT pf.product_id, pf.file_name
    FROM tbl_product_file pf
    INNER JOIN (
        SELECT product_id, MIN(product_file_id) AS min_id
        FROM tbl_product_file
        WHERE file_type = 'Photo' AND active = 'Yes'
        GROUP BY product_id
    ) first_photo ON pf.product_id = first_photo.product_id AND pf.product_file_id = first_photo.min_id
) AS tbl_product_file ON tbl_product_file.product_id = tbl_user_product_view.product_id




-- Latest message by seller
LEFT JOIN (
	SELECT mh1.*
	FROM message_history mh1
	INNER JOIN (
		SELECT product_id, user_id, MAX(created_at) AS max_time
		FROM message_history
		GROUP BY product_id, user_id
	) mh2 ON mh1.product_id = mh2.product_id AND mh1.user_id = mh2.user_id AND mh1.created_at = mh2.max_time
	JOIN tbl_user_master um ON mh1.user_id = um.user_id
	WHERE LOWER(TRIM(um.user_type)) = 'seller'
) AS seller_msg_hist 
	ON seller_msg_hist.product_id = tbl_user_product_view.product_id 
	AND seller_msg_hist.user_id = tbl_user_product_view.seller_id

-- Latest message by buyer
LEFT JOIN (
	SELECT mh1.*
	FROM message_history mh1
	INNER JOIN (
		SELECT product_id, user_id, MAX(created_at) AS max_time
		FROM message_history
		GROUP BY product_id, user_id
	) mh2 ON mh1.product_id = mh2.product_id AND mh1.user_id = mh2.user_id AND mh1.created_at = mh2.max_time
	JOIN tbl_user_master um ON mh1.user_id = um.user_id
	WHERE LOWER(TRIM(um.user_type)) = 'buyer'
) AS buyer_msg_hist 
	ON buyer_msg_hist.product_id = tbl_user_product_view.product_id 
	AND buyer_msg_hist.user_id = tbl_user_product_view.buyer_id





WHERE 1
";


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
	if ($buyer_id != "") {
		$query .= " AND tbl_user_product_view.buyer_id = '" . $buyer_id . "'";
	}
	if ($seller_pincode != "") {
		$query .= " AND tbl_user_product_view.seller_id = '" . $seller_pincode . "'";
	}
	if ($buyer_pincode != "") {
		$query .= " AND tbl_user_product_view.buyer_id = '" . $buyer_pincode . "'";
	}
	if ($product_status != "") {
		$query .= " AND tbl_user_product_view.deal_status = '" . $product_status . "'";
	}
	if ($seller_product_status != "") {
		// $query .= " AND tbl_user_product_view.deal_status = '" . $seller_product_status . "'";
		 $query .= " AND tbl_product_master.product_status = '" . $seller_product_status . "'";
	}

	if ($from_date && $to_date) {
    $query .= " AND DATE(tbl_user_product_view.entry_timestamp) BETWEEN '$from_date' AND '$to_date'";
} elseif ($from_date) {
    $query .= " AND DATE(tbl_user_product_view.entry_timestamp) >= '$from_date'";
} elseif ($to_date) {
    $query .= " AND DATE(tbl_user_product_view.entry_timestamp) <= '$to_date'";
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

	$raw_deal_status = isset($row['deal_status']) ? trim(strtolower($row['deal_status'])) : '';
$close_reason_present = !empty($row['close_reason']);

if ($close_reason_present || $raw_deal_status === 'withdraw') {
    $deal_status = '<span class="label font-weight-bold label-lg label-inline bg-danger" style="color: white;">Withdrawal</span>';
} else {
    switch ($raw_deal_status) {
        case 'credit used':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: purple; color: white;">Credit Used</span>';
            break;
        case 'under negotiation':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: orange; color: white;">Under Negotiation</span>';
            break;
        case 'offer accepted':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #006400; color: white;">Offer Accepted</span>';
            break;
        case 'pickup scheduled':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: blue; color: white;">Pickup Scheduled</span>';
            break;
        case 'offer rejected':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: red; color: white;">Offer Rejected</span>';
            break;
        case 'completed':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: green; color: white;">Completed</span>';
            break;
        case 'third-party transaction':
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: rgb(43, 39, 177); color:white;">Third-Party Transaction</span>';
            break;
        default:
            $deal_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: gray; color: white;">Unknown</span>';
            break;
    }
}


switch ($row['product_status']) {
	case "Active":
		$product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #FFD700; color: white;">Active</span>';
		break;
	case "Withdraw":
		$product_status = '<span class="label font-weight-bold label-lg label-inline bg-danger" style="color: white;">Withdrawal</span>';
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
	default:
		$product_status = '<span class="label font-weight-bold label-lg label-inline" style="background-color: #999; color: white;">Unknown</span>';
}



		$post_id = '';
		if ($row['post_id'] != "") {
			$post_id = '<span class="label font-weight-bold label-lg  label-primary label-inline">' . $row['post_id'] . '</span>';
		}


$seller_details = !empty($row['seller_name']) ? $row['seller_name'] : ' ';
$seller_number = !empty($row['seller_ph_num']) ? $row['seller_ph_num'] : ' ';
$buyer_details = !empty($row['buyer_name']) ? $row['buyer_name'] : ' ';
$buyer_number = !empty($row['buyer_ph_num']) ? $row['buyer_ph_num'] : ' ';
$collector_details = !empty($row['collector_name']) ? $row['collector_name'] : ' ';
$collector_number = !empty($row['collector_ph_num']) ? $row['collector_ph_num'] : ' ';
		
// Seller address
$seller_addressParts = [
    (!empty($row['product_landmark']) && strtolower(trim($row['product_landmark'])) !== 'no landmark') ? $row['product_landmark'] : ' ',
    !empty($row['product_city']) ? $row['product_city'] : ' ',
    !empty($row['product_state']) ? $row['product_state'] : ' ',
    !empty($row['product_country']) ? $row['product_country'] : ' ',
];

// Buyer address
$buyer_addressParts = [
    (!empty($row['buyer_landmark']) && strtolower(trim($row['buyer_landmark'])) !== 'no landmark') ? $row['buyer_landmark'] : ' ',
    !empty($row['buyer_city']) ? $row['buyer_city'] : ' ',
    !empty($row['buyer_state']) ? $row['buyer_state'] : ' ',
    !empty($row['buyer_country']) ? $row['buyer_country'] : ' ',
];

// Build final addresses and clean up
$seller_address = trim(preg_replace('/\s*,\s*/', ', ', implode(', ', $seller_addressParts)), ', ');
$buyer_address = trim(preg_replace('/\s*,\s*/', ', ', implode(', ', $buyer_addressParts)), ', ');


$buyer_message  = !empty($row['buyer_message']) ? "Buyer → " . $row['buyer_message'] : '';
$seller_message = !empty($row['seller_message']) ? "Seller → " . $row['mssg'] : '';

$combined_message = '';

if (!empty($buyer_message) && !empty($seller_message)) {
    $combined_message = $buyer_message . "\n" . $seller_message;
} elseif (!empty($buyer_message)) {
    $combined_message = $buyer_message;
} elseif (!empty($seller_message)) {
    $combined_message = $seller_message;
}




// Some Data Date with AM:PM Format------------
$assignedDateRaw = $row['assigned_date_for_collector'];
$assignedDateFormatted = !empty($row['assigned_date_for_collector']) ? date("M d, Y h:i A", strtotime($assignedDateRaw)) : ' ';


$negotiation_amount = explode(',', $row['negotiation_amount']);

$buyer_negotiation_price = isset($negotiation_amount[0]) && $negotiation_amount[0] !== '' ? $negotiation_amount[0] : '';
$seller_negotiation_price = isset($negotiation_amount[1]) && $negotiation_amount[1] !== '' ? $negotiation_amount[1] : '';

$negotiation_price_history = '';

if (!empty($buyer_negotiation_price)) {
    $negotiation_price_history .= "Buyer Negotiation Price: " . $buyer_negotiation_price;
}

if (!empty($seller_negotiation_price)) {
    // Add newline if buyer price already exists
    if (!empty($negotiation_price_history)) {
        $negotiation_price_history .= "\n";
    }
    $negotiation_price_history .= "Seller Negotiation Price: " . $seller_negotiation_price;
}









// Calculate duration in days between view_date and complete_date
$duration_days = '';

if (!empty($row['view_date']) && !empty($row['complete_date'])) {
    $viewDate = strtotime($row['view_date']);
    $completeDate = strtotime($row['complete_date']);

    
    if ($completeDate > $viewDate) {
        $diffInSeconds = $completeDate - $viewDate;

        
        $days = floor($diffInSeconds / (60 * 60 * 24));
        $hours = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($diffInSeconds % (60 * 60)) / 60);

        
        if ($days > 0) {
            $duration_days = $days . " days " . $hours . " hrs " . $minutes . " min";
        } else {
            $duration_days = $hours . " hrs " . $minutes . " min";
        }
    } else {
        $duration_days = " ";
    }
} else {
    $duration_days = " ";
}



 $status_history_raw = $row['deal_status_history'] ?? '';
$formatted_history = '';
$plain_history = '';

if (!empty($status_history_raw)) {
    $status_data = json_decode($status_history_raw, true);

    $formatted_history = '<ul style="padding-left: 18px; margin: 0;">';

    foreach ($status_data as $entry) {
        $status = trim($entry['status']);
        $time = trim($entry['time']);

        $formatted_history .= '<li style="margin-bottom: 4px;">
            <strong style="color:#333;">' . htmlspecialchars($status) . '</strong>
            <span style="display:block; font-size:11px; color:#777;">' . htmlspecialchars($time) . '</span>
        </li>';

        $plain_history .= $status . ' - ' . $time . "\n";
    }

    $formatted_history .= '</ul>';
}
















$data[] = array(
    "entry_timestamp" => $row['entry_timestamp'],
    "post_id" => $post_id,
    "seller_details" => $seller_details,
    "seller_number" => $seller_number,
    "seller_address" => $seller_address,
    "seller_pincode" => $row['product_pincode'],
    "category_name" => $row['category_name'],
    "product_name" => $row['product_name'],
	"product_image" => !empty($row['file_name']) 
    ? '<img src="../upload_content/upload_img/product_img/' . htmlspecialchars($row['file_name']) . '" style="height:50px;width:auto;" />'
    : 'No Image',


    "description" => $row['description'],
    "brand" => $row['brand'],
    "quantity_kg" => $row['quantity_kg'],
    "quantity_pcs" => $row['quantity_pcs']  == 0 ? '' : $row['quantity_pcs'],
    "product_price" => $row['sale_price'],
    "product_status" => $product_status,
    "closure_remark" => $row['closure_remark'],
	 "withdrawal_date" => ($row['withdrawal_date'] == '0000-00-00' || $row['withdrawal_date'] == '0') ? '' : $row['withdrawal_date'],
    "close_reason" => $row['close_reason'],
    "no_of_post" => $row['no_of_post'],
    "buyer_action_time" => $row['buyer_action_time'],
    "product_status_history" => $formatted_history,
    "buyer_details" => $buyer_details,
    "buyer_number" => $buyer_number,
    "buyer_address" => $buyer_address,
    "buyer_pincode" => $row['buyer_pincode'],
    "trans_id" => $row['trans_id'],
    "deal_status" => $deal_status,
    "used_credits" => $row['used_credits'],
   "purchased_price" => ($row['purchased_price'] == 0) ? '' : (intval($row['purchased_price']) == $row['purchased_price'] ? intval($row['purchased_price']) : $row['purchased_price']),

   "negotiation_amount" => $row['last_negotiation_amount'],

    "mssg" => $row['mssg'],
    "message_history" => $combined_message !== '' ? $combined_message : ' ',
	"negotiation_price_history" => $negotiation_price_history,
    "negotiation_by" => $row['negotiation_by'],
    "negotiation_date" => ($row['negotiation_date'] == '0000-00-00' || $row['negotiation_date'] == '0') ? '' : $row['negotiation_date'],
    "accept_date" => ($row['accept_date'] == '0000-00-00' || $row['accept_date'] == '0') ? '' : $row['accept_date'],
    "pickup_date" => ($row['pickup_date'] == '0000-00-00' || $row['pickup_date'] == '0') ? '' : $row['pickup_date'],
   "complete_date" => (
    !empty($row['complete_date']) && 
    $row['complete_date'] !== '0000-00-00' && 
    $row['complete_date'] !== '0'
) ? date('Y-m-d', strtotime($row['complete_date'])) : '',
    "duration_for_post_completion" => $duration_days,
    "collector_details" => $collector_details,
    "assigned_date_for_collector" => $assignedDateFormatted,
    "view_date" => !empty($row['view_date']) ? date('Y-m-d', strtotime($row['view_date'])) : '',
    "seller_rating_for_buyer" => $row['seller_rating_for_buyer'],
    "buyer_rating_for_seller" => $row['buyer_rating_for_seller'],
    "action" => $action
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
