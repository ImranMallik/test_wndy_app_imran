<?php
include("../db/db.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    // Query to get the in_credit value for the user
    
    
    $credit_query = "SELECT SUM(in_credit) AS total_in_credit FROM db_waste_management.tbl_credit_trans WHERE user_id = '$user_id'";
    $credit_result = mysqli_query($con, $credit_query);
    $credit_data = mysqli_fetch_assoc($credit_result);
    $in_credit = $credit_data['total_in_credit'] ?? 0; 

    // print_r($in_credit);
    // die();

    if ($in_credit > 0) {
        // User has enough credits
        echo json_encode(["status" => "success", "amount" => $in_credit]);
    } else {
        // User does NOT have enough credits
        echo json_encode(["status" => "error", "message" => "Not enough credits", "inamount_credit" => $in_credit]);
    }
    exit;
}

// Invalid request
echo json_encode(["status" => "error", "message" => "Invalid request"]);
?>


<!--  -->

<!--  -->

