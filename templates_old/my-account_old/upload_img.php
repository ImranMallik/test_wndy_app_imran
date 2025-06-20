<?php
require_once "../db/db.php";

//  GET ALL POST DATA 
$postData = json_decode($_POST['sendData'], true);
$file_name = mysqli_real_escape_string($con, $postData['file_name']);
$type = mysqli_real_escape_string($con, $postData['type']);

//  GET FILE DATA 
$uploaded_file = $_FILES['uploaded_file'];

$target_dir = "../../upload_content/upload_img/user_img/";
//current upload selected file name
$target_file = basename($_FILES["uploaded_file"]["name"]);
		
//current upload selected file extension like .jpg/.png/.tif/.bmp etc
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

$image_name = "";

if (in_array($FileType, $allowedImgExt)) {

    //make a new file name like time+date+extention
    $image_name = $file_name.".".$FileType;
    //uploaded file store into computer temp memory which store into varriable
    $temp_file = $_FILES["uploaded_file"]["tmp_name"];
    //copy uploaded file store into desire path or location
    move_uploaded_file($temp_file, $target_dir.$image_name);

    $status = "Success";
    $message = $type." Uploaded Successfully";
}
else{
    $status = "File Type Error";
    $message = "This File Type Not Acceptable";
}

$response = [
    'status' => $status,
    'message' => $message,
    'image_name' => $image_name,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
