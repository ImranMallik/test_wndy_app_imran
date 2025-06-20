<?php
include("../db/db.php");
include("../db/activity.php");
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);
$testimonial_id = mysqli_real_escape_string($con, $sendData['testimonial_id']);

$dataget = mysqli_query($con, "SELECT img FROM tbl_testimonial WHERE tbl_testimonial.testimonial_id='" . $testimonial_id . "' ");
$data = mysqli_fetch_row($dataget);
$previous_img = $data[0];

if ($previous_img != "") {
	unlink("../../../upload_content/upload_img/testimonial_img/" . $previous_img);
}

mysqli_query($con, "DELETE FROM tbl_testimonial where tbl_testimonial.testimonial_id='" . $testimonial_id . "' ");

$activity_details = "You Delete A Record From Manage Testimonials Details";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
