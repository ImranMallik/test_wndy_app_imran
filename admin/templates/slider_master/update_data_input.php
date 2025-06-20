<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'], true);
$slider_id = mysqli_real_escape_string($con, $sendData['slider_id']);

$dataget = mysqli_query($con, "SELECT
		slider_id,
		heading,
		sub_text,
		active,
		link,
		order_num,
		slider_img,
		button_text
		FROM tbl_home_slider 
		WHERE slider_id = '" . $slider_id . "'");

$data = mysqli_fetch_row($dataget);

$slider_img = $data[6] == "" ? "no_image.png" : $data[6];

$response[] = [
	'slider_id' => $data[0],
	'heading' => $data[1],
	'sub_text' => $data[2],
	'active' => $data[3],
	'link' => $data[4],
	'order_num' => $data[5],
	'slider_img' => $slider_img,
	'button_text' => $data[7],
];
echo json_encode($response, true);
?>