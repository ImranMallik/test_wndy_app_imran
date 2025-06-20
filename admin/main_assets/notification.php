<?php
include("../templates/db/db.php");

$totalPendingNotification = 0;
?>

    <?php
    // PENDING WITHDRAW REQUEST
    $withdraw_request_dataget = mysqli_query($con,"select count(*) from withdrawal_request where status='Pending' ");
    $withdraw_request_data = mysqli_fetch_row($withdraw_request_dataget);
    $total_request = $withdraw_request_data[0];

    if ($total_request > 0) {
        $totalPendingNotification += $total_request;
    ?>
    <!--begin::Item-->
    <a href="./withdrawal" class="navi-item">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="fas fa-money-check-alt text-success icon-md"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">Withdraw Request</div>
                <div class="text-muted"><?php echo $total_request; ?> Pending</div>
            </div>
        </div>
    </a>
    <!--end::Item-->
    <?php
    }
    ?>
    
    <input type="hidden" value="<?php echo $totalPendingNotification ?>" id="totalPendingNotification" />

    <?php
    if($totalPendingNotification==0){
    ?>
     <!--begin::Nav if no new notification-->
        <div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!<br />
            No new notifications.
        </div>
    <!--end::Nav-->
    <?php
    }
    ?>