<?php
include("../db/db.php"); // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $demand_post_id = isset($_POST['demand_post_id']) ? $_POST['demand_post_id'] : '';

    if (!empty($demand_post_id)) {
        // Prepared statement
        $stmt = $con->prepare("DELETE FROM tbl_demand_post WHERE demand_post_id = ?");
        $stmt->bind_param("i", $demand_post_id); // "i" indicates an integer

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => "Demand post deleted successfully!"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Error deleting post: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => "Invalid request: demand_post_id is missing or empty"]);
    }
}
?>
