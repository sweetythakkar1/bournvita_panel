<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Password Setting</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xlg-9 col-md-7">
            <?php include APPPATH . '/views/notification.php'; ?>

            <div class="card">
                <div class="card-body">
                    <?php
                    $attr_chang_pass = array('id' => "changePassForm", 'accept-charset' => "utf-8", 'novalidate' => "novalidate", "class" => "form-horizontal form-material");
                    echo form_open('password-change', $attr_chang_pass);
                    ?>                 
                    <div class="form-group">
                        <label>Old Password  : <small class="required">*</small></label>
                        <input type="password" id="admin_old_password" placeholder="Old Password" name="admin_old_password" autocomplete="off" class="form-control form-control-line" value="">
                        <?php echo form_error('admin_old_password'); ?>
                    </div>
                    <div class="form-group">
                        <label >New Password : <small class="required">*</small></label>
                        <input type="password" id="admin_new_password" placeholder="New Password" name="admin_new_password" autocomplete="off" minlength="6" class="form-control form-control-line" value="">
                        <?php echo form_error('admin_new_password'); ?>
                    </div>
                    <div class="form-group">
                        <label >Confirm Password  : <small class="required">*</small></label>
                        <input type="password" id="admin_confirm_password" placeholder="Confirm Password" name="admin_confirm_password"  autocomplete="off" class="form-control form-control-line" value="">
                        <?php echo form_error('admin_confirm_password'); ?>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input  class="btn btn-success" type="submit" value="Update"/>
                            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-dark">Cancel</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_ASSETS; ?>plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        $("#changePassForm").validate({
            rules: {
                admin_old_password: 'required',
                admin_new_password: 'required',
                admin_confirm_password: {
                    required: true,
                    equalTo: "#admin_new_password"
                },
            },
            message: {
                admin_old_password: 'This field is required',
                admin_new_password: 'This field is required',
                admin_confirm_password: 'This field is required',
            }

        });
    });
</script>