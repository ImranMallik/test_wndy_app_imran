<?php
include("../db/db.php");

// Decode incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize and validate inputs
$category_id = isset($sendData['category_id']) ? trim(mysqli_real_escape_string($con, $sendData['category_id'])) : '';

// Use session variable to filter out the current user
$session_user_code = $_SESSION['user_code']; // Make sure this session variable is set

// Initialize the base query
$query = "
SELECT 
    tbl_demand_post.demand_post_id, 
    tbl_demand_post.demand_post_name,
    tbl_demand_post.demand_post_sale_price, 
    tbl_demand_post.demand_post_status, 
    tbl_demand_post.demand_post_by_id, 
    tbl_product_master.product_id, 
    COUNT(tbl_product_master.product_id) AS product_count,
    GROUP_CONCAT(tbl_product_master.product_name SEPARATOR ', ') AS product_names
FROM tbl_demand_post 
JOIN tbl_product_master 
    ON tbl_demand_post.product_id = tbl_product_master.product_id 
WHERE tbl_demand_post.demand_post_by_id != '$session_user_code' 
    AND tbl_demand_post.demand_post_status = 'active'
";

// Add category filter if provided
if (!empty($category_id)) {
    $query .= " AND tbl_demand_post.category_id = '$category_id'";
}



// Add grouping
$query .= " GROUP BY tbl_demand_post.demand_post_id";

// Execute the query
$result = mysqli_query($con, $query);

// Check for query execution errors
if (!$result) {
    die('Error executing query: ' . mysqli_error($con));
}

$totalItems = mysqli_num_rows($result);
?>

<!-- Display Product Count -->
<p class="toolbar-product-count" style="width:100%">
    <?php if ($totalItems > 0) { ?>
        <span>Showing: <?php echo $totalItems; ?> Purchased Items</span>
    <?php } else { ?>
        <span>No items to display.</span>
    <?php } ?>
</p>

<?php if ($totalItems === 0) { ?>
    <div class="no-products-found text-center">
        <h3>No Items <br> Found</h3>
    </div>
<?php } else { ?>
    <div class="container">

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) {
                $file_query = mysqli_query($con, "SELECT file_name FROM tbl_demand_post_file WHERE product_id = '" . $row['product_id'] . "' LIMIT 1");
                $file_data = '';
                if ($file_query) {
                    $file_dataget = mysqli_fetch_assoc($file_query);
                    $file_data = $file_dataget['file_name'];
                } ?>
                <div class="col-4 col-sm-4 col-md-3 col-lg-3 mb-4">
                    <a href="<?php echo "./demand_post_details/" . $row['product_id']; ?>" class="card" style="border: none; border-radius: 15px; overflow: hidden; position: relative; max-width: 100%;">
                        <div class="product-image" style="height: 105px; background-image: url('upload_content/upload_img/product_img/<?php echo $file_data ?>'); background-repeat: no-repeat; background-position: center; background-size: cover; border-radius: 15px 15px 0 0; background-color: #e0e0e0; position: relative;">
                        </div>
                        <div class="card-body text-center" style="background-color: #2f415d; color: #fff; padding: 5px; position: relative; bottom: 0; width: 100%; border-radius: 0 0 15px 15px;">
                            <p class="card-text text-truncate" style="font-size: 12px; font-weight: 500; margin: 0; line-height: 1.4;">
                                <?php echo $row['demand_post_name']; ?>
                            </p>
                        </div>
                    </a>
                    <div class="card-actions text-center mt-2" style="padding: 5px; background-color: transparent;">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-product-id="<?php echo $row['product_id']; ?>"
                            data-product-name="<?php echo htmlspecialchars($row['product_names']); ?>"
                            data-product-price="<?php echo $row['demand_post_sale_price']; ?>"
                            style="color: #2f415d; margin-right: 10px;" title="Edit">
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="edit_post.php" method="POST">
                                    <input type="hidden" name="product_id" id="modalProductID" value="">
                                    <div class="mb-3">
                                        <label for="modalProductName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" id="modalProductName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="modalProductPrice" class="form-label">Product Price</label>
                                        <input type="number" class="form-control" name="product_price" id="modalProductPrice" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php
// Free the result and close the connection
mysqli_free_result($result);
mysqli_close($con);
?>