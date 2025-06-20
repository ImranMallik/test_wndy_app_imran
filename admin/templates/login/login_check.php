<?php
include("../db/db.php");
include("../db/activity.php");

$sendData = json_decode($_POST['sendData'],true);

$user_id = mysqli_real_escape_string($con,$sendData['user_id']);
$password = mysqli_real_escape_string($con,$sendData['password']);
$remember = mysqli_real_escape_string($con,$sendData['remember']);

$encodePassword = base64_encode($password);

$query = "select user_code from user_master where user_id='".$user_id."' and user_password='".$encodePassword."' and active='Yes' ";
$check_user_dataget = mysqli_query($con,$query);
$check_user_data = mysqli_fetch_row($check_user_dataget);

if ($check_user_data) {
    session_start();
    $user_code = $check_user_data[0];
    $user_type = "Admin User";
    $_SESSION['ad_user_code']= $user_code;
    $login = "Yes";

    $activity_details = "LogIn";
    insertActivity($activity_details,$con,$user_code);

    if ($remember=="Yes") {
        
        function getToken($length)
        {
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet .= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i = 0; $i < $length; $i ++) {
                $token .= $codeAlphabet[cryptoRandSecure(0, $max)];
            }
            return $token;
        }
        function cryptoRandSecure($min, $max)
        {
            $range = $max - $min;
            if ($range < 1) {
                return $min; // not so random...
            }
            $log = ceil(log($range, 2));
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            } while ($rnd >= $range);
            return $min + $rnd;
        }
        
        
        $user_code = $user_code;
        $user_type = $user_type;
        $password = getToken(16);
        $password .= uniqid().time();
        $selector = getToken(32);
        $selector .= uniqid().time();
        $cookie_expiration_time = time() + 31556926 ;  // for 1 year
        
        //=============================== DELETE SAME EXITING TOKEN TOKEN AUTH ====================//
        mysqli_query($con,"delete from login_token_auth where user_code='".$user_code."' and password='".$password."' and selector='".$selector."' ");
        
        setcookie("ADRP", $password, $cookie_expiration_time,'/');
        
        setcookie("ADRS", $selector, $cookie_expiration_time,'/');
        
        $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
        
        //=============================== INSERT INTO LOGIN TOKEN AUTH ====================//
        mysqli_query($con,"insert into login_token_auth (id, user_code, user_type, password, selector, expiry_date) values(null,'".$user_code."','".$user_type."','".$password."','".$selector."','".$expiry_date."')");
    }
}
else {
    $login = "No";
}

$response[] = [
        'login' => $login
    ];
echo json_encode($response,true);
?>