<?php
include("../db/db.php");

// Decode data
$sendData = isset($_POST['sendData']) ? json_decode($_POST['sendData'], true) : null;
$sendDataIDs = isset($_POST['sendDataIDs']) ? json_decode($_POST['sendDataIDs'], true) : null;

$category_id = isset($sendData['category_id']) ? trim(mysqli_real_escape_string($con, $sendData['category_id'])) : null;
$product_ids = isset($sendDataIDs['product_id']) ? $sendDataIDs['product_id'] : [];

$product_id_list = !empty($product_ids) ? implode("','", array_map(function ($id) use ($con) {
    return mysqli_real_escape_string($con, $id);
}, $product_ids)) : '';

// Debugging
// error_log("Category ID: " . $category_id);
// error_log("Product IDs: " . implode(", ", $product_ids));

$product_name_new = $description = $brand = "";

// Query Execution
if (!empty($product_id_list)) {
    $query = mysqli_query(
        $con,
        "SELECT 
            GROUP_CONCAT(product_name SEPARATOR ', ') AS product_name_new, 
            GROUP_CONCAT(description SEPARATOR ', ') AS description, 
            GROUP_CONCAT(brand SEPARATOR ', ') AS brand 
         FROM tbl_product_master 
         WHERE product_id IN ('$product_id_list')"
    );

    if ($query && mysqli_num_rows($query) > 0) {
        $row_value = mysqli_fetch_assoc($query);
        $product_name_new = $row_value['product_name_new'];
        $description = $row_value['description'];
        $brand = $row_value['brand'];
    }
}

// Fetch Purchased Items
$query = "SELECT 
    uv.product_id,
    pm.category_id,
    cm.category_name,
    pm.product_name,
    MIN(pf.file_name) AS file_name,
    pm.quantity,
    dt.transferred_status,
    uv.deal_status
FROM tbl_user_product_view uv
LEFT JOIN tbl_product_master pm ON pm.product_id = uv.product_id
LEFT JOIN tbl_direct_transfer dt ON pm.product_id = dt.product_id
LEFT JOIN tbl_product_file pf ON pf.product_id = uv.product_id
LEFT JOIN tbl_category_master cm ON cm.category_id = pm.category_id
WHERE uv.deal_status = 'Completed' 
    AND (dt.transferred_status != 'Direct Transfer' OR dt.transferred_status IS NULL)
    AND uv.buyer_id = '$session_user_code'
    AND uv.transferred_items_status = 'No'
    AND uv.create_post_item_status = 'No'";

if ($category_id != "") {
    $query .= " AND pm.category_id='$category_id'";
}

$query .= " GROUP BY uv.product_id, pm.category_id, cm.category_name, pm.product_name, pm.quantity, dt.transferred_status, uv.deal_status";

$productData = mysqli_query($con, $query);
$totalItems = mysqli_num_rows($productData);
?>


<p class="toolbar-product-count" style="margin-top: 7px; ">
    <span>Showing: <?php echo $totalItems; ?> Purchased Items</span>

</p>

