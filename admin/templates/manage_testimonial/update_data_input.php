<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$testimonial_id = mysqli_real_escape_string($con,$sendData['testimonial_id']);

$dataget = mysqli_query($con,"SELECT 
		tbl_testimonial.testimonial_id,
		tbl_testimonial.name,
		tbl_testimonial.designation,
		tbl_testimonial.msg,
		tbl_testimonial.img,
		tbl_testimonial.rating
		FROM tbl_testimonial
		WHERE tbl_testimonial.testimonial_id='" . $testimonial_id . "'");

$data = mysqli_fetch_row($dataget);

$img = $data[4]=="" ? "no_image.png" : $data[4];

$response = [
	'testimonial_id' => $data[0],
	'name' => $data[1],
	'designation' => $data[2],
	'msg' => $data[3],
	'img' => $img,
	'rating' => $data[5],
];
echo json_encode($response,true);
?>