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
        <div class="card"
            style="
        border: none; 
        border-radius: 15px; 
        overflow: hidden; 
        position: relative; 
        max-width: 100px; 
    ">
            <!-- Product Image -->
            <div class="product-image"
                data-bs-toggle="modal"
                data-bs-target="#productModal<?php echo $row['product_id']; ?>"
                style="
            height: 130px; /* Adjusted height */
            background-image: url('upload_content/upload_img/product_img/<?php echo $row['product_image'] ?: 'no_image.png'; ?>'); 
            background-repeat: no-repeat; 
            background-position: center; 
            background-size: cover; 
            border-radius: 15px 15px 0 0;
            background-color: #e0e0e0;
        ">
            </div>
            <!-- Product Details -->
            <div class="card-body text-center"
                style="
            background-color: #2f415d; 
            color: #fff; 
            padding: 5px; 
            position: absolute; 
            bottom: 0; 
            left: 5%; 
            width: 90%; 
            border-radius: 0 0 15px 15px;
        ">
                <p class="card-text text-truncate"
                    style="
                font-size: 12px; 
                font-weight: 500; 
                margin: 0; 
                line-height: 1.4;
            ">
                    <?php echo htmlspecialchars($row['category_name']); ?>
                </p>
            </div>
        </div>




        <!-- Modal for product details -->
        <div class="modal fade" id="productModal<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="productModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #2f415d;">
                        <h3 class="modal-title" id="productModalLabel<?php echo $row['product_id']; ?>" style="color: white;">Transferred Items List</h3>
                        <span style="color: white;">Transfer Date: <?php echo date('d.m.Y', strtotime($row['entry_timestamp'])); ?></span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <!-- Product Image -->
                            <div>
                                <img src="upload_content/upload_img/product_img/<?php echo $row['product_image'] ?: 'no_image.png'; ?>"
                                    alt="Product Image"
                                    class="rounded shadow img-fluid"
                                    style="width: 90px; height: 100px; object-fit: cover;">
                            </div>
                            <!-- Product Details -->
                            <div class="ms-4">
                                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                                <p class="text-muted"><?php echo htmlspecialchars($row['category_name']); ?></p>
                                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($row['transferred_quantity']); ?></p>
                                <p><strong>Transferred to:</strong> <?php echo htmlspecialchars($row['transferred_to_buyer']); ?></p>
                                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($row['transferred_price']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-between border-top border-3">
                        <div>
                            <span class="text-muted">Total Quantity: <?php echo htmlspecialchars($row['transferred_quantity']); ?></span><br>
                            <span class="fw-bold">Expected Price: ₹<?php echo htmlspecialchars($row['transferred_price']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>