<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

# local credential
$servername = "168.138.112.124";
$username = "db_waste_management";
$password = "drop_waste@2025wndy";
$database = "db_waste_management";

// $servername = "168.138.112.124";
// $username = "db_waste_management";
// $password = "drop_waste@2025wndy";
// $database = "db_waste_management";
// $servername = "168.138.112.124";
// $username = "db_waste_management";
// $password = "drop_waste@2025wndy";
// $database = "db_waste_management";
// $servername = "localhost";
// $username = "root";
// $password = "";
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

session_start();

$login = "No";

$session_user_code = null;

$check_user_dataget = mysqli_query($con, "select * from user_master where user_code='" . $_SESSION['ad_user_code'] . "' and active='Yes' ");
$check_user_data_rw_num = mysqli_num_rows($check_user_dataget);

if ($_SESSION['ad_user_code'] == null || $check_user_data_rw_num == 0) {

	if (!empty($_COOKIE["ADRP"]) && !empty($_COOKIE["ADRS"])) {

		//======================= CHECK USER TOKEN EXIST OR NOT =======//
		$password = mysqli_real_escape_string($con, $_COOKIE["ADRP"]);
		$selector = mysqli_real_escape_string($con, $_COOKIE["ADRS"]);

		$user_token_dataget = mysqli_query($con, "select user_code,user_type,expiry_date from login_token_auth where password='" . $password . "' and selector='" . $selector . "' ");
		$user_token_data = mysqli_fetch_row($user_token_dataget);

		$user_code = $user_token_data[0];
		$user_type = $user_token_data[1];
		$expiry_date = $user_token_data[2];

		if ($user_token_data) {

			$current_timestamp = date("Y-m-d H:i:s", time());
			if ($expiry_date <= $current_timestamp) {

				$cookie_destroy_time = time() - 3600;

				setcookie("ADRP", null, $cookie_destroy_time, '/');
				setcookie("ADRS", null, $cookie_destroy_time, '/');
				$login = "No";
			} else {
				$login = "Yes";
				$_SESSION['ad_user_code'] = $user_code;
			}
		} else {
			$login = "No";
		}
	} else {
		$login = "No";
	}
} else {
	$login = "Yes";
}

if ($login == "Yes") {
	$session_user_code = $_SESSION['ad_user_code'];
}
$query = "select user_master.name, 
				user_master.email, 
				user_master.user_mode_code, 
				user_mode.user_mode, 
				user_master.profile_img, 
				user_master.entry_permission, 
				user_master.view_permission, 
				user_master.edit_permission, 
				user_master.delete_permissioin
				from user_master 
				LEFT JOIN user_mode ON user_mode.user_mode_code = user_master.user_mode_code 
				where user_master.user_code='" . $session_user_code . "' and user_master.active='Yes' ";

$user_dataget = mysqli_query($con, $query);
$user_data = mysqli_fetch_row($user_dataget);
$user_data_rw_num = mysqli_num_rows($user_dataget);

$session_name = $user_data[0];
$session_email = $user_data[1];
$session_user_mode_code = $user_data[2];
$session_user_mode = $user_data[3];
$session_profile_img = $user_data[4];
$entry_permission = $user_data[5];
$view_permission = $user_data[6];
$edit_permission = $user_data[7];
$delete_permissioin = $user_data[8];

$allowedImgExt = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'webp', 'tiff', 'tif');

$inputAllowedImage = '.jpg,.JPG,.jpeg,.JPEG,.png,.PNG,.gif,.webp,.tiff,.tif';

$allowedfileExt = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'webp', 'tiff', 'tif', 'pdf', 'doc');

$inputAllowedDocument = '.pdf,.PDF,.doc,.DOC,.docx,.DOCX,.xls,.XLS,.xlsx,.XLSX,.ppt,.PPT,.pptx,.PPTX,.txt,.TXT,.rtf,.RTF';
$allowedDocumentExt = array('pdf', 'PDF', 'doc', 'DOC', 'docx', 'DOCX', 'xls', 'XLS', 'xlsx', 'XLSX', 'ppt', 'PPT', 'pptx', 'PPTX', 'txt', 'TXT', 'rtf', 'RTF');


$inputAllowedVideo = '.mp4,.MP4,.mkv,.MKV,.avi,.AVI,.mov,.MOV,.wmv,.WMV,.flv,.FLV,.webm,.WEBM';
$allowedVideoExt = array('mp4', 'MP4', 'mkv', 'MKV', 'avi', 'AVI', 'mov', 'MOV', 'wmv', 'WMV', 'flv', 'FLV', 'webm', 'WEBM');
