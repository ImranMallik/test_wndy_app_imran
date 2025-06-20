<?php
include("../db/db.php");

?>

<option value="">Choose Address</option>
<?php
$address_dataget = mysqli_query($con, "select address_id, address_name from tbl_address_master where user_id='" . $session_user_code . "' order by address_name ASC ");
while ($rw = mysqli_fetch_array($address_dataget)) {
?>
    <option value="<?php echo $rw['address_id'] ?>" ><?php echo $rw['address_name'] ?></option>
<?php
}
?>