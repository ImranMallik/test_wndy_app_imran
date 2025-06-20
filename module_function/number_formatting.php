<?php

function getTwoDecimalNum($number){
    $NumOfDecimals = 2;
    $decimalIndicator = '.';
    $thousandSeparator = '';
    $retuenNumber = number_format($number, $NumOfDecimals, $decimalIndicator, $thousandSeparator);
    return $retuenNumber;
}

function getThreeDecimalNum($number){
    $NumOfDecimals = 3;
    $decimalIndicator = '.';
    $thousandSeparator = '';
    $retuenNumber = number_format($number, $NumOfDecimals, $decimalIndicator, $thousandSeparator);
    return $retuenNumber;
}

?>