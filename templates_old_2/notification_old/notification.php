<?php
include("./module_function/date_time_format.php");
?>
<div id="page-content" style="padding-left: 7px; padding-right: 7px;">
    <div class="container" style="max-width: 616px; background: #ffeee1; padding: 10px; border-radius: 10px;">
        <!-- Notification Heading -->
        <p class="notification-text fw-bold mb-2">Notifications</p>

        <!-- Notification Blocks -->
        <?php
        // get notification
        $dataget = mysqli_query($con, "select title, details, notification_url, seen, notification_timestamp from tbl_user_notification where to_user_id='" . $session_user_code . "' order by notification_timestamp DESC ");
        while ($rw = mysqli_fetch_array($dataget)) {
        ?>
            <a <?php echo $rw['notification_url'] != "" ? 'href="' . $rw['notification_url'] . '"' : ""; ?>
                <div class="notification-item address-select-box <?php echo $rw['seen'] == "No" ? "active" : ""; ?> ">
                    <div class="address-box bg-block p-2 rounded">
                        <!-- User Name and Date -->
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="m-0 fw-bold"><?php echo $rw['title']; ?></h6>
                            <span class="notification-date text-muted"><?php echo dateTimeFormat($rw['notification_timestamp']); ?></span>
                        </div>
                        <!-- Notification Details -->
                        <div class="notification-details text-muted">
                            <p class="m-0"><?php echo $rw['details']; ?></p>
                        </div>
                    </div>
                </div>
            </a>
        <?php
        }

        mysqli_query($con, "update tbl_user_notification set seen='Yes' where to_user_id='" . $session_user_code . "' and seen='No' ");

        if (mysqli_num_rows($dataget) == 0) {
        ?>
            <h2 style="text-align: center; color: #3b3b3b; font-weight: 300;">No new notifications at the moment. You’re all caught up</h2>
        <?php
        }
        ?>

    </div>
</div>