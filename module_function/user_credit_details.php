<?php
function getCreditBalance($buyer_id)
{
    global $con;

    $dataget = mysqli_query($con, "select sum(in_credit - out_credit) from tbl_credit_trans where user_id='" . $buyer_id . "' ");
    $data = mysqli_fetch_row($dataget);
    $creditBalance = $data[0];
    return $creditBalance;
}

function insertCreditTransDetails()
{
    global $con;
    global $transBuyerId;
    global $transCredit;
    global $transDate;
    global $transType;
    global $transStatus;
    global $session_user_code;
    global $timestamp;
    global $credit_trans_id;

    $user_id = $transBuyerId;
    $in_credit = 0;
    $out_credit = 0;
    $trans_date = $transDate;
    $trans_type = $transType;
    $status = $transStatus;

    if ($transStatus == "In") {
        $in_credit = $transCredit;
    }
    if ($transStatus == "Out") {
        $out_credit = $transCredit;
    }

    //========================= INSERT IN tbl_credit_trans TABLE =======================
    mysqli_query($con, "INSERT INTO tbl_credit_trans (
            user_id,
            in_credit,
            out_credit,
            trans_date,
            trans_type,   
            status,             
            entry_user_code,
            entry_timestamp
        ) VALUES ( 
            '" . $user_id . "',
            '" . $in_credit . "',
            '" . $out_credit . "',
            '" . $trans_date . "',
            '" . $trans_type . "',
            '" . $status . "',                     
            '" . $session_user_code . "',
            '" . $timestamp . "'
        )");

    $credit_trans_id = mysqli_insert_id($con);
    return $credit_trans_id;
}
