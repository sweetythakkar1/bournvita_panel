<?php
$url_segment = trim($this->uri->segment(1));
$company_log = get_logo();
$site_name = get_site_setting('site_name');
$site_email = get_site_setting('site_email');
$favicon = get_fevicon();
$site_phone = get_site_setting('site_phone');
$type = $this->session->userdata('role');
$title = isset($title) ? $title : "";
$upd_id = $this->session->userdata('id');
$login_user = get_user_details($upd_id);


$preview_image_admin = "";
if (isset($login_user['profile_image']) && $login_user['profile_image'] != "") {
    if (file_exists(FCPATH . 'assets/upload/user_media/' . $login_user['profile_image'])) {
        $preview_image_admin = base_url('assets/upload/user_media/' . $login_user['profile_image']);
    } else {
        $preview_image_admin = base_url('assets/img/no_image.gif');
    }
} else {
    $preview_image_admin = base_url('assets/img/no_image.gif');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $site_name; ?> | <?php echo isset($title) ? $title : ""; ?></title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/puse-icons-feather/feather.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.base.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.addons.css'); ?>">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css'); ?>" />
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
        <!-- endinject -->
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/icheck/skins/all.css'); ?>">
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" />


        <!-- plugins:js -->
        <script src="<?php echo base_url('assets/vendors/js/vendor.bundle.base.js'); ?>"></script>
        <script src="<?php echo base_url('assets/vendors/js/vendor.bundle.addons.js'); ?>"></script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="<?php echo base_url('assets/js/off-canvas.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/hoverable-collapse.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/misc.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/settings.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/todolist.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/form-validation.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/chart.js'); ?>"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/loader.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/google-charts.js'); ?>"></script>
        <!-- End custom js for this page-->
        <script>
            base_url = '<?php echo base_url(); ?>';
            csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>

    </head>
    <body>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-success">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>"><img src="<?php echo $company_log; ?>" alt="logo"/></a>
                    <a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>"><img src="<?php echo $company_log; ?>" alt="logo"/></a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link">
                                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-settings d-lg-block">
                            <a class="nav-link" href="<?php echo base_url('logout'); ?>">
                                <i class="mdi mdi-backburger"></i> Logout
                            </a>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <div class="nav-link d-flex">
                                <div class="profile-image">
                                    <img src="<?php echo $preview_image_admin; ?>" alt="image"/>
                                    <span class="online-status online"></span> <!--change class online to offline or busy as needed-->
                                </div>
                                <div class="profile-name">
                                    <p class="name">
                                        <?php echo $login_user['first_name'] . " " . $login_user['last_name']; ?>
                                    </p>
                                    <p class="designation">
                                        Admin
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-category">
                            <span class="nav-link">Main</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('dashboard'); ?>">
                                <i class="fa fa-dashboard"></i>&nbsp;
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <!--                        <li class="nav-item">
                                                    <a class="nav-link" href="<?php echo base_url('short-code'); ?>">
                                                        <i class="fa fa-code"></i>&nbsp;
                                                        <span class="menu-title">Short Code</span>
                                                    </a>
                                                </li>-->

                        <?php if ($login_user['is_allow_obd_miscall'] == "Y"): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('obd'); ?>">
                                    <i class="fa fa-phone"></i>&nbsp;
                                    <span class="menu-title">Voice</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($login_user['is_allow_long_code'] == "Y"): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('long-code'); ?>">
                                    <i class="fa fa-envelope"></i>&nbsp;
                                    <span class="menu-title">SMS</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($login_user['is_allow_sms'] == "Y"): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('sms-all'); ?>">
                                    <i class="fa fa-bar-chart"></i>&nbsp;
                                    <span class="menu-title">Message</span>
                                </a>
                            </li>
                        <?php endif; ?>



                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('summary-report'); ?>">
                                <i class="fa fa-bar-chart"></i>&nbsp;
                                <span class="menu-title">Summary</span>
                            </a>
                        </li>
                        <?php if ($login_user['is_allow_sms'] == "Y"): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('sms-api'); ?>">
                                    <i class="fa fa-envelope-open-o"></i>&nbsp;
                                    <span class="menu-title">SMS API</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($login_user['allow_report_download'] == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('download-report'); ?>">
                                    <i class="fa fa-download"></i>&nbsp;
                                    <span class="menu-title">Download Report</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($type == 'SA'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('manage-user'); ?>">
                                    <i class="fa fa-user-circle"></i>&nbsp;
                                    <span class="menu-title">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('download-request'); ?>">
                                    <i class="fa fa-user-circle"></i>&nbsp;
                                    <span class="menu-title">Download Request</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts" aria-expanded="false" aria-controls="sidebar-layouts">
                                    <i class="fa fa-gears"></i>&nbsp;
                                    <span class="menu-title">Settings</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="sidebar-layouts">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('site-setting'); ?>">Site Setting</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('email-setting'); ?>">Email Setting</a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
                <?php echo $main_content; ?>
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->


    </body>
</html>
