<?php
## local foldername
$folderName = '/test_wndy_app_imran';

## server foldername
// $folderName = '';
// $request = $_SERVER['REQUEST_URI'];
//Add new For utm (Imran Mallik)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = substr_replace($request, '', 0, strlen($folderName));

$arr = explode('/', $router);
$pg_nm = "";
$fl_nm = "";

if (isset($arr[1])) {
    $pg_nm = $arr[1];
    $fl_nm = $arr[1];
}

$baseHref = "";
for ($i = 2; $i < count($arr); $i++) {
    $baseHref .= "../";
}

$baseUrl = "";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $baseUrl = "https://";
} else {
    $baseUrl = "http://";
}
$baseUrl .= $_SERVER['HTTP_HOST'] . $folderName;