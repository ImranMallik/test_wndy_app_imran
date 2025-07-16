<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

// Fetch buyer type
$user_type_data_get = mysqli_query($con, "SELECT buyer_type FROM tbl_user_master WHERE user_id=$session_user_code");
$user_type_data = mysqli_fetch_row($user_type_data_get);
$user_type = $user_type_data[0];

?>
<div class="product-listview-loadmore" id="product-listview-loadmore"
    style="padding: 20px; background-color: #f8f9fa; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <div class="row ">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label" style="font-weight: bold; color: #333; font-size: 16px;">
                    Filter Your Post Category
                </label>
                <select class="form-control" id="category_id" onchange="get_create_post_list()" required>
                    <option value="">Choose Category</option>
                    <?php

                    $fetchData = mysqli_query($con, "SELECT DISTINCT c.category_id, c.category_name FROM tbl_category_master c INNER JOIN tbl_create_post p ON c.category_id = p.category_id WHERE p.create_post_by_id = '$session_user_code' AND p.create_post_status = 'active'");
                    while ($row = mysqli_fetch_array($fetchData)) {
                        $selected = $row['category_id'] == $category_id ? "selected" : "";
                        echo "<option value='" . $row['category_id'] . "' " . $selected . " >" . $row['category_name'] . "</option>";
                    }
                    ?>
                </select>
                <div id="errorToast" style="color: red; font-size: 12px; display: none; padding: 3px 0;">
                    Please select a category.
                </div>
            </div>
        </div>
    </div>
    <!-- Product Grid -->
    <div class="manage_post_list">
        <div class="" id="manage_post_list">
            <!-- Dynamic Products will be appended here -->
        </div>
    </div>

    <!-- Load More Button -->
    <div class="infinitpaginOuter text-center mt-5">
        <!-- <div class="infiniteload"><a href="#" class="btn btn-xl loadMoreList">Load More</a></div> -->
    </div>
    <!-- End Load More Button -->
</div>
</div>