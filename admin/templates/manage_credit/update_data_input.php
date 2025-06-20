<?php
include("../db/db.php");

// Decode the incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize the input to prevent SQL injection
$option_id = mysqli_real_escape_string($con, $sendData['option_id']);

// Fetch seller data from the database
$dataget = mysqli_query($con,"SELECT 
        tbl_credit_option.option_id,
        tbl_credit_option.credit,
        tbl_credit_option.purchase_amount,
        tbl_credit_option.active
    FROM tbl_credit_option
    WHERE tbl_credit_option.option_id = '$option_id'");

// Check if data was fetched
if ($data = mysqli_fetch_assoc($dataget)) {
    
    // Prepare response array
    $response = [
        'option_id' => $data['option_id'],
        'credit' => $data['credit'],
        'purchase_amount' => $data['purchase_amount'],
        'active' => $data['active'],
    ];
} else {
    // Handle case where no data is found
    $response = [
        'error' => 'No Credit ID found with the provided ID'
    ];
}

// Return the response as JSON
echo json_encode($response);
?>
