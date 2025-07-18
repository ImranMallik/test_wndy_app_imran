<?php
include("../db/db.php");

// Decode incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

$category_id = isset($sendData['category_id']) ? trim(mysqli_real_escape_string($con, $sendData['category_id'])) : '';


// Base query to fetch transferred products
$query = "
    SELECT
    tbl_direct_transfer.entry_timestamp, 
    tbl_direct_transfer.direct_transfer_id,
    tbl_direct_transfer.transferred_by_id,
    transferred_by.name AS transferred_by_buyer,
    transferred_by.ph_num AS transferred_by_buyer_phn,
    tbl_direct_transfer.transferred_to_id,
    transferred_to.name AS transferred_to_buyer,
    transferred_to.ph_num AS transferred_to_buyer_phn,
    tbl_direct_transfer.category_id,
    tbl_category_master.category_name,
    tbl_direct_transfer.product_id,
    tbl_product_master.product_name,
    COALESCE(tbl_product_file.file_name, 'no_image.png') AS product_image, -- Default image if not available
    tbl_direct_transfer.transferred_price,
    tbl_direct_transfer.transferred_quantity,
    tbl_direct_transfer.transferred_status
FROM tbl_direct_transfer
LEFT JOIN tbl_user_master AS transferred_by 
    ON transferred_by.user_id = tbl_direct_transfer.transferred_by_id
LEFT JOIN tbl_user_master AS transferred_to 
    ON transferred_to.user_id = tbl_direct_transfer.transferred_to_id
LEFT JOIN tbl_category_master 
    ON tbl_category_master.category_id = tbl_direct_transfer.category_id
LEFT JOIN tbl_product_master 
    ON tbl_product_master.product_id = tbl_direct_transfer.product_id
LEFT JOIN tbl_product_file 
    ON tbl_product_file.product_id = tbl_product_master.product_id
WHERE tbl_direct_transfer.transferred_by_id = '$session_user_code'
";

// Add filtering by category if provided
if (!empty($category_id)) {
    $query .= " AND tbl_direct_transfer.category_id = '$category_id'";
}

// Add GROUP BY clause
$query .= " GROUP BY tbl_direct_transfer.direct_transfer_id";

// Execute the query
$result = mysqli_query($con, $query);
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
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <!-- Card for each product -->


        <div class="list-item d-flex gap-3 mb-2" onclick="userViewSellerDetails(event, '1964')">
            <a href="./product-details/1964" class="product-img rounded-0">
                <img style="width: 110px !important;
  height: 100px !important; border-radius: 8px;"
                    src="upload_content/upload_img/product_img/<?php echo $row['product_image'] ?: 'no_image.png'; ?>"
                    alt="product_img" class="flex-shrink-0 lazyloaded">
            </a>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="product-name h5 mb-1" href="./product-details/1964">
                        <h3 class="h5 mb-1"><?php echo htmlspecialchars($row['category_name']); ?></h3>
                    </a>
                    <span class="fw-bold mb-0" style="text-align: end !important;">
                        <div data-bs-toggle="modal" data-bs-target="#productModal<?php echo $row['product_id']; ?>"
                            class="product-checkbox" style="bottom: 3px; right: 5px;">
                            <input type="checkbox" name="select[]" class="product_id"
                                style="transform: scale(1.2); cursor: pointer;" />
                        </div>
                    </span>
                </div>
                <span class="text-secondary"><?php echo htmlspecialchars($row['product_name']); ?></span><br>
                <strong>Quantity:</strong> <span
                    class="text-secondary"><?php echo htmlspecialchars($row['transferred_quantity']); ?></span>
            </div>
        </div>






        <!-- Modal for product details -->
        <div class="modal fade" id="productModal<?php echo $row['product_id']; ?>" tabindex="-1"
            aria-labelledby="productModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #b17f4a;">
                        <h3 class="modal-title" id="productModalLabel<?php echo $row['product_id']; ?>" style="color: white;">
                            Transferred Items List</h3>
                        <span style="color: white;">Transfer Date:
                            <?php echo date('d.m.Y', strtotime($row['entry_timestamp'])); ?></span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <!-- Product Image -->
                            <div>
                                <img src="upload_content/upload_img/product_img/<?php echo $row['product_image'] ?: 'no_image.png'; ?>"
                                    alt="Product Image" class="rounded shadow img-fluid"
                                    style="width: 90px; height: 100px; object-fit: cover;">
                            </div>
                            <!-- Product Details -->
                            <div class="ms-4">
                                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                                <p class="text-muted"><?php echo htmlspecialchars($row['category_name']); ?></p>
                                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($row['transferred_quantity']); ?></p>
                                <p><strong>Transferred to:</strong>
                                    <?php echo htmlspecialchars($row['transferred_to_buyer']); ?></p>
                                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($row['transferred_price']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-between border-top border-3">
                        <div>
                            <span class="text-muted">Total Quantity:
                                <?php echo htmlspecialchars($row['transferred_quantity']); ?></span><br>
                            <span class="fw-bold">Expected Price:
                                ₹<?php echo htmlspecialchars($row['transferred_price']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>