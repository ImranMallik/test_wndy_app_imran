<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$pincode = trim(mysqli_real_escape_string($con, $sendData['pincode']));
$landmark = trim(mysqli_real_escape_string($con, $sendData['landmark']));
$city = trim(mysqli_real_escape_string($con, $sendData['city']));

// Initialize filter query
$filterQuery = "";

// Add conditions to filter query if necessary
if ($pincode != "All") {
    $filterQuery .= " AND pincode='" . $pincode . "' ";
}
?>

<option value="All">All City</option>
<?php
// Fetch data based on the filter query
if ($session_user_type == "Seller") {
    $address_city_dataget = mysqli_query($con, "SELECT DISTINCT(city) FROM tbl_address_master WHERE user_id='" . $session_user_code . "' " . $filterQuery . " ORDER BY city ASC ");
} else {
    $address_city_dataget = mysqli_query($con, "SELECT DISTINCT(city) FROM tbl_address_master WHERE 1 " . $filterQuery . " ORDER BY city ASC ");
}

while ($rw = mysqli_fetch_array($address_city_dataget)) {
?>
    <option value="<?php echo $rw['city'] ?>"><?php echo $rw['city'] ?></option>
<?php
}
?>