<?php
include("../db/db.php");

$requestData = json_decode(file_get_contents("php://input"), true);

if (isset($requestData['category_id']) && !empty($requestData['category_id'])) {
    $category_id = $requestData['category_id'];

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
            echo '
             <div class="product-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 10px; background-color: #fff; display: flex; justify-content: space-between; align-items: center;">
                   <div>
                 <strong style="font-size: 17px; color: #333;">' . htmlspecialchars($row['demand_post_name']) . '</strong><br>
                 <small style="font-size: 14px;">Category: ' . htmlspecialchars($row['category_name']) . '</small><br>
                 <small style="font-size: 14px;">Brand: ' . htmlspecialchars($row['brand']) . '</small><br>
                 <small style="font-size: 14px;">Quantity: ' . 
            (!empty($row['quantity_pcs']) 
                ? htmlspecialchars($row['quantity_pcs']) 
                : (!empty($row['quantity_kg']) 
                    ? htmlspecialchars($row['quantity_kg']) 
                    : ' '
                  )
            ) . 
         '</small>
               </div>

                    <div style="display: flex; gap: 10px;">
                        <!-- Edit Button -->
                       <a href="#" 
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
                    style="color: #2f415d; margin-right: 10px;" 
                    title="Edit">
                    <img src="frontend_assets/img-icon/edit.png" alt="Edit" style="width: 24px; height: 24px;">
                </a>

                        <!-- Delete Button -->
                        <a href="javascript:void(0);" style="color: #ff4d4d;" title="Delete" onclick="delete_alert(' . $row['demand_post_id'] . ', event);">
                            <img src="frontend_assets/img-icon/bin.png" alt="Delete" style="width: 24px; height: 24px;">
                        </a>
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
?>
