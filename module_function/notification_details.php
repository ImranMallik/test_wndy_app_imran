<?php
function insertNotificationDetails()
{
    global $con;
    global $noti_title;
    global $noti_details;
    global $noti_url;
    global $noti_to_user_id;
    global $noti_from_user_id;
    global $session_user_code;

    $noti_title = mysqli_real_escape_string($con, $noti_title);
    $noti_details = mysqli_real_escape_string($con, $noti_details);
    $noti_url = mysqli_real_escape_string($con, $noti_url);

    //========================= INSERT IN tbl_credit_trans TABLE =======================
    mysqli_query($con, "INSERT INTO tbl_user_notification (
            title,
            details,
            notification_url,
            to_user_id,
            from_user_id,         
            entry_user_code
        ) VALUES ( 
            '" . $noti_title . "',
            '" . $noti_details . "',
            '" . $noti_url . "',
            '" . $noti_to_user_id . "',
            '" . $noti_from_user_id . "',                 
            '" . $session_user_code . "'
        )");
}
