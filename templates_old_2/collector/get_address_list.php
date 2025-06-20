<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$address_line_1 = trim(mysqli_real_escape_string($con, $sendData['address_line_1']));

$filterQuery = "";

if($address_line_1!="All"){
    $filterQuery = " and address_line_1='".$address_line_1."' ";
}
?>

<option value="All">All Address</option>
<?php
if ($session_user_type == "Buyer" || $session_user_type == "Collector") {
    $address_dataget = mysqli_query($con, "SELECT DISTINCT(address_line_1) FROM tbl_address_master WHERE user_id='" . $session_user_code . "' ".$filterQuery." ORDER BY address_line_1 ASC ");
} else {
    $address_landmark_dataget = mysqli_query($con, "SELECT DISTINCT(address_line_1) FROM tbl_address_master WHERE 1 ".$filterQuery." order by address_line_1 ASC ");
}

while ($rw = mysqli_fetch_array($address_landmark_dataget)) {
?>
    <option value="<?php echo $rw['address_line_1'] ?>"><?php echo $rw['address_line_1'] ?></option>
<?php
}
?>