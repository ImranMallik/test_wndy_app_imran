<title>
    <?php
    if ($session_user_type == "Seller") {
        echo $session_user_type . " Items List | " . $system_name;
    } else {
        echo " Items List | " . $system_name;
    }
    ?>
</title>