<?php
include("../db/db.php");

// --- Sanitize Inputs ---
$product_status = isset($_POST['product_status']) ? trim(mysqli_real_escape_string($con, $_POST['product_status'])) : 'all';
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$limit = 40;
$offset = ($page - 1) * $limit;

// --- Base SELECT Clause ---
$select_fields = "
    p.product_id, p.product_name, c.category_img, c.category_name,
    p.sale_price, p.product_status, p.quantity, p.quantity_unit,
    p.quantity_kg,p.quantity_pcs,
    p.is_draft,p.close_reason,
    p.quantity_kg,
    a.state, a.city, a.landmark, a.pincode
";


// --- Default FROM & JOINs ---
$base_from = "
    FROM tbl_product_master p
    LEFT JOIN tbl_category_master c ON c.category_id = p.category_id
    LEFT JOIN tbl_address_master a ON a.address_id = p.address_id
";

// --- Default WHERE clause ---
$where = "WHERE p.active = 'Yes'";

// --- Use different queries based on user type ---
if ($session_user_type == "Seller") {
    $where .= " AND p.user_id = '$session_user_code'";

    if ($product_status == "draft-post") {
        $where .= " AND p.is_draft = 1";
    } else {
        $where .= " AND p.is_draft = 0";

        if ($product_status == "Active") {
            $where .= " AND p.product_status IN ('Active', 'Post Viewed')";
        } elseif ($product_status == "Completed") {
            $where .= " AND p.product_status IN ('Completed', 'Withdraw')";
        } elseif ($product_status == "in-process") {
            $where .= " AND p.product_status IN ('Under Negotiation', 'Pickup Scheduled','Offer Accepted')";
        } elseif ($product_status == "Third-Party Transaction") {
            $where .= " AND p.product_status = 'Third-Party Transaction'";
        } elseif ($product_status == "all") {
            // Show all statuses, including Withdraw
            $where .= " AND p.product_status IN (
                'Active', 'Post Viewed', 'Completed',
                'Under Negotiation', 'Pickup Scheduled', 'Offer Accepted',
                'Third-Party Transaction'
            )";
        }
    }

    $query = "SELECT $select_fields $base_from $where";
} elseif ($session_user_type == "Buyer") {



    if ($product_status == "in-process") {
        $select_fields .= ", upv.buyer_id, upv.seller_id, upv.deal_status";
        $join = "
        INNER JOIN tbl_user_product_view upv ON upv.product_id = p.product_id
    ";
        $where .= " AND upv.buyer_id = '$session_user_code' AND upv.deal_status IN ('Under Negotiation','Pickup Scheduled','Offer Accepted')";
    } elseif ($product_status == "Completed") {
        $select_fields .= ", upv.buyer_id, upv.seller_id, upv.deal_status";
        $join = "
        INNER JOIN tbl_user_product_view upv ON upv.product_id = p.product_id
    ";
        $where .= " AND upv.buyer_id = '$session_user_code' 
                AND upv.deal_status = 'Completed' 
                AND p.is_draft = 0";
    } elseif ($product_status == "Active") {
        $where .= " AND p.is_draft = 0 AND p.active = 'Yes' AND p.product_status IN ('Active', 'Post Viewed', 'Under Negotiation')";
    } elseif ($product_status == "Pickup Scheduled") {
        $select_fields .= ", upv.buyer_id, upv.seller_id, upv.deal_status";
        $join = "
        INNER JOIN tbl_user_product_view upv ON upv.product_id = p.product_id
    ";
        $where .= " AND upv.buyer_id = '$session_user_code' AND upv.deal_status = 'Pickup Scheduled'";
    } elseif ($product_status == "all") {
        $where .= " AND p.product_status NOT IN ('Completed', 'Third-Party Transaction', 'Pickup Scheduled','Withdraw')";
        $where .= " AND p.is_draft = 0";
    } else {
        $where .= " AND p.product_status != 'Completed'";
    }


    if ($product_status != "all" && $product_status != "Active") {
        $where .= " AND upv.deal_status != 'Third-Party Transaction'";
    }



    $query = "SELECT $select_fields $base_from $join $where";
}






// --- Final pagination & sorting ---
$query .= " ORDER BY p.entry_timestamp DESC LIMIT $limit OFFSET $offset";

// --- Execute Query ---
$product_dataget = mysqli_query($con, $query);

if (mysqli_num_rows($product_dataget) == 0) {
    if ($page === 1) {
        echo '<div class="no-products-found" style="margin-top: 35px;">
                <center>
                    <h3>No Items Found</h3>
                    <p>No products are available for this status: <strong>' . htmlspecialchars($product_status) . '</strong></p>
                </center>
              </div>';
    }
    exit;
}

