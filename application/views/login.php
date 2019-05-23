<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login</title>

        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/puse-icons-feather/feather.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.base.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.addons.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth"  style="background: #fc5103;">
                    <div class="row w-100">

                        <div class="col-lg-8 mx-auto">
                            <?php include APPPATH . '/views/notification.php'; ?>
                            <div class="row">
                                
                                <div class="col-lg-6 login-half-bg d-flex flex-row">
<!--                                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018  All rights reserved.</p>-->
                                </div>
                                <div class="col-lg-6 bg-white">

                                    <div class="auth-form-light text-left p-5">
                                        <h2>Login</h2>
                                        <?php
                                        $form_attr = array("class" => "pt-5", "id" => "login-form", "name" => "login-form", "method" => "post");
                                        echo form_open_multipart(site_url('auth/login_action'), $form_attr);
                                        ?>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Username</label>
                                            <input type="text" class="form-control" required="" id="user_name" name="user_name" placeholder="Username">
                                            <i class="mdi mdi-account"></i>
                                            <?php echo form_error('user_name'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" required="" id="password" name="password" placeholder="Password">
                                            <i class="mdi mdi-eye"></i>
                                        </div>
                                        <div class="mt-5">
                                            <button class="btn btn-block btn-success btn-lg font-weight-medium" type="submit">Log In</button>
                                        </div>
                                        <!--                                        <div class="mt-3 text-center">
                                                                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                                                                </div>-->
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="<?php echo base_url('assets/vendors/js/vendor.bundle.base.js'); ?>"></script>
        <script src="<?php echo base_url('assets/vendors/js/vendor.bundle.addons.js'); ?>"></script>
        <!-- endinject -->
        <!-- inject:js -->
        <script src="<?php echo base_url('assets/js/off-canvas.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/hoverable-collapse.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/misc.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/settings.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/todolist.js'); ?>"></script>
        <!-- endinject -->
    </body>
</html>
