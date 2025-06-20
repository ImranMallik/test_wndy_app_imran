<?php
include("module_function/sms_gateway_api.php");

$sendPhNum = "9073846331";
$sendMssg = "Hi, You have received an offer against the item(s) you posted for Sale on WNDY. Please log into the app to check, negotiate and finalise the deal - ZAG Tech Solutions";
echo sendSms();
