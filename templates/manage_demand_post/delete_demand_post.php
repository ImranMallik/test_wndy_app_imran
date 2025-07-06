<?php
include("../db/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $raw = isset($_POST['sendData']) ? $_POST['sendData'] : '';

    if (!empty($raw)) {
        $data = json_decode($raw, true);
        $demand_post_id = isset($data['demand_post_id']) ? intval($data['demand_post_id']) : 0;

        if ($demand_post_id > 0) {
            $stmt = $con->prepare("DELETE FROM tbl_demand_post WHERE demand_post_id = ?");
            $stmt->bind_param("i", $demand_post_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => "Demand post deleted successfully!"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Error deleting post: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => "Invalid demand_post_id"]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "No data received"]);
    }
}
