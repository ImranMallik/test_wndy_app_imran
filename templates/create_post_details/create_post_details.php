<?php
include("module_function/date_time_format.php");

// Fetch product_view_credit
$system_info_dataget = mysqli_query($con, "SELECT product_view_credit FROM system_info WHERE 1");
if ($system_info_data = mysqli_fetch_row($system_info_dataget)) {
    $product_view_credit = $system_info_data[0];
} else {
    $product_view_credit = 0;
}
$user_info = $session_user_code;

$create_post_id = isset($arr[2]) ? $arr[2] : null;
// print_r($create_post_id);

if ($create_post_id) {
    // SQL query for fetching product details based on productId
    $query = "
SELECT 
    cp.create_post_id, 
    cp.product_id, 
    cp.category_id, 
    cp.create_post_name, 
    cp.create_post_sale_price, 
    cp.create_post_status, 
    cp.create_post_by_id, 
    cp.description, 
    cp.brand, 
    cp.quantity,
    pm.product_status,   
    pm.address_id,       
    um.name,             
    um.country_code,     
    um.ph_num,           
    um.email_id,
    cm.category_name,
    cf.file_name
FROM tbl_create_post AS cp
LEFT JOIN tbl_product_master AS pm ON cp.product_id = pm.product_id
INNER JOIN tbl_create_post_file AS cf ON cp.create_post_id = cf.create_post_product_file_id
LEFT JOIN tbl_user_master AS um ON cp.create_post_by_id = um.user_id
LEFT JOIN tbl_category_master AS cm ON cp.category_id = cm.category_id
WHERE cp.product_id = '$create_post_id'";


    $product_details_get = mysqli_query($con, $query);
    $product_details = mysqli_fetch_assoc($product_details_get);
    $product_id = $product_details['product_id'];


    // Check if the product details are found
    if (!$product_details) {
        echo '<div class="container"><div class="product-single"><h2 class="text-center">No Product Found</h2></div></div>';
    } else {
        // Fetch the product image for display
        $product_file_dataget = mysqli_query($con, "SELECT file_name FROM tbl_create_post_file WHERE product_id = '$product_id' AND file_type = 'Photo' AND active = 'Yes'");
        $imageFiles = [];
        while ($row = mysqli_fetch_assoc($product_file_dataget)) {
            $imageFiles[] = $row['file_name'];
        }
        // If no images found, set a default 'no_image.png'
        if (empty($imageFiles)) {
            $imageFiles[] = 'no_image.png';
        }
        // print_r($imageFiles);

        $sale_price = isset($product_details['create_post_sale_price']) ? $product_details['create_post_sale_price'] : 'N/A';
        $country_code = isset($product_details['country_code']) ? $product_details['country_code'] : 'N/A';
        $name = isset($product_details['name']) ? $product_details['name'] : 'N/A';
        $email = isset($product_details['email_id']) ? $product_details['email_id'] : 'N/A';
        $ph_num = isset($product_details['ph_num']) ? $product_details['ph_num'] : 'N/A';
        $creator_id = $product_details['create_post_by_id'];
?>

        <script>
            const product_view_credit = <?php echo $product_view_credit; ?>;
            let create_post_id = "<?php echo $create_post_id; ?>";
        </script>


        <!-- Page Header -->
        <div class="page-header text-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <!-- Breadcrumbs -->
                        <div class="breadcrumbs">
                            <a href="<?php echo $baseUrl . "/home"; ?>" title="Back to the home page">Home</a>
                            <span class="main-title fw-bold">
                                <i class="icon anm anm-angle-right-l"></i>
                                <?php echo htmlspecialchars($product_details['create_post_name']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <div class="product-single">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-img mb-4 mb-md-0">
                        <div class="product-details-img product-horizontal-style">
                            <!-- Product Image -->
                            <div class="zoompro-wrap">
                                <div class="zoompro-span">
                                    <img id="zoompro" class="zoompro" src="upload_content/upload_img/product_img/<?php echo  $product_details['file_name']; ?>" style="object-fit: cover; height: 300px; width: 100%;" data-zoom-image="upload_content/upload_img/product_img/<?php echo $product_details['file_name']; ?>" alt="product" />
                                </div>
                            </div>

                            <!-- Product Thumb -->
                            <div class="product-thumb product-horizontal-thumb mt-3">
                                <div id="gallery" class="product-thumb-horizontal">
                                    <?php
                                    // Fetch all product photos
                                    $product_file_list_dataget = mysqli_query($con, "SELECT file_name FROM tbl_create_post_file WHERE product_id = '$productId' AND file_type = 'Photo' AND active = 'Yes'");
                                    while ($rw = mysqli_fetch_assoc($product_file_list_dataget)) {
                                    ?>
                                        <a data-image="upload_content/upload_img/product_img/<?php echo $rw['file_name']; ?>" data-zoom-image="upload_content/upload_img/product_img/<?php echo $rw['file_name']; ?>" class="slick-slide slick-cloned active">
                                            <img class="blur-up lazyload" data-src="upload_content/upload_img/product_img/<?php echo $rw['file_name']; ?>" src="upload_content/upload_img/product_img/<?php echo $rw['file_name']; ?>" alt="product" style="object-fit: cover; height: 88px; width: 100%;" />
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-info">
                        <!-- Product Details -->
                        <div class="product-single-meta" style="display: flex; justify-content: space-between; align-items: center; word-wrap: break-word; white-space: wrap;">
                            <h2 class="product-main-title" style="width: 80%;"><?php echo htmlspecialchars($product_details['create_post_name']); ?></h2>
                            <?php if ($session_user_type == "buyer" && $product_details['product_status'] == "Active") { ?>
                                <a href="<?php echo "./seller-post/" . $productId; ?>" class="btn btn-primary btn-sm-2" style="border-radius:3px;">
                                    <img src="frontend_assets/img-icon/edit.png" height="25" width="25" style="padding-left: 4px;" />
                                </a>
                            <?php } ?>
                        </div>

                        <!-- Product Info -->
                        <div class="product-info">
                            <p class="product-type">Category: <span class="text"><?php echo htmlspecialchars($product_details['category_name']); ?></span></p>
                            <p class="product-sku">Brand/Manufacture: <span class="text"><?php echo $product_details['brand']; ?></span></p>
                            <p class="product-sku">Quantity:
                                <span class="text">
                                    <?php
                                    // Check if quantity is NULL or empty, and display "Not Available" if so
                                    echo ($product_details['quantity'] !== NULL && $product_details['quantity'] !== '') ? $product_details['quantity'] : 'N/A';
                                    ?>
                                </span>
                            </p>

                            <p class="product-type">
                                <img src="frontend_assets/img-icon/location.png" style="width: 20px;" />
                                <?php echo $state . ", " . $city . ", " . $landmark . ", " . $pincode; ?>
                            </p>
                        </div>

                        <!-- Product Price -->
                        <div class="product-price d-flex-center my-3">
                            <span class="price" style="font-size: 16px; font-weight: 600;">
                                ₹<?php echo ($sale_price == (int)$sale_price) ? (int)$sale_price : number_format((float)$sale_price, 2, '.', ''); ?>
                            </span>
                        </div>

                        <hr>
                        <!-- Sort Description -->
                        <div class="sort-description"><?php echo htmlspecialchars($product_details['description']); ?></div>
                    </div>
                </div>
            <?php
        }
        // check if this user is not who post this post
        if ($user_info != $creator_id) {
            $product_view_dataget = mysqli_query($con, "
            SELECT view_id, assigned_collecter, seller_id, view_date, deal_status, purchased_price, 
                   negotiation_amount, negotiation_by, mssg, negotiation_date, accept_date, 
                   pickup_date, pickup_time, complete_date 
            FROM tbl_create_post_item_transactions 
            WHERE buyer_id = '$session_user_code' 
              AND product_id = '$product_id'
        ");
            $product_view_data = mysqli_fetch_assoc($product_view_dataget);
            ?>
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

                <?php
                // if buyer did not view this product then he/she can use credits to view seller information
                if (!$product_view_data) {
                ?>
                    <!-- Use Credit Action -->
                    <div class="product-action w-100 d-flex-wrap my-3 my-md-4">
                        <div class="product-form-submit addcart fl-1">
                            <button type="button" onclick="toggleConfirmBox()" class="btn btn-secondary product-form-cart-submit">
                                <span>Use credits to view seller info</span>
                            </button>
                        </div>
                    </div>

                    <!-- Confirmation Box -->
                    <div id="confirmBox" class="confirm-box" style="display: none;">
                        <h2 class="text-center">Are You Sure?</h2>
                        <p><?php echo $product_view_credit; ?> credits will be used to view the contact details. Would you like to proceed?</p>
                        <div class="confirm-box-actions">
                            <button type="button" onclick="closeConfirmBox()" class="btn btn-light" style="background-color: #00ad4c; color: #fff;">No, Cancel!</button>
                            <button type="button" onclick="userViewSellerDetails()" class="btn btn-primary" style="background-color: #eb7923; color: #fff;">Yes, Use Credits</button>
                        </div>
                    </div>
                <?php
                }
                // else buyer already use credits to view the product
                else {
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
                                <h2 style="color: #eb7923; font-weight: 400;">Deal Process Section : </h2>

                                <?php
                                if ($deal_status == "Credit Used" || $deal_status == "Under Negotiation") {
                                ?>
                                    <p style="text-align: center; color: #0088ff; font-weight: 500;">
                                        This deal opened on <?php echo dateFormat($view_date); ?> for you.<br> Or, You can also close the deal.
                                    </p>
                                    <?php

                                    // if any request not inserted
                                    if ($user_info != $creator_id) {
                                        if ($deal_status == "Credit Used") {
                                    ?>
                                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                                <h2>What do you want ?</h2>
                                                <p style="font-weight: 600;">
                                                    The seller has offered at a price of <?php echo ((int)$sale_price); ?>. Would you like to negotiate or accept the price?
                                                </p>
                                                <button type="button" onclick="buyerNegotiate()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                                    I want to Negotiate
                                                </button>
                                                <button type="button" onclick="buyerAcceptPrice()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                                    I’m happy with the price
                                                </button>
                                            </div>

                                            <div class="buyer_negotiate_div" style="display: none;">
                                                <div class="form-group">
                                                    <label for="negotiation_amount">Requested Price <span class="required">*</span></label>
                                                    <input type="number" id="negotiation_amount" class="form-control" placeholder="Enter Requested Price" step="any" required min="1" />
                                                    <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mssg">Want to sent any message ?</label>
                                                    <textarea id="mssg" class="form-control" placeholder="Type your message here ...." maxlength="500"></textarea>
                                                    <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                                </div>
                                                <button type="button" onclick="buyerCancel()" class="btn btn-secondary product-form-cart-submit" style="background: #9d1111; border: 0px; border-radius: 5px;">
                                                    <span>Cancel</span>
                                                </button>
                                                <button type="button" onclick="buyerSendRequest()" class="btn btn-secondary product-form-cart-submit" style="background: #00954f; border: 0px; border-radius: 5px;">
                                                    <span>Send Request To Seller</span>
                                                </button>
                                            </div>
                                        <?php
                                        }
                                    }
                                    // if request submitted from seller end
                                    if ((int)$user_info == (int)$creator_id) {
                                        ?>
                                        <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                            <h2>What do you want ?</h2>
                                            <p style="font-weight: 600;">
                                                This product's requested negotiation price is <?php echo ((int)$negotiation_amount); ?> from seller side. Do you want to negotiate or accept the price ?
                                                <?php
                                                if ($mssg != "") {
                                                ?>
                                                    Message From Seller : <?php echo $mssg; ?>
                                                <?php
                                                }
                                                ?>
                                            </p>
                                            <button type="button" onclick="buyerNegotiate()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                                I want to Negotiate
                                            </button>
                                            <button type="button" onclick="buyerAcceptPrice()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                                I accept
                                            </button>
                                        </div>
                                        <div class="buyer_negotiate_div" style="display: none;">
                                            <div class="form-group">
                                                <label for="negotiation_amount">Negotiate Price <span class="required">*</span></label>
                                                <input type="number" id="negotiation_amount" class="form-control" placeholder="Enter Requested Price" step="any" required min="1" />
                                                <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="mssg">Want to sent any message ?</label>
                                                <textarea id="mssg" class="form-control" placeholder="Type your message here ...." maxlength="500"></textarea>
                                                <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                            </div>
                                            <button type="button" onclick="buyerCancel()" class="btn btn-secondary product-form-cart-submit" style="background: #9d1111; border: 0px; border-radius: 5px;">
                                                <span>Cancel</span>
                                            </button>
                                            <button type="button" onclick="buyerSendRequest()" class="btn btn-secondary product-form-cart-submit" style="background: #00954f; border: 0px; border-radius: 5px;">
                                                <span>Send Request To Seller</span>
                                            </button>
                                        </div>
                                    <?php
                                    }
                                    // if request send from buyer or collector side
                                    else {
                                        if($deal_status == "Under Negotiation") {
                                    ?>
                                        <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                            <h2>Your request has been sent! Waiting for seller's confirmation.</h2>
                                            <p style="font-weight: 600;">
                                                You have requested a negotiation at a price of <?php echo ((int)$negotiation_amount); ?>. Let’s wait for the seller's response.
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
                                }
                                } elseif ($deal_status == "Offer Accepted") {
                                    ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>Your offer has been accepted. You can now directly call and schedule your pickup.</h2>
                                        <p style="font-weight: 600;">
                                            Deal accepted by at a price of <?php echo ((int)$negotiation_amount); ?>
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
                                } elseif ($deal_status == "Pickup Scheduled") {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>Waiting for pickup</h2>
                                        <p style="font-weight: 600;">
                                            Pickup Date : <?php echo dateFormat($pickup_date); ?>, <?php echo timeFormat($pickup_time); ?>
                                        </p>
                                        <!-- <p style="font-weight: 600;">
                                                    Pickup Time : <?php echo timeFormat($pickup_time); ?>
                                                </p> -->
                                        <center>
                                            <button type="button" onclick="buyerPickupComplete(<?php echo $view_id; ?>)" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                                Pickup Complete
                                            </button>
                                        </center>
                                    </div>
                                <?php
                                } elseif ($deal_status == "Completed") {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>Deal completed</h2>
                                        <p style="font-weight: 600;">
                                            Completion date : <?php echo dateFormat($complete_date); ?>
                                        </p>

                                        <?php
                                        // check buyer already give ratings to seller
                                        $dataget = mysqli_query($con, "select * from tbl_ratings where give_user_id='" . $session_user_code . "' and to_user_id='" . $seller_id . "' and rating_from='Buyer' and view_id='" . $view_id . "' ");
                                        $data = mysqli_fetch_row($dataget);
                                        if (!$data) {
                                        ?>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#seller_ratings_modal" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                                Give Ratings to Seller
                                            </button>
                                        <?php
                                        }
                                        ?>
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

                        <?php
                        if ($deal_status != "Completed") {
                        ?>
                            <div class="col-md-6">
                                <form class="product-form product-form-border hidedropdown">
                                    <h2 style="color: #eb7923; font-weight: 400;">Collector Assigned Section : </h2>
                                    <?php
                                    // if collector not asigned
                                    if ($assigned_collecter == "") {
                                    ?>
                                        <p style="text-align: center; color: #0088ff; font-weight: 500;">
                                            This deal opened on <?php echo dateFormat($view_date); ?> for you.<br> Either, Assign a collector to close the deal.
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
                                                        <option value="<?php echo $rw['user_id']; ?>"><?php echo $rw['name'] . " [" . $rw['ph_num'] . "]"; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label data-default-mssg="" class="input_alert collector_id-inp-alert"></label>
                                        </div>

                                        <?php if ($collecter_data_rw_num == 0) { ?>
                                            <div class="col text-left">
                                                <a href="<?php echo $baseUrl; ?>/add-collector">
                                                    <button type="button" class="btn btn-primary">
                                                        <img src="frontend_assets/img-icon/add.png" style="margin-left: 4px; width: 25px;" />&nbsp;Add Collector
                                                    </button>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        <?php if ($collecter_data_rw_num != 0) { ?>
                                            <button type="button" onclick="assignCollector()" class="btn btn-secondary product-form-cart-submit">
                                                <img src="frontend_assets/img-icon/collector-3.png" style="margin-left: 4px; width: 25px;" />
                                                <span>Assign Collector</span>
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
                                        <p style="color: red; text-align: center; font-weight: 600; margin-bottom: 5px;">You already assigned a collector</p>
                                        <h3 style="text-align: center;">
                                            <img src="upload_content/upload_img/user_img/<?php echo $user_img ? $user_img : 'default.png'; ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" />
                                            <?php echo $collector_name; ?> [
                                            <a href="tel:<?php echo $country_code . $ph_num; ?>">
                                                <?php echo $country_code . " " . $ph_num; ?>
                                            </a>]
                                        </h3>
                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        <?php
                        }
                        ?>

                    </div>

                    <!-- Give Seller Ratings Modal -->
                    <div class="modal fade" id="seller_ratings_modal" tabindex="-1" aria-labelledby="sellerRatingsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="sellerRatingsModalLabel">Ratings For Seller</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="rating_seller_id" value="<?php echo $seller_id; ?>" />
                                    <input type="hidden" id="rating_view_id" value="<?php echo $view_id; ?>" />
                                    <form>
                                        <div class="form-group mb-3">
                                            <label for="rating">How many ratings would you like to give the seller? <span class="required">*</span></label>
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
                                            <textarea id="review" class="form-control" placeholder="Write a Review" maxlength="500"></textarea>
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

                <?php
                }
            }
            // check user type Seller
            elseif ($user_info == $creator_id) {

                $dataget = mysqli_query($con, "select 
                                                        tbl_create_post_item_transactions.view_id,
                                                        tbl_create_post_item_transactions.buyer_id,
                                                        tbl_user_master.name, 
                                                        tbl_user_master.user_img, 
                                                        tbl_user_master.country_code, 
                                                        tbl_user_master.ph_num, 
                                                        tbl_create_post_item_transactions.assigned_collecter,
                                                        tbl_create_post_item_transactions.deal_status, 
                                                        tbl_create_post_item_transactions.purchased_price, 
                                                        tbl_create_post_item_transactions.negotiation_amount, 
                                                        tbl_create_post_item_transactions.negotiation_by, 
                                                        tbl_create_post_item_transactions.mssg, 
                                                        tbl_create_post_item_transactions.negotiation_date, 
                                                        tbl_create_post_item_transactions.accept_date, 
                                                        tbl_create_post_item_transactions.pickup_date, 
                                                        tbl_create_post_item_transactions.pickup_time, 
                                                        tbl_create_post_item_transactions.complete_date 
                                                        from tbl_create_post_item_transactions 
                                                        LEFT JOIN tbl_user_master ON tbl_user_master.user_id = tbl_create_post_item_transactions.buyer_id
                                                        where tbl_create_post_item_transactions.product_id='" . $product_id . "' and 
                                                        tbl_create_post_item_transactions.seller_id='" . $session_user_code . "' and
                                                        tbl_create_post_item_transactions.deal_status <> 'Credit Used' 
                                                        order by tbl_create_post_item_transactions.entry_timestamp DESC ");

                if (mysqli_num_rows($dataget) > 0) {
                ?>
                    <form class="product-form product-form-border hidedropdown">
                        <h2 style="color: #eb7923; font-weight: 400;">Make Your Offer : </h2>
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

                                            <span class="badges <?php echo $badgesClass ?>">
                                                <?php echo $rw['deal_status']; ?>
                                            </span>

                                            <h4 class="heading">Buyer Details :</h4>
                                            <div class="user-info-div">
                                                <img src="./upload_content/upload_img/user_img/<?php echo $rw['user_img'] == "" ? "default.png" : $rw['user_img']; ?>" />
                                                <?php echo $rw['name']; ?>
                                                <br />
                                                <a href="tel:<?php echo $rw['country_code'] . $rw['ph_num']; ?>"><i class="fa fa-phone"></i> : <?php echo $rw['country_code'] . " " . $rw['ph_num']; ?></a>
                                            </div>

                                            <?php
                                            if ($rw['assigned_collecter'] != "") {
                                                $collector_dataget = mysqli_query($con, "select name, country_code, ph_num, user_img from tbl_user_master where user_id='" . $rw['assigned_collecter'] . "' ");
                                                $collector_data = mysqli_fetch_assoc($collector_dataget);

                                                if ($collector_data) {
                                            ?>
                                                    <h4 class="heading">Collector Details :</h4>
                                                    <div class="user-info-div">
                                                        <img src="./upload_content/upload_img/user_img/<?php echo $collector_data['user_img'] == "" ? "default.png" : $collector_data['user_img']; ?>" />
                                                        <?php echo $collector_data['name']; ?>
                                                        <br />
                                                        <a href="tel:<?php echo $collector_data['country_code'] . $collector_data['ph_num']; ?>"><i class="fa fa-phone"></i> : <?php echo $collector_data['country_code'] . " " . $collector_data['ph_num']; ?></a>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>

                                            <h4 class="heading">Offer Details :</h4>
                                            <div class="user-info-div">
                                                <label>Offered Price : <?php echo $rw['negotiation_amount']; ?> /-</label>
                                                <?php
                                                if ($rw['mssg'] != "") {
                                                    echo '<label>Message : ' . $rw['mssg'] . '</label>';
                                                }
                                                ?>
                                            </div>

                                            <!-- Deal status wise action  -->

                                            <?php
                                            if ($rw['deal_status'] == "Offer Accepted") {
                                            ?>
                                                <button type="button" onclick="sellerAcceptPrice(<?php echo $rw['view_id']; ?>)" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                                    Schedule Pickup
                                                </button>
                                            <?php
                                            } elseif ($rw['deal_status'] == "Pickup Scheduled") {
                                            ?>
                                                <p>Pickup DateTime : <?php echo dateFormat($rw['pickup_date']); ?></p>
                                                <p>Pickup Time : <?php echo timeFormat($rw['pickup_time']); ?></p>
                                            <?php
                                            } elseif ($rw['deal_status'] == "Completed") {
                                            ?>
                                                <p>The Deal is Completed on <?php echo dateFormat($rw['complete_date']); ?> date</p>

                                                <?php
                                                if ($product_status != "Completed") {
                                                ?>
                                                    <button type="button" onclick="sellerCloseProduct(<?php echo $rw['view_id'] ?>)" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
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
                                                        <button type="button" onclick="openRatingModal(<?php echo $rw['buyer_id']; ?>,<?php echo $rw['view_id']; ?>)" data-bs-toggle="modal" data-bs-target="#buyer_ratings_modal" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                                            Give Ratings to Buyer
                                                        </button>
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
                                                    <button type="button" onclick="sellerNegotiate(<?php echo $rw['view_id']; ?>)" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                                        Negotiate
                                                    </button>
                                                    <button type="button" onclick="sellerAcceptPrice(<?php echo $rw['view_id']; ?>)" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                                        Accept
                                                    </button>
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
                    <div class="modal fade" id="price_request_modal" tabindex="-1" aria-labelledby="priceRequestModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="priceRequestModalLabel">Send Your Price Request</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="nego_view_id" value="" />
                                    <form class="add-address-from" method="post" action="#">
                                        <div class="form-group">
                                            <label for="negotiation_amount">Negotiate Price <span class="required">*</span></label>
                                            <input type="number" value="" id="negotiation_amount" class="form-control" placeholder="Enter Negotiate Price" step="any" required min="1" />
                                            <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="mssg">Want to sent any message ?</label>
                                            <textarea id="mssg" class="form-control" placeholder="Type your message here ...." maxlength="500"></textarea>
                                            <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" onclick="sellerSendRequest();" class="btn btn-primary m-0">
                                        <span>Send Request To Buyer/Collector</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pickup Schedule Modal -->
                    <div class="modal fade" id="pickup_schedule_modal" tabindex="-1" aria-labelledby="pickupScheduleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="pickupScheduleModalLabel">Send Your Pickup Request</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="pickup_view_id" value="" />
                                    <form class="add-address-from" method="post" action="#">
                                        <div class="form-group">
                                            <label for="pickup_date">Pickup Date <span class="required">*</span></label>
                                            <input type="date" value="" id="pickup_date" class="form-control" placeholder="Enter Pickup Date" required min="<?php echo $date; ?>" />
                                            <label data-default-mssg="" class="input_alert pickup_date-inp-alert"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="pickup_time">Pickup Time <span class="required">*</span></label>
                                            <input type="time" value="" id="pickup_time" class="form-control" placeholder="Enter Pickup Time" required />
                                            <label data-default-mssg="" class="input_alert pickup_time-inp-alert"></label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" onclick="updatePickupDate();" class="btn btn-primary m-0">
                                        <span>Update Pickup Date & Time</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Give Buyer Ratings Modal -->
                    <div class="modal fade" id="buyer_ratings_modal" tabindex="-1" aria-labelledby="buyerRatingsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="buyerRatingsModalLabel">Ratings For Buyer</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="rating_buyer_id" value="" />
                                    <input type="hidden" id="rating_view_id" value="" />
                                    <form>
                                        <div class="form-group mb-3">
                                            <label for="rating">How many ratings would you like to give the buyer? <span class="required">*</span></label>
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
                                            <textarea id="review" class="form-control" placeholder="Write a Review" maxlength="500"></textarea>
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


                <?php
                }
            }
            // if user type == collector
            else {

                $product_view_dataget = mysqli_query($con, "select view_id, view_date, deal_status, purchased_price, negotiation_amount, negotiation_by, mssg, negotiation_date, accept_date, pickup_date, pickup_time, complete_date from tbl_create_post_item_transactions where assigned_collecter='" . $session_user_code . "' and product_id='" . $product_id . "' ");
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
                            <h2 style="color: #eb7923; font-weight: 400;">Deal Process Section : </h2>

                            <?php
                            if ($deal_status == "Offer Made" || $deal_status == "Under Negotiation") {
                            ?>
                                <p style="text-align: center; color: #0088ff; font-weight: 500;">
                                    This deal opened on <?php echo dateFormat($view_date); ?> for you.<br> Or, You can also close the deal.
                                </p>
                                <?php
                                // if any request not inserted
                                if ($negotiation_by == "") {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>What do you want ?</h2>
                                        <p style="font-weight: 600;">
                                            The seller has offered at a price of <?php echo ((int)$sale_price); ?>. Would you like to negotiate or accept the price?
                                        </p>
                                        <button type="button" onclick="buyerNegotiate()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                            <img class="img" src="frontend_assets/img-icon/no.png" />
                                            No, I want to Negotiate
                                        </button>
                                        <button type="button" onclick="buyerAcceptPrice()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                            <img class="img" src="frontend_assets/img-icon/yes.png" />
                                            Yes, I’m happy with the price
                                        </button>
                                    </div>
                                    <div class="buyer_negotiate_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="negotiation_amount">Requested Price <span class="required">*</span></label>
                                            <input type="number" id="negotiation_amount" class="form-control" placeholder="Enter Requested Price" step="any" required min="1" />
                                            <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="mssg">Want to sent any message ?</label>
                                            <textarea id="mssg" class="form-control" placeholder="Type your message here ...." maxlength="500"></textarea>
                                            <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                        </div>
                                        <button type="button" onclick="buyerCancel()" class="btn btn-secondary product-form-cart-submit" style="background: #9d1111; border: 0px; border-radius: 5px;">
                                            <span>Cancel</span>
                                        </button>
                                        <button type="button" onclick="buyerSendRequest()" class="btn btn-secondary product-form-cart-submit" style="background: #00954f; border: 0px; border-radius: 5px;">
                                            <span>Send Request To Seller</span>
                                        </button>
                                    </div>
                                <?php
                                }
                                // if request submitted from seller end
                                if ((int)$user_info === (int)$creator_id) {
                                ?>
                                    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                        <h2>What do you want ?</h2>
                                        <p style="font-weight: 600;">
                                            This product's requested negotiation price is <?php echo ((int)$negotiation_amount); ?> from seller side. Do you want to negotiate or accept the price ?
                                            <?php
                                            if ($mssg != "") {
                                            ?>
                                                Message From Seller : <?php echo $mssg; ?>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <button type="button" onclick="buyerNegotiate()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                            <img class="img" src="frontend_assets/img-icon/no.png" />
                                            No, I want to Negotiate
                                        </button>
                                        <button type="button" onclick="buyerAcceptPrice()" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                            <img class="img" src="frontend_assets/img-icon/yes.png" />
                                            Yes, I accept
                                        </button>
                                    </div>
                                    <div class="buyer_negotiate_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="negotiation_amount">Negotiate Price <span class="required">*</span></label>
                                            <input type="number" id="negotiation_amount" class="form-control" placeholder="Enter Requested Price" step="any" required min="1" />
                                            <label data-default-mssg="" class="input_alert negotiation_amount-inp-alert"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="mssg">Want to sent any message ?</label>
                                            <textarea id="mssg" class="form-control" placeholder="Type your message here ...." maxlength="500"></textarea>
                                            <label data-default-mssg="" class="input_alert mssg-inp-alert"></label>
                                        </div>
                                        <button type="button" onclick="buyerCancel()" class="btn btn-secondary product-form-cart-submit" style="background: #9d1111; border: 0px; border-radius: 5px;">
                                            <span>Cancel</span>
                                        </button>
                                        <button type="button" onclick="buyerSendRequest()" class="btn btn-secondary product-form-cart-submit" style="background: #00954f; border: 0px; border-radius: 5px;">
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
                                            You have requested a negotiation at a price of <?php echo ((int)$negotiation_amount); ?>. Let’s wait for the seller's response.
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
                                        Deal accepted by at a price of <?php echo ((int)$negotiation_amount); ?>! Waiting for the seller's confirmation and pickup details
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
                                <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
                                    <h2>Waiting for pickup</h2>
                                    <p style="font-weight: 600;">
                                        Pickup Datetime : <?php echo dateFormat($pickup_date); ?>, <?php echo timeFormat($rw['pickup_time']); ?>
                                    </p>
                                    <!-- <p style="font-weight: 600;">
                                                Pickup Time : <?php echo timeFormat($rw['pickup_time']); ?>
                                            </p> -->
                                    <center>
                                        <button type="button" onclick="buyerPickupComplete(<?php echo $view_id; ?>)" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                            Pickup Complete
                                        </button>
                                    </center>
                                </div>
                            <?php
                            } elseif ($deal_status == "Completed") {
                            ?>
                                <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
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
        </div>
    <?php
}
    ?>
    </div>
    </div>
    <!-- End Body Container -->