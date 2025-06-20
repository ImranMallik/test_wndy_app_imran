<?php
include("./module_function/date_time_format.php");

// Database Connection Check
if (!isset($con)) {
    die("Database connection not found.");
}

// User session check
if (!isset($session_user_code)) {
    die("User session not found.");
}

$today_date = date("Y-m-d");

// Fetch the total number of today's notifications
$notification_count_query = mysqli_query($con, "SELECT COUNT(*) as count FROM tbl_user_notification WHERE to_user_id='$session_user_code' AND DATE(notification_timestamp) = '$today_date'");
$notification_count_result = mysqli_fetch_assoc($notification_count_query);
$notification_count = $notification_count_result['count'] ?? 0;

// Fetch unread notification count
$unread_query = mysqli_query($con, "SELECT COUNT(*) as unread_count FROM tbl_user_notification WHERE to_user_id='$session_user_code' AND seen='No'");
$unread_result = mysqli_fetch_assoc($unread_query);
$unread_notifications = $unread_result['unread_count'] ?? 0;

// Fetch notifications
$dataget = mysqli_query($con, "SELECT title, details, notification_url, seen, notification_timestamp FROM tbl_user_notification WHERE to_user_id='$session_user_code' ORDER BY notification_timestamp DESC");

// Store fetched notifications in an array to prevent mysqli_num_rows() issue
$notifications = [];
while ($row = mysqli_fetch_assoc($dataget)) {
    $notifications[] = $row;
}

// Mark all notifications as "seen"
mysqli_query($con, "UPDATE tbl_user_notification SET seen='Yes' WHERE to_user_id='$session_user_code' AND seen='No'");
?>

<div class="container">
    <!-- Header Icons -->
    <div class="notification-header">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link p-0" onclick="goBack()">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
            </button>
        </div>

    </div>

    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0">Notification</h1>
        </div>

        <p class="mb-4">
            You have
            <span class="notification-count">
                <?php echo $notification_count . " Notification" . ($notification_count > 1 ? 's' : ''); ?>
            </span> today
        </p>
        <div style="margin-bottom: 50px;">
            <?php
            if (!empty($notifications)) {
                foreach ($notifications as $rw) {
                    ?>
                    <a <?php echo !empty($rw['notification_url']) ? 'href="' . $rw['notification_url'] . '"' : ""; ?>>
                        <div class="notification-card">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="mb-0"><?php echo htmlspecialchars($rw['title']); ?></h6>
                                <span
                                    class="notification-time"><?php echo dateTimeFormat($rw['notification_timestamp']); ?></span>
                            </div>
                            <p class="notification-text"><?php echo htmlspecialchars($rw['details']); ?></p>
                        </div>
                    </a>
                    <?php
                }
            } else {
                ?>
                <h2 style="text-align: center; color: #3b3b3b; font-weight: 300;">
                    No new notifications at the moment. You’re all caught up.
                </h2>
                <?php
            }
            ?>
        </div>
    </div>
</div>