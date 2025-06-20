<?php
include("../db/db.php");


$product_status = isset($_POST['product_status']) ? trim(mysqli_real_escape_string($con, $_POST['product_status'])) : 'all';

$query = "SELECT 
        tbl_product_master.product_id,
        tbl_product_master.product_name,
        tbl_category_master.category_img,
        tbl_category_master.category_name,
        tbl_product_master.sale_price,
        tbl_product_master.product_status,
        tbl_product_master.quantity,
        tbl_product_master.quantity_unit,
        tbl_address_master.state,
        tbl_address_master.city,
        tbl_address_master.landmark,
        tbl_address_master.pincode
        FROM tbl_product_master
        LEFT JOIN tbl_category_master ON tbl_category_master.category_id = tbl_product_master.category_id
        LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id
        WHERE tbl_product_master.active = 'Yes' ";




if ($session_user_type == "Seller") {
    $query .= " AND tbl_product_master.user_id = '$session_user_code' ";
}


if ($product_status == "Active") {
    $query .= " AND tbl_product_master.product_status = 'Active' ";
} elseif ($product_status == "Completed") {
    $query .= " AND tbl_product_master.product_status = 'Completed' ";
} elseif ($product_status == "in-process") {
    $query .= " AND tbl_product_master.product_status = 'Under Negotiation' ";
}

$query .= " ORDER BY tbl_product_master.entry_timestamp DESC ";

$product_dataget = mysqli_query($con, $query);



if (mysqli_num_rows($product_dataget) == 0) {
    echo '<div class="no-products-found">
            <center>
                <h3>No Items Found</h3>
                <p>No products are available for this status: <strong>' . htmlspecialchars($product_status) . '</strong></p>
            </center>
          </div>';
    exit; // Stop execution here
}

echo '<div class="container-fluid" style="margin-top:50px;"><div class="row">';

while ($rw = mysqli_fetch_assoc($product_dataget)) {

    $query_img = mysqli_query($con, "SELECT file_name FROM tbl_product_file WHERE product_id = '" . $rw['product_id'] . "' LIMIT 1");
    $file_dataget = mysqli_fetch_assoc($query_img);
    $file_data = $file_dataget['file_name'];


    $statusLabel = ($rw['product_status'] == "Active") ? "Open" : (($rw['product_status'] == "Completed") ? "Closed" : "In Process");

    echo '<div class="list-item d-flex gap-3">
            <a href="./product-details/' . $rw['product_id'] . '" class="product-img rounded-0">
                <img src="upload_content/upload_img/product_img/' . $file_data . '" alt="product_img" class="flex-shrink-0 lazyload">
            </a>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="product-name h5 mb-1" href="./product-details/' . $rw['product_id'] . '">
                        <h3 class="h5 mb-1">' . $rw['product_name'] . '</h3>
                    </a>
                    <span class="fw-bold mb-0" style="text-align: end !important;">
                        <span class="status">' . $statusLabel . '</span><br><br>
                        ₹' . $rw['sale_price'] . '
                    </span>
                </div>
                <span class="text-secondary">' . $rw['category_name'] . '</span><br>
              <span class="text-secondary">' . htmlspecialchars($rw['quantity']) . (!empty($rw['quantity_unit']) ? '(' . htmlspecialchars($rw['quantity_unit']) . ')' : '') . '</span>

            </div>
          </div>';
}

echo '</div></div>';
