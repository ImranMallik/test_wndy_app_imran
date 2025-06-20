<?php
include("../db/db.php");

$url_path = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url_path);
$demand_post_id = end($parts);



if (is_numeric($demand_post_id)) {
    $demand_post_id = mysqli_real_escape_string($con, $demand_post_id);

    $query = "SELECT 
    dp.product_id,
    dp.category_id,
    dp.demand_post_name,
    dp.demand_post_sale_price,
    dp.demand_post_by_id,  
    dp.description,
    dp.qty_type,
    dp.brand,
    dp.quantity,
    dp.demad_nego_qty,
    dp.demand_nego_price,
    CAST(dp.is_nagociat AS UNSIGNED) AS is_nagociat,
    cm.category_name,
    um.name AS posted_by_name,
    um.ph_num AS mobile_num,
    um.email_id AS email_num,
   
    am.state,
    am.city,
    am.landmark,
    am.pincode
  FROM tbl_demand_post AS dp
  INNER JOIN tbl_category_master AS cm ON dp.category_id = cm.category_id
  INNER JOIN tbl_user_master AS um ON dp.demand_post_by_id = um.user_id
  INNER JOIN tbl_address_master AS am ON dp.demand_post_by_id = am.user_id
  WHERE dp.demand_post_id = '$demand_post_id'";





    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $demand_post = mysqli_fetch_assoc($result);

        // Correctly fetch demand_post_by_id
        $demand_post_by_id = $demand_post['demand_post_by_id'];
        $is_nagociat = $demand_post['is_nagociat'];
        $demand_nago_qty = $demand_post['demad_nego_qty'];
        $demand_nago_price = $demand_post['demand_nego_price'];
    } else {
        echo "<div class='no-products-found'>
                <center>
                    <h3>No Demand Post Found</h3>
                </center>
              </div>";
        exit;
    }
} else {
    echo "<div class='no-products-found'>
            <center>
                <h3>Invalid Demand Post ID</h3>
            </center>
          </div>";
    exit;
}
?>