<?php if ($totalItems === 0) { ?>
    <div class="no-products-found">
        <center>
            <h3>No Items <br> Found</h3>
        </center>
    </div>
    <p></p>
<?php } else { ?>
    <div class="container-fluid product-list-main-div">
        <div class="row g-3">


        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($productData)) {

            if ($row['transferred_status'] === 'Direct Transfer') {
                continue;
            }
            ?>
            <div class="list-item d-flex gap-3" onclick="userViewSellerDetails(event, '1964')">
                <a href="./product-details/1964" class="product-img rounded-0">
                    <img style="width: 110px !important;
  height: 100px !important; border-radius: 8px;"
                        src="upload_content/upload_img/product_img/<?php echo $row['file_name']; ?>" alt="product_img"
                        class="flex-shrink-0 lazyloaded">
                </a>

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="product-name h5 mb-1" href="./product-details/1964">
                            <h3 class="h5 mb-1"><?php
                            echo !empty($row['product_name'])
                                ? (mb_strlen($row['product_name']) > 6
                                    ? htmlspecialchars(mb_substr($row['product_name'], 0, 100)) . '..'
                                    : htmlspecialchars($row['product_name']))
                                : 'NA';
                            ?></h3>
                        </a>
                        <span class="fw-bold mb-0" style="text-align: end !important;">
                            <div class="product-checkbox" style="bottom: 3px; right: 5px;">
                                <input type="checkbox" id="product_id_<?php echo $row['product_id']; ?>" name="select[]"
                                    value="<?php echo htmlspecialchars($row['product_id']); ?>" class="product_id"
                                    onclick="showAlert(this)" onchange="getAllProductIds()"
                                    style="transform: scale(1.2); cursor: pointer;" />
                            </div>
                        </span>
                    </div>
                    <span class="text-secondary">E waste</span><br><span class="text-secondary">20.00 (kg)</span>
                </div>
            </div>



            <!-- Next Button Div -->
            <div id="nextButtonDiv"
                style="display: none; position: fixed; bottom: 68px; left: 0; width: 100%; background-color: #cdd3dd; padding: 10px; background-color:#b5753e; z-index: 99;">
                <!-- Create Post Button -->
                <button id="createPostButton" data-bs-toggle="modal" data-bs-target="#createPostModal"
                    style="position:relative; background-color: #28a745; color: white; border: none; border-radius: 5px; padding: 10px 30px; cursor: pointer; margin-right: auto; float: left;">
                    Create Post
                    <i class="fa fa-plus-circle"></i>
                </button>

                <button id="nextButton" onclick="nextAction()"
                    style="position:relative; background-color: #0571ae; color: white; border: none; border-radius: 5px; padding: 10px 30px; cursor: pointer; margin-left: auto; float: right;">
                    Next
                    <i class="fa fa-chevron-circle-right"></i>
                </button>
            </div>
        <?php } ?>

        <!-- create post modal starts here -->
        <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <section class="fxt-template-animation fxt-template-layout2">
                        <div class="container py-4">

                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-10 col-12 bg-form-color">

                                    <!-- Modal Header -->
                                    <div
                                        class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                                        <h5 class="title-text f-w-550">Create Your Post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <input type="hidden" value="<?php echo $product_id_list; ?>" id="product_id" />
                                    <!-- Post Details -->
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">
                                            Item Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            value="<?php echo isset($row_value['product_name_new']) && !empty($row_value['product_name_new']) ? $row_value['product_name_new'] : 'null'; ?>"
                                            class="form-control" id="product_name" placeholder="e.g: Waste" required
                                            maxlength="100" />
                                        <label class="input_alert product_name-inp-alert"></label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="description" placeholder="e.g: Description"
                                            required><?php echo isset($row_value['brand']) && !empty($row_value['brand']) ? $row_value['brand'] : 'null'; ?></textarea>
                                        <label class="input_alert description-inp-alert"></label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text"
                                            value="<?php echo isset($row_value['brand']) && !empty($row_value['brand']) ? $row_value['brand'] : 'null'; ?>"
                                            class="form-control" id="brand" placeholder="e.g: WM" maxlength="100" />
                                        <label class="input_alert brand-inp-alert"></label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sale_price" class="form-label">Expected Price <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="" class="form-control" id="sale_price"
                                            placeholder="e.g: 100, 200" required maxlength="8">
                                        <label class="input_alert sale_price-inp-alert"></label>
                                    </div>



                                    <?php if ($product_data) { ?>
                                        <div class="scroll-container">
                                            <?php
                                            $product_file_dataget = mysqli_query($con, "SELECT create_post_product_file_id, file_name FROM tbl_create_post_file WHERE file_type='Photo' AND product_id='$product_id'");
                                            while ($rw = mysqli_fetch_array($product_file_dataget)) {
                                                ?>
                                                <div class="scroll-item">
                                                    <img src="upload_content/upload_img/product_img/<?php echo $rw['file_name']; ?>"
                                                        class="img-fluid" />
                                                    <button
                                                        onclick="show_del_data_confirm_box(<?php echo $rw['create_post_product_file_id']; ?>)"
                                                        class="btn btn-danger btn-sm mt-2">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <!-- Submit Button -->
                                    <div class="text-end mt-4">
                                        <button type="button" class="btn btn-primary" onclick="save_details()">Continue
                                            <i class="fa fa-arrow-right"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>