<?php
include("../db/db.php");

$category_dataget = mysqli_query($con, "SELECT category_id,category_img, category_name FROM tbl_category_master WHERE active='Yes' ORDER BY order_number ASC");


// print_r($session_user_code);
?>


<div class="category-body" id="step1">
    <div class="container-fluid px-4 pt-2 pb-3">

        <div class="d-flex align-items-center mb-4">
            <i class="bi bi-arrow-left fs-4"></i>&nbsp; &nbsp;
            <h1 class="fs-4 fw-semibold mb-0">Choose a Category</h1>
            <!-- <i class="bi bi-search fs-4"></i> -->
        </div>


        <div class="categories-list mb-4">
            <?php while ($rw = mysqli_fetch_array($category_dataget)) { ?>
                <button class="category-item" data-category="<?= strtolower($rw['category_id']) ?>">
                    <div class="d-flex align-items-center gap-2">
                        <div class="radio-circle"></div>
                        <span><?= $rw['category_name'] ?></span>
                    </div>
                    <span>
                        <img src="./upload_content/upload_img/category_img/<?= empty($rw['category_img']) ? "no_image.png" : $rw['category_img'] ?>"
                            alt="<?= $rw['category_name'] ?>" width="40" height="40" />
                    </span>
                </button>
            <?php } ?>
        </div>

        <div style="width: 100%; background-color: #fff; z-index: 999; position: fixed;
        bottom: 10px;
        width: 90% !important;
        right: 50px;
        left: 17px;">
            <button id="continueStep1"
                class="btn btn-primary w-100 py-3 fw-medium seller-post-continue">Continue</button>
        </div>
    </div>
</div>


<div id="step2" class="container-fluid px-0 seeler-item-details-bg d-none">
    <header class="header px-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="#" id="backToStep1" class="btn btn-link text-dark p-0">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <h1 class="h5 mb-0">Item Details</h1>
        </div>
    </header>


    <main class="px-3 pb-4 mt-2">
        <form id="itemDetailsForm">
            <div class="mb-3">
                <label for="postName" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="postName" placeholder="e.g: Waste">
            </div>

            <div class="mb-3">
                <span class="info-container d-flex"><label for="description" class="form-label">
                        Description</label>&nbsp;&nbsp;
                    <button class="info-button" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Please describe the objects that you are trying to sell with their conditions e.g. working or not working, damage levels etc. This will facilitate a clear understanding and help receive relevant responses."
                        style="padding: 1px 8px !important;
        margin-bottom: 5px !important; border-radius:100px;">i</button>
                </span>
                <input type="text" class="form-control" id="description" placeholder="e.g: description">
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" placeholder="e.g: WM">
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="quantity" placeholder="e.g: 1 Pcs, 2 k.g">
            </div>
            <div class="mb-3">
                <label class="form-label">Select Unit:</label>
                <div class="d-flex">
                    <div class="form-check" style="padding-left:0px !important">
                        <input class="form-check-input" type="radio" name="unit" id="quantityRadio" value="kg"
                            style="width:16px;height:16px;">&nbsp;
                        <span>
                            Kg
                        </span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="unit" id="pcsRadio" value="pcs"
                            style="width:16px;height:16px;">&nbsp;
                        <span>
                            Pcs
                        </span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Expected Price</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="price" placeholder="Eg - 2000">

                </div>
            </div>
            <button id="viewRateListBtn" style="background-color: #b5753e; padding: 4px 8px; color: white; border:none;"
                class="btn mb-3">
                VIEW RATE LIST
            </button>

            <div class="mb-4">
                <label class="form-label d-flex">Add Item Images <span class="text-danger">*</span> &nbsp;&nbsp;
                    <button class="info-button" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Please upload clear photos of the products from multiple angles to receive quick and best responses for your posts."
                        style="padding: 1px 8px !important;
        margin-bottom: 5px !important; border-radius:100px;">i</button></label>
                <div class="d-flex gap-3 image-upload-container">

                    <!-- Dynamic Image Upload Inputs -->
                    <div id="image-upload-wrapper">
                        <input type="file" id="imageUploadInput" class="d-none" accept="image/*" multiple>

                        <button type="button" class="btn btn-outline-secondary upload-btn"
                            onclick="document.getElementById('imageUploadInput').click();">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button id="continueStep2" class="btn btn-primary w-100 py-3 fw-medium">Continue</button>
        </form>
    </main>
</div>



<div id="step3" class="container py-4 d-none">
    <div class="address-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="#" id="backToStep2" class="back-button ">←</a>
                <h1 class="h4 mb-0">Manage Address</h1>
            </div>


            <a href="#" class="addAddress">
                <img src="frontend_assets/img-icon/add-location.png" height="24" width="24" class="address-icon ">

            </a>
        </div>

        <div id="addressList">

        </div>
    </div>




    <input type="hidden" id="selected_address_id" name="selected_address_id" value="">

    <button class="add-address-btn " id="saveAllData">Save</button>
</div>


<!-- Edit and Add Modal -->

<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAddressForm">
                    <input type="hidden" id="edit_address_id">

                    <div class="mb-3">
                        <label for="edit_address_name" class="form-label">Address Name</label>
                        <input type="text" class="form-control" id="edit_address_name" required>
                    </div>


                    <div class="mb-3">
                        <label for="edit_contact_name" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="edit_contact_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" id="edit_contact_phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="edit_country" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_state" class="form-label">State</label>
                        <input type="text" class="form-control" id="edit_state" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_city" class="form-label">City</label>
                        <input type="text" class="form-control" id="edit_city" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="edit_pincode" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_landmark" class="form-label">Landmark</label>
                        <input type="text" class="form-control" id="edit_landmark" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_address_line" class="form-label">Address Line</label>
                        <input type="text" class="form-control" id="edit_address_line" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="saveAddressBtn"></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Start rate list modal -->
<div class="modal fade catgory-rate-list-div" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Category Rate List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>