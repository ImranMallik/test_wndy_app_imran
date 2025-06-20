<?php
include("../db/db.php");

if (!isset($session_user_code)) {
    die("Error: User ID is missing.");
}

$total_balance = 0.00;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Query to calculate total incoming credits (in_credit) for the user
$buyer_total_in_credit = mysqli_query($con, "SELECT SUM(in_credit) AS total_in_credit FROM tbl_credit_trans WHERE user_id = '" . $session_user_code . "' ");
$buyer_total_in_credit_rw = mysqli_fetch_assoc($buyer_total_in_credit);

// Query to calculate total outgoing credits (out_credit) for the user
$buyer_total_out_credit = mysqli_query($con, "SELECT SUM(out_credit) AS total_out_credit FROM tbl_credit_trans WHERE user_id = '" . $session_user_code . "' ");
$buyer_total_out_credit_rw = mysqli_fetch_assoc($buyer_total_out_credit);

// Calculating the total credit balance: Total incoming credit - Total outgoing credit
$buyer_total_credit = $buyer_total_in_credit_rw['total_in_credit'] - $buyer_total_out_credit_rw['total_out_credit'];

// If the total credit is NULL, set it to 0
if ($buyer_total_credit === NULL) {
    $buyer_total_credit = 0.00;
}

$formatted_balance = number_format($buyer_total_credit, 2);

// print_r($formatted_balance);

// Determine the balance color based on the total balance
$balance_color = ($buyer_total_credit == 0.00) ? 'red' : 'black';
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


