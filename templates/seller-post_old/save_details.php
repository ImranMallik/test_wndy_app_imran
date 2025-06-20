<?php
include("../db/db.php");
include("../../module_function/notification_details.php");
include("../../module_function/sms_gateway_api.php");
include("../../module_function/whatsapp_notification.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {

    $sendData = json_decode($_POST['sendData'], true);

    $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
    $category_id = mysqli_real_escape_string($con, $sendData['category_id']);
    $address_id = mysqli_real_escape_string($con, $sendData['address_id']);
    $product_name = mysqli_real_escape_string($con, $sendData['product_name']);
    $description = mysqli_real_escape_string($con, $sendData['description']);
    $brand = mysqli_real_escape_string($con, $sendData['brand']);
    $quantity = mysqli_real_escape_string($con, $sendData['quantity']);
    $sale_price = mysqli_real_escape_string($con, $sendData['sale_price']);
    $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);

    $product_img_array = $sendData['product_img_array'];
    $total_img_rw = mysqli_real_escape_string($con, $sendData['total_img_rw']);

    // auto-generated post_id for per-post
    $post_id = "POST" . time();

    $execute = 1;

    if ($execute == 1) {
        if ($product_id == "") {
            $query = "SELECT * FROM tbl_product_master WHERE tbl_product_master.product_name = '" . $product_name . "' AND user_id = '" . $session_user_code . "' AND product_status='Active' ";
        } else {
            $query = "SELECT * FROM tbl_product_master WHERE tbl_product_master.product_name = '" . $product_name . "' AND user_id = '" . $session_user_code . "' AND product_status='Active' AND product_id != '" . $product_id . "' ";
        }
        $dataget = mysqli_query($con, $query);
        $rw = mysqli_num_rows($dataget);
    }

    if ($execute == 1) {
        if ($product_id == "") {
            //========================= INSERT IN tbl_product_master TABLE =======================
            mysqli_query($con, "INSERT INTO tbl_product_master (
                product_name,
                post_id,
                category_id,
                user_id, 
                sale_price,
                description,   
                brand,
                quantity,
                address_id,                 
                entry_user_code,
                entry_timestamp
            ) VALUES ( 
                '" . $product_name . "',
                '" . $post_id . "',
                '" . $category_id . "',
                '" . $session_user_code . "',
                '" . $sale_price . "',
                '" . $description . "',
                '" . $brand . "',
                '" . $quantity . "',
                '" . $address_id . "',                        
                '" . $session_user_code . "',
                '" . $timestamp . "'
            )");

            $product_id = mysqli_insert_id($con);

            ## product name gets
            $productNameDataGet = mysqli_query($con, "SELECT product_name FROM tbl_product_master WHERE product_id = '" . $product_id . "'");
            $productNameData = mysqli_fetch_row($productNameDataGet);
            $productName = $productNameData[0];

            // get address details and send notification to all same pincode buyer
            $address_dataget = mysqli_query($con, "select pincode from tbl_address_master where address_id='" . $address_id . "' ");
            $address_data = mysqli_fetch_row($address_dataget);
            $pincode = $address_data[0];

            // category details get
            $category_dataget = mysqli_query($con, "select category_name from tbl_category_master where category_id='" . $category_id . "' ");
            $category_data = mysqli_fetch_row($category_dataget);
            $category_name = $category_data[0];

            // get all the buyer details of this pincode
            $dataget = mysqli_query($con, "select 
                        distinct(tbl_user_master.user_id)
                        from tbl_address_master 
                        LEFT JOIN tbl_user_master ON tbl_user_master.user_id=tbl_address_master.user_id
                        where tbl_user_master.user_type='Buyer' and tbl_address_master.pincode='" . $pincode . "' ");
            while ($rw = mysqli_fetch_array($dataget)) {
                $noti_title = "New Post Available";
                $noti_details = "In your locality new post available of " . $category_name . ". click for view the item";
                $noti_url = $baseUrl . "/product-details/" . $product_id;
                $noti_to_user_id = $rw['user_id'];
                $noti_from_user_id = $session_user_code;
                insertNotificationDetails();
            }

            ## buyer will get sms if any seller made a post on buyer's relevent pincode
            ## Get the count of buyers based on pincode
            $buyersQuery = "SELECT 
                                tbl_user_master.ph_num,
                                tbl_user_master.name
                            FROM tbl_user_master 
                            LEFT JOIN tbl_address_master ON tbl_address_master.user_id = tbl_user_master.user_id
                            WHERE tbl_address_master.pincode = '$pincode' AND tbl_user_master.user_type = 'Buyer'";
            $buyersResult = mysqli_query($con, $buyersQuery);

            ## Check if any buyers exist and send SMS
            if (mysqli_num_rows($buyersResult) > 0) {
                while ($buyer = mysqli_fetch_assoc($buyersResult)) {
                    // SMS notification
                    $sendPhNum = $buyer['ph_num'];
                    $sendMssg = "Dear Buyer, we have some scrap item(s) posted for sale in your location. Please log on to WNDY and check the app for details - ZAG Tech Solutions";
                    sendSms();
                    // Whatsapp notification
                    $sendPhoneNumber = $buyer['ph_num'];
                    $fetchUserName = $buyer['name'];
                    $campaignName = "Post_Creation_msg";
                    $params = [$fetchUserName];
                    sendWhatsappMessage();
                }
            }

            $status = "Save";
            $status_text = "New Post Data Added Successfully";
        } else {
            //========================= UPDATE tbl_product_master TABLE =======================
            mysqli_query($con, "UPDATE tbl_product_master SET  
                            product_name='$product_name', 
                            category_id='$category_id', 
                            sale_price='$sale_price', 
                            description='$description', 
                            brand='$brand', 
                            quantity='$quantity', 
                            address_id='$address_id', 
                            entry_user_code='$session_user_code', 
                            update_timestamp='$timestamp' 
                            WHERE product_id='$product_id'");

            $status = "Save";
            $status_text = "Post Data Updated Successfully";
        }

        //========================= INSERT IN tbl_product_file TABLE =======================
        if ($product_id != "") {
            for ($i = 0; $i < $total_img_rw; $i++) {
                $file_name = mysqli_real_escape_string($con, $product_img_array[$i]);

                mysqli_query($con, "INSERT INTO tbl_product_file (
                                    file_type,
                                    file_name,
                                    product_id,
                                    entry_user_code,
                                    entry_timestamp
                                    ) VALUES (
                                    'Photo',
                                    '" . $file_name . "',
                                    '" . $product_id . "',
                                    '" . $session_user_code . "',
                                    '" . $timestamp . "'
                            )");
            }
        }
    }
}
header('Content-Type: application/json'); // Set the correct header for JSON
$response = [
    [
        "status" => "Save",
        "status_text" => "New Post Data Added Successfully"
    ]
];
echo json_encode($response); // Output the JSON response
exit;
