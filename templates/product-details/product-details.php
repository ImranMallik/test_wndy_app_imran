<?php
include("module_function/date_time_format.php");

// Fetch system info
$system_info_dataget = mysqli_query($con, "SELECT product_view_credit FROM system_info WHERE 1");
$system_info_data = mysqli_fetch_row($system_info_dataget);
$product_view_credit = $system_info_data[0] ?? 0;

$product_id = "";

if (!empty($arr[2])) {
    $product_id = mysqli_real_escape_string($con, $arr[2]);
}
?>

<script>
    const product_view_credit = <?php echo json_encode($product_view_credit); ?>;
    let product_id = "";
</script>

<?php
if ($product_id) {
    // Prepare product query
    $query = "SELECT
    tbl_product_master.product_id,
    tbl_product_master.close_reason ,
    tbl_product_master.product_name,
    tbl_category_master.category_name,
    tbl_category_master.category_img,
    tbl_product_master.sale_price,
    tbl_product_master.description,
    tbl_product_master.brand,
        tbl_product_master.is_draft,
    tbl_product_master.quantity,
    tbl_product_master.quantity_pcs,
    tbl_product_master.quantity_kg,
    tbl_product_master.quantity_unit,
    tbl_address_master.country,
    tbl_address_master.state,
    tbl_address_master.city,
    tbl_address_master.landmark,
    tbl_address_master.pincode,
    tbl_address_master.address_line_1,
    tbl_user_master.name,
    tbl_user_master.country_code,
    tbl_user_master.ph_num,
    tbl_user_master.email_id,          
    tbl_product_master.address_id,  
    tbl_product_master.product_status,
    tbl_credit_trans.in_credit
FROM tbl_product_master
LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_product_master.user_id
LEFT JOIN tbl_credit_trans ON tbl_credit_trans.user_id = tbl_product_master.user_id
WHERE tbl_product_master.product_id = '$product_id'
";

    if ($session_user_type === "Seller") {
        $query .= " AND tbl_product_master.user_id='" . mysqli_real_escape_string($con, $session_user_code) . "'";
    }

    $product_details_get = mysqli_query($con, $query);
    $product_details = mysqli_fetch_row($product_details_get);

    if ($product_details) {
        list(
            $product_id,
            $close_reason,
            $product_name,
            $category_name,
            $category_img,
            $sale_price,
            $description,
            $brand,
            $is_draft,
            $quantity,
            $quantity_pcs,   // Correct position
            $quantity_kg,    // Correct position
            $quantity_unit,
            $country,
            $state,
            $city,
            $landmark,
            $pincode,
            $address_line_1,
            $name,
            $country_code,
            $ph_num,
            $email_id,
            $address_id,
            $product_status
        ) = $product_details;



        // echo "<pre>";
        // print_r($address_id);
        // echo "<pre>";




        $product_file_dataget = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id='$product_id' AND file_type='Photo' AND active='Yes'");
        $product_images = [];
        while ($row = mysqli_fetch_assoc($product_file_dataget)) {
            $product_images[] = $row['file_name'];
        }
        if (empty($product_images)) {
            $product_images[] = "no_image.png";
        }
?>

        <script>
            product_id = <?php echo json_encode($product_id); ?>;
        </script>

        <a href="<?php echo $baseUrl . "/product_list"; ?>" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!--<div class="image-counter">-->
                <!--    <span id="currentSlide">1</span>/<?php echo count($product_images); ?>-->
                <!--</div>-->

                <?php
                foreach ($product_images as $index => $file_name) {
                    echo '
            <div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">
                <img src="upload_content/upload_img/product_img/' . $file_name . '" class="d-block w-100" alt="Product Image">
            </div>';
                }
                ?>
            </div>
        </div>

        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-start">
                <h4 id="product_name"><?php echo htmlspecialchars($product_name); ?></h4>
                <h4 class="price">Rs <?php echo htmlspecialchars($sale_price); ?>/-</h4>
            </div>

            <hr>




            <div class="mt-1">
                <p><strong>Category:</strong> <?php echo htmlspecialchars($category_name); ?>
                    <?php if ($session_user_type == "Seller" && $product_status == "Active") { ?>
                        <a href="<?php echo "./seller-post-edit/" . $product_id; ?>" class="edit-right" style="font-size:10px !important; width:42px; text-align:center; color: #fff; border-radius:5px; margin-top: -25px;">
                            <div style="border-radius:5px;">
                                <p style="margin: 0 0 5px;"></p>
                                <i class="bi bi-pencil-square" style="font-size:13px !important; margin-top:15px; padding-top:9px;"></i> <br>
                                <p style="font-weight: normal; margin-bottom:5px;">Edit</p>
                            </div>

                        </a>
                    <?php } ?>
                </p>


                <p><strong>Brand:</strong> <?php echo htmlspecialchars($brand); ?></p>
                <p><strong>Quantity:</strong>
                    <?php
                    function formatNumber($value)
                    {
                        return rtrim(rtrim(number_format((float)$value, 2, '.', ''), '0'), '.');
                    }

                    $pcs = isset($quantity_pcs) && is_numeric($quantity_pcs) && $quantity_pcs > 0 ? formatNumber($quantity_pcs) . ' pcs' : '';
                    // print_r($pcs);
                    $kg  = isset($quantity_kg) && is_numeric($quantity_kg) && $quantity_kg > 0 ? formatNumber($quantity_kg) . ' kg' : '';

                    if ($pcs && $kg) {
                        echo $pcs . ', ' . $kg;
                    } elseif ($pcs) {
                        echo $pcs;
                    } elseif ($kg) {
                        echo $kg;
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </p>

                <p><strong>Description:</strong><?php echo nl2br(htmlspecialchars($description)); ?></p>
                <p><strong>Location:</strong>
                    <?php
                    $address_parts = array_filter([
                        $landmark ?? '',
                        $address_line_1 ?? '',
                        $city ?? '',
                        $state ?? '',
                        $pincode ?? '',
                        $country ?? ''
                    ]);

                    echo htmlspecialchars(implode(', ', $address_parts)) ?: ' ';
                    ?>
                </p>

            </div>
            <?php if ($session_user_type == "Buyer") {
                // Step 1: Get seller ID from current product
                $getSellerQuery = mysqli_query($con, "SELECT user_id FROM tbl_product_master WHERE product_id = '$product_id' LIMIT 1");
                $sellerRow = mysqli_fetch_assoc($getSellerQuery);
                $product_user_id = $sellerRow['user_id'];

                // Step 2: Count seller's products with valid status
                $productCountQuery = mysqli_query($con, "
    SELECT COUNT(*) 
    FROM tbl_product_master 
    WHERE user_id = '$product_user_id' 
    AND is_draft = 0
    AND product_status IN ('Active', 'Post Viewed', 'Under Negotiation')
");
                $totalProducts = mysqli_fetch_row($productCountQuery)[0];

                // Step 3: Exclude current product
                $otherProducts = $totalProducts > 0 ? $totalProducts - 1 : 0;

                // Step 4: Show button only if seller has more than 1 product (i.e., at least one more)
                if ($otherProducts > 0) {
            ?>
                    <div class="mt-3 text-center">
                        <button
                            data-product-id="<?= $product_id; ?>"
                            onclick="redirectWithProductId(this)"
                            style="padding:12px 28px !important; background-color:#c17533; border:none; font-size:12px; color:#fff; font-weight:400; border-radius:8px;">
                            View More Items from this seller +<?= $otherProducts; ?>
                        </button>
                    </div>
            <?php
                }
            }
            ?>



            <!-- Trigger Button -->
            <!--<div class="text-center">-->
            <!--    <button type="button" class="btn mt-4"-->
            <!--        style="padding: 6px 18px; border-radius: 6px; background-color: #b5753e; border-color: transparent;"-->
            <!--        data-bs-toggle="modal" data-bs-target="#product">Close Product</button>-->
            <!--</div>-->

            <?php if (
                $session_user_type === "Seller" &&
                in_array($product_status, ["Post Viewed", "Active", "Under Negotiation", "Offer Accepted", "Pickup Scheduled"])
            ): ?>
                <div class="text-center" data-product-id="<?= htmlspecialchars($product_id) ?>">
                    <button type="button" class="btn mt-4"
                        style="padding: 6px 18px; border-radius: 6px; background-color: #b5753e; border-color: transparent;"
                        data-bs-toggle="modal" data-bs-target="#product">
                        Withdraw Post
                    </button>
                </div>
            <?php endif; ?>




            <!-- Modal -->
            <div class="modal fade" id="product" tabindex="-1" role="dialog" aria-labelledby="productLabel">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document"> <!-- centered modal -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="productLabel">Choose a reason to
                                close this post.</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg text-dark" style="font-size:20px;"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="what-kind">

                            <!-- Radio Buttons for Reasons -->
                            <div class="form-group"> <!-- text color -->
                                <label class="radio-inline">
                                    <input type="radio" name="closeReason" value="Item no longer available"
                                        style="accent-color: #b5753e;"> Item no longer available
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="closeReason" value="Change of mind"
                                        style="accent-color: #b5753e;"> Change of mind
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="closeReason" value="Found a better deal elsewhere"
                                        style="accent-color: #b5753e;"> Found a better deal elsewhere
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="closeReason" value="Negotiation issues"
                                        style="accent-color: #b5753e;"> Negotiation issues
                                </label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="closeReason" value="Other" id="otherReason"
                                        style="accent-color: #b5753e;"> Other (Please specify)
                                </label><br>

                                <!-- Text field for "Other" reason -->
                                <div id="otherReasonText" style="display:none; margin-top: 10px;">
                                    <label for="otherReasonInput">Please specify:</label>
                                    <textarea rows="3" type="text" class="form-control" id="otherReasonInput"
                                        placeholder="Enter reason"></textarea>
                                </div>
                            </div>

                            <button class="next-button mt-3 btn btn-primary btn-block" onclick="colse_product()">NEXT</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($session_user_type === "Buyer") {
                $product_view_dataget = mysqli_query($con, "select view_id, assigned_collecter, seller_id, view_date, deal_status, purchased_price, negotiation_amount, negotiation_by, mssg, negotiation_date, accept_date, pickup_date, pickup_time, complete_date from tbl_user_product_view where buyer_id='" . $session_user_code . "' and product_id='" . $product_id . "' ");
                $product_view_data = mysqli_fetch_assoc($product_view_dataget);
            ?>
                <?php if (empty($close_reason)) { ?>
                    <div class="mt-4">
                        <h5 id="seller_info" style="color:#b5753e !important;">Seller Contact Info</h5>

                        <p id="seller_name">
                            <strong>Name:</strong> <?php echo $name; ?>
                        </p>

                        <p id="seller_num">
                            <strong>Number:</strong>
                            <a href="tel:<?php echo $country_code . $ph_num; ?>">
                                <?php echo $country_code . " " . $ph_num; ?>
                            </a>
                        </p>

                        <p id="seller_address">
                            <strong>Address:</strong>
                            <?php echo $address_line_1 . ", " . $landmark . ", " . $city . ", " . $state . " - " . $pincode . ", " . $country; ?>
                        </p>
                    </div>



                    <?php if (!$product_view_data) { ?>
                        <button class="view-seller-btn mt-3 mb-5" onclick="toggleConfirmBox()">Use Credits to view Seller Info</button>
                        <div class="modal fade" id="confirmBoxModal" tabindex="-1" aria-labelledby="confirmBoxLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="confirmBoxLabel">Are You Sure?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                                class="bi bi-x f-20"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $product_view_credit; ?> credits will be used to view the contact details. Would you
                                            like to proceed?</p>
                                    </div>
                                    <div class="modal-footer text-center" style="justify-content: center;">
                                        <button type="button" onclick="closeConfirmBox()" class="btn btn-light"
                                            style="padding: 6px 26px; background-color:rgb(218, 36, 36); color: #fff;"
                                            data-bs-dismiss="modal">No, Cancel!</button>
                                        <button type="button" onclick="userViewSellerDetails()" class="btn"
                                            style="padding: 6px 18px; border-radius: 6px; background-color: #00aa49; border-color: transparent;">Yes,
                                            Use Credits</button>
                                    </div>
                                </div>
                                <input type="hidden" id="user_id" value="<?php echo $session_user_code; ?>">
                            </div>
                        </div>
                    <?php
                    } else {
                        // Extract deal details when the product view data is available
                        $view_id = $product_view_data['view_id'];
                        $assigned_collecter = $product_view_data['assigned_collecter'];
                        $seller_id = $product_view_data['seller_id'];
                        $view_date = $product_view_data['view_date'];
                        $deal_status = $product_view_data['deal_status'];
                        $purchased_price = $product_view_data['purchased_price'];
                        $negotiation_amount = $product_view_data['negotiation_amount'];
                        $negotiation_by = $product_view_data['negotiation_by'];
                        $mssg = $product_view_data['mssg'];
                        $negotiation_date = $product_view_data['negotiation_date'];
                        $accept_date = $product_view_data['accept_date'];
                        $pickup_date = $product_view_data['pickup_date'];
                        $pickup_time = $product_view_data['pickup_time'];
                        $complete_date = $product_view_data['complete_date'];
                    ?>

                        <div class="row">
                            <div class="col-md-6">
                                <form class="product-form product-form-border hidedropdown">
                                    <h2 style="color: #c17533 !important; font-weight: 700 !important;">Deal Process Section:</h2>

                                    <?php
                                    if ($deal_status == "Credit Used" || $deal_status == "Under Negotiation") {
                                    ?>
                                        <p class="mt-3 mb-3" style="color: #000; font-weight: 500;">
                                            This deal opened on <?php echo dateFormat($view_date); ?> for you.<br> Or, You can also close the
                                            deal.
                                        </p>

                                        <?php if (empty($negotiation_by)) { ?>
                                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                                <h2>What do you want?</h2>
                                                <p style="font-weight: 600;">
                                                    The seller has offered a price of <?php echo (int) $sale_price; ?>. Would you like to negotiate
                                                    or accept the price?
                                                </p>
                                                <div class="d-flex mt-3 mb-2 text-center justify-content-center" style="width: 100%;">
                                                    <button type="button" onclick="buyerNegotiate()" class="btn btn-warning" style="padding: 6px 30px;
  border-radius: 6px;
  background-color: #C17533;
  border-color: #a34600;">
                                                        Accept and Negotiate
                                                    </button>
                                                    <!--                                              <button type="button" onclick="buyerAcceptPrice()" class="btn btn-success" style="padding: 8px 30px;-->
                                                    <!--border-radius: 6px;-->
                                                    <!--background-color: green;-->
                                                    <!--border-color: #fff;-->
                                                    <!--border:1px solid #fff;-->
                                                    <!--color:#fff;">-->

                                                    <!--                                                  Accept-->
                                                    <!--                                              </button>-->
                                                </div>
                                            </div>

                                            <div class="buyer_negotiate_div" style="display: none;">
                                                <div class="form-group">
                                                    <label for="negotiation_amount">Requested Price <span class="required">*</span></label>
                                                    <input type="number" id="negotiation_amount" class="form-control"
                                                        placeholder="Enter Requested Price" step="any" required min="1" />
                                                    <label class="input_alert negotiation_amount-inp-alert"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mssg">Want to send any message?</label>
                                                    <textarea id="mssg" class="form-control" placeholder="Type your message here..."
                                                        maxlength="500"></textarea>
                                                    <label class="input_alert mssg-inp-alert"></label>
                                                </div>
                                                <button type="button" onclick="buyerCancel()" class="btn btn-danger"
                                                    style="border:none; padding:8px 35px;">
                                                    Cancel
                                                </button>
                                                <button type="button" onclick="buyerSendRequest(event)" class="btn btn-success"
                                                    style="background-color: #C17533 !important; border:none;">
                                                    Send Request To Seller
                                                </button>
                                            </div>

                                        <?php } elseif ($negotiation_by == "Seller") { ?>
                                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                                <h2>What do you want?</h2>
                                                <p style="font-weight: 600;">
                                                    <?php

                                                    $last_price = '';
                                                    if (!empty($negotiation_amount) && strpos($negotiation_amount, ',') !== false) {
                                                        $last_price = substr(strrchr($negotiation_amount, ','), 1);
                                                    } else {
                                                        $last_price = $negotiation_amount;
                                                    }
                                                    ?>
                                                    The seller requested a negotiation price of <?php echo $last_price; ?>.

                                                    <?php if (!empty($mssg)) { ?>
                                                        <br>Message From Seller: <?php echo $mssg; ?>
                                                    <?php } ?>
                                                </p>
                                                <div style="width:100%; justify-content:center; text-align:center;">
                                                    <button style="padding: 10px 45px;" type="button" onclick="buyerNegotiate()" class="btn btn-warning">
                                                        Negotiate
                                                    </button>
                                                    <button style="padding: 10px 45px;" type="button" onclick="buyerAcceptPrice()" class="btn btn-success">
                                                        Accept
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="buyer_negotiate_div" style="display: none;">

                                                <div class="form-group">

                                                    <label for="negotiation_amount">Requested Price <span class="required">*</span></label>

                                                    <input type="number" id="negotiation_amount" class="form-control"
                                                        placeholder="Enter Requested Price" step="any" required min="1" />

                                                    <label class="input_alert negotiation_amount-inp-alert"></label>

                                                </div>

                                                <div class="form-group">

                                                    <label for="mssg">Want to send any message?</label>

                                                    <textarea id="mssg" class="form-control" placeholder="Type your message here..."
                                                        maxlength="500"></textarea>

                                                    <label class="input_alert mssg-inp-alert"></label>

                                                </div>

                                                <button type="button" onclick="buyerCancel()" class="btn btn-danger"
                                                    style="border:none; padding:8px 35px;">

                                                    Cancel

                                                </button>

                                                <button type=" button" onclick="buyerSendRequest(event)" class="btn btn-success"
                                                    style="background-color: #C17533 !important; border:none;">

                                                    Send Request To Seller

                                                </button>

                                            </div>

                                        <?php } else { ?>
                                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                                <h2>Your request has been sent!</h2>
                                                <p style="font-weight: 600;">
                                                    You have requested a negotiation at a price of <?php echo (int) $negotiation_amount; ?>. Waiting
                                                    for the seller's response.
                                                    <?php if (!empty($mssg)) { ?>
                                                        <br>Message From You: <?php echo $mssg; ?>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                        <?php } ?>

                                    <?php } elseif ($deal_status == "Offer Accepted") { ?>
                                        <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                            <h2>Offer Accepted</h2>
                                            <p style="font-weight: 600;">
                                                Deal accepted at a price of <?php echo (int) $negotiation_amount; ?>.
                                                <?php if (!empty($mssg)) { ?>
                                                    <br>Message From You: <?php echo $mssg; ?>
                                                <?php } ?>
                                            </p>
                                        </div>

                                    <?php } elseif ($deal_status == "Pickup Scheduled") { ?>
                                        <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp"
                                            style="width: 100% !important;">
                                            <h2>Waiting for Pickup</h2>
                                            <p style="font-weight: 600;">
                                                Pickup Date: <?php echo dateFormat($pickup_date); ?>
                                            </p>

                                            <button type="button" onclick="buyerPickupComplete(<?php echo $view_id; ?>)"
                                                class="btn btn-success">
                                                Pickup Complete
                                            </button>

                                        </div>

                                    <?php } elseif ($deal_status == "Completed") { ?>
                                        <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp"
                                            style="width: 100%;">
                                            <h2>Deal Completed</h2>
                                            <p style="font-weight: 600;">
                                                Completion date: <?php echo dateFormat($complete_date); ?>
                                            </p>

                                            <?php
                                            $dataget = mysqli_query($con, "SELECT * FROM tbl_ratings WHERE give_user_id='$session_user_code' AND to_user_id='$seller_id' AND rating_from='Buyer' AND view_id='$view_id'");
                                            if (!mysqli_fetch_row($dataget)) {
                                            ?>
                                                <?php if (empty($close_reason)): ?>
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#seller_ratings_modal"
                                                        class="btn btn-warning">
                                                        Give Ratings to Seller
                                                    </button>
                                                <?php endif; ?>

                                            <?php } ?>
                                        </div>

                                    <?php } else { ?>
                                        <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                            <h2>Deal Cancelled</h2>
                                            <p style="font-weight: 600;">
                                                Some other buyer closed the deal.
                                            </p>
                                        </div>
                                    <?php } ?>

                                </form>
                            </div>

                            <?php if ($deal_status != "Completed") { ?>
                                <div class="col-md-6">
                                    <form class="product-form  hidedropdown">
                                        <h2 style="color: #C17533; font-weight: 400;">Collector Assigned Section : </h2>
                                        <?php
                                        // if collector not asigned
                                        if ($assigned_collecter == "") {
                                        ?>
                                            <p style="color: #C17533; font-weight: 500;">
                                                This deal opened on <?php echo dateFormat($view_date); ?> for you.<br> Either, Assign a collector to
                                                close the deal.
                                            </p>

                                            <div class="form-group">
                                                <label for="collector_id">Collector <span class="required">*</span></label>
                                                <select class="form-control" id="collector_id" required>
                                                    <?php
                                                    $collecter_dataget = mysqli_query($con, "SELECT user_id, name, ph_num FROM tbl_user_master WHERE under_buyer_id='$session_user_code' AND user_type='Collector' ");
                                                    $collecter_data_rw_num = mysqli_num_rows($collecter_dataget);

                                                    if ($collecter_data_rw_num == 0) { ?>
                                                        <option value="">No collector found</option>
                                                    <?php } else { ?>
                                                        <option value="">Choose Collector</option>
                                                        <?php while ($rw = mysqli_fetch_array($collecter_dataget)) { ?>
                                                            <option value="<?php echo $rw['user_id']; ?>">
                                                                <?php echo $rw['name'] . " [" . $rw['ph_num'] . "]"; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <label data-default-mssg="" class="input_alert collector_id-inp-alert"></label>
                                            </div>

                                            <?php if ($collecter_data_rw_num == 0) { ?>
                                                <div class="col text-left">
                                                    <a href="<?php echo $baseUrl; ?>/add-collector">
                                                        <button type="button" class="btn btn-primary">
                                                            <img src="frontend_assets/img-icon/add.png"
                                                                style="margin-left: 4px; width: 25px;" />&nbsp;Add Collector
                                                        </button>
                                                    </a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($collecter_data_rw_num != 0) { ?>
                                                <button type="button" onclick="assignCollector()" class="btn btn-secondary product-form-cart-submit"
                                                    style="margin-bottom: 50px !important; background-color: #c17533; font-size: 14px;
                                                border:none; font-weight: 500; padding: 3px 10px !important;">
                                                    <i class="bi bi-person-circle" style="font-size: 18px; color:#000;"></i>
                                                    <span>&nbsp; Assign Collector</span>
                                                </button>
                                            <?php } ?>

                                        <?php
                                        }
                                        // if collector asigned then show collector details
                                        else {
                                            $assigned_collector_dataget = mysqli_query($con, "SELECT name, country_code, ph_num, user_img FROM tbl_user_master WHERE user_id='$assigned_collecter' AND active='Yes' ");
                                            $assigned_collector_data = mysqli_fetch_row($assigned_collector_dataget);
                                            $collector_name = $assigned_collector_data[0];
                                            $country_code = $assigned_collector_data[1];
                                            $ph_num = $assigned_collector_data[2];
                                            $user_img = $assigned_collector_data[3];
                                        ?>
                                            <div style="margin-bottom: 40px;">
                                                <p style="margin-top: 10px; color: red; font-weight: 600; margin-bottom: 5px;">You already
                                                    assigned a
                                                    collector</p>
                                                <h3>
                                                    <i class="bi bi-person f-20"></i>
                                                    <?php echo $collector_name; ?> [
                                                    <a href="tel:<?php echo $country_code . $ph_num; ?>">
                                                        <?php echo $country_code . " " . $ph_num; ?>
                                                    </a>]
                                                </h3>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Give Seller Ratings Modal -->
                        <div class="modal fade" id="seller_ratings_modal" tabindex="-1" aria-labelledby="sellerRatingsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="sellerRatingsModalLabel">Ratings For Seller</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                                class="bi bi-x f-20"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="rating_seller_id" value="<?php echo $seller_id; ?>" />
                                        <input type="hidden" id="rating_view_id" value="<?php echo $view_id; ?>" />
                                        <form>
                                            <div class="form-group mb-3">
                                                <label for="rating">How many ratings would you like to give the seller? <span
                                                        class="required">*</span></label>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star star-1" onclick="ratingStar(1)"></i>
                                                    <i class="fa fa-star star-2" onclick="ratingStar(2)"></i>
                                                    <i class="fa fa-star star-3" onclick="ratingStar(3)"></i>
                                                    <i class="fa fa-star star-4" onclick="ratingStar(4)"></i>
                                                    <i class="fa fa-star star-5" onclick="ratingStar(5)"></i>
                                                </div>
                                                <input type="number" value="" id="rating" required min="1" max="5" class="d-none" />
                                                <label data-default-mssg="" class="input_alert rating-inp-alert"></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="review">Review</label>
                                                <textarea id="review" class="form-control" placeholder="Write a Review"
                                                    maxlength="500"></textarea>
                                                <label data-default-mssg="" class="input_alert review-inp-alert"></label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" onclick="buyerSaveRatings();" class="btn btn-primary m-0">
                                            <span>Submit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <!--<div class="text-center mt-4 p-3" style="background-color:#c17533; border-radius:5px;">-->

                    <!--    <p style="color:#fff;">This Post has been withdrawn by the seller due to  <?php echo htmlspecialchars($close_reason); ?> </p>-->
                    <!--</div>-->
                    <!--                    <center><button style="font-size:12px; background-color: #ffeedf; color:#000;" type="button" class="btn mt-3" data-bs-toggle="modal" data-bs-target="#withdrawModal">-->
                    <!--  Withdrawal Reason-->
                    <!--</button> <a style="font-size:12px; color:#000;" href="product_list" class="btn btn-warning mt-3">-->
                    <!-- View More Items-->
                    <!--</a></center>-->
                    <div class="modal fade" id="withdrawModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0" style="border-radius: 10px; overflow: hidden;">
                                <!-- Close Button -->


                                <!-- No header/footer to keep your design intact -->
                                <div class="text-center p-3 pt-4" style="background-color:#c17533; border-radius:5px;">
                                    <p style="color:#fff; margin: 0;">
                                        This Post has been withdrawn by the seller <a style="font-size:12px; color:#000; background-color:#ffeedf !important;" href="product_list" class="btn btn-warning mt-3">
                                            View More Items
                                        </a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php } ?>


                <?php } elseif ($session_user_type == "Seller") {

                if (!empty($close_reason)) {
                ?>
                    <!-- Modal HTML -->
                    <div class="modal fade" id="SellerwithdrawModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0" style="border-radius: 10px; overflow: hidden;">
                                <div class="text-center p-3 pt-4" style="background-color:#c17533; border-radius:5px;">
                                    <p style="color:#fff; margin: 0;">
                                        This post has been withdrawn by you <br>
                                        <a style="font-size:12px; color:#000; background-color:#ffeedf !important;" href="product_list" class="btn btn-warning mt-3">
                                            Go Back
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var myModal = new bootstrap.Modal(document.getElementById('SellerwithdrawModal'));
                            myModal.show();
                        });
                    </script>

                <?php
                    // STOP execution after modal
                    return;
                }

                // ELSE: $close_reason is empty, continue with your SQL
                $dataget = mysqli_query($con, "SELECT 
        tbl_user_product_view.view_id,
        tbl_user_product_view.buyer_id,
        tbl_user_master.name, 
        tbl_user_master.user_img, 
        tbl_user_master.country_code, 
        tbl_user_master.ph_num, 
        tbl_user_product_view.assigned_collecter,
        tbl_user_product_view.deal_status, 
        tbl_user_product_view.purchased_price, 
        tbl_user_product_view.negotiation_amount, 
        tbl_user_product_view.negotiation_by, 
        tbl_user_product_view.mssg, 
        tbl_user_product_view.negotiation_date, 
        tbl_user_product_view.accept_date, 
        tbl_user_product_view.pickup_date, 
        tbl_user_product_view.pickup_time, 
        tbl_user_product_view.complete_date 
        FROM tbl_user_product_view 
        LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_user_product_view.buyer_id
        WHERE tbl_user_product_view.product_id = '" . $product_id . "' AND 
              tbl_user_product_view.seller_id = '" . $session_user_code . "' AND
              tbl_user_product_view.deal_status <> 'Credit Used' 
        ORDER BY tbl_user_product_view.entry_timestamp DESC");

                if (mysqli_num_rows($dataget) > 0) {
                    // Your normal content rendering goes here
                ?>


                    <?php
                    ?>
                    <?php if (empty($close_reason)) { ?>

                        <form class="product-form product-form-border hidedropdown">
                            <h2 style="color: #C17533; font-weight: 400;">Make Your Offer : </h2>
                            <div class="request-list-div">
                                <div class="row">
                                    <?php
                                    // get this product's buyer view
                                    $i = 1;

                                    while ($rw = mysqli_fetch_array($dataget)) {

                                        if ($rw['deal_status'] == "Offer Accepted" || $rw['deal_status'] == "Completed") {
                                            $badgesClass = "success-badge";
                                        } elseif ($rw['deal_status'] == "Credit Used" || $rw['deal_status'] == "Under Negotiation") {
                                            $badgesClass = "info-badge";
                                        } elseif ($rw['deal_status'] == "Pickup Scheduled") {
                                            $badgesClass = "warning-badge";
                                        } else {
                                            $badgesClass = "danger-badge";
                                        }
                                    ?>
                                        <div class="col-md-4">
                                            <div class="buyer-request-div">

                                                <?php


                                                if (!empty($close_reason)) {
                                                    // Product was closed by the seller
                                                    echo '<span class="badges ' . $badgesClass . '" style="background-color:#dc362e !important;">Closed By Seller</span>';
                                                } else {
                                                    // Show deal status from your result
                                                    echo '<span class="badges ' . $badgesClass . '">' . $rw['deal_status'] . '</span>';
                                                }
                                                ?>

                                                <h4 class="heading">Buyer Details :</h4>
                                                <div class="user-info-div">
                                                    <!-- <img
                                                    src="./upload_content/upload_img/user_img/<?php echo $rw['user_img'] == "" ? "default.png" : $rw['user_img']; ?>" /> -->
                                                    <i class="bi bi-person uicon-u"></i>
                                                    <?php echo $rw['name']; ?>
                                                    <br />
                                                    <a href="tel:<?php echo $rw['country_code'] . $rw['ph_num']; ?>"><i
                                                            class="bi bi-telephone uicon"></i>
                                                        : <?php echo $rw['country_code'] . " " . $rw['ph_num']; ?></a>
                                                </div>

                                                <?php
                                                if ($rw['assigned_collecter'] != "") {
                                                    $collector_dataget = mysqli_query($con, "select name, country_code, ph_num, user_img from tbl_user_master where user_id='" . $rw['assigned_collecter'] . "' ");
                                                    $collector_data = mysqli_fetch_assoc($collector_dataget);

                                                    if ($collector_data) {
                                                ?>
                                                        <h4 class="heading">Collector Details :</h4>
                                                        <div class="user-info-div">
                                                            <i class="bi bi-person-circle" style="font-size: 18px; color:#000;"></i>
                                                            <?php echo $collector_data['name']; ?>
                                                            <br />
                                                            <a href="tel:<?php echo $collector_data['country_code'] . $collector_data['ph_num']; ?>"><i
                                                                    class="bi bi-telephone" style="font-size: 18px;"></i> :
                                                                <?php echo $collector_data['country_code'] . " " . $collector_data['ph_num']; ?></a>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>

                                                <h4 class="heading">Offer Details :</h4>
                                                <div class="user-info-div">
                                                    <?php
                                                    // Get the last value from negotiation_amount
                                                    $negotiation_values = explode(',', $rw['negotiation_amount']);
                                                    $last_negotiation_price = end($negotiation_values); // gets the last element (e.g., 40)

                                                    echo '<label>Offered Price : ' . $last_negotiation_price . ' /-</label>';

                                                    if (!empty($rw['mssg'])) {
                                                        echo '<label>Message : ' . $rw['mssg'] . '</label>';
                                                    }
                                                    ?>
                                                </div>

                                                <!-- Deal status wise action  -->

                                                <?php
                                                if ($rw['deal_status'] == "Offer Accepted") {
                                                ?>
                                                    <button type="button" onclick="sellerAcceptPrice(<?php echo $rw['view_id']; ?>)" class="btn"
                                                        style="padding: 6px 40px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                                        Schedule Pickup
                                                    </button>
                                                <?php
                                                } elseif ($rw['deal_status'] == "Pickup Scheduled") {
                                                ?>
                                                    <p>Pickup Date : <?php echo dateFormat($rw['pickup_date']); ?></p>

                                                <?php
                                                } elseif ($rw['deal_status'] == "Completed") {
                                                ?>
                                                    <p>The Deal is Completed on <?php echo dateFormat($rw['complete_date']); ?></p>

                                                    <?php
                                                    if ($product_status != "Completed") {
                                                    ?>
                                                        <button type="button" onclick="sellerCloseProduct(<?php echo $rw['view_id'] ?>)" class="btn"
                                                            style="padding: 6px 40px; border-radius: 6px; background-color: #b5753e; border-color: #a34600;">
                                                            Close Product
                                                        </button>
                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($product_status == "Completed") {
                                                        // check seller already give ratings to buyer
                                                        $dataget = mysqli_query($con, "select * from tbl_ratings where give_user_id='" . $session_user_code . "' and to_user_id='" . $rw['buyer_id'] . "' and rating_from='Seller' and view_id='" . $rw['view_id'] . "' ");
                                                        $data = mysqli_fetch_row($dataget);
                                                        if (!$data) {
                                                    ?>

                                                            <?php if (empty($close_reason)): ?>
                                                                <button type="button"
                                                                    onclick="openRatingModal(<?php echo (int) $rw['buyer_id']; ?>, <?php echo (int) $rw['view_id']; ?>)"
                                                                    data-bs-toggle="modal" data-bs-target="#buyer_ratings_modal" class="btn"
                                                                    style="padding: 6px 40px; border-radius: 6px; background-color: #C17533; border-color: #a34600;">
                                                                    Give Ratings to Buyer
                                                                </button>
                                                            <?php endif; ?>

                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                } elseif ($rw['deal_status'] == "Under Negotiation") {

                                                    if ($rw['negotiation_by'] == "Seller") {

                                                        echo '<p>Requested By You</p>';
                                                    } else {
                                                    ?>
                                                        <div class="text-center">
                                                            <button type="button" onclick="sellerNegotiate(<?php echo $rw['view_id']; ?>)" class="btn"
                                                                style="padding: 10px 40px; border-radius: 6px; background-color: #b5753e; border-color: #a34600;">
                                                                Negotiate
                                                            </button>
                                                            <button type="button" onclick="sellerAcceptPrice(<?php echo $rw['view_id']; ?>)" class="btn"
                                                                style="padding: 10px 40px; border-radius: 6px; background-color: #198754; color:#fff; border-color: none;">
                                                                Accept
                                                            </button>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                } else {
                                                    echo '<p>The deal was cancelled</p>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if ($i == 1) {
                            ?>
                                <center>
                                    <h3>No Items Found</h3>
                                </center>
                            <?php
                            }
                            ?>

                        </form>

                        <!-- Price Request Modal -->
                        <div class="modal fade" id="price_request_modal" tabindex="-1" aria-labelledby="priceRequestModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="priceRequestModalLabel">Send Your Price Request</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                                class="bi bi-x f-20"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="nego_view_id" value="" />
                                        <form class="add-address-from" method="post" action="#">
                                            <div class="form-group">
                                                <label for="negotiation_amount">Negotiate Price <span class="required">*</span></label>
                                                <input type="text" value="" id="negotiation_amount" class="form-control"
                                                    placeholder="Enter Negotiate Price" step="any" required min="1" />
                                                <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="mssg">Want to sent any message ?</label>
                                                <textarea id="mssg" class="form-control" placeholder="Type your message here ...."
                                                    maxlength="500"></textarea>
                                                <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" onclick="sellerSendRequest();" class="btn btn-primary m-0">
                                            <span class="f-15">Send Request To Buyer/Collector</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pickup Schedule Modal -->
                        <div class="modal fade" id="pickup_schedule_modal" tabindex="-1" aria-labelledby="pickupScheduleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"> <!-- Ensures Centering -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="pickupScheduleModalLabel">Send Your Pickup Request</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                                class="bi bi-x f-20"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="pickup_view_id" value="" />
                                        <form class="add-address-from" method="post" action="#">
                                            <div class="form-group">
                                                <label for="pickup_date">Pickup Date <span class="required">*</span></label>
                                                <input type="date" id="pickup_date" class="form-control" placeholder="Enter Pickup Date"
                                                    required min="<?php echo date('Y-m-d'); ?>" />
                                                <label data-default-mssg="" class="input_alert pickup_date-inp-alert"></label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" onclick="updatePickupDate();" class="btn btn-primary m-0">
                                            <span class="f-15">Update Pickup Date</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Give Buyer Ratings Modal -->
                        <div class="modal fade" id="buyer_ratings_modal" tabindex="-1" aria-labelledby="buyerRatingsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="buyerRatingsModalLabel">Ratings For Buyer</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                                class="bi bi-x f-20"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="rating_buyer_id" value="" />
                                        <input type="hidden" id="rating_view_id" value="" />
                                        <form>

                                            <div class="form-group mb-3">
                                                <label for="rating">How many ratings would you like to give the buyer? <span
                                                        class="required">*</span></label>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star star-1" onclick="ratingStar(1)"></i>
                                                    <i class="fa fa-star star-2" onclick="ratingStar(2)"></i>
                                                    <i class="fa fa-star star-3" onclick="ratingStar(3)"></i>
                                                    <i class="fa fa-star star-4" onclick="ratingStar(4)"></i>
                                                    <i class="fa fa-star star-5" onclick="ratingStar(5)"></i>
                                                </div>
                                                <input type="number" value="" id="rating" required min="1" max="5" class="d-none" />
                                                <label data-default-mssg="" class="input_alert rating-inp-alert"></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="review">Review</label>
                                                <textarea id="review" class="form-control" placeholder="Write a Review"
                                                    maxlength="500"></textarea>
                                                <label data-default-mssg="" class="input_alert review-inp-alert"></label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" onclick="sellerSaveRatings();" class="btn btn-primary m-0">
                                            <span>Submit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>



                        <div class="modal fade" id="SellerwithdrawModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0" style="border-radius: 10px; overflow: hidden;">
                                    <!-- Close Button -->


                                    <!-- No header/footer to keep your design intact -->
                                    <div class="text-center p-3 pt-4" style="background-color:#c17533; border-radius:5px;">
                                        <p style="color:#fff; margin: 0;">
                                            This post has been withdrawn by you <a style="font-size:12px; color:#000; background-color:#ffeedf !important;" href="product_list" class="btn btn-warning mt-3">
                                                Go Back
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>


                    <?php } ?>


                <?php
                }
            } else {

                $product_view_dataget = mysqli_query($con, "select view_id, view_date, deal_status, purchased_price, negotiation_amount, negotiation_by, mssg, negotiation_date, accept_date, pickup_date, pickup_time, complete_date from tbl_user_product_view where assigned_collecter='" . $session_user_code . "' and product_id='" . $product_id . "' ");
                $product_view_data = mysqli_fetch_assoc($product_view_dataget);

                $view_id = $product_view_data['view_id'];
                $assigned_collecter = $product_view_data['assigned_collecter'];
                $view_date = $product_view_data['view_date'];
                $deal_status = $product_view_data['deal_status'];
                $purchased_price = $product_view_data['purchased_price'];
                $negotiation_amount = $product_view_data['negotiation_amount'];
                $negotiation_by = $product_view_data['negotiation_by'];
                $mssg = $product_view_data['mssg'];
                $negotiation_date = $product_view_data['negotiation_date'];
                $accept_date = $product_view_data['accept_date'];
                $pickup_date = $product_view_data['pickup_date'];
                $pickup_time = $product_view_data['pickup_time'];
                $complete_date = $product_view_data['complete_date'];
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Seller contact information  -->
                        <div class="sort-description">
                            <h3 class="text-center">Seller Contact Information</h3>
                            <p class="product-sku"><b>Seller Name:</b>
                                <span class="text">
                                    <?php echo $product_view_data ? $name : substr($name, 0, 2) . "***"; ?>
                                </span>
                            </p>
                            <p class="product-sku"><b>Contact Number:</b>
                                <span class="text">
                                    <?php echo $product_view_data ? '<a href="tel:' . $country_code . $ph_num . '">' . $country_code . " " . $ph_num . '</a>' : $country_code . " " . substr($ph_num, 0, 3) . "***"; ?>
                                </span>
                            </p>
                            <?php
                            if ($email != "") {
                            ?>
                                <p class="product-sku"><b>Email:</b>
                                    <span class="text">
                                        <?php echo $product_view_data ? '<a href="mailto:' . $email . '">' . $email . '</a>' : substr($email, 0, 2) . "***"; ?>
                                    </span>
                                </p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form class="product-form product-form-border hidedropdown">
                            <h2 style="color: #C17533; font-weight: 400;">Deal Process Section : </h2>

                            <?php
                            if ($deal_status == "Offer Made" || $deal_status == "Under Negotiation") {
                            ?>
                                <p style="text-align: center; color: #0088ff; font-weight: 500;">
                                    This deal opened on <?php echo dateFormat($view_date); ?> for you.<br> Or, You can also close the
                                    deal.
                                </p>
                                <?php
                                // if any request not inserted
                                if ($negotiation_by == "") {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>What do you want ?</h2>
                                        <p style="font-weight: 600;">
                                            The seller has offered at a price of <?php echo ((int) $sale_price); ?>. Would you like to
                                            negotiate or accept the price?
                                        </p>
                                        <button type="button" onclick="buyerNegotiate()" class="btn"
                                            style="padding: 6px 40px; border-radius: 6px; background-color: #C17533; border-color: #a34600;">
                                            <img class="img" src="frontend_assets/img-icon/no.png" />
                                            I want to Negotiate
                                        </button>
                                        <button type="button" onclick="buyerAcceptPrice()" class="btn"
                                            style="padding: 6px 40px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                            <img class="img" src="frontend_assets/img-icon/yes.png" />
                                            I accept
                                        </button>
                                    </div>
                                    <div class="buyer_negotiate_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="negotiation_amount">Requested Price <span class="required">*</span></label>
                                            <input type="number" id="negotiation_amount" class="form-control"
                                                placeholder="Enter Requested Price" step="any" required min="1" />
                                            <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="mssg">Want to sent any message ?</label>
                                            <textarea id="mssg" class="form-control" placeholder="Type your message here ...."
                                                maxlength="500"></textarea>
                                            <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                        </div>
                                        <button type="button" onclick="buyerCancel()" class="btn btn-secondary product-form-cart-submit"
                                            style="background: #9d1111; border: 0px; border-radius: 5px;">
                                            <span>Cancel</span>
                                        </button>
                                        <button type="button" onclick="buyerSendRequest(event)"
                                            class="btn btn-secondary product-form-cart-submit"
                                            style="background: #c17533; border: 0px; border-radius: 5px;">
                                            <span>Send Request To Seller</span>
                                        </button>
                                    </div>
                                <?php
                                }
                                // if request submitted from seller end
                                elseif ($negotiation_by == "Seller") {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>What do you want ?</h2>
                                        <p style="font-weight: 600;">
                                            This product's requested negotiation price is <?php echo ((int) $negotiation_amount); ?> from
                                            seller side. Do you want to negotiate or accept the price ?
                                            <?php
                                            if ($mssg != "") {
                                            ?>
                                                Message From Seller : <?php echo $mssg; ?>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <button type="button" onclick="buyerNegotiate()" class="btn"
                                            style="padding: 6px 40px; border-radius: 6px; background-color: #C17533; border-color: #a34600;">
                                            <img class="img" src="frontend_assets/img-icon/no.png" />
                                            No, I want to Negotiate
                                        </button>
                                        <button type="button" onclick="buyerAcceptPrice()" class="btn"
                                            style="padding: 6px 40px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                            <img class="img" src="frontend_assets/img-icon/yes.png" />
                                            Yes, I accept
                                        </button>
                                    </div>
                                    <div class="buyer_negotiate_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="negotiation_amount">Negotiate Price <span class="required">*</span></label>
                                            <input type="number" id="negotiation_amount" class="form-control"
                                                placeholder="Enter Requested Price" step="any" required min="1" />
                                            <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="mssg">Want to sent any message ?</label>
                                            <textarea id="mssg" class="form-control" placeholder="Type your message here ...."
                                                maxlength="500"></textarea>
                                            <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                        </div>
                                        <button type="button" onclick="buyerCancel()" class="btn btn-secondary product-form-cart-submit"
                                            style="background: #9d1111; border: 0px; border-radius: 5px;">
                                            <span>Cancel</span>
                                        </button>
                                        <button type="button" onclick="buyerSendRequest(event)"
                                            class="btn btn-secondary product-form-cart-submit"
                                            style="background: #00954f; border: 0px; border-radius: 5px;">
                                            <span>Send Request To Seller</span>
                                        </button>
                                    </div>
                                <?php
                                }
                                // if request send from buyer or collector side
                                else {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>Your request has been sent! Waiting for seller's confirmation.</h2>
                                        <p style="font-weight: 600;">
                                            You have requested a negotiation at a price of <?php echo ((int) $negotiation_amount); ?>. Let’s
                                            wait for the seller's response.
                                            <?php
                                            if ($mssg != "") {
                                            ?>
                                                Message From You : <?php echo $mssg; ?>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php
                                }
                            } elseif ($deal_status == "offer Accepted") {
                                ?>
                                <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                    <h2>Your request has been sent! Waiting for seller's confirmation.</h2>
                                    <p style="font-weight: 600;">
                                        Deal accepted by at a price of <?php echo ((int) $negotiation_amount); ?>! Waiting for the
                                        seller's confirmation and pickup details
                                        <?php
                                        if ($mssg != "") {
                                        ?>
                                            Message From You : <?php echo $mssg; ?>
                                        <?php
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php
                            } elseif ($deal_status == "Pickup Schedule") {
                            ?>
                                <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp"
                                    style="width: 100% !important;">
                                    <h2>Waiting for pickup</h2>
                                    <p style="font-weight: 600;">
                                        Pickup Date : <?php echo dateFormat($pickup_date); ?>

                                    </p>
                                    <!-- <p style="font-weight: 600;">
                                Pickup Time : <?php echo timeFormat($rw['pickup_time']); ?>
                            </p> -->

                                    <button type="button" onclick="buyerPickupComplete(<?php echo $view_id; ?>)" class="btn"
                                        style="padding: 6px 40px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                        Pickup Complete
                                    </button>

                                </div>
                            <?php
                            } elseif ($deal_status == "Completed") {
                            ?>
                                <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp"
                                    style="width:100%;">
                                    <h2>Deal completed</h2>
                                    <p style="font-weight: 600;">
                                        Completion date : <?php echo dateFormat($complete_date); ?>
                                    </p>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                    <h2>Deal was cancelled </h2>
                                    <p style="font-weight: 600;">
                                        Some other buyer crack the deal
                                    </p>
                                </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>

            <?php
            }
            ?>


        </div>

    <?php
    } else {
    ?>
        <div class="container">
            <div class="product-single">
                <h2 class="text-center">No Product Found</h2>
            </div>
        </div>
    <?php
    }
} else { // If product_id is empty or invalid
    ?>
    <div class="container">
        <div class="product-single">
            <h2 class="text-center">Invalid Product ID</h2>
        </div>
    </div>
<?php
}
?>

<div id="insufficientCreditsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Insufficient Credits</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="path-to-warning-icon.png" alt="Warning" style="width: 50px; height: 50px;">
                <p>Oops! You do not have enough credits for this.</p>
                <button class="btn btn-primary" onclick="window.location.href='wallet'">Add More Credits</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Overlay -->
<!-- Insufficient Credits Modal -->