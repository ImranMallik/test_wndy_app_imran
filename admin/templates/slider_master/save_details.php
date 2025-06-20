<?php
include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
    $activity_details = "Your Session Was Destroy In Manage User Details";
} else {

    if ($entry_permission == 'Yes') {

        // GET FILE DATA
        $slider_img_fl = $_FILES['slider_img_fl'];

        $sendData = json_decode($_POST['sendData'], true);

        $slider_id = mysqli_real_escape_string($con, $sendData['slider_id']);
        $heading = mysqli_real_escape_string($con, $sendData['heading']);
        $sub_text = mysqli_real_escape_string($con, $sendData['sub_text']);
        $button_text = mysqli_real_escape_string($con, $sendData['button_text']);
        $link = mysqli_real_escape_string($con, $sendData['link']);
        $active = mysqli_real_escape_string($con, $sendData['active']);
        $order_num = mysqli_real_escape_string($con, $sendData['order_num']);
        $slider_img = mysqli_real_escape_string($con, $sendData['slider_img']);

        $allowedImgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'tiff', 'tif'];

        $execute = 1;

        // Check file extension
        if ($execute == 1 && $slider_img_fl) {
            $target_file = basename($slider_img_fl["name"]);
            $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if (!in_array($FileType, $allowedImgExt)) {
                $status = "slider_img error";
                $execute = 0;
                $status_text = "File Type is Not Acceptable. Only jpg, jpeg, png, gif, webp, tiff, tif Accepted";
            }
        }

        // Check file size
        if ($execute == 1 && $slider_img_fl) {
            $fileSize = $slider_img_fl["size"];
            $getMaxFileSizeDataget = mysqli_query($con, "SELECT home_slider_max_kb_size FROM system_info WHERE 1 ");
            $getMaxFileSizeData = mysqli_fetch_row($getMaxFileSizeDataget);
            $getMaxFileSizeKb = $getMaxFileSizeData[0];
            $getMaxFileSizeByets = $getMaxFileSizeKb * 1024;

            if ($fileSize > $getMaxFileSizeByets) {
                $status = "slider_img error";
                $execute = 0;
                $status_text = "File size exceeded. Please keep under " . $getMaxFileSizeKb . " kb";
            }
        }

        // If there's an error, stop further execution and return response
        if ($execute == 0) {
            $response[] = [
                'status' => $status,
                'status_text' => $status_text,
            ];
            echo json_encode($response, true);
            exit();
        }

        // Upload file 
        if ($execute == 1 && $slider_img_fl) {
            $target_dir = "../../../upload_content/upload_img/slider_img/";
            $target_file = basename($slider_img_fl["name"]);
            $image_name = $slider_img;
            $temp_file = $slider_img_fl["tmp_name"];
            move_uploaded_file($temp_file, $target_dir . $image_name);
        }

        if ($execute == 1) {
            // IF CODE BLANK THEN INSERT
            if ($slider_id == "") {       

                // INSERT IN TABLE
                mysqli_query($con, "INSERT INTO tbl_home_slider (
                        slider_id, 
                        heading,
                        sub_text,
                        button_text,
                        link,
                        active, 
                        slider_img, 
                        order_num,
                        entry_user_code) VALUES (
                            NULL,
                        '" . $heading . "',
                        '" . $sub_text . "',
                        '" . $button_text . "',
                        '" . $link . "',
                        '" . $active . "',
                        '" . $slider_img . "',
                        '" . $order_num . "',
                        '" . $session_user_code . "')");

                $status = "Save";
                $status_text = "New Home Slider Data Saved Successfully";
                $activity_details = "You Insert A Record In Slider Details";

            // IF DOES NOT BLANK THEN UPDATE
            } else {
                // UPDATE TABLE
                mysqli_query($con, "UPDATE tbl_home_slider SET
                        heading='" . $heading . "', 
                        sub_text='" . $sub_text . "',
                        button_text='" . $button_text . "',
                        link='" . $link . "', 
                        active='" . $active . "', 
                        order_num='" . $order_num . "', 
                        update_timestamp='" . $timestamp . "' 
                        WHERE 
                        slider_id='" . $slider_id . "' ");

                $dataget = mysqli_query($con, "SELECT slider_img FROM tbl_home_slider WHERE slider_id='" . $slider_id . "' ");
                $data = mysqli_fetch_row($dataget);
                $previous_slider_img = $data[0];

                if ($slider_img != "") {
                    mysqli_query($con, "UPDATE tbl_home_slider SET slider_img='" . $slider_img . "' WHERE slider_id='" . $slider_id . "'");
                    if ($previous_slider_img != "") {
                        unlink("../../../upload_content/upload_img/slider_img/".$previous_slider_img);
                    }
                }

                $status = "Save";
                $status_text = "Home Slider Data Updated Successfully";
                $activity_details = "You Update A Record In Slider Details";
            }
        }
    } else {
        $status = "NoPermission";
        $status_text = "You Don't Have Permission To Entry Any Data !!";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
if ($activity_details != "") {
    insertActivity($activity_details, $con, $session_user_code);
}
?>
