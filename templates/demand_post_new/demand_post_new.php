<?php
include("../db/db.php");

$category_dataget = mysqli_query($con, "SELECT category_id,category_img, category_name FROM tbl_category_master WHERE active='Yes' ORDER BY order_number ASC");


// print_r($session_user_code);
?>


<div class="category-body" id="step1">
    <div class="container-fluid px-4 pt-2 pb-3">

        <div class="d-flex align-items-center mb-4">
            <a href="<?php echo $baseUrl . '/manage_demand_post'; ?>"> <i class="bi bi-arrow-left fs-4"></i>&nbsp; &nbsp;</a>
            <h1 class="fs-6 fw-semibold mb-0">Choose a Category</h1>

        </div>


        <div class="d-flex justify-content-center mb-4">
            <div class="progress-steps">
                <div class="step active">1</div>
                <div class="step-line"></div>
                <div class="step">2</div>

            </div>
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
    <header class="header px-3" style="border-bottom: 1px solid #fff !important;">
        <div class="d-flex align-items-center">
            <a href="#" id="backToStep1" class="btn btn-link text-dark p-0">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>&nbsp; &nbsp;
            <h1 class="h5 mb-0 fs-6">Demand Your Post</h1>
        </div>
    </header>
    <!-- Progress Steps -->
    <div class="progress-steps d-flex justify-content-center align-items-center gap-2">
        <div class="step-circle completed">
            <i class="bi bi-check-lg"></i>
        </div>
        <div class="step-line completed"></div>
        <div class="step-circle active">2</div>
    </div>

    <main class="px-3 pb-4 mt-2">
        <form id="itemDetailsForm">
            <div class="mb-3">
                <label for="postName" class="form-label">Item Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="postName" placeholder="e.g: Laptop,TV,Washing Machine">
            </div>

            <div class="mb-3">
                <span class="info-container d-flex">
                    <label for="description" class="form-label">Description<span class="text-danger">*</span></label>&nbsp;&nbsp;

                </span>
                <textarea class="form-control" id="description" placeholder="e.g: Enter details about your item and its condition" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" placeholder="e.g: Samsung,LG,Dell">
            </div>
            <div class="mb-3">
                <input type="hidden" class="form-control" id="user_id" value="<?php echo $session_user_code  ?>">
            </div>

            <div class="mb-3">
                <label for="quantityPcs" class="form-label">Quantity(Pieces)</label>
                <input type="text" class="form-control" id="quantityPcs" placeholder="e.g: 1,2,3">
            </div>

            <div class="mb-3">
                <label for="quantityKg" class="form-label">Quantity(Kg)<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="quantityKg" placeholder="e.g: 0.5, 1, 1.5">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="price" placeholder="e.g: 2000">

                </div>
            </div>

            <button id="save_details" class="btn btn-primary w-100 py-3 fw-medium">Save</button>
        </form>
    </main>
</div>


<style>


</style>