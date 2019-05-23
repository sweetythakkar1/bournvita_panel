<?php
$contact_id = isset($app_contact['contact_id']) ? (int) $app_contact['contact_id'] : (int) set_value('contact_id');
$first_name = isset($app_contact['first_name']) ? $app_contact['first_name'] : set_value('first_name');
$last_name = isset($app_contact['last_name']) ? $app_contact['last_name'] : set_value('last_name');
$email = isset($app_contact['email']) ? $app_contact['email'] : set_value('email');
$phone = isset($app_contact['phone']) ? $app_contact['phone'] : set_value('phone');
$business_name = isset($app_contact['business_name']) ? $app_contact['business_name'] : set_value('business_name');
$status = isset($app_contact['status']) ? $app_contact['status'] : set_value('status');
?>
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Contact</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('manage-contacts'); ?>">Manage Contacts</a></li>
                <?php if ($contact_id > 0): ?>
                    <li class="breadcrumb-item active">Update Contact</li>
                <?php else: ?>
                    <li class="breadcrumb-item active">Add New Contact</li>

                <?php endif; ?>

            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php include APPPATH . '/views/notification.php'; ?>
            <div class="card card-outline-info">
                <div class="card-body">
                    <?php
                    $form_attr = array("class" => "form-horizontal", "id" => "frm_add_contact", "name" => "frm_add_contact");
                    echo form_open_multipart("add-contact-action", $form_attr);
                    ?>
                    <input id="contact_id" type="hidden" name="contact_id" value="<?php echo $contact_id; ?>" />
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">First Name <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control" required>
                                        <?php echo form_error('first_name'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Last Name <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" required>
                                        <?php echo form_error('last_name'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Business Name</label>
                                    <div class="col-md-9 controls">
                                        <input type="text" id="business_name" name="business_name" value="<?php echo $business_name; ?>" class="form-control">
                                        <?php echo form_error('business_name'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Email <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <input type="email" name="email" id="email"  value="<?php echo $email; ?>" class="form-control" required>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Mobile <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <input type="text" name="phone" id="phone"  value="<?php echo $phone; ?>" required class="form-control">
                                        <?php echo form_error('phone'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>


                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3"></label>
                                    <div class="controls">
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input name="status" type="radio" value="A" <?php echo ($status == 'A') ? "checked=''" : "checked"; ?>  class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Active</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input name="status" type="radio" <?php echo ($status == 'I') ? "checked=''" : ""; ?> value="I" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Inactive</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3"></label>
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $("#frm_add_contact").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true
                },
            },
            messages: {
                email: {
                    remote: "Email is already exist."
                }
            }
        });
    });
</script>