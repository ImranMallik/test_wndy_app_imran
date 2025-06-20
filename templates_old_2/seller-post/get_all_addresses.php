<?php
include("../db/db.php");

$address_dataget = mysqli_query($con, "SELECT address_id, address_name, contact_name, contact_ph_num, country, state, city, landmark, pincode, address_line_1 FROM tbl_address_master WHERE user_id='" . $session_user_code . "' ORDER BY address_id ASC");

$first = true; // Variable to mark the first address

if (mysqli_num_rows($address_dataget) > 0) {
    while ($rw = mysqli_fetch_array($address_dataget)) {
        $selectedClass = $first ? "default-selected" : ""; 
?>
        <div class="address-card p-3 <?php echo $selectedClass; ?>" data-address-id="<?php echo $rw['address_id']; ?>">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="address-type">
                        <?php echo htmlspecialchars($rw['address_name']); ?>
                        <span class="default-text" style="<?php echo $first ? '' : 'display:none;'; ?> font-weight: bold; color: #b5753e;">(Default)</span>
                    </div>
                    <div class="address-text">
                        <b>Contact:</b> <?php echo htmlspecialchars($rw['contact_name']) . " (" . htmlspecialchars($rw['contact_ph_num']) . ")"; ?><br>
                        <b>Address:</b> <?php echo htmlspecialchars($rw['country'] . ", " . $rw['state'] . ", " . $rw['city'] . ", " . $rw['pincode']); ?><br>
                        <b>Landmark:</b> <?php echo htmlspecialchars($rw['landmark']); ?><br>
                        <b>Address Line:</b> <?php echo htmlspecialchars($rw['address_line_1']); ?>
                    </div>
                </div>
                <button style="border:none !important;" class="btn p-0 edit-address-btn" data-address-id="<?php echo $rw['address_id']; ?>">
                    <i class="bi bi-pencil edit-icon" style="font-size: 20px;
    background-color: #b5753e;
    padding: 3px 6px;
    border-radius: 5px;
    color: #fff;
    border: 1px solid #fff;"></i>
                </button>
            </div>
        </div>
<?php
        $first = false; // After first iteration, default is not set
    }
} else {
    echo '<p class="text-muted">No saved addresses found.</p>';
}
?>
