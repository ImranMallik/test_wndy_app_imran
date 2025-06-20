<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);

$product_id = trim(mysqli_real_escape_string($con, $sendData['product_id']));
$baseUrl = trim(mysqli_real_escape_string($con, $sendData['baseUrl']));

// Fetch buyers list and collectors
$fetch_users_query = "SELECT 
                          tbl_product_master.product_id,
                          tbl_user_product_view.buyer_id,
                          tbl_user_product_view.assigned_collecter,
                          tbl_user_product_view.deal_status,
                          tbl_user_product_view.purchased_price,
                          tbl_user_product_view.negotiation_amount,
                          tbl_user_product_view.negotiation_by,
                          tbl_user_product_view.mssg,
                          tbl_user_product_view.negotiation_date,
                          tbl_user_product_view.accept_date,
                          tbl_user_product_view.pickup_date,
                          tbl_user_product_view.complete_date,
                          buyer.name AS buyer_name,
                          buyer.ph_num AS buyer_phone,
                          buyer.user_img AS buyer_img,
                          collector.name AS collector_name,
                          collector.ph_num AS collector_phone
                      FROM tbl_product_master
                      LEFT JOIN tbl_user_product_view ON tbl_product_master.product_id = tbl_user_product_view.product_id
                      LEFT JOIN tbl_user_master AS buyer ON buyer.user_id = tbl_user_product_view.buyer_id
                      LEFT JOIN tbl_user_master AS collector ON collector.user_id = tbl_user_product_view.assigned_collecter
                      WHERE tbl_product_master.product_id = '$product_id'";

$fetch_result = mysqli_query($con, $fetch_users_query);

$fetch_count = mysqli_num_rows($fetch_result);

// Display buyers' information and collectors as cards
if ($fetch_count > 0) {
  $i = 1;

  while ($row = mysqli_fetch_assoc($fetch_result)) {

    $buyer_name = $row['buyer_name'] . ' [ <i class="fas fa-phone-alt text-primary"></i> ' . $row['buyer_phone'] . ']';
    $collector_name = !empty($row['collector_name']) 
        ? $row['collector_name'] . ' [ <i class="fas fa-phone-alt text-primary"></i> ' . $row['collector_phone'] . ' ]' 
        : 'No Collector Assigned';
    $purchased_price = !empty($row['purchased_price']) ? $row['purchased_price'] : '-';
    $negotiation_amount = !empty($row['negotiation_amount']) ? $row['negotiation_amount'] : '-';
    $negotiation_by = !empty($row['negotiation_by']) ? $row['negotiation_by'] : '-';
    $mssg = !empty($row['mssg']) ? $row['mssg'] : '-';
    $negotiation_date = !empty($row['negotiation_date']) ? $row['negotiation_date'] : '-';
    $accept_date = !empty($row['accept_date']) ? $row['accept_date'] : '-';
    $pickup_date = !empty($row['pickup_date']) ? $row['pickup_date'] : '-';
    $complete_date = !empty($row['complete_date']) ? $row['complete_date'] : '-';
    $deal_status = !empty($row['deal_status']) ? $row['deal_status'] : '-';
    $buyer_img = !empty($row['buyer_img']) ? '../upload_content/upload_img/user_img/' . $row['buyer_img'] : '../upload_content/upload_img/user_img/default.png';

    
    // $initial = strtoupper($buyer_name[0]);
    // $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Random color for avatar

    echo '<div class="card mb-3" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
              <div class="d-flex align-items-start mb-3">
                <img src="' . $buyer_img . '" alt="Buyer Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px; border: 1px solid #c1c1c1;">
                <div>
                  <h4 class="card-title">' . $buyer_name . '</h4>
                  <p class="card-text"><strong>Collector:</strong> ' . $collector_name . '</p>
                  <p><strong>Purchased Price:</strong> ' . $purchased_price . '</p>
                  <p><strong>Negotiation Amount:</strong> ' . $negotiation_amount . '</p>
                  <p><strong>Negotiation By:</strong> ' . $negotiation_by . '</p>
                  <p><strong>Message:</strong> ' . $mssg . '</p>
                  <p><strong>Negotiation Date:</strong> ' . $negotiation_date . '</p>
                  <p><strong>Accept Date:</strong> ' . $accept_date . '</p>
                  <p><strong>Pickup Date:</strong> ' . $pickup_date . '</p>
                  <p><strong>Complete Date:</strong> ' . $complete_date . '</p>
                  <p><strong>Deal Status:</strong> ' . $deal_status . '</p>
                </div>
              </div>
            </div>
          </div>';
    $i++;
  }
  if ($fetch_count > 0) {
    echo '<div style="text-align: right; margin-top: 20px;">
            <a href="' . $baseUrl . '/manage_transactional_list/MC_64662383d90fb1684415363/' . $product_id . '" target="_blank">
                <button type="button" class="btn btn-light-primary font-weight-bold desktop_view" id="manageAddressButton">Transactional Table View</button>
            </a>
          </div>';
}
} else {
  echo "<p style='text-align: center; font-size: 20px; color: #555;'>No one has viewed the product 🥺</p>";
}
?>
