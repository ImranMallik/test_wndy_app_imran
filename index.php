<?php
include("templates/db/router.php");
include("templates/db/db.php");
include("./module_function/user_credit_details.php");
include("./module_function/custom_number_format.php");
$current_page = $_SERVER['REQUEST_URI'] ?? "";
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$isIOS = preg_match('/iPhone|iPad|iPod/i', $userAgent);
// et UTM parameters from the URL
$utm_parameters = $_SERVER['QUERY_STRING'];
// $main_url = "https://wndy.app/user-login?utm_source=QR_Website&utm_medium=Website&utm_campaign=QR_Code&utm_id=Website_QR";
$is_qr_scan = strpos($utm_parameters, "utm_source=QR_Website") !== false;


$referral_code = null;

if (isset($_GET['url'])) {
    $url_parts = explode('/', $_GET['url']);

    // Check if it's a user-login link with a referral code
    if (isset($url_parts[0]) && $url_parts[0] === 'user-login' && isset($url_parts[1])) {
        $referral_code = $url_parts[1];
    }
}


// Clean up unnecessary parameters
parse_str($utm_parameters, $query_params);
unset($query_params['url']); // Remove 'url=user-login' if present

// ebuild UTM query string without unnecessary parameters
$cleaned_utm_parameters = http_build_query($query_params);

// onstruct the full login URL with UTM parameters
$full_login_url = $baseUrl . "/user-login" . (!empty($cleaned_utm_parameters) ? "?" . $cleaned_utm_parameters : "");


