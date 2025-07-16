<?php
include("../db/db.php");

// Decode incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize and retrieve input
$category_id = isset($sendData['category_id']) ? trim(mysqli_real_escape_string($con, $sendData['category_id'])) : '';

// Initialize the query
$query = "
SELECT 
    tbl_create_post.create_post_id, 
    tbl_create_post.create_post_name,
    tbl_create_post.description,
    tbl_create_post.brand,
    tbl_create_post.create_post_sale_price,  
    tbl_create_post.create_post_status, 
    tbl_create_post.create_post_by_id, 
    tbl_product_master.product_id, 
    COUNT(tbl_product_master.product_id) AS product_count,
    GROUP_CONCAT(tbl_product_master.product_name SEPARATOR ', ') AS product_names
FROM tbl_create_post 
JOIN tbl_product_master 
    ON tbl_create_post.product_id = tbl_product_master.product_id 
WHERE tbl_create_post.create_post_by_id = '$session_user_code' 
    AND tbl_create_post.create_post_status = 'active'
";

// Add condition for category_id if provided
if (!empty($category_id)) {
    $query .= " AND tbl_create_post.category_id = '$category_id'";
}

// Add GROUP BY clause
$query .= " GROUP BY tbl_create_post.create_post_id";

// Execute the query
$result = mysqli_query($con, $query);

// Check for query execution errors
if (!$result) {
    die('Error executing query: ' . mysqli_error($con));
}

// Get the total number of items
$totalItems = mysqli_num_rows($result);
?>

<!-- Display Product Count -->
<p class="toolbar-product-count" style="width:100%">
    <?php if ($totalItems > 0) { ?>
        <span>Showing: <?php echo htmlspecialchars($totalItems); ?> Purchased Items</span>
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
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="list-item d-flex gap-3">
                    <a href="<?php echo "./create_post_details/" . $row['product_id']; ?>" class="product-img rounded-0">
                        <img style="width: 110px !important;
  height: 100px !important; border-radius: 8px;"
                            src="upload_content/upload_img/product_img/<?php echo $row['create_post_img'] ?: 'no_image.png'; ?>"
                            alt="product_img" class="flex-shrink-0 lazyloaded">
                    </a>

                    <div class="flex-grow-1">
                        <?php
                        if ($rw['product_status'] == "Active") {
                            ?>
                            <img src="frontend_assets/img-icon/status-open.png" class="product-status-img" />
                            <?php
                        } else if ($rw['product_status'] == "Completed") {
                            ?>
                                <img src="frontend_assets/img-icon/status-close.png" class="product-status-img" />
                            <?php
                        } else {
                            ?>
                                <img src="frontend_assets/img-icon/unlocked.png" class="product-status-img open_deal" />
                            <?php
                        }

                        ?><br><br>
                        <span
                            class="text-secondary"><?php echo htmlspecialchars($row['create_post_name'] ?: 'null'); ?></span><br>
                        <div class="d-flex align-items-center" style="justify-content: flex-end; margin-top: -40px;">
                            <!-- Edit button with modal trigger -->


                            <a href="#" class="bottom-btn btn-sm pb-2" style="background-color:#c17f59 !important; border:none;"
                                data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['product_id']; ?>"
                                style="color: #2f415d; margin-right: 10px;" title="Edit">
                                <i class="bi bi-pencil-square" style="font-size:18px; color:#fff; padding-top:15px;"></i>
                            </a> &nbsp;
                            <br>
                            <!-- Delete button -->
                            <a href="javascript:void(0);" class="bottom-btn btn-sm pb-2"
                                style="background-color:#c17f59 !important; border:none;" title="Delete"
                                onclick="delete_alert(<?php echo htmlspecialchars($row['create_post_id']); ?>, event);">
                                <i class="bi bi-trash" style="font-size:18px; color:#fff; padding-top:15px;"></i>
                            </a>
                        </div>

                    </div>
                </div>




                <!-- Modal for Editing Product -->
                <div class="modal fade" id="editModal<?php echo $row['product_id']; ?>" tabindex="-1"
                    aria-labelledby="editModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <section class="fxt-template-animation fxt-template-layout2">
                                <div class="container py-4">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8 col-md-10 col-12 bg-form-color">
                                            <div
                                                class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                                                <h5 class="title-text f-w-550">Edit Your Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <!-- Hidden Product ID -->
                                            <input type="hidden" value="<?php echo $row['create_post_id']; ?>"
                                                id="product_id" />

                                            <!-- Post Details -->
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Item Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars($row['create_post_name']); ?>"
                                                    class="form-control" id="product_name" placeholder="e.g: Waste" required
                                                    maxlength="100" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" id="description" placeholder="e.g: Description"
                                                    required><?php echo htmlspecialchars(isset($row['description']) ? $row['description'] : ''); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Brand</label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars(isset($row['brand']) ? $row['brand'] : ''); ?>"
                                                    class="form-control" id="brand" placeholder="e.g: WM" maxlength="100" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="sale_price" class="form-label">Expected Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars(isset($row['create_post_sale_price']) ? $row['create_post_sale_price'] : ''); ?>"
                                                    class="form-control" id="sale_price" placeholder="e.g: 100, 200" required
                                                    maxlength="8">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                                                <button type="button" class="fxt-btn-fill disabled"
                                                    onclick="update_details(<?php echo htmlspecialchars($row['create_post_id']); ?>, event);">Update
                                                    Post <i class="fa fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
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