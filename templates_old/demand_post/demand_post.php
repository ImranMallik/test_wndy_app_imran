<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");


// Fetch buyer type
$user_type_data_get = mysqli_query($con, "SELECT buyer_type FROM tbl_user_master WHERE user_id=$session_user_code");
$user_type_data = mysqli_fetch_row($user_type_data_get);
$user_type = $user_type_data[0];
$maxIdQuery = "SELECT IFNULL(MAX(demand_post_id), 0) AS max_id FROM tbl_demand_post";
$maxIdResult = mysqli_query($con, $maxIdQuery);
$maxIdRow = mysqli_fetch_assoc($maxIdResult);
$nextId = (int)$maxIdRow['max_id'] + 1;

?>

<button style="background-color: #4eaf52; padding: 4px 8px; align-items:center" class="btn">
    <a href="<?php echo $baseUrl ?>/manage_demand_post" style="color: #FFF;">
        Manage Your Post
    </a>
</button>
<div class="product-listview-loadmore" id="product-listview-loadmore" style="padding: 20px; background-color: #f8f9fa; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">


    <section class="fxt-template-animation fxt-template-layout2">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12 bg-form-color">


                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                        <h5 class="title-text f-w-550">Demand Your Post</h5>
                    </div>


                    <form id="demandForm">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-control select2" id="category_id" required onchange="storeCategoryAndProduct()">
                                <option value="">Select Category</option>
                                <?php
                                $fetchData = mysqli_query($con, "SELECT * FROM db_waste_management.tbl_category_master WHERE active = 'Yes' ORDER BY order_number ASC");

                                while ($row = mysqli_fetch_array($fetchData)) {
                                    $selected = $row['category_id'] == $category_id ? "selected" : "";
                                    echo "<option value='" . $row['category_id'] . "' " . $selected . ">" . $row['category_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="demand_product_name" placeholder="e.g: Waste" required maxlength="100" name="product_name" required />
                            <label class="input_alert product_name-inp-alert"></label>
                            <input type="hidden" id="nextDemandId" value="<?php echo $nextId; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="demand_brand" placeholder="e.g: WM" maxlength="100" name="brand" required />
                            <label class="input_alert brand-inp-alert"></label>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="demand_description" placeholder="e.g: Description" required name="description" required></textarea>
                            <label class="input_alert description-inp-alert"></label>
                        </div>


                        <!-- <div class="mb-3">
                            <label class="form-label">Filter Post Category</label>
                            <select class="form-control" id="category_id" required onchange="storeCategoryAndProduct()">
                                <option value="">Choose Category</option>
                                <?php
                                $fetchData = mysqli_query($con, "SELECT DISTINCT 
                                    cm.category_id, 
                                    cm.category_name,
                                    pm.product_id
                                    FROM 
                                        tbl_user_product_view AS upv
                                    INNER JOIN 
                                        tbl_product_master AS pm ON upv.product_id = pm.product_id
                                    INNER JOIN 
                                        tbl_category_master AS cm ON pm.category_id = cm.category_id
                                    WHERE 
                                        upv.buyer_id = $session_user_code AND upv.deal_status = 'Completed' AND cm.active = 'Yes';");

                                while ($row = mysqli_fetch_array($fetchData)) {
                                    $selected = $row['category_id'] == $category_id ? "selected" : "";
                                    echo "<option value='" . $row['category_id'] . "' data-product-id='" . $row['product_id'] . "' " . $selected . " >" . $row['category_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="demand_quantity" placeholder="e.g: 10kg, 20kg" required maxlength="8" name="quantity" required>
                            <label class="input_alert quantity-inp-alert"></label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="qty_type" id="unit_kg" value="kg" required>
                                    <label class="form-check-label" for="unit_kg">kg</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="qty_type" id="unit_pcs" value="pcs" required>
                                    <label class="form-check-label" for="unit_pcs">pcs</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="demand_sale_price" placeholder="e.g: 100, 200" required maxlength="8" name="sale_price" required>
                            <label class="input_alert sale_price-inp-alert"></label>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-primary" onclick="save_demand_details()">Continue <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- End Load More Button -->
</div>
<script>
    let selectedCategoryId = "";
    let selectedProductId = "";

    function storeCategoryAndProduct() {
        const selectElement = document.getElementById('category_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        selectedCategoryId = selectedOption.value;
        selectedProductId = selectedOption.getAttribute('data-product-id');
    }



    function save_demand_details() {

        let save_no = 1;
        clearInputAleart();
        toastr.clear();

        var numberRegex = /^\d+$/;
        if (!_("#demand_product_name").checkValidity()) {
            toastr["warning"](
                "demand_product_name: " + _("#demand_product_name").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_product_name",
                "warning",
                _("#demand_product_name").validationMessage
            );
            _("#demand_product_name").focus();
            save_no = 0;
            return false;
        }

        if (!_("#demand_description").checkValidity()) {
            toastr["warning"](
                "demand_description: " + _("#demand_description").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_description",
                "warning",
                _("#demand_description").validationMessage
            );
            _("#demand_product_name").focus();
            save_no = 0;
            return false;
        }
        if (!_("#demand_brand").checkValidity()) {
            toastr["warning"](
                "demand_brand: " + _("#demand_brand").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_brand",
                "warning",
                _("#demand_brand").validationMessage
            );
            _("#demand_product_name").focus();
            save_no = 0;
            return false;
        }
        if (!_("#demand_sale_price").checkValidity()) {
            toastr["warning"](
                "demand_sale_price: " + _("#demand_sale_price").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_sale_price",
                "warning",
                _("#demand_sale_price").validationMessage
            );
            _("#demand_sale_price").focus();
            save_no = 0;
            return false;
        }
        if (!_("#demand_sale_price").checkValidity()) {
            toastr["warning"](
                "demand_sale_price: " + _("#demand_sale_price").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_sale_price",
                "warning",
                _("#demand_sale_price").validationMessage
            );
            _("#demand_sale_price").focus();
            save_no = 0;
            return false;
        }
        // if (!_("input[name='qty_type']:checked")) {
        //     toastr["warning"](
        //         "Please select a unit for quantity (kg or pcs).",
        //         "WARNING"
        //     );
        //     showInputAlert(
        //         "quantity_unit",
        //         "warning",
        //         "Please select a unit for quantity (kg or pcs)."
        //     );
        //     _("#unit_kg").focus(); // Focus on the first radio button
        //     save_no = 0;
        //     return false;
        // }

        if (!_("#demand_quantity").checkValidity()) {
            toastr["warning"](
                "demand_quantity: " + _("#demand_quantity").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_quantity",
                "warning",
                _("#demand_quantity").validationMessage
            );
            _("#demand_quantity").focus();
            save_no = 0;
            return false;
        }

        const formData = new FormData(document.getElementById('demandForm'));
        const qtyType = document.querySelector('input[name="qty_type"]:checked');
        formData.append('category_id', selectedCategoryId);
        formData.append('product_id', selectedProductId);
        if (qtyType) {
            formData.append('qty_type', qtyType.value);
        } else {
            toastr["warning"]("Please select a quantity type (kg or pcs).", "WARNING");
            return; // Prevent the fetch call if qty_type is not selected
        }
        fetch('templates/demand_post/save_demand_details.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log("Response Data:", data);
                if (data.success) {
                    toastr["success"](
                        "Demand post saved successfully!",
                        "Success"
                    );
                    save_notification_details();
                    // console.log(data.demand_post_id);
                    document.getElementById('demandForm').reset();
                } else {
                    alert('Error saving demand post: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the demand post.');
            });
    }

    function save_notification_details() {
        const nextId = document.getElementById('nextDemandId').value;
        // Prepare notification data
        const notificationData = {
            title: "New Demand Post Created",
            details: "A new demand post has been created",
            notification_url: "demand_post_details/" + nextId,
            from_user_id: "<?php echo $session_user_code; ?>",
            entry_user_code: "<?php echo $session_user_code; ?>"
        };

        console.log("Sending Notification Data:", notificationData);


        fetch('templates/demand_post/save_notification_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(notificationData),
            })
            .then(response => response.json()) // Automatically parse JSON
            .then(data => {
                console.log('Server Response:', data);
                // alert(data.message); // Show success message
            })
            .catch(error => {
                console.error('Fetch error:', error.message);
                alert('Failed to send data');
            });






    }
</script>