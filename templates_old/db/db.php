<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// # test local credential
$servername = "168.138.112.124";
$username = "wndy_test_2804";
$password = "wndy_test_2804";
$database = "wndy_test_2804";

# localhost credential
// $servername = "localhost";
// $username = "wast_db";
// $password = "wast_db";
// $database = "wast_db";

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

mysqli_query($con, "SET time_zone = '+5:30' ");
mysqli_query($con, "SET CHARACTER SET utf8");
mysqli_query($con, "SET SESSION collation_connection ='utf8_general_ci'");

date_default_timezone_set("Asia/Kolkata");

$date = date("Y-m-d");
$time = date("H:i:s");
$day = date("l");
$month = date("F");
$year = date("Y");
$timestamp = date("Y-m-d H:i:s");


$allowedImgExt = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'webp', 'tiff', 'tif');
$allowedVideoExt = array('WEBM', 'MPG', 'MP2', 'MPEG', 'MPE', 'MPV', 'OGG', 'M4V', 'MP4', 'M4P', 'AVI', 'WMV', 'MOV', 'QT', 'FLV', 'SWF', 'AVCHD', 'webm', 'mpg', 'mp2', 'mpeg', 'mpe', 'mpv', 'ogg', 'm4v', 'mp4', 'm4p', 'avi', 'wmv', 'mov', 'qt', 'flv', 'swf', 'avchd');
$inputAllowedImage = '.jpg,.JPG,.jpeg,.JPEG,.png,.PNG,.gif,.webp,.tiff,.tif';

session_start();

$login = "No";

$session_user_code = null;

if (!empty($_COOKIE["FRCP"]) && !empty($_COOKIE["FRCS"])) {

  //======================= CHECK USER TOKEN EXIST OR NOT =======//
  $password = mysqli_real_escape_string($con, $_COOKIE["FRCP"]);
  $selector = mysqli_real_escape_string($con, $_COOKIE["FRCS"]);

  $user_token_dataget = mysqli_query($con, "select user_code, user_type, expiry_date from login_token_auth where password='" . $password . "' and selector='" . $selector . "' ");
  $user_token_data = mysqli_fetch_row($user_token_dataget);

  $user_code = $user_token_data[0];
  $user_type = $user_token_data[1];
  $expiry_date = $user_token_data[2];

  if ($user_token_data) {

    $current_timestamp = date("Y-m-d H:i:s", time());
    if ($expiry_date <= $current_timestamp) {

      $cookie_destroy_time = time() - 3600;

      setcookie("FRCP", null, $cookie_destroy_time, '/');
      setcookie("FRCS", null, $cookie_destroy_time, '/');
      $login = "No";
    } else {

      $check_user_dataget = mysqli_query($con, "SELECT * FROM tbl_user_master WHERE tbl_user_master.user_id='" . $user_code . "' and tbl_user_master.active='Yes' ");
      $check_user_data_rw_num = mysqli_num_rows($check_user_dataget);
      if ($check_user_data_rw_num != 0) {
        $login = "Yes";
        $_SESSION['fr_user_code'] = $user_code;
      }
    }
  } else {
    $login = "No";
  }
} else {
  $login = "No";
}


if ($login == "Yes") {
  $session_user_code = $_SESSION['fr_user_code'];
}

$query = "select
        tbl_user_master.name, 
        tbl_user_master.ph_num, 
        tbl_user_master.email_id, 
				tbl_user_master.user_img,
				tbl_user_master.user_type
				from tbl_user_master 
				where tbl_user_master.user_id='" . $session_user_code . "' and tbl_user_master.active='Yes' ";

$user_dataget = mysqli_query($con, $query);
$user_data = mysqli_fetch_row($user_dataget);

$session_name = $user_data[0];
$session_ph_num = $user_data[1];
$session_email_id = $user_data[2];
$session_user_img = $user_data[3] == "" ? "no_image.png" : $user_data[3];
$session_user_type = $user_data[4];
$session_buyer_type = $user_data[5];
