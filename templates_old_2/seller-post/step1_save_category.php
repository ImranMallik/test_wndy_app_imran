<?php
include("../db/db.php");
// session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $session_user_code;
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $post_id = "POST" . time();
    // print_r($category_id);

 
    $current_timestamp = date('Y-m-d H:i:s'); 

    $query = "INSERT INTO tbl_product_master (
         post_id, user_id, category_id, is_draft, entry_user_code, entry_timestamp, update_timestamp
    ) VALUES (
         '$post_id', '$user_id', '$category_id', 1, '$user_id', '$current_timestamp', '$current_timestamp'
    )";
    

   

if (mysqli_query($con, $query)) {
    echo json_encode(["status" => "Draft", "post_id" => $post_id]);
} else {
    echo json_encode(["status" => "Error", "error" => mysqli_error($con)]);
}

}
