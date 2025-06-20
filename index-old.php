<?php
include("templates/db/router.php");
include("templates/db/db.php");
include("./module_function/user_credit_details.php");
include("./module_function/custom_number_format.php");

if ($login == "No") {
    if ($pg_nm == "") {
        $pg_nm = 'user-login';
    } else {
        if (
            $pg_nm != "about-us" &&
            $pg_nm != "user-login" &&
            $pg_nm != "contact" &&
            $pg_nm != "terms-conditions" &&
            $pg_nm != "privacy-policy" &&
            $pg_nm != "shipping-returns-refund-policy" &&
            $pg_nm != "about-terms-privacy-shipping-returns-refund-policy"
        ) {
            header('location: ' . $baseUrl . '/user-login');
        }
    }
} else {
    if ($pg_nm == "") {
        if ($session_user_type == "Collector") {
            $pg_nm = "assigned_product_list";
        } else {
            $pg_nm = "product_list";
        }
    } else {
        if ($pg_nm == "user-login") {
            if ($session_user_type == "Seller") {
                header('location: ' . $baseUrl . '/product_list');
            }
            if ($session_user_type == "Buyer") {
                header('location: ' . $baseUrl . '/product_list');
            }
            if ($session_user_type == "Collector") {
                header('location: ' . $baseUrl . '/assigned_product_list');
            }
        }
    }
}


$system_info_dataget = mysqli_query($con, "select system_name, logo, favicon, email, address, ph_num from system_info ");
$system_info_data = mysqli_fetch_row($system_info_dataget);

$system_name = $system_info_data[0];
$system_logo = $system_info_data[1];
$system_favicon = $system_info_data[2];
$system_email = $system_info_data[3];
$system_address = $system_info_data[4];
$system_ph_num = $system_info_data[5];

$seo_dataget = mysqli_query($con, "select description, keywords, author from tbl_seo_details where 1 ");
$seo_data = mysqli_fetch_row($seo_dataget);
$description = $seo_data[0];
$keywords = $seo_data[1];
$author = $seo_data[2];

$version = '8.0.3';
?>
<!DOCTYPE html>
<html lang="en-US">

<head>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-W2Z8VXZ5');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '3327626044036759');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=3327626044036759&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <!-- New Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TZFX533H19"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-TZFX533H19');
    </script>

    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="manifest" href="manifest.webmanifest.json?v=<?php echo $version; ?>" />
    <meta name="theme-color" content="#2f415d">
    <link rel="apple-touch-icon" href="pwa-images/icon-192x192.png">
    </link>

    <?php
    if (file_exists("templates/" . $pg_nm . "/page_details/meta_details.php")) {
        include("templates/" . $pg_nm . "/page_details/meta_details.php");
    } else {

    ?>
        <meta name="description" content="<?php echo $description; ?>" />
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <meta name="author" content="<?php echo $author; ?>" />

    <?php
    }
    ?>

    <?php
    if (file_exists("templates/" . $pg_nm . "/page_details/title.php")) {
        include("templates/" . $pg_nm . "/page_details/title.php");
    } else {
    ?>
        <title>
            <?php echo $system_name; ?>
        </title>
    <?php
    }
    ?>
    <base href="<?php echo $baseHref; ?>" />
    <link rel="shortcut icon" href="./upload_content/upload_img/system_img/<?php echo $system_favicon; ?>" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!-- ========================================== -->
    <!-- WEBSITE CSS START -->
    <!-- ========================================== -->
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css?v=<?php echo $version; ?>">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style-min.css?v=<?php echo $version; ?>">
    <link rel="stylesheet" href="assets/css/responsive.css?v=<?php echo $version; ?>">
    <!-- ========================================== -->
    <!-- WEBSITE CSS END -->
    <!-- ========================================== -->

    <link href="frontend_assets/assets/animate.min.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />

    <!-- <link href="frontend_assets/assets/global/css/components.min.css?v=<?php echo $version; ?>" rel="stylesheet" id="style_components" type="text/css" /> -->
    <link href="frontend_assets/assets/global/css/plugins.min.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />
    <link href="frontend_assets/assets/global/plugins/bootstrap-sweetalert/sweetalert.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />
    <link href="frontend_assets/assets/global/plugins/bootstrap-toastr/toastr.min.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />
    <link href="frontend_assets/assets/global/plugins/font-awesome/css/font-awesome.min.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="frontend_assets/common_assets/style.css?v=<?php echo $version; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="pwa-js/index.js?v=<?php echo $version; ?>"></script>

    <?php
    if (file_exists("templates/" . $pg_nm . "/page_details/css.php")) {
        include("templates/" . $pg_nm . "/page_details/css.php");
    }
    ?>
    <script>
        const baseUrl = "<?php echo $baseUrl; ?>";
        const login = "<?php echo $login; ?>";
    </script>