// --- Loop Through Results ---
while ($rw = mysqli_fetch_assoc($product_dataget)) {
    $query_img = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id = '" . $rw['product_id'] . "' LIMIT 1");
    $file_dataget = mysqli_fetch_assoc($query_img);
    $file_data = isset($file_dataget['file_name']) ? $file_dataget['file_name'] : 'default.jpg';

    // Status label
    // if ($rw['product_status'] === "Active" || (isset($rw['product_status']) && $rw['product_status'] === "Post Viewed") || (isset($rw['deal_status']) && $rw['deal_status'] === "Credit Used") ) {
    //     $statusLabel = "Open";

    // } elseif ($rw['product_status'] === "Completed") {
    //     $statusLabel = "Closed";

    // } elseif (isset($rw['deal_status']) && $rw['deal_status'] === "Offer Accepted") {
    //     $statusLabel = "Offer Accepted";
    // } elseif ($rw['product_status'] === "Under Negotiation" || (isset($rw['deal_status']) && $rw['deal_status'] === "Under Negotiation") || $rw['product_status'] === "Pickup Scheduled") {
    //     $statusLabel = "In Process";
    // }  elseif ($rw['product_status'] === "Third-Party Transaction" || isset($rw['deal_status']) && $rw['deal_status'] === "Third-Party Transaction") {
    //     $statusLabel = "Not Sold";
    // }else{
    //     $statusLabel = " ";
    // }

    if ($session_user_type === "Buyer") {
        if (
            $rw['deal_status'] === "Credit Used" ||
            $rw['deal_status'] === "Post Viewed" ||
            $rw['product_status'] === "Active" ||
            $rw['product_status'] === "Post Viewed"
        ) {
            $statusLabel = "Open";
        } elseif ($rw['deal_status'] === 'Completed') {
            $statusLabel = "Closed";
        } elseif (in_array($rw['deal_status'], ['Under Negotiation', 'Pickup Scheduled', 'Offer Accepted'])) {
            $statusLabel = "In Process";
        } elseif (in_array($rw['product_status'], ['Under Negotiation', 'Pickup Scheduled', 'Offer Accepted'])) {
            $statusLabel = "Open";
        } else {
            $statusLabel = "";
        }
    } elseif ($session_user_type === "Seller") {
        if ((int)$rw['is_draft'] === 1) {
            $statusLabel = "Draft";
        } elseif ($rw['product_status'] === "Active" || $rw['product_status'] === "Post Viewed") {
            $statusLabel = "Open";
        } elseif ($rw['product_status'] === "Completed" || $rw['product_status'] === "Withdraw") {
            $statusLabel = "Closed";
        } elseif (in_array($rw['product_status'], ['Under Negotiation', 'Pickup Scheduled', 'Offer Accepted'])) {
            $statusLabel = "In Process";
        } elseif ($rw['product_status'] === "Third-Party Transaction") {
            $statusLabel = "Not Sold";
        } else {
            $statusLabel = "";
        }
    }





    echo '<div class="list-item d-flex gap-3" ' .
        ($session_user_type === 'Buyer' ? 'onclick="userViewSellerDetails(event, \'' . $rw['product_id'] . '\')"' : '') .
        '>
        <a href="./product-details/' . $rw['product_id'] . '" class="product-img rounded-0">
            <img src="upload_content/upload_img/product_img/' . $file_data . '" alt="product_img" class="flex-shrink-0 lazyload">
        </a>

        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <a class="product-name h5 mb-1" href="./product-details/' . $rw['product_id'] . '">
                    <h3 class="h5 mb-1">' . htmlspecialchars($rw['product_name']) . '</h3>
                </a>
                <span class="fw-bold mb-0" style="text-align: end !important;">
                    <span class="status">' . $statusLabel . '</span><br><br>
                    ₹' . $rw['sale_price'] . '
                </span>
            </div>
            <span class="text-secondary">' . htmlspecialchars($rw['category_name']) . '</span><br>' .
        (
            (float)$rw['quantity_kg'] > 0
            ? '<span class="text-secondary">' . htmlspecialchars($rw['quantity_kg']) . ' (kg)</span>'
            : '<span class="text-secondary">' . htmlspecialchars($rw['quantity']) .
            (!empty($rw['quantity_unit']) ? ' (' . htmlspecialchars($rw['quantity_unit']) . ')' : '') .
            '</span>'
        ) . '
        </div>
    </div>';
}
