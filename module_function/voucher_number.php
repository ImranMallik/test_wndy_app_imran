<?php

function generateVoucherNumber(){
    global $con;
    global $voucher_type;
    global $generate_type;

    $voucher_config_dataget = mysqli_query($con,"select
        prefix_text, 
        mid_character_length, 
        suffix_text, 
        current_num 
        from voucher_number_config where 
        voucher_type='".$voucher_type."' ");
    $voucher_config_data = mysqli_fetch_row($voucher_config_dataget);

    $prefix_text = $voucher_config_data[0];
    $mid_character_length = $voucher_config_data[1];
    $suffix_text = $voucher_config_data[2];
    $current_num = $voucher_config_data[3];

    $currentVoucherNumber = str_pad($current_num, $mid_character_length, '0', STR_PAD_LEFT);

    $generateVoucherNumber = $prefix_text.$currentVoucherNumber.$suffix_text;

    if ($generate_type!="Show") {
        $nextCurrentNumber = $current_num + 1;

        mysqli_query($con,"update voucher_number_config set 
            current_num='".$nextCurrentNumber."' where  
            voucher_type='".$voucher_type."' ");
    }

    return $generateVoucherNumber;
}

function restoreVoucherNumber(){
    global $con;
    global $voucher_type;
    global $voucher_num;

    $voucher_config_dataget = mysqli_query($con,"select
        prefix_text, 
        mid_character_length, 
        suffix_text, 
        current_num 
        from voucher_number_config where 
        voucher_type='".$voucher_type."' ");
    $voucher_config_data = mysqli_fetch_row($voucher_config_dataget);

    $prefix_text = $voucher_config_data[0];
    $mid_character_length = $voucher_config_data[1];
    $suffix_text = $voucher_config_data[2];
    $current_num = $voucher_config_data[3];
    $previousNumber = $current_num - 1;

    $previousVoucherNumber = str_pad($previousNumber, $mid_character_length, '0', STR_PAD_LEFT);

    $previousVoucherNumber = $prefix_text.$previousVoucherNumber.$suffix_text;

    if ($voucher_num == $previousVoucherNumber) {
        mysqli_query($con,"update voucher_number_config set 
            current_num='".$previousNumber."' where  
            voucher_type='".$voucher_type."' ");
    }
}

?>