<?php
include("../db/db.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {

    $sendData = json_decode($_POST['sendData'], true);

    $credit = mysqli_real_escape_string($con, $sendData['credit']);
    $order_id = mysqli_real_escape_string($con, $sendData['order_id']);
    $amount = 0;

    $execute = 1;

    if ($execute == 1) {
        $dataget = mysqli_query($con, "select purchase_amount from tbl_credit_option where credit='" . $credit . "' and active='Yes' ");
        $data = mysqli_fetch_row($dataget);

        if (!$data) {
            $status = "error";
            $status_text = "Credit Option Not Found";
            $execute = 0;
        } else {
            $amount = $data[0];
        }
    }

    // check payment
    // if ($execute == 1) {
    //     $dataget = mysqli_query($con, "select * from payment_details where status='Complete' and order_id='" . $order_id . "' ");
    //     $data = mysqli_fetch_row($dataget);

    //     if (!$data) {
    //         $status = "payment error";
    //         $status_text = "Payment Not Verified";
    //         $execute = 0;
    //     }
    // }

    if ($execute == 1) {

        $user_id = $session_user_code;
        $in_credit = $credit;
        $purchase_amount = $amount;
        $trans_date = $date;
        $trans_type = "Credit Purchase";
        $status = "In";

        //========================= INSERT IN tbl_credit_trans TABLE =======================
        mysqli_query($con, "INSERT INTO tbl_credit_trans (
            user_id,
            in_credit,
            purchase_amount, 
            trans_date,
            trans_type,   
            status,             
            entry_user_code,
            entry_timestamp
        ) VALUES ( 
            '" . $user_id . "',
            '" . $in_credit . "',
            '" . $purchase_amount . "',
            '" . $trans_date . "',
            '" . $trans_type . "',
            '" . $status . "',                     
            '" . $session_user_code . "',
            '" . $timestamp . "'
        )");

        $status = "success";
        $status_text = "🤩 Thank You For Purchasing";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