if ($login == "No") {
    if ($pg_nm == "") {
        $pg_nm = 'welcome';
    } else {
        if (
            $pg_nm != "about-us" &&
            $pg_nm != "user-login" &&
            $pg_nm != "welcome" &&
            $pg_nm != "contact" &&
            $pg_nm != "terms-conditions" &&
            $pg_nm != "privacy-policy" &&
            $pg_nm != "shipping-returns-refund-policy" &&
            $pg_nm != "about-terms-privacy-shipping-returns-refund-policy"
        ) {
            header('location: ' . $full_login_url);
            exit;
        }
    }
} else {
    if ($pg_nm == "") {
        if ($session_user_type == "Collector") {
            $pg_nm = "assigned_product_list";
        } else {
            $pg_nm = "dashboard";
        }
    } else {
        if ($pg_nm == "user-login") {
            if ($session_user_type == "Seller") {
                header('location: ' . $baseUrl . '/dashboard');
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

$version = '9.0.3';
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
    <meta name="theme-color" content="#b17b4f">
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">



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
    <link href="frontend_assets/assets/global/css/plugins.min.css?v=<?php echo $version; ?>" rel="stylesheet"
        type="text/css" />
    <link href="frontend_assets/assets/global/plugins/bootstrap-sweetalert/sweetalert.css?v=<?php echo $version; ?>"
        rel="stylesheet" type="text/css" />
    <link href="frontend_assets/assets/global/plugins/bootstrap-toastr/toastr.min.css?v=<?php echo $version; ?>"
        rel="stylesheet" type="text/css" />
    <link href="frontend_assets/assets/global/plugins/font-awesome/css/font-awesome.min.css?v=<?php echo $version; ?>"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="frontend_assets/common_assets/style.css?v=<?php echo $version; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
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
    <style>
        .btn-primary {
            background-color: #b5753e !important;
        }

        #loadMore {
            padding-bottom: 100px !important;
        }
    </style>


</head>

<body class="template-index index-demo1" style="overflow-x: hidden;">

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2Z8VXZ5" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!--======================Background overlay===========---->
    <div class="background_overlay">
        <img class="preloader_img"
            src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif?v=<?php echo $version; ?>" />
    </div>
    <!--====================== Background overlay of Numeric preloader for file uploading ===========---->
    <div class="background_overlay_preloader">
        <div class="preloader_inner_text">Wait For File Uploading...</div>
        <div class="preloader_inner"><span class="preloader_inner_number">0</span>%</div>
    </div>





    <!--Page Wrapper-->
    <div class="page-wrapper">
        <!--Header-->
        <?php if ($login == 'Yes' && strpos($current_page, "/my-account") === false && strpos($current_page, "/notification") === false && strpos($current_page, "/product-details") === false && strpos($current_page, "/manage_demand_post") === false) { ?>
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
                                    <div onclick="toggleSidebar()"><i class="bi bi-list font-size" style="font-size:30px"></i>
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
                        <div
                            class="col-10 col-sm-9 col-md-9 col-lg-4 align-self-center icons-col d-flex justify-content-end align-items-center">
                            <!-- Post or Collector Button -->
                            <?php if ($login == "Yes") { ?>
                                <?php if ($session_user_type == "Seller") { ?>

                                    <!-- Create Post -->

                                    <button style="background-color: #fff; color:#000; padding: 4px 8px;" class="btn"
                                        data-bs-toggle="modal" data-bs-target="#languageExchangeModal">
                                        <span>A | अ</span>
                                    </button>


                                <?php } elseif ($session_user_type == "Buyer") { ?>
                                    <!-- Add Collector -->
                                    <div class="header-collector iconset" title="Add Collector">
                                        <a class="add-collector" href="<?php echo $baseUrl ?>/add-collector">
                                            <img src="./frontend_assets/img-icon/add-collector.png" height="28px;" width="28px;"
                                                style="margin-left: 4px;">
                                        </a>
                                    </div>
                                    <!-- Credit Balance -->
                                    <button class="credit-button">
                                        <a href="<?php echo $baseUrl ?>/wallet">
                                            <img class="credit" src="./frontend_assets/img-icon/wallet-2.png" height="21px"
                                                width="21px">
                                            <span
                                                class="credit"><?php echo customNumberFormat(getCreditBalance($session_user_code)); ?></span>
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
                                        <img src="./frontend_assets/img-icon/notification-alert.gif"
                                            style="height: 32px; width: auto; max-width: 100%;" />
                                        <span class="notification-count"></span>
                                    <?php
                                    } else {
                                    ?>
                                        <img src="./frontend_assets/img-icon/notification.png"
                                            style="height: 32px; width: auto; max-width: 100%;" />
                                    <?php
                                    }
                                    ?>
                                </a>
                            </div>
                            <!-- Notification Service End -->

                            <!-- Mobile Menu Toggle -->

                        </div>

                        <!--End Right Icon-->
                    </div>
                </div>
            </header>
        <?php } ?>
        <!--End Header-->
        <!--Mobile Menu-->
        <div class="mobile-sidebar" id="mobileSidebar">
            <!-- Close Button -->
            <div class="d-flex justify-content-end p-3">
                <button onclick="toggleSidebar()" class="btn-close" aria-label="Close"></button>
            </div>


            <div class="px-4 pb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?php echo $baseUrl ?>/my-account">
                        <div class="position-relative">
                            <img src="upload_content/upload_img/user_img/<?php echo isset($profile_img['user_img']) && $profile_img['user_img'] != "" ? $profile_img['user_img'] : 'default.png'; ?>"
                                alt="<?php echo htmlspecialchars($session_name); ?>" class="rounded-circle profile-img">
                            <span class="seller-badge"><?php echo htmlspecialchars($session_user_type); ?></span>
                        </div>
                    </a>
                    <div>
                        <h2 class="fs-6 fw-semibold mb-0"><?php echo $session_name ?></h2>
                        <p class="text-muted small mb-0"><?php echo $session_ph_num ?></< /p>
                    </div>
                </div>
            </div>
            <?php if ($login == "Yes") { ?>
                <?php if ($session_user_type == "Seller") { ?>

                    <!-- Create Post -->
                    <div class="px-4">
                        <a href="<?php echo $baseUrl . "/seller-post"; ?>" class="action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Create Post
                        </a>

                        <a href="<?php echo $baseUrl . "/help-support"; ?>"" class=" action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 18v-6a9 9 0 0 1 18 0v6" />
                                <path
                                    d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z" />
                            </svg>
                            Help & Support
                        </a>
                    </div>

                <?php } elseif ($session_user_type == "Buyer") { ?>
                    <div class="px-4">
                        <a href="<?php echo $baseUrl . "/my-account"; ?>" class="action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            My Profile
                        </a>
                        <a href="<?php echo $baseUrl . "/help-support"; ?>"" class=" action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 18v-6a9 9 0 0 1 18 0v6" />
                                <path
                                    d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z" />
                            </svg>
                            Help & Support
                        </a>
                        <a href="<?php echo $baseUrl . "/direct_transfer"; ?>" class="action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4v6h6M20 20v-6h-6" />
                                <path d="M4 14a8 8 0 0 1 16-4" />
                            </svg>
                            Direct Transfer
                        </a>
                        <a href="<?php echo $baseUrl . "/create_post"; ?>" class="action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                            Create Post
                        </a>
                        <a href="<?php echo $baseUrl . "/manage_demand_post"; ?>" class="action-link">
                            <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3h18v18H3V3z" />
                                <path d="M8 6h8M8 10h8M8 14h6" />
                            </svg>
                            Demand Post
                        </a>


                    </div>
                <?php } ?>
            <?php } ?>


            <!-- Useful Links -->
            <div class="px-4 mt-4">
                <h3 class="fs-5 fw-semibold mb-3">Useful Links</h3>
                <div class="d-flex flex-column gap-3">
                    <a href="<?php echo $baseUrl . "/about-us"; ?>" class="useful-link">About Us</a>
                    <a href="<?php echo $baseUrl . "/terms-conditions"; ?>" class="useful-link">Terms & Conditions</a>
                    <a href="<?php echo $baseUrl . "/privacy-policy"; ?>" class="useful-link">Privacy Policy</a>
                    <a href="<?php echo $baseUrl . "/shipping-returns-refund-policy"; ?>" class="useful-link">Shipping,
                        Returns, and Refund Policy</a>
                </div>
            </div>
            <!-- Sign Out Button -->
            <div class="px-4" style="margin-top:80px;">
                <button onclick="log_out()" class="btn btn-sign-out w-100">Sign Out</button>
            </div>
            <!-- Social Media Icons -->
            <div class="px-4 social-icons" style="margin-top:90px;">
                <?php
                $dataget = mysqli_query($con, "select facebook, instagram, youtube from tbl_social_link_details where 1 ");
                $data = mysqli_fetch_row($dataget);
                $facebook = $data[0];
                $instagram = $data[1];
                $youtube = $data[2];
                ?>
                <?php
                if ($facebook != "") {
                ?>
                    <a href="<?php echo $facebook; ?>" class="social-icon">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                <?php
                }

                if ($instagram != "") {
                ?>
                    <a href="=" <?php echo $instagram; ?>" class="social-icon">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                        </svg>
                    </a>
                <?php
                }

                if ($youtube != "") {
                ?>
                    <a href="<?php echo $youtube; ?>" class="social-icon">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                <?php
                }
                ?>
            </div>
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

        <!-- <button class="btn language-switch-btn" data-bs-toggle="modal" data-bs-target="#languageExchangeModal" style="padding: 6px !important;">
            <img style="width: 35px;" src="frontend_assets/img-icon/language-exchange.png" />
        </button> -->

        <!-- New Address Modal -->
        <div clas="closeGoogleLang" onclick="closeGoogleLang();">
            <div class="modal fade" id="languageExchangeModal" tabindex="-1" aria-labelledby="addNewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="addNewModalLabel" style="color:#b5753e !important;">Switch Language</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="google_translate_element"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- footer -->
    <?php

    if (

        $login == 'Yes' &&
        strpos($current_page, "/seller-post") === false &&
        strpos($current_page, "/demand_post") === false &&
        strpos($current_page, "/demand_post_new") === false

    ) {
    ?>

        <div class="nav-container-footer">
            <div class="container">
                <div class="row justify-content-around align-items-center">
                    <div class="col-2 text-center">
                        <a href="<?php echo $baseUrl . "/dashboard"; ?>"
                            class="nav-item  <?php echo $pg_nm == "dashboard" ? "active" : ""; ?>">
                            <i class="bi bi-house"></i>
                            <span style="font-size: 11px !important;">Home</span>
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <a href="<?php echo $baseUrl . "/product_list"; ?>"
                            class="nav-item <?php echo $pg_nm == "product_list" ? "active" : ""; ?>"
                            onclick="setFilterAndRedirect(event, 'all')">
                            <i class="bi bi-cart3"></i>
                            <span style="font-size: 11px !important;">My Items</span>
                        </a>
                    </div>


                    <!-- ✅ Show this only if the user is NOT a Buyer -->
                    <?php if ($session_user_type != "Buyer") { ?>
                        <div class="col-2 text-center">
                            <a href="<?php echo $baseUrl . "/seller-post"; ?>" class="add-button">
                                <i class="bi bi-plus"></i>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if ($session_user_type == "Buyer" && strpos($current_page, "/manage_demand_post") !== false) { ?>
                        <div class="col-2 text-center">
                            <a href="<?php echo $baseUrl . "/demand_post_new"; ?>" class="add-button">
                                <i class="bi bi-plus"></i>
                            </a>
                        </div>
                    <?php } ?>

                    <div class="col-2 text-center">
                        <a href="<?php echo $baseUrl . "/address-book"; ?>"
                            class="nav-item <?php echo $pg_nm == "address-book" ? "active" : ""; ?>">
                            <i class="bi bi-geo-alt"></i>
                            <span style="font-size: 11px !important;">Addresses</span>
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <a href="<?php echo $baseUrl . "/my-account"; ?>"
                            class="nav-item  <?php echo $pg_nm == "my-account" ? "active" : ""; ?>">
                            <i class="bi bi-person"></i>
                            <span style="font-size: 11px !important;">My Profile</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    <?php
    }
    ?>


    <!-- End footer -->

    <script src="frontend_assets/assets/global/plugins/jquery.min.js?v=<?php echo $version; ?>"
        type="text/javascript"></script>
    <script src="frontend_assets/assets/global/plugins/bootstrap/js/bootstrap.min.js?v=<?php echo $version; ?>"
        type="text/javascript"></script>

    <!-- Plugins JS -->
    <script src="assets/js/plugins.js?v=<?php echo $version; ?>"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js?v=<?php echo $version; ?>"></script>

    <script src="frontend_assets/assets/global/plugins/bootstrap-toastr/toastr.min.js?v=<?php echo $version; ?>"
        type="text/javascript"></script>
    <script src="frontend_assets/assets/global/plugins/bootstrap-sweetalert/sweetalert.js?v=<?php echo $version; ?>"
        type="text/javascript">
    </script>

    <script src="frontend_assets/common_assets/main_controller.js?v=<?php echo $version; ?>"
        type="text/javascript"></script>
    <script src="pwa-js/main.js?v=<?php echo $version; ?>" type="text/javascript"></script>

    <!-- Google translate pages  -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'hi,ml,pa,tcy,mr,ta,te,kn,gu,bn,gom,ks,or,as,en,ur',
                autoDisplay: false
            }, 'google_translate_element');
        }


        const languages = [{
                code: "hi",
                name: "हिंदी"
            },
            {
                code: "en",
                name: "English"
            },
            {
                code: "kn",
                name: "ಕನ್ನಡ"
            },
            {
                code: "ta",
                name: "தமிழ்"
            },
            {
                code: "ml",
                name: "മലയാളം"
            },
            {
                code: "pa",
                name: "ਪੰਜਾਬੀ"
            },
            {
                code: "mr",
                name: "मराठी"
            },
            {
                code: "te",
                name: "తెలుగు"
            },
            {
                code: "gu",
                name: "ગુજરાતી"
            },
            {
                code: "bn",
                name: "বাংলা"
            },
            {
                code: "ur",
                name: "اردو"
            }
        ];


        function generateLanguageOptions() {
            let container = document.querySelector(".language-options");
            container.innerHTML = "";

            let savedLanguage = localStorage.getItem("selectedLanguage") || "en";

            languages.forEach(lang => {
                let label = document.createElement("label");
                label.className = "language-option";
                label.innerHTML = `
                    <input type="radio" name="language" value="${lang.code}" class="radio-input" ${savedLanguage === lang.code ? "checked" : ""}>
                    <span class="language-label">${lang.name}</span>
                `;
                container.appendChild(label);
            });

            // Attach event listeners to the newly created radio buttons
            document.querySelectorAll('input[name="language"]').forEach(radio => {
                radio.addEventListener("change", onLanguageChange);
            });
        }

        function changeLanguage(lang) {
            var selectField = document.querySelector(".goog-te-combo");
            if (selectField) {
                selectField.value = lang;
                selectField.dispatchEvent(new Event("change"));
            }
        }

        function onLanguageChange(event) {
            var selectedLanguage = event.target.value;
            localStorage.setItem("selectedLanguage", selectedLanguage);
            changeLanguage(selectedLanguage);
        }

        window.onload = function() {
            generateLanguageOptions();
            let savedLanguage = localStorage.getItem("selectedLanguage");
            if (savedLanguage) {
                changeLanguage(savedLanguage);
            }
        };
    </script>

    <script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Google translate pages  -->

    <!-- google modal close start-->
    <script>
        function closeGoogleLang() {
            $('#closeGoogleLang').modal('hide');
        }
    </script>
    <script>
        function setFilterAndRedirect(event, filter) {
            event.preventDefault();
            localStorage.setItem("selectedFilter", filter);
            window.location.href = "<?php echo $baseUrl . '/product_list'; ?>";
        }
    </script>

    <script>
        const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
        if (isIOS) {
            document.querySelector('.header-install-bar').style.display = 'none';
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