<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
?>

<div class="product-listview-loadmore" id="product-listview-loadmore" style="padding: 20px; background-color: #f8f9fa; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <div class="row">
        <!-- Filter Dropdown -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" style="font-weight: bold; color: #333; font-size: 16px;">
                    <strong>Filter Your Post Category</strong>
                </label>
                <select class="form-control" id="category_id" onchange="get_demand_post_list_category()" required>
    <option value="">Choose Category</option>
    <?php
    // Fetch unique category_id values from tbl_demand_post and join with tbl_category_master
    $fetchData = mysqli_query($con, "
        SELECT DISTINCT cm.category_id, cm.category_name 
        FROM tbl_category_master cm
        INNER JOIN tbl_demand_post dp 
        ON cm.category_id = dp.category_id
    ");

    while ($row = mysqli_fetch_array($fetchData)) {
        echo "<option value='" . $row['category_id'] . "'>" . htmlspecialchars($row['category_name']) . "</option>";
    }
    ?>
</select>

                <div id="errorToast" style="color: red; font-size: 12px; display: none; padding: 3px 0;">
                    Please select a category.
                </div>
            </div>
        </div>
    </div>

    <!-- Product Cards -->
    <div class="product-grid" style="margin-top: 20px;" id="product-grid">
        <?php
        // Initially, fetch all posts from the database
        $query = "
        SELECT 
            dp.demand_post_id, 
            dp.demand_post_name, 
            dp.category_id, 
            cm.category_name, 
            dp.brand, 
            dp.quantity_pcs, 
            dp.quantity_kg
        FROM tbl_demand_post dp
        INNER JOIN tbl_category_master cm 
        ON dp.category_id = cm.category_id
        WHERE dp.demand_post_status = 'active'
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
            echo '<div style="text-align: center; color: #666; padding: 20px;">No posts found.</div>';
        }
        ?>
    </div>
    <!-- Edit Modal -->

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Demand Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <!-- Demand Post Name -->
                    <div class="mb-3">
                        <label for="editDemandPostName" class="form-label">Demand Post Name</label>
                        <input type="text" class="form-control" id="editDemandPostName" name="demand_post_name" required>
                    </div>

                    <div class="mb-3">
    <label for="editCategoryId" class="form-label">Category</label>
    <select class="form-control" id="editCategoryId" name="category_id" required>
        <option value="">Choose Category</option>
        <?php
        // Fetch unique categories from tbl_category_master
        $fetchCategories = mysqli_query($con, "
            SELECT DISTINCT cm.category_id, cm.category_name 
            FROM tbl_category_master cm
            INNER JOIN tbl_demand_post dp 
            ON cm.category_id = dp.category_id
        ");
        while ($category = mysqli_fetch_array($fetchCategories)) {
            echo "<option value='" . $category['category_id'] . "'>" . htmlspecialchars($category['category_name']) . "</option>";
        }
        ?>
    </select>
     </div>


                    <!-- Brand -->
                    <div class="mb-3">
                        <label for="editBrand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="editBrand" name="brand" required>
                    </div>

                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Quantity(Pieces)</label>
                      <input type="text" class="form-control" id="editQuantitypcs" name="quantity_pcs" required>
                    </div>
                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Quantity(Kg)</label>
                <input type="text" class="form-control" id="editQuantitykg" name="quantity_kg" required>
                    </div>

                    <!-- Hidden input field for demand_post_id -->
                    <input type="hidden" id="editDemandPostId" name="demand_post_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

</div>
