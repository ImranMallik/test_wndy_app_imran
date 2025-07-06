<?php
include("../db/db.php");
include("../../module_function/user_credit_details.php");
include("../../module_function/notification_details.php");

mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
  $status = "SessionDestroy";
  $status_text = "";
} else {

  $sendData = json_decode($_POST['sendData'], true);

  $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
  $baseUrl = mysqli_real_escape_string($con, $sendData['baseUrl']);

  // $userCreditBalance = getCreditBalance($session_user_code);

  $system_info_dataget = mysqli_query($con, "select product_view_credit from system_info where 1 ");
  $system_info_data = mysqli_fetch_row($system_info_dataget);
  $product_view_credit = $system_info_data[0];

  $execute = 1;

  // check credit balance
  // if ($execute == 1) {
  //   if ($product_view_credit > $userCreditBalance) {
  //     $status = "balance error";
  //     $status_text = "Insufficient Credit Balance. Please purchase some credit";
  //     $execute = 0;
  //   }
  // }

  // check product valid or not
  if ($execute == 1) {
    $product_dataget = mysqli_query($con, "select * from tbl_product_master where product_id='" . $product_id . "' ");
    $product_data = mysqli_fetch_row($product_dataget);
    if (!$product_data) {
      $status = "error";
      $status_text = "Product Details Not Found";
      $execute = 0;
    }
  }

  if ($execute == 1) {

    $product_dataget = mysqli_query($con, "select user_id from tbl_product_master where product_id='" . $product_id . "' ");
    $product_data = mysqli_fetch_assoc($product_dataget);
    $seller_id = $product_data['user_id'];

    $buyer_id = $session_user_code;
    // $view_date = $date;
    $view_date = date('Y-m-d H:i:s');

    $deal_status = "Credit Used";
    $product_status = "Post viewed";
    $trans_id = "WNDY" . uniqid() . time();
    $buyer_action_time = date('Y-m-d H:i:s');


    $current_history_buyer[] = [
      'status' => 'Credit Used',
      'time' => $timestamp
    ];

    $new_json_buyer = mysqli_real_escape_string($con, json_encode($current_history_buyer));


    $check_query = mysqli_query($con, "
       SELECT view_id 
       FROM tbl_user_product_view 
       WHERE product_id = '$product_id' 
       AND buyer_id = '$buyer_id'
       LIMIT 1
       ");


    //========================= INSERT IN tbl_user_product_view TABLE =======================

    if (mysqli_num_rows($check_query) == 0) {
      mysqli_query($con, "INSERT INTO tbl_user_product_view (
            trans_id,
            buyer_id,
            product_id,
            seller_id,
            view_date, 
            deal_status, 
             buyer_action_time,
             deal_status_history,
              used_credits,  
            entry_user_code,
            entry_timestamp
        ) VALUES ( 
            '" . $trans_id . "',
            '" . $buyer_id . "',
            '" . $product_id . "',
            '" . $seller_id . "',
            '" . $view_date . "',
            '" . $deal_status . "', 
            '" . $buyer_action_time . "',
            '" . $new_json_buyer . "',
            '10',
            '" . $session_user_code . "',
            '" . $timestamp . "'
        )");

      $view_id = mysqli_insert_id($con);


      $current_history[] = [
        'status' => $product_status,
        'time' => $timestamp
      ];






      // 4. Encode to JSON
      $new_json = mysqli_real_escape_string($con, json_encode($current_history));

      // ========================= UPDATE IN tbl_product_master TABLE =======================
      mysqli_query($con, "
    UPDATE tbl_product_master SET 
        product_status = '" . $product_status . "',
        product_status_history = '" . $new_json . "'
    WHERE product_id = '" . $product_id . "'
");



      // Insert into product_status_update_tbl
      // mysqli_query($con, "INSERT INTO product_status_update_tbl (
      //     buyer_id,
      //     product_id,
      //     product_update_status,
      //     created_at
      // ) VALUES (
      //     '" . $session_user_code . "',
      //     '" . $product_id . "',
      //     '" . $product_status . "',
      //     NOW()
      // )");





      // deduct credit from buyer
      $transBuyerId = $buyer_id;
      $transCredit = $product_view_credit;
      $transDate = $date;
      $transType = 'Product View Deduct';
      $transStatus = "Out";
      $credit_trans_id = insertCreditTransDetails();

      // update credit trans id in product_view_table
      mysqli_query($con, "update tbl_user_product_view 
           SET credit_trans_id='" . $credit_trans_id . "', used_credits='" . $product_view_credit . "' 
           WHERE view_id='" . $view_id . "' ");

      // seller will notified that buyer want to purchase 
      $productDataget = mysqli_query($con, "select 
                        tbl_product_master.product_name,
                        tbl_product_master.user_id
                        from tbl_product_master
                        where tbl_product_master.product_id='" . $product_id . "' ");
      $productData = mysqli_fetch_assoc($productDataget);
      $product_name = $productData['product_name'];
      $seller_id = $productData['user_id'];

      $noti_title = "New Purchase Request";
      $noti_details = "A buyer has sent a price request for purchasing your " . $product_name;
      $noti_url = $baseUrl . "/product-details/" . $product_id;
      $noti_to_user_id = $seller_id;
      $noti_from_user_id = $session_user_code;
      // insertNotificationDetails();

      $status = "success";
      $status_text = "10 Credits Has Been Deducted. You can view seller details now for this product";
    }
  } else {
    $status = "success";
    $status_text = "You have already viewed this product. No credits deducted.";
  }
}


$response[] = [
  'status' => $status,
  'status_text' => $status_text,
];
echo json_encode($response, true);
