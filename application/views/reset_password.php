<?php
$company_log = get_logo();
$site_name = get_site_setting('site_name');
$favicon = get_fevicon();

$token = isset($token) ? $token : set_value('token');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" href="<?php echo $favicon; ?>">
        <title>Admin | Reset Password</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url('assets/admin/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo base_url('assets/admin/css/style.css'); ?>" rel="stylesheet">
        <!--alerts CSS -->
        <link href="<?php echo base_url('assets/admin/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
        <!-- You can change the theme colors from here -->
        <link href="<?php echo base_url('assets/admin/css/colors/blue.css'); ?>" id="theme" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <section id="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-register">  
                       <div class="text-center  mb-2">
                            <a href="<?php echo base_url(); ?>">
                                <img src="<?php echo base_url('assets/img/login.png'); ?>" height="40" width="260" class="light-logo" />
                            </a>
                        </div>
                        <br/>
                        <div class="login-box card">
                            <div class="card-body">
                                <?php
                                $form_attr = array("class" => "form-horizontal form-material", "id" => "Reset-form", "name" => "Reset-form");
                                echo form_open("reset-password-action", $form_attr);
                                ?>
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>"/>
                                <h2 class="box-title m-b-40 text-center">Reset Password</h2>
                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <input class="form-control" value="" id="password" type="password" name="password" required="" placeholder="Password"> 
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <input class="form-control" value="" type="password" name="cpassword" required="" placeholder="Confirm Password"> 
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group text-center m-t-50">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="<?php echo base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="<?php echo base_url('assets/admin/plugins/bootstrap/js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="<?php echo base_url('assets/admin/js/jquery.slimscroll.js'); ?>"></script>
        <!--Wave Effects -->
        <script src="<?php echo base_url('assets/admin/js/waves.js'); ?>"></script>
        <!--Menu sidebar -->
        <script src="<?php echo base_url('assets/admin/js/sidebarmenu.js'); ?>"></script>
        <!--stickey kit -->
        <!-- Sweet-Alert  -->
        <script src="<?php echo base_url('assets/admin/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/plugins/sweetalert/jquery.sweet-alert.custom.js'); ?>"></script>
        <!--Custom JavaScript -->
        <script src="<?php echo base_url('assets/admin/js/custom.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/custom.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>

        <!-- ============================================================== -->
        <!-- Style switcher -->
        <!-- ============================================================== -->
        <script src="<?php echo base_url('assets/admin/plugins/styleswitcher/jQuery.style.switcher.js'); ?>"></script>

        <!-- auto hide message div-->
        <script type="text/javascript">
            $(document).ready(function () {
                $('.hide_msg').delay(2000).slideUp();
            });

            $("#Reset-form").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6,
                    },
                    cpassword: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                //For custom messages
                messages: {
                    email: {
                        required: "Enter a email",
                    }
                }
            });

        </script>
    </body>


</html>