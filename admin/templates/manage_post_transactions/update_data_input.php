<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize the input to prevent SQL injection
$view_id = mysqli_real_escape_string($con, $sendData['view_id']);

// Fetch seller data from the database
$dataget = mysqli_query($con, "SELECT 
				tbl_user_product_view.view_id,
				tbl_user_product_view.buyer_id,
				buyer_table.name AS buyer_name,
				buyer_table.ph_num AS buyer_ph_num,
                tbl_user_product_view.assigned_collecter,
				collector_table.name AS collector_name,
				collector_table.ph_num AS collector_ph_num,
                tbl_user_product_view.product_id,
				tbl_product_master.product_name,
				tbl_product_master.quantity_pcs,
				tbl_product_master.quantity_kg,
				tbl_product_master.withdrawal_date,
				tbl_product_master.close_reason,
                tbl_user_product_view.seller_id,
				seller_table.name AS seller_name,
				seller_table.ph_num AS seller_ph_num,
				tbl_user_product_view.view_date,
				tbl_user_product_view.deal_status,
				tbl_user_product_view.purchased_price,
				SUBSTRING_INDEX(tbl_user_product_view.negotiation_amount, ',', -1) AS last_negotiation_amount,
				tbl_user_product_view.negotiation_by,
				tbl_user_product_view.mssg,
				tbl_user_product_view.negotiation_date,
				tbl_user_product_view.accept_date,
				tbl_user_product_view.pickup_date,
				tbl_user_product_view.pickup_time,
				tbl_user_product_view.complete_date
			FROM tbl_user_product_view
			LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
			LEFT JOIN tbl_user_master AS buyer_table ON buyer_table.user_id = tbl_user_product_view.buyer_id
			LEFT JOIN tbl_user_master AS collector_table ON collector_table.user_id = tbl_user_product_view.assigned_collecter
			LEFT JOIN tbl_user_master AS seller_table ON seller_table.user_id = tbl_user_product_view.seller_id
			WHERE tbl_user_product_view.view_id='" . $view_id . "' ");

// Check if data was fetched
if ($data = mysqli_fetch_assoc($dataget)) {
    // Handle case where user_img might be empty

    $buyer_details = $data['buyer_name']." [ ".$data['buyer_ph_num']." ]";
    $collector_details = $data['collector_name']." [ ".$data['collector_ph_num']." ]";
    $seller_details = $data['seller_name']." [ ".$data['seller_ph_num']." ]";

    // Prepare response array
    $response = [
        'view_id' => $data['view_id'],
        'buyer_id' => $data['buyer_id'],
        'buyer_details' => $buyer_details,
        'assigned_collecter' => $data['assigned_collecter'],
        'collector_details' => $collector_details,
        'product_id' => $data['product_id'],
        'quantity_pcs' => $data['quantity_pcs'],
        'withdrawal_date' => $data['withdrawal_date'],
        'quantity_kg' => $data['quantity_kg'],
        'product_name' => $data['product_name'],
        'seller_id' => $data['seller_id'],
        'seller_details' => $seller_details,
        'view_date' => !empty($data['view_date']) ? date('Y-m-d', strtotime($data['view_date'])) : '',
        'deal_status' => $data['deal_status'],
        'purchased_price' => $data['purchased_price'],
        'negotiation_amount' => $data['last_negotiation_amount'],
        'negotiation_by' => $data['negotiation_by'],
        'mssg' => $data['mssg'],
        'widthdraw_reason' => $data['close_reason'],
        'negotiation_date' => $data['negotiation_date'],
        'accept_date' => $data['accept_date'],
        'pickup_date' => $data['pickup_date'],
        'pickup_time' => $data['pickup_time'],
        'complete_date' => (!empty($data['complete_date']) && $data['complete_date'] !== '0000-00-00' && $data['complete_date'] !== '0') ? date('Y-m-d', strtotime($data['complete_date'])) : '',
    ];
} else {
    // Handle case where no data is found
    $response = [
        'error' => 'No Data found with the provided ID'
    ];
}

// Return the response as JSON
echo json_encode($response);
