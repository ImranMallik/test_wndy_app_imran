<?php
    include ("../db/db.php");

    $sendData = json_decode($_POST['sendData'], true);

    $ph_num = mysqli_real_escape_string($con, $sendData['ph_num']);
    $otp = mysqli_real_escape_string($con, $sendData['otp']);
    $remember = 'Yes';


    $execute = 1;

    if ($execute == 1) 
    {
    
       $dataget = mysqli_query($con, "select * from tbl_otp_details where ph_num='" . $ph_num . "' and otp='" . $otp . "' ");
	    $data = mysqli_fetch_row($dataget);
        
        if (!$data) {
            $status = "otp Not Match";
            $status_text = "Wrong otp !!";
            $execute = 0;
        }
    }


    if ($execute == 1) {
        // Check if user ID matches with a user
        $userDataget = mysqli_query($con, "select * from tbl_user_master where ph_num='" . $ph_num . "' ");
	    $userData = mysqli_fetch_assoc($userDataget);

            if($userData)
                {
                    $status = "Match";
                    $status_text = "Logged In Successfully.";
                    $usercode = $userData["user_id"];
                    $usertype = $userData["user_type"];
                    $_SESSION['fr_user_code'] = $user_code;
                    $login = "Yes";
                }
        }

    if ($execute == 1) {

        // after sign in delete otp from otp_table
	    mysqli_query($con,"delete from tbl_otp_details where ph_num='".$ph_num."' ");

        if ($remember == "Yes") {

            function getToken($length)
            {
                $token = "";
                $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
                $codeAlphabet .= "0123456789";
                $max = strlen($codeAlphabet) - 1;
                for ($i = 0; $i < $length; $i++) {
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

            $user_code = $usercode;
            $user_type = $usertype;
            $password = getToken(16);
            $password .= uniqid() . time();
            $selector = getToken(32);
            $selector .= uniqid() . time();
            $cookie_expiration_time = time() + 31556926;  // for 1 year

            //=============================== DELETE PREVIOUS TOKEN AUTH FOR LOGIN USER ====================//
            mysqli_query($con, "DELETE FROM login_token_auth WHERE login_token_auth.user_code='" . $user_code . "' ");

            setcookie("FRCP", $password, $cookie_expiration_time, '/');
            setcookie("FRCS", $selector, $cookie_expiration_time, '/');

            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

            //=============================== INSERT INTO LOGIN TOKEN AUTH ====================//
            mysqli_query($con, "INSERT INTO login_token_auth (id, user_code, user_type, password, selector, expiry_date) VALUES (null,'" . $user_code . "','" . $user_type . "','" . $password . "','" . $selector . "','" . $expiry_date . "')");
        }
    } else {
        $login = "No";
    }

    $response = [
        'status' => $status,
        'status_text' => $status_text,
        'user_type' => $user_type
    ];
    echo json_encode($response, true);
?>