<?php
include("module_function/whatsapp_notification.php");

$sendPhoneNumber = "916297616918";
$fetchUserName = "ZAG Tech Solutions";
$campaignName = "welcome_buyer_msg";
// Assuming the API expects an array for templateParams
$params = ["nadim"];
$media = [
    "url" => "https://tpecom.tpddt.shop/wndyapp-local/upload_content/upload_img/product_img/product_image_1_4-2-2025-1741097838345.jpg",
    "filename" => "sample_media"
];
echo sendWhatsappMessage();
