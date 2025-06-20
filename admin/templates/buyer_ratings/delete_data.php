<?php
include("../db/db.php");
include("../db/activity.php");

$activity_details = "";

$sendData = json_decode($_POST['sendData'], true);
$rating_id = mysqli_real_escape_string($con, $sendData['rating_id']);

mysqli_query($con, "DELETE FROM tbl_ratings WHERE tbl_ratings.rating_id='" . $rating_id . "' ");

$activity_details = "You Delete A Record From Buyers Ratings";

if ($activity_details != "") {
	insertActivity($activity_details, $con, $session_user_code);
}
