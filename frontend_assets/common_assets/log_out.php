<?php
include("../../templates/db/db.php");

session_unset();
session_destroy();

$password = mysqli_real_escape_string($con,$_COOKIE["FRCP"]);
$selector = mysqli_real_escape_string($con,$_COOKIE["FRCS"]);

$cookie_destroy_time = time() - 3600 ;

setcookie("FRCP", null, $cookie_destroy_time, '/');
setcookie("FRCS", null, $cookie_destroy_time, '/');

mysqli_query($con,"delete from login_token_auth where password='".$password."' and selector='".$selector."'  ");
?>