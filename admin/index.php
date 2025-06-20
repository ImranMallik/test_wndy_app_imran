<?php
include("templates/db/db.php");
include("templates/db/router.php");

$system_info_dataget = mysqli_query($con, "select system_name, logo, favicon from system_info ");
$system_info_data = mysqli_fetch_row($system_info_dataget);

$system_name = $system_info_data[0];
$system_logo = $system_info_data[1] == "" ? "no_image.png" : $system_info_data[1];
$system_favicon = $system_info_data[2] == "" ? "no_image.png" : $system_info_data[2];

$version = '1.0.3';

if ($login == "No") {
?>
	<!DOCTYPE html>
	<html lang="en">
	<!--begin::Head-->

	<head>
		<meta charset="utf-8" />
		<title><?php echo $system_name; ?>-Login</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<base href="<?php echo $baseHref; ?>" />
		<link rel="shortcut icon" href="../upload_content/upload_img/system_img/<?php echo $system_favicon; ?>" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="../backend_assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="../backend_assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/themes/layout/header/menu/dark.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link href="main_assets/style.css" rel="stylesheet" type="text/css" />

		<?php
		include("templates/login/page_details/css.php");
		?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<?php
		include("templates/login/login.php");
		?>

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>
			var KTAppSettings = {
				"breakpoints": {
					"sm": 576,
					"md": 768,
					"lg": 992,
					"xl": 1200,
					"xxl": 1400
				},
				"colors": {
					"theme": {
						"base": {
							"white": "#ffffff",
							"primary": "#3699FF",
							"secondary": "#E5EAEE",
							"success": "#1BC5BD",
							"info": "#8950FC",
							"warning": "#FFA800",
							"danger": "#F64E60",
							"light": "#E4E6EF",
							"dark": "#181C32"
						},
						"light": {
							"white": "#ffffff",
							"primary": "#E1F0FF",
							"secondary": "#EBEDF3",
							"success": "#C9F7F5",
							"info": "#EEE5FF",
							"warning": "#FFF4DE",
							"danger": "#FFE2E5",
							"light": "#F3F6F9",
							"dark": "#D6D6E0"
						},
						"inverse": {
							"white": "#ffffff",
							"primary": "#ffffff",
							"secondary": "#3F4254",
							"success": "#ffffff",
							"info": "#ffffff",
							"warning": "#ffffff",
							"danger": "#ffffff",
							"light": "#464E5F",
							"dark": "#ffffff"
						}
					},
					"gray": {
						"gray-100": "#F3F6F9",
						"gray-200": "#EBEDF3",
						"gray-300": "#E4E6EF",
						"gray-400": "#D1D3E0",
						"gray-500": "#B5B5C3",
						"gray-600": "#7E8299",
						"gray-700": "#5E6278",
						"gray-800": "#3F4254",
						"gray-900": "#181C32"
					}
				},
				"font-family": "Poppins"
			};
		</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="../backend_assets/plugins/global/plugins.bundle.js"></script>
		<script src="../backend_assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="../backend_assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="../backend_assets/js/pages/widgets.js"></script>
		<!--end::Page Scripts-->
		<script src="main_assets/main_controller.js"></script>

		<?php
		include("templates/login/page_details/js.php");
		?>
	</body>
	<!--end::Body-->

	</html>
<?php
} else {
	if ($pg_nm == "" || $pg_nm == "?") {
		header("Location: " . $baseUrl . "/landing");
	}
?>
	<!DOCTYPE html>
	<html lang="en">
	<!--begin::Head-->

	<head>
		<meta charset="utf-8" />
		<?php
		if (file_exists("templates/" . $pg_nm . "/page_details/title.php")) {
			include("templates/" . $pg_nm . "/page_details/title.php");
		} else {
		?>
			<title><?php echo $system_name; ?></title>
		<?php
		}
		?>

		<meta name="description" content="Page with empty content" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<base href="<?php echo $baseHref; ?>" />
		<link rel="shortcut icon" href="../upload_content/upload_img/system_img/<?php echo $system_favicon; ?>" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="../backend_assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="../backend_assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/themes/layout/header/menu/dark.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="../backend_assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link href="main_assets/style.css" rel="stylesheet" type="text/css" />

		<?php
		if (file_exists("templates/" . $pg_nm . "/page_details/css.php")) {
			include("templates/" . $pg_nm . "/page_details/css.php");
		}
		?>
		<script>
			const insert_per = "<?php echo $entry_permission; ?>";
			const view_per = "<?php echo $view_permission; ?>";
			const edit_per = "<?php echo $edit_permission; ?>";
			const del_per = "<?php echo $delete_permissioin; ?>";
			const baseUrl = "<?php echo $baseUrl; ?>"
		</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-minimize aside-minimize-hoverable page-loading">

		<!--======================Background overlay===========---->
		<div class="background_overlay">
			<div class="preloader spinner spinner-primary"></div>
		</div>

		<!--====================== Background overlay of Numeric preloader for file uploading ===========---->
		<div class="background_overlay_preloader">
			<div class="preloader_inner_text">Wait For File Uploading...</div>
			<div class="preloader_inner"><span class="preloader_inner_number">0</span>%</div>
		</div>

		<!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="?">
				<img alt="Logo" style="max-width: 160px; max-height: 45px;" src="../upload_content/upload_img/system_img/<?php echo $system_logo; ?>" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">

				<!-- SIDE BAR START -->
				<!--begin::Aside-->
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<!--begin::Brand-->
					<div class="brand flex-column-auto" id="kt_brand">
						<!--begin::Logo-->
						<a href="" class="brand-logo">
							<img style="max-width: 160px; max-height: 45px;" alt="Logo" src="../upload_content/upload_img/system_img/<?php echo $system_logo; ?>" />
						</a>
						<!--end::Logo-->
						<!--begin::Toggle-->
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</button>
						<!--end::Toolbar-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside Menu-->
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul style="padding:0px;" class="menu-nav">
								<li style="margin-top: 5px;" class="menu-section">
									<h4 class="menu-text">Menu List</h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>

								<!--================= MENU START ==============-->
								<?php
								if ($session_user_mode_code == "Project Admin") {
									$menuQuery = "select menu_code,menu_name,menu_icon,sub_menu_status,file_name,folder_name from menu_master where active='Yes' order by order_num ";
								} else {
									$menuQuery = "select 
												menu_master.menu_code,
												menu_master.menu_name,
												menu_master.menu_icon,
												menu_master.sub_menu_status,
												menu_master.file_name,
												menu_master.folder_name
												from menu_master RIGHT JOIN user_permission ON user_permission.all_menu_code=menu_master.menu_code where menu_master.active='Yes' and user_permission.user_mode_code='" . $session_user_mode_code . "' order by order_num ";
								}
								$menu_dataget = mysqli_query($con, $menuQuery);
								while ($menu_rw = mysqli_fetch_assoc($menu_dataget)) {
									if ($menu_rw['sub_menu_status'] == "Yes") {
								?>

										<li class="menu-item menu-item-submenu <?php echo $urlMenuCode == $menu_rw['menu_code'] ? "menu-item-open menu-item-here" : ""; ?>" aria-haspopup="true" data-menu-toggle="hover">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-icon">
													<i style="line-height: revert;" class="<?php echo $menu_rw['menu_icon'] ?> mr-5"></i>
												</span>
												<span class="menu-text"><?php echo $menu_rw['menu_name'] ?></span>
												<i class="menu-arrow"></i>
											</a>
											<div class="menu-submenu">
												<ul class="menu-subnav">
													<?php
													if ($session_user_mode_code == "Project Admin") {
														$submenuQuery = "select sub_menu_name,menu_icon,file_name,folder_name from sub_menu_master where menu_code='" . $menu_rw['menu_code'] . "' and active='Yes' order by order_num ";
													} else {
														$submenuQuery = "select 
														sub_menu_master.sub_menu_name,
														sub_menu_master.menu_icon,
														sub_menu_master.file_name,
														sub_menu_master.folder_name
														from sub_menu_master RIGHT JOIN user_permission ON user_permission.all_menu_code=sub_menu_master.sub_menu_code where sub_menu_master.menu_code='" . $menu_rw['menu_code'] . "' and sub_menu_master.active='Yes' and user_permission.user_mode_code='" . $session_user_mode_code . "' order by order_num ";
													}
													$sub_menu_dataget = mysqli_query($con, $submenuQuery);
													while ($sub_menu_rw = mysqli_fetch_array($sub_menu_dataget)) {
													?>
														<li class="menu-item <?php echo $pg_nm == $sub_menu_rw['file_name'] ? "menu-item-active" : ""; ?>" aria-haspopup="true">
															<a href="<?php echo $baseUrl . "/" . $sub_menu_rw['file_name'] . "/" . $menu_rw['menu_code'] ?>" class="menu-link">
																<span class="menu-icon">
																	<i style="line-height: revert;color: #00aeef;" class="<?php echo $sub_menu_rw['menu_icon'] ?> mr-5"></i>
																</span>
																<span class="menu-text"><?php echo $sub_menu_rw['sub_menu_name'] ?></span>
															</a>
														</li>
													<?php
													}
													?>
												</ul>
											</div>
										</li>

									<?php
									} else {
									?>
										<li class="menu-item <?php echo $urlMenuCode == $menu_rw['menu_code'] ? "menu-item-open menu-item-here" : ""; ?>" aria-haspopup="true">
											<a href="<?php echo $baseUrl . "/" . $menu_rw['file_name'] . "/" . $menu_rw['menu_code'] ?>" class="menu-link">
												<i style="line-height: revert;" class="<?php echo $menu_rw['menu_icon'] ?> mr-5"></i>
												<span class="menu-text"><?php echo $menu_rw['menu_name'] ?></span>
											</a>
										</li>
								<?php
									}
								}
								?>
								<!--================= MENU END ==============-->
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside-->
				<!-- SIDE BAR END -->

				<!--begin::Wrapper-->
				<div style="padding-top: 50px;" class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

					<!-- TOPBAR START -->
					<!--begin::Header-->
					<div style="max-height:48px;" id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								<!--begin::Header Menu-->
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
									<!--begin::Header Nav-->
									<div class="topbar_company_details">
										<?php
										echo $system_name;
										?>
									</div>

									<!--end::Header Nav-->
								</div>
								<!--end::Header Menu-->
							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->
							<div class="topbar">
								<!--begin::Search-->
								<div style="display: none;" class="dropdown" id="kt_quick_search_toggle">
									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
										<div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
											<span class="svg-icon svg-icon-xl svg-icon-primary">
												<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</div>
									</div>
									<!--end::Toggle-->
									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
											<!--begin:Form-->
											<form class="quick-search-form">
												<div class="input-group">
													<select onchange="showSearchDetails()" id="search_details" class="form-control select2" data-placeholder="Search What You Want"></select>
												</div>
											</form>
											<!--end::Form-->
											<!--begin::Scroll-->
											<div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" data-mobile-height="200"></div>
											<!--end::Scroll-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
								<!--end::Search-->
								<!--begin::Notifications-->
								<div class="dropdown">
									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
										<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-2">
											<img style="height: 34px;" src="../backend_assets/img_icon/noti_icon.png" class="noti_icon_img" />
										</div>
									</div>
									<!--end::Toggle-->
									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<form>
											<!--begin::Header-->
											<div class="d-flex flex-column flex-center py-10 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(../backend_assets/media/misc/bg-1.jpg)">
												<h4 class="text-white font-weight-bold">Notification</h4>
												<span class="btn btn-success btn-sm font-weight-bold font-size-sm mt-2"><span class="noti_count">0</span> pending
													Notification</span>
											</div>
											<!--end::Header-->
											<!--begin::Content-->
											<div class="tab-content">
												<!--begin::Tabpane-->
												<div class="tab-pane active" id="topbar_notifications_events" role="tabpanel">
													<!--begin::Nav-->
													<div class="navi navi-hover scroll my-4 notification_item_list" data-scroll="true" data-height="300" data-mobile-height="200">

													</div>
													<!--end::Nav-->

												</div>
												<!--end::Tabpane-->
											</div>
											<!--end::Content-->
										</form>
									</div>
									<!--end::Dropdown-->
								</div>
								<!--end::Notifications-->
								<!--begin::User-->
								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?php echo strstr($session_name, ' ', true); ?></span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold"><?php echo substr($session_name, 0, 1); ?></span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->

					<!-- TOPBAR END -->

					<!--begin::Content-->
					<div class="page_render_div">
						<?php
						// Page Render Here

						$sub_menu_dataget = mysqli_query($con, "select sub_menu_code from sub_menu_master where file_name='" . $pg_nm . "' ");
						$sub_menu_data = mysqli_fetch_row($sub_menu_dataget);

						$sub_menu_code = $sub_menu_data[0];

						if ($sub_menu_code == "") {
							$allMenuCode = $urlMenuCode;
						} else {
							$allMenuCode = $sub_menu_code;
						}

						$check_user_page_access_dataget = mysqli_query($con, "select * from user_permission where user_mode_code='" . $session_user_mode_code . "' and all_menu_code='" . $allMenuCode . "' ");
						$check_user_page_access_data = mysqli_num_rows($check_user_page_access_dataget);

						if ($session_user_mode_code == "Project Admin") {
							$check_user_page_access_data = 1;
						}

						if ($allMenuCode == "") {
							$check_user_page_access_data = 1;
						}

						if ($check_user_page_access_data == 1) {

							if (file_exists("templates/" . $fl_nm . "/" . $pg_nm . ".php")) {
								include("templates/" . $fl_nm . "/" . $pg_nm . ".php");
							}
						} else {
						?>
							<div style="width: 50%; margin: 65px auto;" class="alert alert-custom alert-danger fade show mb-5" role="alert">
								<div class="alert-icon">
									<i class="flaticon-warning"></i>
								</div>
								<div class="alert-text">
									<h3>You Have No Permission To Access It</h3>
								</div>
								<div class="alert-close">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">
											<i class="ki ki-close"></i>
										</span>
									</button>
								</div>
							</div>
						<?php
						}
						?>

					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-2 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div style="width: 100%;" class="text-dark order-2 order-md-1">
								<span style="line-height: 30px;" class="text-muted font-weight-bold mr-2">© <?php echo $year; ?></span>
								<a href="" target="_blank" class="text-dark-75 text-hover-primary"><?php echo $system_name; ?></a>

								<a style="float: right;" onclick="history.forward()" class="btn btn-icon btn-light-primary btn-sm mr-2">
									<i class="fa fa-arrow-alt-circle-right"></i>
								</a>

								<a style="float: right;" href="<?php echo $baseUrl; ?>" class="btn btn-icon btn-light-success btn-sm mr-2">
									<i class="fa fa-home"></i>
								</a>

								<a style="float: right;" onclick="history.back()" class="btn btn-icon btn-light-primary btn-sm mr-2">
									<i class="fa fa-arrow-alt-circle-left"></i>
								</a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->

		<!-- USER PANEL START -->
		<!-- begin::User Panel-->
		<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">User Profile
					<small class="text-muted font-size-sm ml-2"></small>
				</h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
				<!--begin::Header-->
				<div class="d-flex align-items-center mt-5">
					<div class="symbol symbol-100 mr-5">
						<div class="symbol-label" style="background-image:url('../upload_content/upload_img/profile_img/<?php echo $session_profile_img == "" ? "user_icon.png" : $session_profile_img; ?>')"></div>
						<i class="symbol-badge bg-success"></i>
					</div>
					<div class="d-flex flex-column">
						<span class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?php echo $session_name; ?></span>
						<div class="text-muted mt-1"><?php echo $session_user_mode_code == "Project Admin" ? "Project Admin" : $session_user_mode; ?></div>
						<div class="navi mt-2">
							<a <?php echo $session_email == "" ? "" : "href='mailto:" . $session_email . "'"; ?> class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
									</span>
									<span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="navi-text text-muted text-hover-primary"><?php echo $session_email == "" ? "Update Your Email" : $session_email; ?></span>
								</span>
							</a>
							<a onclick="log_out()" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
						</div>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Separator-->
				<div class="separator separator-dashed mt-8 mb-5"></div>
				<!--end::Separator-->
				<!--begin::Nav-->
				<div class="navi navi-spacer-x-0 p-0">
					<!--begin::Item-->
					<a href="<?php echo $baseUrl . "/manage_profile/MC_62e041fd9a5401658864125"; ?>" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-success">
										<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
												<circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Profile</div>
								<div class="text-muted">Account settings and more
									<span class="label label-light-danger label-inline font-weight-bold">update</span>
								</div>
							</div>
						</div>
					</a>
					<!--end:Item-->

					<!--begin::Item-->
					<a href="<?php echo $baseUrl . "/activity/MC_62e041fd9a5401658864125"; ?>" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-danger">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Files/Selected-file.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<path d="M4.85714286,1 L11.7364114,1 C12.0910962,1 12.4343066,1.12568431 12.7051108,1.35473959 L17.4686994,5.3839416 C17.8056532,5.66894833 18,6.08787823 18,6.52920201 L18,19.0833333 C18,20.8738751 17.9795521,21 16.1428571,21 L4.85714286,21 C3.02044787,21 3,20.8738751 3,19.0833333 L3,2.91666667 C3,1.12612489 3.02044787,1 4.85714286,1 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
												<path d="M6.85714286,3 L14.7364114,3 C15.0910962,3 15.4343066,3.12568431 15.7051108,3.35473959 L20.4686994,7.3839416 C20.8056532,7.66894833 21,8.08787823 21,8.52920201 L21,21.0833333 C21,22.8738751 20.9795521,23 19.1428571,23 L6.85714286,23 C5.02044787,23 5,22.8738751 5,21.0833333 L5,4.91666667 C5,3.12612489 5.02044787,3 6.85714286,3 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Activities</div>
								<div class="text-muted">Track Your Activities</div>
							</div>
						</div>
					</a>
					<!--end:Item-->

				</div>
				<!--end::Nav-->
				<!--begin::Separator-->
				<div class="separator separator-dashed my-7"></div>
				<!--end::Separator-->

			</div>
			<!--end::Content-->
		</div>
		<!-- end::User Panel-->
		<!-- USER PANEL END -->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
				<!--end::Svg Icon-->
			</span>
		</div>
		<!--end::Scrolltop-->

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>
			var KTAppSettings = {
				"breakpoints": {
					"sm": 576,
					"md": 768,
					"lg": 992,
					"xl": 1200,
					"xxl": 1400
				},
				"colors": {
					"theme": {
						"base": {
							"white": "#ffffff",
							"primary": "#3699FF",
							"secondary": "#E5EAEE",
							"success": "#1BC5BD",
							"info": "#8950FC",
							"warning": "#FFA800",
							"danger": "#F64E60",
							"light": "#E4E6EF",
							"dark": "#181C32"
						},
						"light": {
							"white": "#ffffff",
							"primary": "#E1F0FF",
							"secondary": "#EBEDF3",
							"success": "#C9F7F5",
							"info": "#EEE5FF",
							"warning": "#FFF4DE",
							"danger": "#FFE2E5",
							"light": "#F3F6F9",
							"dark": "#D6D6E0"
						},
						"inverse": {
							"white": "#ffffff",
							"primary": "#ffffff",
							"secondary": "#3F4254",
							"success": "#ffffff",
							"info": "#ffffff",
							"warning": "#ffffff",
							"danger": "#ffffff",
							"light": "#464E5F",
							"dark": "#ffffff"
						}
					},
					"gray": {
						"gray-100": "#F3F6F9",
						"gray-200": "#EBEDF3",
						"gray-300": "#E4E6EF",
						"gray-400": "#D1D3E0",
						"gray-500": "#B5B5C3",
						"gray-600": "#7E8299",
						"gray-700": "#5E6278",
						"gray-800": "#3F4254",
						"gray-900": "#181C32"
					}
				},
				"font-family": "Poppins"
			};
		</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="../backend_assets/plugins/global/plugins.bundle.js"></script>
		<script src="../backend_assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="../backend_assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="../backend_assets/js/pages/widgets.js"></script>
		<!--end::Page Scripts-->
		<script src="main_assets/main_controller.js"></script>

		<?php
		if (file_exists("templates/" . $pg_nm . "/page_details/js.php")) {
			include("templates/" . $pg_nm . "/page_details/js.php");
		}
		?>
	</body>
	<!--end::Body-->

	</html>
<?php
}
?>