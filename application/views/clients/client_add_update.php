<?php
$user_id = isset($admin_data['user_id']) ? $admin_data['user_id'] : set_value('user_id');
$first_name = isset($admin_data['first_name']) ? $admin_data['first_name'] : set_value('first_name');
$last_name = isset($admin_data['last_name']) ? $admin_data['last_name'] : set_value('last_name');
$email = isset($admin_data['email']) ? $admin_data['email'] : set_value('email');
$password = isset($admin_data['password']) ? $admin_data['password'] : set_value('password');
$phone = isset($admin_data['phone']) ? $admin_data['phone'] : set_value('phone');
$status = isset($admin_data['status']) ? $admin_data['status'] : set_value('status');
$profile_image = isset($admin_data['profile_image']) ? $admin_data['profile_image'] : set_value('profile_image');

$preview_image = "";
if (isset($profile_image) && $profile_image != "") {
    if (file_exists(FCPATH . 'assets/upload/user_media/' . $admin_data['profile_image'])) {
        $preview_image = base_url('assets/upload/user_media/' . $admin_data['profile_image']);
    } else {
        $preview_image = base_url('assets/img/no_image.gif');
    }
} else {
    $preview_image = base_url('assets/img/no_image.gif');
}
?>
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Client</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('manage-client'); ?>">Manage Client</a></li>
                <li class="breadcrumb-item active">Add New Client</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php include APPPATH . '/views/notification.php'; ?>
            <div class="card card-outline-info">
                <div class="card-body">
                    <?php
                    $form_attr = array("class" => "form-horizontal", "id" => "frm_add_client", "name" => "frm_add_client");
                    echo form_open_multipart("add-client-action", $form_attr);
                    ?>
                    <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                    <input id="admin_id" type="hidden" name="admin_id" value="<?php echo (int) $user_id; ?>" />
                    <input id="type" type="hidden" name="type" value="A" />
                    <input id="token" type="hidden" name="token" value="<?php echo $this->session->userdata('token'); ?>" />
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">First Name <span class="text-danger">*</span></label>
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
                                    <label class="control-label text-left col-md-3">Last Name <span class="text-danger">*</span></label>
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
                                    <label class="control-label text-left col-md-3">Email <span class="text-danger">*</span></label>
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
                                    <label class="control-label text-left col-md-3">Mobile <span class="text-danger">*</span></label>
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
                                    <label class="control-label text-left col-md-3">Profile Picture </label>
                                    <div class="col-md-9 controls">
                                        <input type="file" onchange="readURL(this)"  name="profile_image" id="profile_image" value="<?php echo $profile_image; ?>" class="form-control">
                                        <?php echo form_error('profile_image'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"></label>
                                    <div class="col-md-9 controls">
                                        <input type="hidden" id="profile_image_old" name="profile_image_old" value="<?php echo $profile_image; ?>"/>
                                        <img src="<?php echo $preview_image; ?>" height="100" width="100" id="preview_image" name="preview_image"/>
                                    </div>

                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"></label>
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
                        <!-- CSRF token -->
<!--                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />-->
                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"></label>
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Save Client</button>
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
<!--<link href="<?php echo base_url('assets/js/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />-->
<!--<script src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>-->
<script>
//                                            $("#assigned_server").select2({
//                                                theme: "bootstrap",
//                                                placeholder: 'Select Server',
//                                                allowClear: true
//                                            });
    //$('#assigned_server').multiselect();
    function readURL(input) {
        var id = $(input).attr("id");
        var image = '#' + id;
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview_image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    $(document).ready(function () {

        $("#frm_add_client").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true,
                    remote: {
                        url: base_url + "check-client-email",
                        type: "post",
                        data: {
                            csrf_test_name: function () {
                                return csrf_token;
                            },
                            email: function () {
                                return $("#email").val();
                            },
                            id: function () {
                                return $("#user_id").val();
                            }
                        }
                    }
                }
            },
            messages: {
                email: {
                    remote: "Email is already exist."
                }
            }
        });
    });
</script>