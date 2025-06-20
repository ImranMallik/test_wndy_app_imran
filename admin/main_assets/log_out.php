<?php
include("../templates/db/db.php");
include("../templates/db/activity.php");
$activity_details = "LogOut";
insertActivity($activity_details,$con,$session_user_code);

session_unset();
session_destroy();

$cookie_destroy_time = time() - 3600 ;
setcookie("ADRP", null, $cookie_destroy_time, '/');
setcookie("ADRS", null, $cookie_destroy_time, '/');
?>