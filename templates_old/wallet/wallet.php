<?php
include("../db/db.php");

if (!isset($session_user_code)) {
    die("Error: User ID is missing.");
}

$total_balance = 0.00;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT SUM(in_credit) AS total FROM tbl_credit_trans WHERE user_id = ?";
$stmt = $con->prepare($query);
if (!$stmt) {
    die("Error in preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $session_user_code);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    $total_balance = 0.00;
} else {
    $row = $result->fetch_assoc();
    $total_balance = $row['total'] ?? 0.00;
}

if ($total_balance === NULL) {
    $total_balance = 0.00;
}

$formatted_balance = number_format($total_balance, 2);

$balance_color = ($total_balance == 0.00) ? 'red' : 'black';
?>


<div class="wallet-header">
    <a href="<?php echo $baseUrl; ?>/product_list/" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div class="wallet-balance">
        <div class="balance-title">Total Wallet Balance</div>
        <div class="balance-amount" id="walletBalance" style="color: <?= $balance_color; ?>;">
            Rs <?= $formatted_balance; ?>
        </div>
    </div>
</div>

    <div class="container mt-4">
        <h5>Add Credit</h5>
        <div class="input-group mb-3">
            <span class="input-group-text">Rs(₹)</span>
            <input type="text" id="creditAmount" class="form-control" placeholder="Enter amount">
        </div>

        <div class="recommended-amounts">
        <div class="amount-chip" onclick="setAmount(500)">500</div>
        <div class="amount-chip" onclick="setAmount(1000)">1000</div>
        <div class="amount-chip" onclick="setAmount(1500)">1500</div>
        </div>

        <button class="add-credit-btn" id="addCredit">Add Credit</button>

        <div class="transaction-history">
    <div>Wallet Transaction History</div>
    <a href="transaction-history" class="btn btn-primary">
        <i class="fas fa-chevron-right"></i> 
    </a>
</div>


    </div>
    <?php
      
    
    include("templates/footer/footer.php");

     ?>
