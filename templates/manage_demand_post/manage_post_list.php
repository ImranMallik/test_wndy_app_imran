<?php
include("../db/db.php");

// Decode incoming JSON data
$sendData = json_decode($_POST['sendData'], true);

// Sanitize and retrieve input
$category_id = isset($sendData['category_id']) ? $sendData['category_id'] : '';

// Initialize the query
$query = "
SELECT 
    tbl_demand_post.demand_post_id, 
    tbl_demand_post.demand_post_name,
    tbl_demand_post.description,
    tbl_demand_post.brand,
    tbl_demand_post.quantity,
    tbl_demand_post.demand_post_sale_price,  
    tbl_demand_post.demand_post_status, 
    tbl_demand_post.demand_post_by_id, 
    tbl_product_master.product_id, 
    COUNT(tbl_product_master.product_id) AS product_count,
    GROUP_CONCAT(tbl_product_master.product_name SEPARATOR ', ') AS product_names
FROM tbl_demand_post 
JOIN tbl_product_master 
    ON tbl_demand_post.product_id = tbl_product_master.product_id 
WHERE tbl_demand_post.demand_post_by_id = '$session_user_code' 
    AND tbl_demand_post.demand_post_status = 'active'
";

// Add condition for category_id if provided
if (!empty($category_id)) {
    $query .= " AND tbl_demand_post.category_id = '$category_id'";
}

// Add GROUP BY clause
$query .= " GROUP BY tbl_demand_post.demand_post_id";

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
              
    <div class="container my-4">
        <!-- Address Card -->
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <!-- Title -->
                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($row['demand_post_name'] ?: 'null'); ?></h5>
                    <!-- Action Buttons -->
                    <div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['product_id']; ?>"
                                style="color: #2f415d; margin-right: 10px;" title="Edit">
                                <img src="frontend_assets/img-icon/edit.png" alt="Edit">
                            </a>
                            <a href="javascript:void(0);" style="color: #ff4d4d;" title="Delete" onclick="delete_alert(<?php echo htmlspecialchars($row['demand_post_id']); ?>, event);">
                            <img src="frontend_assets/img-icon/bin.png" alt="Delete">
                        </a>
                    </div>
                </div>
                <!-- Address Content -->
                <p class="text-muted mb-0">quantity: <?php echo htmlspecialchars($row['quantity']."kg" ?: 'null'); ?></p>
            </div>
        </div>
    </div>

                <!-- Modal for Editing Product -->
                <div class="modal fade" id="editModal<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <section class="fxt-template-animation fxt-template-layout2">
                                <div class="container py-4">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8 col-md-10 col-12 bg-form-color">
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                                                <h5 class="title-text f-w-550">Edit Your Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Hidden Product ID -->
                                            <input type="hidden" value="<?php echo $row['demand_post_id']; ?>" id="product_id" />

                                            <!-- Post Details -->
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Item Name <span class="text-danger">*</span></label>
                                                <input type="text" value="<?php echo htmlspecialchars($row['demand_post_name']); ?>" class="form-control" id="product_name" placeholder="e.g: Waste" required maxlength="100" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="description" placeholder="e.g: Description" required><?php echo htmlspecialchars(isset($row['description']) ? $row['description'] : ''); ?>
                                                </textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Quantity</label>
                                                <input type="text" value="<?php echo htmlspecialchars(isset($row['quantity']) ? $row['quantity'] : ''); ?>" class="form-control" id="quantity" placeholder="e.g: WM" maxlength="100" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sale_price" class="form-label">Expected Price <span class="text-danger">*</span></label>
                                                <input type="text" value="<?php echo htmlspecialchars(isset($row['demand_post_sale_price']) ? $row['demand_post_sale_price'] : ''); ?>" class="form-control" id="sale_price" placeholder="e.g: 100, 200" required maxlength="8">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                                                <button type="button" class="fxt-btn-fill disabled" onclick="updatePostDetails();">Update Post <i class="fa fa-arrow-right"></i></button>
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
<script>
    //update data details :-
    function updatePostDetails() {
    var product_id = document.getElementById('product_id').value;
    var product_name = document.getElementById('product_name').value;
    var description = document.getElementById('description').value;
    var quantity = document.getElementById('quantity').value;
    var sale_price = document.getElementById('sale_price').value;

    var data = {
        product_id: product_id,
        product_name: product_name,
        description: description,
        quantity: quantity,
        sale_price: sale_price
    };

    // Make AJAX request to update post details
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "templates/manage_demand_post/edit_demand_post.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                toastr["success"](
                "Demand post updated successfully!", 
                "Success"
            );

            location.reload();
               // Reload the page to reflect changes
            } else {
                alert(response.message);
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

// delete data details:-

function delete_alert(demand_post_id, event) {
    //console.log("Post ID to delete:", demand_post_id);

    event.preventDefault();  // Prevent default action (if any)
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        }
    }).then(function (result) {
        if (result.isConfirmed) {
            location.reload();
            delete_data(demand_post_id);  // Call the function to delete the post
        }
    });
}

// Function to delete the post by sending an AJAX request to the server
function delete_data(demand_post_id) {
    console.log("Post ID to delete:", demand_post_id);

    if (demand_post_id > 0) {
        // Show loading overlay
        document.querySelector(".background_overlay").style.display = "block";

        // Prepare the data to be sent
        let data = new FormData();
        const sendData = { demand_post_id: demand_post_id };
        console.log("Data being sent:", sendData);
        data.append("sendData", JSON.stringify(sendData));

        // Create a new XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                // Hide the loading overlay
                document.querySelector(".background_overlay").style.display = "none";

                if (xhr.status === 200) {
                    // Parse server response
                    const response = JSON.parse(xhr.responseText);
                    console.log("Server response:", response);

                    if (response.status === "Success") {
                        toastr.info("Data Deleted Successfully.", "SUCCESS!!");
                        
                    } else {
                        toastr.error(response.status_text, "ERROR!!");
                    }

                    // Reload the page after deletion
                    setTimeout(() => {
                        window.reload();
                    }, 1000);
                } else {
                    console.error("Error deleting data:", xhr.responseText);
                    toastr.error("Failed to delete data. Please try again.", "ERROR!!");
                }
            }
        };

        // Open the request and send the data
        xhr.open('POST', 'templates/manage_demand_post/delete_demand_post.php', true);
        xhr.send(data);
    } else {
        toastr.error("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
    }
}


</script>

<?php
// Free the result and close the connection
mysqli_free_result($result);
mysqli_close($con);
?>