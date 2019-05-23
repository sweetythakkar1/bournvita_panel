<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">

            <div class="col-lg-12 col-xlg-9 col-md-7">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Email Setting</h4>
                        <?php
                        $form_attr = array("class" => "form-horizontal form-material", "id" => "site_email_form", "name" => "site_email_form");
                        echo form_open("update-email", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SMTP Host : <small class="required">*</small></label>
                                    <input type="text" id="smtp_host" name="smtp_host" required="" class="form-control form-control-line" value="<?php echo isset($email_data['smtp_host']) ? $email_data['smtp_host'] : set_value('smtp_host'); ?>">
                                    <?php echo form_error('smtp_host'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Password : <small class="required">*</small></label>
                                    <input type="password" id="smtp_password" name="smtp_password" required="" class="form-control form-control-line" value="<?php echo isset($email_data['smtp_password']) ? $email_data['smtp_password'] : set_value('smtp_password'); ?>">
                                    <?php echo form_error('smtp_password'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >SMTP Secure : <small class="required">*</small></label>
                                    <select class="form-control form-control-line" required="" id="smtp_secure" name="smtp_secure">
                                        <option value="tls" <?php echo isset($email_data['smtp_secure']) && $email_data['smtp_secure'] == 'tsl' ? "selected" : "" ?>>TLS</option>
                                        <option value="ssl" <?php echo isset($email_data['smtp_secure']) && $email_data['smtp_secure'] == 'ssl' ? "selected" : "" ?>>SSL</option>
                                    </select>
                                    <?php
                                    echo form_error('smtp_secure');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Username : <small class="required">*</small></label>
                                    <input type="text" id="smtp_username" required="" name="smtp_username" class="form-control form-control-line" value="<?php echo isset($email_data['smtp_username']) ? $email_data['smtp_username'] : set_value('smtp_username'); ?>">
                                    <?php echo form_error('smtp_username'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SMTP Port : <small class="required">*</small></label>
                                    <input type="text" id="smtp_port" required="" name="smtp_port"  class="form-control form-control-line" value="<?php echo isset($email_data['smtp_port']) ? $email_data['smtp_port'] : set_value('smtp_port'); ?>">
                                    <?php echo form_error('smtp_port'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >From Name : <small class="required">*</small></label>
                                    <input type="text" id="email_from_name" required="" name="email_from_name" class="form-control form-control-line" value="<?php echo isset($email_data['email_from_name']) ? $email_data['email_from_name'] : set_value('email_from_name'); ?>">
                                    <?php echo form_error('email_from_name'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_ASSETS; ?>plugins/jquery/jquery.min.js"></script>

<!-- Column -->
<script>
    $(document).ready(function () {
        $("#site_email_form").validate({
            rules: {
                smtp_host: 'required',
                smtp_password: 'required',
                smtp_username: 'required',
                smtp_port: 'required',
                email_from_name: 'required'
            },
            message: {
                smtp_host: 'This field is required',
                password: 'This field is required',
                username: 'This field is required',
                port: 'This field is required',
                email_from_name: 'This field is required'
            }
        });
    });
</script>

