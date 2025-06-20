<?php
$product_id = $arr[2];
$product_dataget = mysqli_query($con, "select product_id, product_name, category_id, sale_price, description, brand, quantity, address_id from tbl_product_master where product_id='" . $product_id . "' and user_id='" . $session_user_code . "' and product_status='Active' and active='Yes' ");
$product_data = mysqli_fetch_row($product_dataget);

$product_id = $product_data[0];
$product_name = $product_data[1];
$category_id = $product_data[2];
$sale_price = $product_data[3];
$description = $product_data[4];
$brand = $product_data[5];
$quantity = $product_data[6];
$address_id = $product_data[7];

?>

<script>
    let product_update_address_id = "";
    let update_category_id = "";
</script>
<?php
if ($product_data) {
?>
    <script>
        product_update_address_id = <?php echo $address_id; ?>;
        update_category_id = <?php echo $category_id; ?>;
    </script>
<?php
}
?>
<section class="fxt-template-animation fxt-template-layout2 lg-mt-5 lg-mb-5">
    <div class="container">

        <div class="row justify-content-center align-self-center d-flex">
            <div class="col-lg-6 col-md-7 col-12 bg-form-color">

                <div class="row justify-content-space-around d-flex" style="border-bottom: 1px solid #dee2e6;">
                    <div class="col-6">
                        <p class="title-text f-w-550 pb-3 pt-2" style="white-space: nowrap;">Create Your Post</p>
                    </div>
                    <?php
                    // check seller previous product exist or not
                    $dataget = mysqli_query($con, "select * from tbl_product_master where user_id='" . $session_user_code . "' limit 1 ");
                    $data = mysqli_fetch_row($dataget);
                    if ($data) {
                    ?>
                        <div class="col-6 text-end">
                            <a href="<?php echo $baseUrl . "/product_list"; ?>" class="btn btn-primary btn-sm" style="border-radius: 3px; padding: 7px 9px !important;">
                                <i class="icon anm anm-eye-r me-1" style="padding-left: 2px;"></i>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <input type="hidden" value="<?php echo $product_id; ?>" id="product_id" />

                <!-- Choose a Category start -->
                <p class="title-text f-w-550 pt-3" style="margin-bottom: 5px;">Select Category</p>
                <select class="" id="category_id" name="param" style="display: none;" required>
                    <option value="">Select a Category</option>
                    <?php
                    $fetchData = mysqli_query($con, "SELECT category_id, category_name FROM tbl_category_master WHERE tbl_category_master.active='Yes' AND tbl_category_master.category_name LIKE '%" . $search . "%' LIMIT 50");

                    while ($row = mysqli_fetch_array($fetchData)) {
                        $selected = $row['category_id'] == $category_id ? "selected" : "";
                        echo "<option value='" . $row['category_id'] . "' " . $selected . " >" . $row['category_name'] . "</option>";
                    }
                    ?>
                </select>
                <label data-default-mssg="" class="input_alert category_id-inp-alert"></label>

                <div style="position: relative;">
                    <div class="category-div text-center">
                        <div style="padding: 5px;">

                            <?php
                            $category_dataget = mysqli_query($con, "select category_id, category_name, category_img from tbl_category_master where active='Yes' order by order_number ASC ");
                            while ($rw = mysqli_fetch_array($category_dataget)) {
                            ?>
                                <button onclick="selectCategory(<?php echo $rw['category_id']; ?>);" data-category_id="<?php echo $rw['category_id']; ?>" data-category_name="<?php echo $rw['category_name'] ?>" class="cat-btn cate_btn_<?php echo $rw['category_id']; ?>" title="<?php echo $rw['category_name']; ?>">
                                    <img src="./upload_content/upload_img/category_img/<?php echo $rw['category_img'] == "" ? "no_image.png" : $rw['category_img'] ?>" />
                                    <br />
                                    <?php echo $rw['category_name']; ?>
                                </button>
                            <?php
                            }
                            ?>

                        </div>

                    </div>
                    <div class="catgory-show-div">

                        <span class="category-close-btn" onclick="closeCategory()">
                            <i class="fa fa-remove"></i>
                        </span>

                        <button class="cat-btn main-cate-btn animate__animated animate__bounceIn" style="line-height: normal; width: 100%; font-size: 12px;">
                            <img src="./upload_content/upload_img/category_img/category_img_3-5-2024-1717401090147.png" />
                            Category Name With Full
                        </button>
                    </div>
                </div>

                <!-- Confirm Your Location start -->
                <p class="title-text f-w-550 pt-4">Confirm Your Location</p>
                <div style="display: flex; justify-content: space-between;">
                    <p class="title-text">
                        Address <span class="text-danger">*</span>
                    </p>
                    <a data-bs-toggle="modal" data-bs-target="#addressModal" onclick="clear_address_input()" class="btn btn-primary btn-sm create-new text-right" style="border-radius:3px; padding: 2px 9px !important;">
                        <img src="frontend_assets/img-icon/add-location.png" height="24" width="24" />
                    </a>
                </div>

                <select class="form-control select2" id="address_id" onchange="showAddressDetails()" required style="margin-top: 5px;">
                    <option value="">Choose Address</option>
                </select>
                <label data-default-mssg="" class="input_alert address_id-inp-alert"></label>

                <div class="address_details">
                    <!-- Here show address details of choose address -->
                </div>
                <!-- Confirm Your Location end -->


                <!-- Seller post details start -->
                <p class="title-text f-w-550 pt-4" style="margin-bottom: 3px;">Post Details</p>
                <div class="fxt-form">
                    <p class="title-text">Item Name <span class="text-danger">*</span></p>
                    <div class="col-12 icon-group">
                        <input type="text" value="<?php echo $product_name; ?>" class="form-control rounded-0" id="product_name" required placeholder="e.g: Waste" maxlength="100" />
                        <label data-default-mssg="" class="input_alert product_name-inp-alert"></label>
                    </div>
                </div>

                <div class="fxt-form">
                    <p class="title-text">Description <span class="text-danger">*</span></p>
                    <div class="col-12 icon-group">
                        <textarea class="form-control rounded-0" placeholder="e.g: description" name="" id="description" required><?php echo $description; ?></textarea>
                        <label data-default-mssg="" class="input_alert description-inp-alert"></label>
                    </div>
                </div>

                <div class="fxt-form">
                    <p class="title-text">Brand</p>
                    <div class="col-12  icon-group">
                        <input type="text" value="<?php echo $brand; ?>" class="form-control rounded-0" id="brand" placeholder="e.g: WM" maxlength="100" />
                        <label data-default-mssg="" class="input_alert brand-inp-alert"></label>
                    </div>
                </div>

                <div class="fxt-form">
                    <p class="title-text">Quantity</p>
                    <div class="col-12  icon-group">
                        <input type="text" value="<?php echo $quantity; ?>" class="form-control rounded-0" id="quantity" placeholder="e.g: 1 Pcs, 2 k.g" min="1">
                        <label data-default-mssg="" class="input_alert quantity-inp-alert"></label>
                    </div>
                </div>

                <!-- <p class="avg_price_p"> -->
                <!-- Generate from js      -->
                <!-- Average Price : 5000 /- -->
                <!-- </p> -->

                <div class="fxt-form">
                    <p class="title-text">Expected Price <span class="text-danger">*</span></p>
                    <div class="col-12 icon-group">
                        <input type="text" value="<?php echo isset($sale_price) && is_numeric($sale_price) ? (int)$sale_price : ''; ?>" class="form-control rounded-0" id="sale_price" placeholder="e.g: 100, Or, 200" required min="1" maxlength="8">
                        <label data-default-mssg="" class="input_alert sale_price-inp-alert"></label>
                    </div>
                </div>
                <!-- view rate list div -->
                <div id="rate_list_button" class="rate_list_button" style="display: none;">
                    <button style="background-color: #0571ae; padding: 4px 8px;" onclick="getCategoryWiseRateList();" class="btn">
                        View Rate List
                    </button>
                </div>

                <!-- product Image Start  -->
                <div class="col-md-12">
                    <div class="input_group_div">
                        <div style="width: 226px;" class="input_group_heading">
                            <p class="title-text">Item Image <span class="text-danger">*</span></p>
                        </div>
                        <div style="overflow-x: auto; ">
                            <table class="table mb-6 p-4">
                                <tbody class="BusinessImageDetailsEntryTbody">
                                    <tr class="tr_busimg tr_busimg_1 " style="align-content: center;">
                                        <td scope="row" class="busimg_sl_num" style="text-align: center;">
                                            1
                                        </td>
                                        <td scope="row">
                                            <div class="form-group product_img_div">
                                                <input style="display: none;" type="file" onchange="loadFile(this,'preview_img_1'); checkFile(1);" id="busimg_1" class="form-control image" accept="<?php echo $inputAllowedImage; ?>" required />
                                                <img style="max-width: 80px; height: 50px !important;" onclick="chooseImg(1,'gallery')" data-blank-image="../upload_content/upload_img/product_img/no_image.png" src="frontend_assets/img-icon/gallery.png" />
                                                <img style="max-width: 80px; height: 50px !important;" onclick="chooseImg(1,'camera')" data-blank-image="../upload_content/upload_img/product_img/no_image.png" src="frontend_assets/img-icon/camera.png" />
                                                <span class="img_name img_name_1" style="display:none;">Choose Image</span>
                                                <!-- Placeholder for selected image preview -->
                                                <img id="preview_img_1" style="max-height: 80px; max-width: 100px; margin-left: 20px;" />
                                            </div>
                                            <label data-default-mssg="" class="input_alert busimg_1-inp-alert"></label>
                                        </td>

                                        <td class="busimgactionTd_1" style="text-align: center;">
                                            <button onclick="createBusimgRow(1)" class="btn btn-icon btn-primary btn-lg mt-2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- product Image End -->

                <?php
                if ($product_data) {
                ?>
                    <p class="title-text f-w-550 pt-4" style="margin-bottom: 3px;">Item Images</p>

                    <div class="scroll-container">
                        <?php
                        $product_file_dataget = mysqli_query($con, "select product_file_id, file_name from tbl_product_file where file_type='Photo' and product_id='" . $product_id . "' ");
                        while ($rw = mysqli_fetch_array($product_file_dataget)) {
                        ?>
                            <div class="scroll-item previous_image_<?php echo $rw['product_file_id']; ?>">
                                <img src="upload_content/upload_img/product_img/<?php echo $rw['file_name']; ?>" />
                                <a onclick="show_del_data_confirm_box(<?php echo $rw['product_file_id']; ?>)" class="btn btn-danger btn-sm image-delete-btn" style="border-radius: 3px; padding: 7px 9px !important; background: #ff5a5a; border: 0px; margin-top: 5px; display:flex;">
                                    <i class="fa fa-remove me-1"></i>
                                    Delete
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>


                <!-- Seller post details end -->
                <div class="fxt-form-btn fxt-transformY-50 fxt-transition-delay-4">
                    <button type="button" class="fxt-btn-fill disabled" onclick="save_details()">Continue <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- New Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="addNewModalLabel">Address Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="modal_address_id" />
                <form class="add-address-from" method="post" action="#">
                    <div class="form-row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1">
                        <div class="form-group">
                            <label for="contact_name">Contact Name <span class="required">*</span></label>
                            <input name="contact_name" placeholder="e.g: John Doe" value="<?php echo $session_name; ?>" id="contact_name" type="text" required />
                            <label data-default-mssg="" class="input_alert contact_name-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="contact_ph_num">Contact Number <span class="required">*</span></label>
                            <input name="contact_ph_num" placeholder="e.g: 9988774455" value="<?php echo $session_ph_num; ?>" id="contact_ph_num" maxlength="10" minlength="10" type="text" required />
                            <label data-default-mssg="" class="input_alert contact_ph_num-inp-alert"></label>
                        </div>
                        <div class="form-group d-none">
                            <label for="alternative_num">Alternative Number </label>
                            <input name="alternative_num" placeholder="e.g: 9988774455" value="" id="alternative_num" maxlength="10" minlength="10" type="text" />
                            <label data-default-mssg="" class="input_alert alternative_num-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="address_name">Address Name <span class="required">*</span></label>
                            <input name="address_name" placeholder="e.g: Home Address Or, Office Address" value="" id="address_name" type="text" required />
                            <label data-default-mssg="" class="input_alert address_name-inp-alert"></label>
                        </div>
                        <div class="form-group d-none">
                            <label for="address_tag">Address Tag <span class="required">*</span></label>
                            <select name="address_tag" id="address_tag">
                                <option value="">Address Tag</option>
                                <option value="home">Home</option>
                                <option value="office">Office</option>
                                <option value="other">Other</option>
                            </select>
                            <label data-default-mssg="" class="input_alert address_tag-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="country">Country <span class="required">*</span></label>
                            <input name="country" placeholder="e.g: India" value="" id="country" type="text" required />
                            <label data-default-mssg="" class="input_alert country-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="state">State <span class="required">*</span></label>
                            <input name="state" placeholder="e.g: WB" value="" id="state" type="text" required />
                            <label data-default-mssg="" class="input_alert state-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input name="city" placeholder="e.g: Kolkata" value="" id="city" type="text" required />
                            <label data-default-mssg="" class="input_alert city-inp-alert"></label>
                        </div>
                        <div class="form-group">
                            <label for="landmark">Landmark <span class="required">*</span></label>
                            <input name="landmark" placeholder="e.g: Saltlake" value="" id="landmark" type="text" required />
                            <label data-default-mssg="" class="input_alert landmark-inp-alert"></label>
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label for="pincode">Pincode <span class="required">*</span></label>
                            <input name="pincode" placeholder="e.g: 785421" value="" id="pincode" type="text" minlength="6" maxlength="6" required />
                            <label data-default-mssg="" class="input_alert pincode-inp-alert"></label>
                        </div><br>
                        <div class="form-group" style="width: 100%">
                            <label for="address_line_1">Address <span class="required">*</span></label>
                            <textarea name="address_line_1" placeholder="e.g: 38, Sector 1, AB Block, Saltlake, 700125" value="" id="address_line_1" type="text" required></textarea>
                            <label data-default-mssg="" class="input_alert address_line_1-inp-alert"></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" onclick="save_address_details();" class="btn btn-primary m-0">
                    <span>Save Address</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End New Address Modal -->

<!-- Start rate list modal -->
<!-- Modal-->
<div class="modal fade catgory-rate-list-div" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" onclick="closeCategoryRateList()">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <span class="catgory-rate-list-close-btn">
                <i class="fa fa-remove"></i>
            </span>
            <div class="modal-body" style="height: 100vh;">
                <!-- here dynamically rate list data will get -->
            </div>
        </div>
    </div>
</div>
<!-- End rate list modal -->