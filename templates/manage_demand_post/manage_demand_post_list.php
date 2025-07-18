<?php
include("../db/db.php");

$requestData = json_decode(file_get_contents("php://input"), true);

if (isset($requestData['category_id']) && !empty($requestData['category_id'])) {
    $category_id = (int) $requestData['category_id']; // Cast to int for safety

    $query = "
        SELECT 
            dp.demand_post_id, 
            dp.demand_post_name, 
            cm.category_name, 
            dp.brand, 
            dp.quantity_pcs, 
            dp.quantity_kg,
            dp.category_id
        FROM tbl_demand_post dp
        INNER JOIN tbl_category_master cm 
        ON dp.category_id = cm.category_id
        WHERE dp.category_id = '$category_id' AND dp.demand_post_status = 'active'
        ORDER BY dp.demand_post_id DESC
    ";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Prepare quantity display
            $quantityDisplay = '';
            if (!empty($row['quantity_pcs'])) {
                $quantityDisplay = htmlspecialchars($row['quantity_pcs']);
            } elseif (!empty($row['quantity_kg'])) {
                $quantityDisplay = htmlspecialchars($row['quantity_kg']);
            }

            echo '
                <div class="demand-card mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1 fw-bold">' . htmlspecialchars($row['demand_post_name']) . '</h5>
                            <div class="text-secondary small">Category: ' . htmlspecialchars($row['category_name']) . '</div>
                            <div class="text-secondary small">Brand: ' . htmlspecialchars($row['brand']) . '</div>
                            <div class="text-secondary small">Quantity: ' . $quantityDisplay . '</div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <!-- Edit Button -->
                            <a class="bottom-btn btn-sm pb-2" style="background-color:#c17f59 !important; border:none;" href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                onclick="populateEditModal(
                                    ' . $row['demand_post_id'] . ',
                                    \'' . htmlspecialchars($row['demand_post_name'], ENT_QUOTES) . '\',
                                    \'' . htmlspecialchars($row['category_id'], ENT_QUOTES) . '\',
                                    \'' . htmlspecialchars($row['brand'], ENT_QUOTES) . '\',
                                    \'' . htmlspecialchars($row['quantity_pcs'], ENT_QUOTES) . '\',
                                    \'' . htmlspecialchars($row['quantity_kg'], ENT_QUOTES) . '\'
                                )"
                                title="Edit">
                                <i class="bi bi-pencil-square" style="font-size:18px; color:#fff; padding-top:15px;"></i>
                            </a>

                            <!-- Delete Button -->
                            <a class="bottom-btn btn-sm pb-2" style="background-color:#c17f59 !important; border:none;" href="javascript:void(0);" title="Delete" onclick="delete_alert(' . $row['demand_post_id'] . ', event);">
                                <i class="bi bi-trash" style="font-size:18px; color:#fff; padding-top:15px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        echo '<div style="text-align: center; color: #666;">No posts found for the selected category.</div>';
    }
} else {
    echo '<div style="text-align: center; color: red;">Invalid category selected.</div>';
}