<div class="template-product">
    <div id="page-content">

        <div class="page-header text-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="breadcrumbs">
                            <a href="<?php echo $baseUrl . "/home"; ?>" title="Back to the home page">Home</a>
                            <span class="main-title fw-bold">
                                <i class="icon anm anm-angle-right-l"></i>
                                <?php echo htmlspecialchars($demand_post['demand_post_name']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="product-single">
                <div class="row">


                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-info">
                        <div class="product-info">
                            <p class="product-type">Category:
                                <span class="text"><?php echo htmlspecialchars($demand_post['category_name']); ?></span>
                            </p>
                            <p class="product-type">Item:
                                <span class="text"><?php echo htmlspecialchars($demand_post['demand_post_name']); ?></span>
                            </p>
                            <?php if (!empty($demand_post['brand'])): ?>
                                <p class="product-sku">Brand:
                                    <span class="text"><?php echo htmlspecialchars($demand_post['brand']); ?></span>
                                </p>
                            <?php endif; ?>
                            <p class="product-type">Description:
                                <span class="text"> <?php echo $demand_post['description']; ?></span>
                            </p>

                            <?php
                            if (!empty($demand_post['quantity'])) {
                                $quantity = htmlspecialchars($demand_post['quantity']);
                                $qty_type = isset($demand_post['qty_type']) ? htmlspecialchars($demand_post['qty_type']) : ''; // Safely fetch qty_type
                            ?>
                                <p class="product-sku">Quantity:
                                    <span class="text">
                                        <?php echo $quantity . ' (' . $qty_type . ')'; ?>
                                    </span>
                                </p>
                            <?php
                            }
                            ?>

                            <p class="product-type">Price:
                                <span class="text">₹<?php
                                                    echo ($demand_post['demand_post_sale_price'] == (int)$demand_post['demand_post_sale_price'])
                                                        ? (int)$demand_post['demand_post_sale_price']
                                                        : number_format((float)$demand_post['demand_post_sale_price'], 2, '.', '');
                                                    ?></span>
                            </p>


                        </div>

                    </div>
                    <div class="sort-description">
                        <h3 class="text-center">Contact Information</h3>
                        <p class="product-sku"><b> Name:</b>
                            <span class="text"><?php echo htmlspecialchars($demand_post['posted_by_name']); ?></span>
                        </p>
                        <p class="product-sku"><b>Contact Number:</b>
                            <span class="text"><?php echo htmlspecialchars($demand_post['mobile_num']); ?></span>
                        </p>
                        <?php
                        if (!empty($demand_post['email_num'])) {
                        ?>
                            <p class="product-sku"><b>Email:</b>
                                <span class="text"><?php echo htmlspecialchars($demand_post['email_num']); ?></span>
                            </p>
                        <?php
                        }
                        ?>
                        <hr>
                        <p class="product-type">
                            <img src="frontend_assets/img-icon/location.png" alt="Location Icon" style="width: 20px; margin-right: 5px;" />
                            <?php
                            echo (!empty($demand_post['state']) ? htmlspecialchars($demand_post['state']) : '') . ", " .
                                (!empty($demand_post['city']) ? htmlspecialchars($demand_post['city']) : '') . ", " .
                                (!empty($demand_post['landmark']) ? htmlspecialchars($demand_post['landmark']) : '') . ", " .
                                (!empty($demand_post['pincode']) ? htmlspecialchars($demand_post['pincode']) : '');
                            ?>
                        </p>


                        <hr>
                    </div>
                    <div class="deal-process-section">
                        <form class="product-form product-form-border hidedropdown">
                            <h2 style="color: #eb7923; font-weight: 400;">Deal Process Section : </h2>

                            <!-- Section for "Credit Used" or "Under Negotiation" -->
                            <p style="text-align: center; color: #0088ff; font-weight: 500;">
                                This deal opened on 27-01-25 for you.<br> Or, You can also close the deal.
                            </p>

                            <!-- Initial Negotiation Section -->
                            <?php if (isset($is_nagociat) && ($is_nagociat == 0 || $is_nagociat === "0")) : ?>
            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
            <h2>What do you want?</h2>
            <p style="font-weight: 600;">
            The seller has offered at a price of <span id="offerPrice">10</span>. Would you like to negotiate or accept the price?
              </p>
           <button
            type="button"
            class="btn"
            style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;"
            onclick="showNegotiateDiv()">
            I want to Negotiate
             </button>
            <button
            type="button" 
            class="btn"
            style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
            I want to Accept
            </button>
        </div>
            <?php endif; ?>

            <?php if (isset($is_nagociat) && ($is_nagociat == 1 || $is_nagociat === "1")) : ?>
    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
        <h2>Your request has been sent! Waiting for Seller's confirmation.</h2>
        <p style="font-weight: 600;">
            You have requested a negotiation at a price of ₹<?php echo htmlspecialchars($demand_nago_price); ?> 
            for a quantity of <?php echo htmlspecialchars($demand_nago_qty); ?>. Let’s wait for the seller's response.
        </p>
    </div>
<?php endif; ?>



                            <!-- Negotiation Form -->
                            <div class="buyer_negotiate_div" style="display: none;">
                                <!-- Item Price -->
                                <div class="form-group">
                                    <label for="negotiation_price">Item Price <span class="required">*</span></label>
                                    <input
                                        type="text"
                                        id="negotiation_price"
                                        class="form-control"
                                        placeholder="Enter Requested Price"
                                        step="any"
                                        required
                                        min="1" />
                                    <label data-default-mssg="" class="input_alert negotiation_price-inp-alert"></label>
                                </div>

                                <!-- Item Quantity -->
                                <div class="form-group">
                                    <label for="negotiation_quantity">Item Quantity <span class="required">*</span></label>
                                    <input
                                        type="text"
                                        id="negotiation_quantity"
                                        class="form-control"
                                        placeholder="Enter Requested Quantity"
                                        step="any"
                                        required
                                        min="1" />
                                    <label data-default-mssg="" class="input_alert negotiation_quantity-inp-alert"></label>
                                </div>

                                <!-- Quantity Unit (Radio Buttons) -->
                                <div class="form-group">
                                    <label for="quantity_unit">Quantity Unit <span class="required">*</span></label>
                                    <div style="margin-top: 5px;">
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="quantity_unit"
                                                id="unit_kg"
                                                value="kg"
                                                required />
                                            <label class="form-check-label" for="unit_kg">kg</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="quantity_unit"
                                                id="unit_pcs"
                                                value="pcs"
                                                required />
                                            <label class="form-check-label" for="unit_pcs">pcs</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Optional Message -->
                                <div class="form-group">
                                    <label for="negotiation_message">Want to send any message?</label>
                                    <textarea
                                        id="negotiation_message"
                                        class="form-control"
                                        placeholder="Type your message here ...."
                                        maxlength="500"></textarea>
                                    <label data-default-mssg="" class="input_alert negotiation_message-inp-alert"></label>
                                </div>

                                <!-- Cancel and Send Buttons -->
                                <button
                                    type="button"
                                    class="btn btn-secondary product-form-cart-submit"
                                    style="background: #9d1111; border: 0px; border-radius: 5px;"
                                    onclick="cancelNegotiation()">
                                    <span>Cancel</span>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary product-form-cart-submit"
                                    style="background: #00954f; border: 0px; border-radius: 5px;"
                                    onclick="sendNegotiationRequest()">
                                    <span>Send Request To Seller</span>
                                </button>
                            </div>



                            <!-- Waiting for Seller Response -->
                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp" style="display: none;">
                                <h2>Your request has been sent! Waiting for seller's confirmation.</h2>
                                <p style="font-weight: 600;">
                                    You have requested a negotiation at a price of 15. Let’s wait for the seller's response.
                                    Message From You: Please consider this offer.
                                </p>
                            </div>

                            <!-- Offer Accepted Section -->
                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp" style="display: none;">
                                <h2>Your offer has been accepted. You can now directly call and schedule your pickup.</h2>
                                <p style="font-weight: 600;">
                                    Deal accepted at a price of 15.
                                </p>
                            </div>

                            <!-- Pickup Scheduled Section -->
                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp" style="display: none;">
                                <h2>Waiting for pickup</h2>
                                <p style="font-weight: 600;">
                                    Pickup Date: 28-01-25, Time: 10:00 AM.
                                </p>
                                <center>
                                    <button type="button" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #00aa49; border-color: #016a2e;">
                                        Pickup Complete
                                    </button>
                                </center>
                            </div>

                            <!-- Deal Completed Section -->
                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp" style="display: none;">
                                <h2>Deal completed</h2>
                                <p style="font-weight: 600;">
                                    Completion date: 29-01-25.
                                </p>
                                <button type="button" class="btn" style="padding: 3px 10px; border-radius: 6px; background-color: #eb7923; border-color: #a34600;">
                                    Give Ratings to Seller
                                </button>
                            </div>

                            <!-- Deal Cancelled Section -->
                            <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp" style="display: none;">
                                <h2>Deal was cancelled </h2>
                                <p style="font-weight: 600;">
                                    Some other buyer cracked the deal.
                                </p>
                            </div>
                        </form>

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>

<script>
    function showNegotiateDiv() {
        // Hide the confirmation box
        document.querySelector('.buyer_confirm_box').style.display = 'none';

        // Show the negotiation box
        document.querySelector('.buyer_negotiate_div').style.display = 'block';
    }

    function cancelNegotiation() {
        // Hide the negotiation box
        document.querySelector('.buyer_negotiate_div').style.display = 'none';

        // Show the confirmation box
        document.querySelector('.buyer_confirm_box').style.display = 'block';
    }

    function sendNegotiationRequest() {
        // Collect data from input fields
        const negotiationPrice = document.getElementById('negotiation_price').value.trim();
        const negotiationQuantity = document.getElementById('negotiation_quantity').value.trim();
        const quantityUnit = document.querySelector('input[name="quantity_unit"]:checked')?.value; // Get selected radio button value
        const negotiationMessage = document.getElementById('negotiation_message').value.trim();

        // Validate required fields
        if (!negotiationPrice || !negotiationQuantity || !quantityUnit) {
            alert('Please fill all required fields.');
            return;
        }

        // Prepare notification data
        const notificationData = {
            title: "New Negotiation Notification",
            details: "A New Negotiation Notification",
            negotiation_url: "demand_post_negotiation_details",
            from_user_id: "<?php echo $session_user_code; ?>",
            entry_user_code: "<?php echo $session_user_code; ?>",
            negotiation_price: negotiationPrice,
            negotiation_quantity: negotiationQuantity,
            quantity_unit: quantityUnit,
            negotiation_message: negotiationMessage || null,
            to_notification: "<?php echo $demand_post_by_id; ?>",
            demand_post_id: "<?php echo $demand_post_id; ?>"

        };

        console.log("Sending Notification Data:", notificationData);

        fetch('templates/demand_post/demand_post_negotiate_notification.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(notificationData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server Response:', data);

                if (data.success) {
                    toastr.success(data.message || "Negotiation sent successfully.");
                    document.getElementById('negotiation_price').value = '';
                    document.getElementById('negotiation_quantity').value = '';
                    document.querySelector('input[name="quantity_unit"]:checked').checked = false;
                    document.getElementById('negotiation_message').value = '';
                } else {
                    toastr.error(data.message || "Failed to send negotiation request.");
                }
            })
            .catch(error => {
                console.error('Fetch error:', error.message);
                alert('Failed to send data');
            });
    }
</script>