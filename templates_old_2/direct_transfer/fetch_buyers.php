<?php
include("../db/db.php");
header('Content-Type: application/json');

// Decode JSON data received from POST
if (!isset($_POST['sendData'])) {
    echo json_encode(["error" => "No data received"]);
    exit;
}

$sendData = json_decode($_POST['sendData'], true);
if (!$sendData || !isset($sendData['category_id'])) {
    echo json_encode(["error" => "Invalid data received"]);
    exit;
}

$category_id = mysqli_real_escape_string($con, trim($sendData['category_id']));
if (empty($category_id)) {
    echo json_encode(["error" => "Category ID is required"]);
    exit;
}

$userTypeQuery = "SELECT buyer_type FROM tbl_user_master WHERE user_id = '$session_user_code'";
$userTypeResult = mysqli_query($con, $userTypeQuery);

if (!$userTypeResult || mysqli_num_rows($userTypeResult) === 0) {
    echo json_encode(["error" => "Failed to fetch user type"]);
    exit;
}
$userType = mysqli_fetch_row($userTypeResult)[0];

// Prepare SQL query based on user type
$query = "";
if ($userType === "Scrap Dealer") {
    $query = "
        SELECT DISTINCT um.user_id, um.name
        FROM tbl_user_product_view AS upv
        INNER JOIN tbl_product_master AS pm ON upv.product_id = pm.product_id
        INNER JOIN tbl_user_master AS um ON upv.buyer_id = um.user_id
        WHERE pm.category_id = '$category_id' 
        AND upv.deal_status = 'Completed'
        AND (um.buyer_type = 'Aggregator' OR um.buyer_type = 'Recycler')
        AND um.active = 'Yes'
        AND um.user_id != '$session_user_code';
    ";
} elseif ($userType === "Aggregator" || $userType === "Recycler") {
    $query = "
        SELECT DISTINCT um.user_id, um.name
        FROM tbl_user_product_view AS upv
        INNER JOIN tbl_product_master AS pm ON upv.product_id = pm.product_id
        INNER JOIN tbl_user_master AS um ON upv.buyer_id = um.user_id
        WHERE pm.category_id = '$category_id' 
        AND upv.deal_status = 'Completed'
        AND um.active = 'Yes'
        AND um.user_id != '$session_user_code';
    ";
} else {
    echo json_encode(["error" => "Invalid user type"]);
    exit;
}

// Execute query
$result = mysqli_query($con, $query);

if ($result) {
    $buyers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (empty($buyers)) {
        echo json_encode(["success" => false, "message" => "No buyers found"]);
    } else {
        echo json_encode(["success" => true, "data" => $buyers]);
    }
} else {
    echo json_encode(["error" => "Failed to fetch buyers", "sql_error" => mysqli_error($con)]);
}

exit;
