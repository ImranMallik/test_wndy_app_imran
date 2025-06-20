<?php
function customNumberFormat($number)
{
    if ($number < 1000) {
        $number_format = number_format($number);
    } else if ($number < 1000000) {
        // Anything less than a thousand
        $number_format = number_format($number / 1000, 2) . 'K';
    } else if ($number < 1000000000) {
        // Anything less than a billion
        $number_format = number_format($number / 1000000, 2) . 'M';
    } else {
        // At least a billion
        $number_format = number_format($number / 1000000000, 2) . 'B';
    }
    
    return $number_format;
}
