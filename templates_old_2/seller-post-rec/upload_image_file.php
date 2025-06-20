<?php
require_once "../db/db.php";

//  GET ALL POST DATA 
$postData = json_decode($_POST['sendData'], true);
$file_name = mysqli_real_escape_string($con, $postData['file_name']);
$type = mysqli_real_escape_string($con, $postData['type']);

//  GET FILE DATA 
$uploaded_file = $_FILES['uploaded_file'];

$target_dir = "../../upload_content/upload_img/product_img/";
//current upload selected file name
$target_file = basename($_FILES["uploaded_file"]["name"]);
		
//make a new file name like time+date+extention
$image_name = $file_name;
//uploaded file store into computer temp memory which store into varriable
$temp_file = $_FILES["uploaded_file"]["tmp_name"];
//copy uploaded file store into desire path or location
move_uploaded_file($temp_file, $target_dir.$image_name);

$status = "Success";
$message = $type." Uploaded Successfully";

$response = [
    'status' => $status,
    'message' => $message,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
