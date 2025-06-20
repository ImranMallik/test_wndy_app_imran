<?php
include("../db/db.php");
?>

<option value="">Choose Category</option>
<?php
$address_dataget = mysqli_query($con, "SELECT 
                                            category_id, 
                                            category_name 
                                        FROM 
                                            tbl_category_master 
                                        WHERE 
                                            active = 'YES'");
while ($rw = mysqli_fetch_array($address_dataget)) {
?>
    <option value="<?php echo $rw['category_id'] ?>"><?php echo $rw['category_name'] ?></option>
<?php
}
?>