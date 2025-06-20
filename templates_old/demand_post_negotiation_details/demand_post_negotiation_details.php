<?php
include("../db/db.php");

$url_path = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url_path);
$notification_id = end($parts);

if (is_numeric($notification_id)) {
  $notification_id = mysqli_real_escape_string($con, $notification_id);

  $query = "
        SELECT 
    tn.to_user_id,
    tn.from_user_id,
    tn.negotiation_price,
    tn.negotiation_quantity,
    tn.quantity_unit,
    tn.negotiation_message,
    tn.demand_id,
    tn.is_negotiation,
    dp.product_id,
    dp.category_id,
    dp.demand_post_name,
    dp.demand_post_sale_price,
    dp.demand_post_by_id,  
    dp.description,
   
    dp.qty_type,
    dp.brand,
    dp.quantity,
    cm.category_name,
    um.name AS posted_by_name,
    um.ph_num AS mobile_num,
    um.email_id AS email_num,
    am.state,
    am.city,
    am.landmark,
    am.pincode
FROM tbl_user_notification AS tn
INNER JOIN tbl_demand_post AS dp ON tn.demand_id = dp.demand_post_id
INNER JOIN tbl_category_master AS cm ON dp.category_id = cm.category_id
INNER JOIN tbl_user_master AS um ON tn.from_user_id = um.user_id
INNER JOIN tbl_address_master AS am ON tn.from_user_id = am.user_id
WHERE tn.notification_id = '$notification_id'
    ";

  $result = mysqli_query($con, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $demand_post = mysqli_fetch_assoc($result);
    $notification_data = $demand_post;
    $demand_post_id = $notification_data['demand_id'];
    $toUserId = $notification_data['from_user_id'];
    $is_nagotation = $notification_data['is_negotiation'];
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
                <h3>Invalid Notification ID</h3>
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
          <?php if (isset($is_nagotation) && ($is_nagotation == 0 || $is_nagotation === "0")) : ?>
          <div class="deal-process-section">
            <form class="product-form product-form-border hidedropdown">
              <h2 style="color: #eb7923; font-weight: 400;">Deal Process Section : </h2>

              <!-- Section for "Credit Used" or "Under Negotiation" -->
              <p style="text-align: center; color: #0088ff; font-weight: 500;">
                This deal opened on 27-01-25 for you.<br> Or, You can also close the deal.
              </p>
              <!-- Negotiation Form -->
               
              <div class="buyer_negotiate_div">
                <!-- Item Price -->
                <div class="form-group">
                  <label for="negotiation_price">Item Price <span class="required">*</span></label>
                  <input
                    type="text"
                    id="negotiation_price"
                    class="form-control"
                    placeholder="Enter Requested Price"
                    step="any"
                    readonly="readonly"
                    required
                    min="1"
                    value="<?php echo htmlspecialchars($notification_data['negotiation_price']); ?>" />

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
                    readonly="readonly"
                    required
                    min="1"
                    value="<?php echo htmlspecialchars($notification_data['negotiation_quantity']); ?>" />
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
                        readonly="readonly"
                        value="kg"
                        required
                        <?php echo $notification_data['quantity_unit'] === 'kg' ? 'checked' : ''; ?> />
                      <label class="form-check-label" for="unit_kg">kg</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="quantity_unit"
                        id="unit_pcs"
                        readonly="readonly"
                        value="pcs"
                        required
                        <?php echo $notification_data['quantity_unit'] === 'pcs' ? 'checked' : ''; ?> />
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
                    readonly="readonly"
                    placeholder="Type your message here ...."
                    maxlength="500"><?php echo htmlspecialchars($notification_data['negotiation_message'] ?? ''); ?></textarea>
                  <label data-default-mssg="" class="input_alert negotiation_message-inp-alert"></label>
                </div>

                <!-- Cancel and Send Buttons -->
                <button
                  type="button"
                  class="btn btn-secondary product-form-cart-submit"
                  style="background: #6c757d; border: 0px; border-radius: 5px;"
                  onclick="cancelAction()">
                  <span>Cancel</span>
                </button>
                <button
                  type="button"
                  class="btn btn-secondary product-form-cart-submit"
                  style="background: #28a745; border: 0px; border-radius: 5px;"
                  onclick="acceptNegotiationRequest()">
                  <span>Accept</span>
                </button>

              </div>
              <?php endif; ?>

              <?php if (isset($is_nagotation) && ($is_nagotation == 1 || $is_nagotation === "1")) : ?>
    <div class="buyer_confirm_box confirm-option-div animate__animated animate__backInUp">
        <h2>Thank you for accepting the negotiation.</h2>
        <p style="font-weight: 600;">
            Your acceptance has been recorded successfully. The seller will be notified.
        </p>
    </div>
<?php endif; ?>

            </form>

          </div>

        </div>


      </div>
    </div>

  </div>
</div>

<script>
  function acceptNegotiationRequest() {
    const negotiationPrice = document.getElementById('negotiation_price').value.trim();
    const negotiationQuantity = document.getElementById('negotiation_quantity').value.trim();
    const quantityUnit = document.querySelector('input[name="quantity_unit"]:checked')?.value; 
    const negotiationMessage = document.getElementById('negotiation_message').value.trim();

    if (!negotiationPrice || !negotiationQuantity || !quantityUnit) {
      alert('Please fill all required fields.');
      return;
    }
  
    const notificationData = {
      title: "You'r Negotiation Accepted",
      details: "A New Negotiation Notification",
      negotiation_url: "demand_post_negotiation_accepted_details/",
      from_user_id: "<?php echo $session_user_code; ?>",
      entry_user_code: "<?php echo $session_user_code; ?>",
      negotiation_price: negotiationPrice,
      negotiation_quantity: negotiationQuantity,
      quantity_unit: quantityUnit,
      negotiation_message: negotiationMessage || null,
      to_notification: "<?php echo $toUserId; ?>",
      demand_post_id: "<?php echo $demand_post_id; ?>",
      negotation_id: "<?php echo $notification_id; ?>",

    };

    // console.log("Sending Notification Data:", notificationData);
    fetch('templates/demand_post/demand_post_negotiate_accept.php', {
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