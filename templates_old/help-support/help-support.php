<div id="page-content" style="padding-left: 7px; padding-right: 7px;">
    <div class="container" style="max-width: 616px; background: #ffeee1; padding: 10px; border-radius: 10px;">
        <!-- Heading -->
        <p class="notification-text fw-bold mb-2">Help & Support</p>

        <?php
        $systemInfoDataget = mysqli_query($con, "select system_name, logo, email, ph_num from system_info");
        $systemInfoData = mysqli_fetch_assoc($systemInfoDataget);
        ?>

        <center>
            <img src="upload_content/upload_img/system_img/<?php echo $systemInfoData['logo']; ?>" style="height: 80px; max-width: 100%;" />
            <h3 style="margin-top: 10px;"><?php echo $systemInfoData['system_name']; ?></h3>
        </center>

        <h3 style="text-align: center; color: #3b3b3b; font-weight: 300;">Hi, we are ready to help you!</h3>

        <?php
        if ($systemInfoData['ph_num'] != "") {
        ?>
            <h3>
                <i class="fa fa-phone"></i> :
                <a href="tel:<?php echo $systemInfoData['ph_num'] ?>"><?php echo $systemInfoData['ph_num'] ?></a>
            </h3>
        <?php
        }
        if ($systemInfoData['email'] != "") {
        ?>
            <h3>
                <i class="fa fa-envelope"></i> :
                <a href="mailto:<?php echo $systemInfoData['email'] ?>"><?php echo $systemInfoData['email'] ?></a>
            </h3>
        <?php
        }
        ?>

    </div>
</div>