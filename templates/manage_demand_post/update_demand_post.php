<?php
include("../db/db.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $demand_post_id = mysqli_real_escape_string($con, $_POST['demand_post_id']);
    $demand_post_name = mysqli_real_escape_string($con, $_POST['demand_post_name']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
       $quantity_pcs      = mysqli_real_escape_string($con, $_POST['quantity_pcs']);
    $quantity_kg       = mysqli_real_escape_string($con, $_POST['quantity_kg']);

    // Update query
    $query = "
        UPDATE tbl_demand_post 
        SET 
            demand_post_name = '$demand_post_name',
            category_id = '$category_id',
            brand = '$brand',
             quantity_pcs = '$quantity_pcs',
            quantity_kg = '$quantity_kg'
        WHERE demand_post_id = '$demand_post_id'
    ";

    if (mysqli_query($con, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }
}
?>
