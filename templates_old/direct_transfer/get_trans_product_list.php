<?php
include("../db/db.php");



// Decode JSON data sent via POST
$sendData = json_decode($_POST['sendData'], true);
$category_id = trim(mysqli_real_escape_string($con, $sendData['category_id']));


// SQL query to fetch purchased items

$query = "SELECT dt.transferred_to_id, 
                cm.category_id, 
                dt.product_id, 
                pm.product_name, 
                MIN(pf.file_name) AS file_name
            FROM tbl_direct_transfer dt 
            LEFT JOIN tbl_product_master pm ON pm.product_id = dt.product_id 
            LEFT JOIN tbl_product_file pf ON pf.product_id = dt.product_id
            LEFT JOIN tbl_category_master cm ON cm.category_id = pm.category_id
            WHERE dt.transferred_to_id = '$session_user_code' 
            AND dt.transferred_status = 'Direct Transfer'
            AND pm.product_status = 'Completed' 
            AND pf.active = 'Yes'
            AND cm.active = 'Yes' ";

if ($category_id != "") {
    $query .= " AND pm.category_id='$category_id'";
}

$query .= "GROUP BY dt.transferred_to_id, cm.category_id, dt.product_id, pm.product_name, pf.file_name ";

$productData = mysqli_query($con, $query);

$totalItems = mysqli_num_rows($productData);
//echo json_encode($totalItems); exit;
?>

<p class="toolbar-product-count" style="margin-top: 7px; ">
    <span>Showing: <?php echo $totalItems; ?> Purchased Items</span>
    <!-- <span></span> -->

</p>

<?php if ($totalItems === 0) { ?>
    <div class="no-products-found">
        <center>
            <h3>No Items <br> Found</h3>
        </center>
    </div>
    <p></p>
<?php } else { ?>
    <div class="container-fluid">
        <div class="row" id="transferredProductList">
      
     
            <?php while ($row = mysqli_fetch_assoc($productData)) { ?>
                <div class="col-4 col-sm-12 col-md-4 mb-1">
                    <div class="product-box position-relative"
                        style="border-radius: 10px; background-color: #f9f9f9; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden; height:150px;">

                        <!-- Product Image as Background -->
                        <div class="product-image"
                            style="height: 140px; background: url('upload_content/upload_img/product_img/<?php echo $row['file_name'] ?: 'no_image.png'; ?>') no-repeat center center/cover;">
                        </div>

                        <div class="product-details text-center"
                            style="background-color: #2f415d; color: #fff; padding: 7px; position: absolute; bottom: 0; width: 100%;">
                            <div class="product-name" style="font-size: 14px; font-weight: 500; margin: 0; line-height: 1.5;">
                                <?php
                                echo !empty($row['product_name'])
                                    ? (mb_strlen($row['product_name']) > 6
                                        ? htmlspecialchars(mb_substr($row['product_name'], 0, 6)) . '..'
                                        : htmlspecialchars($row['product_name']))
                                    : 'NA';
                                ?>
                            </div>
                        </div>
               
      
                     
					</div>
				</div>
               

				<?php } ?>
        
        </div>
       
        
    </div>
    <input type="hidden" id="buyer_id" value="<?php echo $session_user_code; ?>">
    <button id="acceptButton" onclick="acceptProduct()" 
            style="position:relative; background-color: #28a745; color: white; border: none; border-radius: 5px; padding: 10px 30px; cursor: pointer; margin-right: auto; float: left;">
        Accept
        <i class="fa fa-check-circle"></i>
    </button>
	<?php } ?>