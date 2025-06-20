<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$pincode = trim(mysqli_real_escape_string($con, $sendData['pincode']));

$filterQuery = "";

if($pincode!="All"){
    $filterQuery = " and pincode='".$pincode."' ";
}

?>

<option value="All">All Landmark</option>
<?php
if ($session_user_type == "Seller") {
    $address_landmark_dataget = mysqli_query($con, "select distinct(landmark) from tbl_address_master where user_id='" . $session_user_code . "' ".$filterQuery." order by landmark ASC ");
} else {
    $address_landmark_dataget = mysqli_query($con, "select distinct(landmark) from tbl_address_master where 1 ".$filterQuery." order by landmark ASC ");
}

while ($rw = mysqli_fetch_array($address_landmark_dataget)) {
?>
    <option value="<?php echo $rw['landmark'] ?>"><?php echo $rw['landmark'] ?></option>
<?php
}
?>