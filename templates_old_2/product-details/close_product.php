<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../db/db.php");
include("../../module_function/notification_details.php");

header('Content-Type: application/json');

$response = array(
    'status' => 'error',
    'message' => 'Something went wrong.'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

    if ($product_id > 0 && !empty($reason)) {
        $reason = mysqli_real_escape_string($con, $reason);

        // Begin transaction for safety
        mysqli_begin_transaction($con);

        try {
            // Step 1: Get current product status before updating
            $currentStatusQuery = "SELECT product_status FROM tbl_product_master WHERE product_id = $product_id";
            $currentStatusResult = mysqli_query($con, $currentStatusQuery);
            $currentStatusRow = mysqli_fetch_assoc($currentStatusResult);
            $currentStatus = $currentStatusRow['product_status'] ?? '';

            // Step 2: Update tbl_product_master
$query1 = "UPDATE tbl_product_master 
           SET product_status = 'Completed',
               close_reason = '$reason',
               withdrawal_date = NOW()
           WHERE product_id = $product_id";

            $result1 = mysqli_query($con, $query1);
            if (!$result1) {
                throw new Exception("Error updating tbl_product_master: " . mysqli_error($con));
            }

            // Step 3: Update all matching rows in tbl_user_product_view
            $query2 = "UPDATE tbl_user_product_view 
                       SET deal_status = 'Completed' 
                       WHERE product_id = $product_id";
            $result2 = mysqli_query($con, $query2);
            if (!$result2) {
                throw new Exception("Error updating tbl_user_product_view: " . mysqli_error($con));
            }

            // Step 4: Send notifications to buyers
            $getBuyersQuery = "SELECT DISTINCT buyer_id FROM tbl_user_product_view WHERE product_id = $product_id";
            $buyersResult = mysqli_query($con, $getBuyersQuery);

            if ($buyersResult && mysqli_num_rows($buyersResult) > 0) {
                // Prepare notification content
                $noti_title = "Product Closed";
                $noti_details = "This product has been closed by the seller.";

                // Check for Pickup Scheduled status
                if ($currentStatus === "Pickup Scheduled") {
                    $noti_details = "The seller has withdrawn this post. It is no longer available for pickup.";
                }

                while ($buyer = mysqli_fetch_assoc($buyersResult)) {
                    $noti_to_user_id = $buyer['buyer_id'];
                    $noti_from_user_id = $session_user_code; 
                    $noti_url = $baseUrl . "/product-details/" . $product_id;
                    insertNotificationDetails(); 
                }
            }

            // Step 5: Commit all actions
            mysqli_commit($con);

            $response = array(
                'status' => 'success',
                'message' => 'Product and user deals closed successfully. Buyers notified.',
                'product_id' => $product_id,
                'reason' => $reason
            );
        } catch (Exception $e) {
            mysqli_rollback($con);
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['message'] = 'Missing product ID or reason.';
    }
}

echo json_encode(array($response));
exit;
