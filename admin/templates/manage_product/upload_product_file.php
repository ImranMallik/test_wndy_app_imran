<?php
include("../db/db.php");

if ($login == "No") {
	echo "session destroy";
} else {
	if (isset($_FILES['uploaded_file'])) {

			$type = $_GET['type'];


		if($type=="Product Iamge 1")
		{
				$target_dir = "../../../upload_content/upload_img/product_img/";
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
		}	
	}
}
