<?php
include("../db/db.php");

// Get user_id from URL or session
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $session_user_code;

if (!$user_id) {
    die("Error: User ID is missing.");
}

// Fetch transactions for the user
$query = "SELECT in_credit, out_credit, purchase_amount, trans_date, trans_type FROM tbl_credit_trans WHERE user_id = ? ORDER BY trans_date DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Store transactions in an array
$transactions = [];

while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}
?>


<div class="header d-flex align-items-center">
    <!-- <a href="<?php echo $baseUrl; ?>/wallet/" class="back-button me-3">
            <i class="bi bi-arrow-left"></i>
        </a> -->
    <h1 class="h5 mb-0">Wallet Transactions</h1>
</div>

<div class="container py-3">
    <?php if (!empty($transactions)) : ?>
        <?php foreach ($transactions as $txn) : ?>
            <div class="transaction-item" style="background-color: #f8f1eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <?php if ($txn['in_credit'] > 0) : ?>
                            <div class="amount positive">+<?= number_format($txn['in_credit'], 2) ?></div>
                        <?php else : ?>
                            <div class="amount negative">-<?= number_format($txn['out_credit'], 2) ?></div>
                        <?php endif; ?>

                        <div class="description"><?= htmlspecialchars($txn['trans_type']) ?></div>
                        <?php if ($txn['purchase_amount'] > 0) : ?>
                            <div class="description">Purchased Amount: <?= number_format($txn['purchase_amount'], 2) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="date">Date: <?= date("d-m-Y", strtotime($txn['trans_date'])) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No transactions found.</p>
    <?php endif; ?>
</div>