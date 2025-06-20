<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if($login == "No"){
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroyed In Manage Customer Cart Details";
} else {
    if($entry_permission == 'Yes'){
        $sendData = json_decode($_POST['sendData'], true);

        $cart_id = mysqli_real_escape_string($con, $sendData['cart_id']);
        $buyer_id = mysqli_real_escape_string($con, $sendData['buyer_id']);
        $product_id = mysqli_real_escape_string($con, $sendData['product_id']);
        
        $excecute = 1;

        //============================== IF CODE BLANK THEN INSERT ==================================
        if($cart_id == "") {
            //========================= CHECK SAME DATA EXIST OR NOT =======================
            $dataget = mysqli_query($con, "SELECT * FROM tbl_buyer_cart WHERE buyer_id = '$buyer_id' AND product_id = '$product_id'");
            $data_num_row = mysqli_num_rows($dataget);
            
            if($data_num_row > 0) {
                $status = "Exist";
                $status_text = "Already Exists Same Buyer With Same Product !!";
            } else {
                //========================= INSERT IN TABLE =======================
                mysqli_query($con, "INSERT INTO tbl_buyer_cart (
                    cart_id,
                    buyer_id, 
                    product_id,
                    entry_user_code
                    ) VALUES (
                    NULL,
                    '$buyer_id',
                    '$product_id',
                    '$session_user_code')");
                
                $status = "Save";
                $status_text = "New Cart Data Added Successfully";
                $activity_details = "You Inserted A Record In Manage Buyer Cart Details";
            }
        } 
        //============================== IF DOES NOT BLANK THEN UPDATE ==================================
        else {
            //========================= CHECK SAME DATA EXIST OR NOT =======================
            $dataget = mysqli_query($con, "SELECT * FROM tbl_buyer_cart WHERE cart_id <> '$cart_id' AND buyer_id = '$buyer_id' AND product_id = '$product_id'");
            $data_num_row = mysqli_num_rows($dataget);
            
            if($data_num_row > 0) {
                $status = "Exist";
                $status_text = "Already Exists Same Buyer and Product Data !!";
            } else {
                mysqli_query($con, "UPDATE tbl_buyer_cart 
                    SET buyer_id = '$buyer_id', 
                        product_id = '$product_id', 
                        entry_user_code = '$session_user_code', 
                        update_timestamp = '$timestamp' 
                    WHERE cart_id = '$cart_id'");

                $status = "Save";
                $status_text = "Cart Data Updated Successfully";
                $activity_details = "You Updated A Record In Manage Buyer Cart Details";
            }
        }
    } else {
        $status = "NoPermission";
        $status_text = "You Don't Have Permission To Enter Any Data !!";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);

if ($activity_details != "") {
    insertActivity($activity_details, $con, $session_user_code);
}
?>