</head>

<body class="template-index index-demo1" style="overflow-x: hidden;">

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2Z8VXZ5" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!--======================Background overlay===========---->
    <div class="background_overlay">
        <img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif?v=<?php echo $version; ?>" />
    </div>
    <!--====================== Background overlay of Numeric preloader for file uploading ===========---->
    <div class="background_overlay_preloader">
        <div class="preloader_inner_text">Wait For File Uploading...</div>
        <div class="preloader_inner"><span class="preloader_inner_number">0</span>%</div>
    </div>

    <div class="header-install-bar" style="display: none;">
        Try Our App -> <button class="app-install-btn">Install</button>
    </div>

    <!--Page Wrapper-->
    <div class="page-wrapper">
        <!--Header-->
        <?php if ($login == 'Yes') { ?>
            <header class="header d-flex align-items-center header-1 header-fixed" style="background-color: f7fbfa;">
                <div class="container">
                    <div class="row">
                        <!--Logo-->
                        <!-- <div class="logo col-2 col-sm-1 col-md-3 col-lg-2 align-self-center"> -->
                        <div class="col-2 account-parent iconset align-self-center">
                            <?php
                            if ($login == "Yes") {
                                $profile_img_dataget = mysqli_query($con, "SELECT name, user_img FROM tbl_user_master WHERE user_id = '" . $session_user_code . "' AND active = 'Yes' ");
                                $profile_img = mysqli_fetch_assoc($profile_img_dataget);

                                // Split the name to get the first name
                                $full_name = $profile_img['name'];
                                $first_name = explode(' ', trim($full_name))[0];
                            ?>
                                <div class="account-link" title="Account">
                                    <button class="account-button">
                                        <div class="account-details">
                                            <img class="sign_img" src="upload_content/upload_img/user_img/<?php echo $profile_img['user_img'] ? $profile_img['user_img'] : 'default.png'; ?>" height="25px" width="25px">
                                            <span>Hi, <?php echo $first_name; ?></span>
                                        </div>
                                    </button>
                                </div>

                                <div id="accountBox">
                                    <div class="customer-links">
                                        <ul class="m-0">
                                            <?php
                                            if ($login == "Yes") {
                                            ?>
                                                <li><a href="<?php echo $baseUrl; ?>/my-account">
                                                        <i class="icon anm anm-user-cil"></i> My Account
                                                    </a>
                                                </li>
                                                <li>
                                                    <a onclick="log_out()"><i class="icon anm anm-sign-out-al"></i> Sign Out</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo $baseUrl . "/about-us" ?>" style="white-space: nowrap;">
                                                        <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                                                        About Us
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo $baseUrl . "/terms-conditions" ?>" style="white-space: nowrap;">
                                                        <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                                                        Terms & Con...
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo $baseUrl . "/privacy-policy" ?>" style="white-space: nowrap;">
                                                        <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                                                        Privacy Policy
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo $baseUrl . "/shipping-returns-refund-policy" ?>" style="white-space: nowrap;">
                                                        <i class="fa fa-dot-circle-o" style="font-size: 9px; margin-right: 3px;"></i>
                                                        Shipping, Ret...
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>

                        <!-- </div> -->
                        <!--End Logo-->
                        <!--Menu-->
                        <div class="col-1 col-sm-1 col-md-1 col-lg-6 align-self-center d-menu-col">
                            <nav class="navigation" id="AccessibleNav">
                                <ul id="siteNav" class="site-nav medium center">
                                    <?php
                                    if ($login == "Yes") {
                                    ?>
                                        <li class="lvl1 parent megamenu d-none">
                                            <a href="<?php echo $baseUrl; ?>/product_list">
                                                Products
                                                <!-- <i class="icon anm anm-angle-down-l"></i> -->
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li class="lvl1 parent dropdown d-none">
                                        <a href="<?php echo $baseUrl; ?>/contact">Contact Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!--End Menu-->
                        <!--Right Icon-->
                        <div class="col-10 col-sm-9 col-md-9 col-lg-4 align-self-center icons-col d-flex justify-content-end align-items-center">
                            <!-- Post or Collector Button -->
                            <?php if ($login == "Yes") { ?>
                                <?php if ($session_user_type == "Seller") { ?>

                                    <!-- Create Post -->

                                    <button style="background-color: #4eaf52; padding: 4px 8px;" class="btn">
                                        <a href="<?php echo $baseUrl ?>/seller-post" style="color: #FFF;">
                                            <!-- <i class="fa fa-plus"></i> -->
                                            Create Post
                                        </a>
                                    </button>

                                <?php } elseif ($session_user_type == "Buyer") { ?>
                                    <!-- Add Collector -->
                                    <div class="header-collector iconset" title="Add Collector">
                                        <a class="add-collector" href="<?php echo $baseUrl ?>/add-collector">
                                            <img src="./frontend_assets/img-icon/add-collector.png" height="28px;" width="28px;" style="margin-left: 4px;">
                                        </a>
                                    </div>
                                    <!-- Credit Balance -->
                                    <button class="credit-button">
                                        <a href="<?php echo $baseUrl ?>/credit_addon">
                                            <img class="credit" src="./frontend_assets/img-icon/wallet-2.png" height="21px" width="21px">
                                            <span class="credit"><?php echo customNumberFormat(getCreditBalance($session_user_code)); ?></span>
                                        </a>
                                    </button>
                                <?php } ?>
                            <?php } ?>
                            <!-- Notification Service Start -->
                            <div class="notification me-2 position-relative" title="noti">
                                <a class="notification" href="<?php echo $baseUrl ?>/notification">
                                    <?php
                                    // get user unseen notification
                                    $dataget = mysqli_query($con, "select count(*) from tbl_user_notification where to_user_id='" . $session_user_code . "' and seen='No' ");
                                    $data = mysqli_fetch_row($dataget);
                                    if ($data[0] > 0) {
                                    ?>
                                        <img src="./frontend_assets/img-icon/notification-alert.gif" style="height: 32px; width: auto; max-width: 100%;" />
                                        <span class="notification-count"></span>
                                    <?php
                                    } else {
                                    ?>
                                        <img src="./frontend_assets/img-icon/notification.png" style="height: 32px; width: auto; max-width: 100%;" />
                                    <?php
                                    }
                                    ?>
                                </a>
                            </div>
                            <!-- Notification Service End -->

                            <!-- Mobile Menu Toggle -->
                            <button type="button" class="iconset pe-0 menu-icon js-mobile-nav-toggle mobile-nav--open d-lg-none" title="Menu">
                                <img src="./frontend_assets/img-icon/hamburger.webp" height="28px;" width="28px;">
                            </button>
                        </div>

                        <!--End Right Icon-->
                    </div>
                </div>
            </header>
        <?php } ?>
        <!--End Header-->
        <!--Mobile Menu-->
        <div class="mobile-nav-wrapper" role="navigation" style="overflow: auto;">
            <div class="closemobileMenu"><i class="icon anm anm-times-l"></i></div>
            <?php
            if ($login == "Yes") {
            ?>
                <div class="profile-top text-center mb-0 px-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="profile-image mb-3">
                                <img style="width: 70px; height: 70px; border: 2px solid #eeeeee; margin-top: 10px;" class="rounded-circle blur-up lazyload" data-src="upload_content/upload_img/user_img/<?php echo isset($profile_img['user_img']) && $profile_img['user_img'] != "" ? $profile_img['user_img'] : 'default.png'; ?>" src="upload_content/upload_img/user_img/<?php echo isset($profile_img['user_img']) && $profile_img['user_img'] != "" ? $profile_img['user_img'] : 'default.png'; ?>" alt="<?php echo $session_name; ?>" />
                            </div>

                        </div>
                        <div class="col">
                            <div class="profile-detail text-left">
                                <p class="user-type"><?php echo $session_user_type ?></p>
                                <h2 class="mb-1"><?php echo $session_name ?></h2>
                                <p class="mb-1"><?php echo $session_ph_num ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <ul id="MobileNav" class="mobile-nav">
                <div class="closemobileMenu"> Menu List</div>
                <?php
                if ($login == "Yes") {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo $baseUrl; ?>/dashboard" class="nav-link <?php echo $pg_nm == "dashboard" ? "active" : ""; ?>"><i class="anm anm-dashboard"></i>&nbsp;&nbsp;
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $baseUrl; ?>/my-account" class="nav-link <?php echo $pg_nm == "my-account" ? "active" : ""; ?>"><i class="fas fa-user-alt"></i>&nbsp;&nbsp;
                            My Profile
                        </a>
                    </li>
                    <?php
                    if ($session_user_type == "Seller") {
                        // seller menu
                    ?>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl; ?>/address-book" class="nav-link <?php echo $pg_nm == "address-book" ? "active" : ""; ?>"><i class="anm anm-map-marker-ar"></i>&nbsp;&nbsp;
                                Address Book
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/seller-post"; ?>" class="nav-link <?php echo $pg_nm == "seller-post" ? "active" : ""; ?>">
                                <img src="./frontend_assets/img-icon/post.png" height="20px;" width="20px;" style="margin-left:-2px;">&nbsp;
                                Create Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/product_list"; ?>" class="nav-link <?php echo $pg_nm == "product_list" ? "active" : ""; ?>">
                                <i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;
                                My Items
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if ($session_user_type == "Buyer") {
                        // buyer menu
                    ?>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl; ?>/address-book" class="nav-link <?php echo $pg_nm == "address-book" ? "active" : ""; ?>"><i class="anm anm-map-marker-ar"></i>&nbsp;&nbsp;
                                Address Book
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/product_list"; ?>" class="nav-link <?php echo $pg_nm == "product_list" ? "active" : ""; ?>">
                                <i class="fas fa-luggage-cart"></i>&nbsp;
                                Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/deal-items"; ?>" class="nav-link <?php echo $pg_nm == "deal-items" ? "active" : ""; ?>">
                                <i class="anm anm-unlock-ar"></i>&nbsp;&nbsp;
                                Deal Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/collector"; ?>" class="nav-link <?php echo $pg_nm == "collector" ? "active" : ""; ?>">
                                <img src="./frontend_assets/img-icon/collector.png" height="18px;" width="18px;">&nbsp;
                                Add Collector
                            </a>
                        </li>
                        <li class="lvl1 parent dropdown">
                            <a><img src="./frontend_assets/img-icon/tracebility.png" height="18px;" width="18px"> &nbsp;Onward Material Sales <i class="icon anm anm-angle-down-l"></i></a>
                            <ul class="lvl-2">
                                <li><a href="<?php echo $baseUrl . "/direct_transfer"; ?>" class="site-nav"><img src="./frontend_assets/img-icon/direct_transfer.png" height="18px;" width="18px"> &nbsp;Direct Transfer</a></li>
                                <li><a href="<?php echo $baseUrl . "/demand_post"; ?>" class="site-nav"><img src="./frontend_assets/img-icon/Create-post.png" height="18px;" width="18px"> &nbsp;Demand Post</a></li>

                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if ($session_user_type == "Collector") {
                        // Collector menu
                    ?>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/assigned_product_list"; ?>" class="nav-link <?php echo $pg_nm == "assigned_product_list" ? "active" : ""; ?>">
                                <img src="frontend_assets/img-icon/assign-logo.png" height="22" width="22" />
                                Assigned Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl . "/deal-items"; ?>" class="nav-link <?php echo $pg_nm == "deal-items" ? "active" : ""; ?>">
                                <i class="anm anm-lock"></i>&nbsp;&nbsp;
                                Deal Items
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a href="<?php echo $baseUrl . "/help-support"; ?>" class="nav-link <?php echo $pg_nm == "help-support" ? "active" : ""; ?>">
                            <i class="fa fa-support"></i>&nbsp;&nbsp;
                            Help & Support
                        </a>
                    </li>
                    <li class="nav-item">
                        <a onclick="log_out()" class="nav-link"><i class="anm anm-sign-out-al"></i>&nbsp;&nbsp;
                            Sign Out
                        </a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo $baseUrl . "/user-login"; ?>" class="nav-link <?php echo $pg_nm == "user-login" ? "active" : ""; ?>">
                            <i class="anm anm-sign-in-al"></i>&nbsp;&nbsp;
                            Sign-In
                        </a>
                    </li>

                <?php
                }
                ?>

                <li class="mobile-menu-bottom">

                    <div class="mobile-follow">
                        <h5 class="title" style="border-top: none; margin-top: 0px;">Our Social Media:</h5>
                        <?php
                        $dataget = mysqli_query($con, "select facebook, twitter, pinterest, linkedin, instagram, youtube from tbl_social_link_details where 1 ");
                        $data = mysqli_fetch_row($dataget);
                        $facebook = $data[0];
                        $twitter = $data[1];
                        $pinterest = $data[2];
                        $linkedin = $data[3];
                        $instagram = $data[4];
                        $youtube = $data[5];
                        ?>
                        <ul class="list-inline social-icons d-inline-flex mt-1">
                            <?php
                            if ($facebook != "") {
                            ?>
                                <li class="list-inline-item"><a href="<?php echo $facebook; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook" target="_blank"><i class="icon anm anm-facebook-f"></i></a></li>
                            <?php
                            }
                            if ($twitter != "") {
                            ?>
                                <li class="list-inline-item"><a href="<?php echo $twitter; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter" target="_blank"><i class="icon anm anm-twitter"></i></a></li>
                            <?php
                            }
                            if ($pinterest != "") {
                            ?>
                                <li class="list-inline-item"><a href="<?php echo $pinterest; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Pinterest" target="_blank"><i class="icon anm anm-pinterest-p"></i></a></li>
                            <?php
                            }
                            if ($linkedin != "") {
                            ?>
                                <li class="list-inline-item"><a href="<?php echo $linkedin; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Linkedin" target="_blank"><i class="icon anm anm-linkedin-in"></i></a></li>
                            <?php
                            }
                            if ($instagram != "") {
                            ?>
                                <li class="list-inline-item"><a href="<?php echo $instagram; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram" target="_blank"><i class="icon anm anm-instagram"></i></a></li>
                            <?php
                            }
                            if ($youtube != "") {
                            ?>
                                <li class="list-inline-item"><a href="<?php echo $youtube; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Youtube" target="_blank"><i class="icon anm anm-youtube"></i></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="mobile-links">
                        <ul class="list-inline d-inline-flex flex-column w-100" style="margin-top: 0px;">
                            <li class="title h5" style="border-top-width: 0px;">Useful Links</li>
                            <li>
                                <a href="<?php echo $baseUrl . "/about-us"; ?>">• About Us</a>
                            </li>
                            <li>
                                <a href="<?php echo $baseUrl . "/terms-conditions"; ?>">• Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="<?php echo $baseUrl . "/privacy-policy"; ?>">• Privacy Policy</a>
                            </li>
                            <li>
                                <a href="<?php echo $baseUrl . "/shipping-returns-refund-policy"; ?>">• Shipping, Returns, and Refund Policy </a>
                            </li>
                        </ul>
                    </div>

                </li>
            </ul>
        </div>
        <!--End Mobile Menu-->

        <?php
        if (file_exists("templates/" . $pg_nm . "/" . $pg_nm . ".php")) {
            include("templates/" . $pg_nm . "/" . $pg_nm . ".php");
        }
        ?>

        <!--Sticky Menubar Mobile-->
        <!--End Sticky Menubar Mobile-->

        <!--Scoll Top-->
        <!-- <div id="site-scroll"><i class="icon anm anm-arw-up"></i></div> -->
        <!--End Scoll Top-->

        <button class="btn language-switch-btn" data-bs-toggle="modal" data-bs-target="#languageExchangeModal" style="padding: 6px !important;">
            <img style="width: 35px;" src="frontend_assets/img-icon/language-exchange.png" />
        </button>

        <!-- New Address Modal -->
        <div clas="closeGoogleLang" onclick="closeGoogleLang();">
            <div class="modal fade" id="languageExchangeModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="addNewModalLabel">Switch Language</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="google_translate_element"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End New Address Modal -->

    </div>
    <!--End Page Wrapper-->

    <script src="frontend_assets/assets/global/plugins/jquery.min.js?v=<?php echo $version; ?>" type="text/javascript"></script>
    <script src="frontend_assets/assets/global/plugins/bootstrap/js/bootstrap.min.js?v=<?php echo $version; ?>" type="text/javascript"></script>

    <!-- Plugins JS -->
    <script src="assets/js/plugins.js?v=<?php echo $version; ?>"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js?v=<?php echo $version; ?>"></script>

    <script src="frontend_assets/assets/global/plugins/bootstrap-toastr/toastr.min.js?v=<?php echo $version; ?>" type="text/javascript"></script>
    <script src="frontend_assets/assets/global/plugins/bootstrap-sweetalert/sweetalert.js?v=<?php echo $version; ?>" type="text/javascript">
    </script>

    <script src="frontend_assets/common_assets/main_controller.js?v=<?php echo $version; ?>" type="text/javascript"></script>
    <script src="pwa-js/main.js?v=<?php echo $version; ?>" type="text/javascript"></script>

    <!-- Google translate pages  -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'en',
                    includedLanguages: 'hi,ml,pa,tcy,mr,ta,te,kn,gu,bn,gom,ks,or,as,en,ur',
                },
                'google_translate_element'
            );
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Google translate pages  -->

    <!-- google modal close start-->
    <script>
        function closeGoogleLang() {
            $('#closeGoogleLang').modal('hide');
        }
    </script>
    <!-- google modal close end-->

    <?php
    if (file_exists("templates/" . $pg_nm . "/page_details/js.php")) {
        include("templates/" . $pg_nm . "/page_details/js.php");
    }
    ?>
</body>

</html>