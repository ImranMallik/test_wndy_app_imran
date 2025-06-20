<?php
include("../db/db.php");

// Get selected address ID from POST (e.g., 1299)
$active_address_id = isset($_POST['selected_address_id']) ? (int)$_POST['selected_address_id'] : 0;

$address_dataget = mysqli_query($con, "SELECT address_id, address_name, contact_name, contact_ph_num, country, state, city, landmark, pincode, address_line_1 FROM tbl_address_master WHERE user_id='" . $session_user_code . "' ORDER BY address_id ASC");

$first = true;

if (mysqli_num_rows($address_dataget) > 0) {
    while ($rw = mysqli_fetch_array($address_dataget)) {
        $address_id = (int)$rw['address_id'];

        // Mark as active only if it matches selected address ID
        $selectedClass = ($address_id === $active_address_id) ? "default-selected" : "";
?>
        <div class="address-card p-3 <?php echo $selectedClass; ?>" data-address-id="<?php echo $address_id; ?>">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="address-type">
                        <?php echo htmlspecialchars($rw['address_name']); ?>
                        <?php if ($first): ?>
                            <span class="default-text" style="font-weight: bold; color: #b5753e;">(Default)</span>
                        <?php endif; ?>
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
        $first = false;
    }
} else {
    echo '<p class="text-muted">No saved addresses found.</p>';
}
?>
