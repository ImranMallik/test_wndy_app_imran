<?php

include("../db/db.php");
include("../db/activity.php");
$activity_details = "";

if($login=="No"){
	$status = "SessionDestroy";
	$status_text = "";
	$activity_details = "Your Session Was Destroy In Manage Customer Wishlist Details";
}
else{
	
	if($entry_permission=='Yes'){
	

		$sendData = json_decode($_POST['sendData'],true);

		$wishlist_id = mysqli_real_escape_string($con,$sendData['wishlist_id']);
		$buyer_id = mysqli_real_escape_string($con,$sendData['buyer_id']);
		$product_id = mysqli_real_escape_string($con,$sendData['product_id']);
		
		//============================== IF CODE BLANK THEN INSERT ==================================
		if($wishlist_id==""){
			
			//========================= CHECK SAME DATA EXIST OR NOT =======================
			$dataget = mysqli_query($con,"SELECT * FROM tbl_buyer_wishlist WHERE buyer_id='".$buyer_id."' and product_id='".$product_id."' ");
			$data_num_row = mysqli_num_rows($dataget);
			
			if($data_num_row==0){
				// $whishlist_code = "CWLC_".uniqid().time();

				mysqli_query($con, "SET FOREIGN_KEY_CHECKS=0");

				//========================= INSERT IN TABLE =======================
				mysqli_query($con,"INSERT INTO tbl_buyer_wishlist (
					wishlist_id,
					buyer_id, 
					product_id,
					entry_user_code
					) values (null,
					'".$buyer_id."',
					'".$product_id."',
					'".$session_user_code."')");
				
				$status = "Save";
				$status_text = "New Whishlist Data Added Successfully";
				$activity_details = "You Insert A Record In Manage Buyer Wishlist Details";
			}
			else{
				$status = "Exist";
				$status_text = "Already Exist Same Buyer with Same Product !!";
			}
		}
		//============================== IF DOES NOT BLANK THEN UPDATE ==================================
		else{
			//========================= CHECK SAME DATA EXIST OR NOT =======================
			$dataget = mysqli_query($con,"SELECT * FROM tbl_buyer_wishlist WHERE wishlist_id<>'".$wishlist_id."' and buyer_id='".$buyer_id."' and product_id='".$product_id."' ");
			$data_num_row = mysqli_num_rows($dataget);

			if($data_num_row==0){				
				mysqli_query($con,"UPDATE tbl_buyer_wishlist 
						SET buyer_id='".$buyer_id."', 
						product_id='".$product_id."', 						
						entry_user_code='".$session_user_code."', 
						update_timestamp='".$timestamp."' 
						WHERE 
						wishlist_id='".$wishlist_id."' ");

				$status = "Save";
				$status_text = "Wishlist Data Updated Successfully";
				$activity_details = "You Update A Record In Manage Buyer Wishlist Details";
			}
			else{
				$status = "Exist";
				$status_text = "Already Exist Same Buyer and Product Data !!";
			}
		}
	}
	else{
		$status = "NoPermission";
		$status_text = "You Don't Have Permission To Entry Any Data !!";
	}
}

$response[] = [
	'status' => $status,
	'status_text' => $status_text,
];
echo json_encode($response,true);
if ($activity_details!="") {
	insertActivity($activity_details,$con,$session_user_code);
}

?>