<?php
include("../db/db.php");

if ($login == "No") {
    $status = "SessionDestroy";
    $status_text = "";
} else {
    $sendData = json_decode($_POST['sendData'], true);

    $rating_seller_id = mysqli_real_escape_string($con, $sendData['rating_seller_id']);
    $rating_view_id = mysqli_real_escape_string($con, $sendData['rating_view_id']);
    $rating = mysqli_real_escape_string($con, $sendData['rating']);
    $review = mysqli_real_escape_string($con, $sendData['review']);

    $execute = 1;

    // Check rating already given or not
    if ($execute == 1) {
        $dataget = mysqli_query($con, "SELECT * FROM tbl_ratings WHERE give_user_id='" . $session_user_code . "' AND to_user_id='" . $rating_seller_id . "' AND rating_from='Buyer' AND view_id='" . $rating_view_id . "'");
        $data = mysqli_fetch_row($dataget);
        if ($data) {
            $status = "error";
            $status_text = "You Have Already Rated The Seller";
            $execute = 0;
        }
    }

    if ($execute == 1) {

        // INSERT IN TABLE
        mysqli_query($con, "INSERT INTO tbl_ratings (
            give_user_id, 
            to_user_id,
            view_id,
            rating,
            review,
            rating_from,
            entry_user_code) VALUES (
            '" . $session_user_code . "',
            '" . $rating_seller_id . "',
            '" . $rating_view_id . "',
            '" . $rating . "',
            '" . $review . "',
            'Buyer',
            '" . $session_user_code . "')");

        $status = "success";
        $status_text = "Ratings Submitted Successfully";
    }
}

$response[] = [
    'status' => $status,
    'status_text' => $status_text,
];
echo json_encode($response, true);
