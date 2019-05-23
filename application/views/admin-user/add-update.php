<?php
//echo "<pre>";
//print_r($admin_data);
//exit;
$user_id = isset($admin_data['user_id']) ? $admin_data['user_id'] : set_value('user_id');
$first_name = isset($admin_data['first_name']) ? $admin_data['first_name'] : set_value('first_name');
$last_name = isset($admin_data['last_name']) ? $admin_data['last_name'] : set_value('last_name');
$email = isset($admin_data['email']) ? $admin_data['email'] : set_value('email');
$password = isset($admin_data['password']) ? $admin_data['password'] : set_value('password');
$phone = isset($admin_data['phone']) ? $admin_data['phone'] : set_value('phone');
$status = isset($admin_data['type']) ? trim($admin_data['type']) : "U";
$profile_image = isset($admin_data['profile_image']) ? $admin_data['profile_image'] : set_value('profile_image');
$allow_report_download = isset($admin_data['allow_report_download']) ? $admin_data['allow_report_download'] : 1;
$is_allow_obd_miscall = isset($admin_data['is_allow_obd_miscall']) ? $admin_data['is_allow_obd_miscall'] : "N";
$is_allow_obd_sms = isset($admin_data['is_allow_long_code']) ? $admin_data['is_allow_long_code'] : "N";
$is_allow_sms = isset($admin_data['is_allow_sms']) ? $admin_data['is_allow_sms'] : "N";

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
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add/Update Users</h4>
                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_add_user", "name" => "frm_add_user");
                        echo form_open_multipart("add-user-action", $form_attr);
                        ?>
                        <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                        <input id="admin_id" type="hidden" name="admin_id" value="<?php echo (int) $user_id; ?>" />
                        <input id="token" type="hidden" name="token" value="<?php echo $this->session->userdata('token'); ?>" />
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control" required>
                                        <?php echo form_error('first_name'); ?>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label >Last Name <span class="text-danger">*</span></label>
                                        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" required>
                                        <?php echo form_error('last_name'); ?>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label >Username <span class="text-danger">*</span></label>
                                        <input type="text" name="email" id="email"  value="<?php echo $email; ?>" class="form-control" required>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <?php if ($user_id == 0): ?>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label >Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" value="<?php echo $password; ?>" required class="form-control">
                                            <?php echo form_error('password'); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label >Mobile <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required class="form-control">
                                        <?php echo form_error('phone'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label >Profile Picture </label>
                                        <input type="file" onchange="readURL(this)"  name="profile_image" id="profile_image" value="<?php echo $profile_image; ?>" class="form-control">
                                        <?php echo form_error('profile_image'); ?>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label ></label>
                                        <input type="hidden" id="profile_image_old" name="profile_image_old" value="<?php echo $profile_image; ?>"/>
                                        <img src="<?php echo $preview_image; ?>" height="100" width="100" id="preview_image" name="preview_image"/>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label >Type <span class="text-danger">*</span></label>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($status) && $status == 'A') ? "checked='checked'" : ""; ?> name="type" id="type_admin" value="A">
                                            Admin
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($status) && $status == 'E') ? "checked='checked'" : ""; ?> name="type" id="type_exe" value="E">
                                            Executive
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($status) && $status == 'U') ? "checked='checked'" : ""; ?> name="type" id="type_user" value="U">
                                            User
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label >Permission </label>
                                </div>

                                <div class="col-md-12">
                                    <label >Allow user to download report </label>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($allow_report_download) && $allow_report_download == 1) ? "checked='checked'" : ""; ?> name="allow_report_download" id="allow_report_downloady" value="1">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($allow_report_download) && $allow_report_download == 0) ? "checked='checked'" : ""; ?> name="allow_report_download" id="allow_report_downloadn" value="0">
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label >Allow user to obd miscall report </label>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($is_allow_obd_miscall) && $is_allow_obd_miscall == "Y") ? "checked='checked'" : ""; ?> name="is_allow_obd_miscall" id="is_allow_obd_miscall" value="Y">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($is_allow_obd_miscall) && $is_allow_obd_miscall == "N") ? "checked='checked'" : ""; ?> name="is_allow_obd_miscall" id="is_allow_obd_miscall" value="N">
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label >Allow user to obd SMS report </label>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($is_allow_obd_sms) && $is_allow_obd_sms == "Y") ? "checked='checked'" : ""; ?> name="is_allow_obd_sms" id="is_allow_obd_sms" value="Y">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($is_allow_obd_sms) && $is_allow_obd_sms == "N") ? "checked='checked'" : ""; ?> name="is_allow_obd_sms" id="is_allow_obd_sms" value="N">
                                            No
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <label >Allow user to SMS report & API</label>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($is_allow_sms) && $is_allow_sms == "Y") ? "checked='checked'" : ""; ?> name="is_allow_sms" id="is_allow_sms" value="Y">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-radio form-radio-flat">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" <?php echo (isset($is_allow_sms) && $is_allow_sms == "N") ? "checked='checked'" : ""; ?> name="is_allow_sms" id="is_allow_sms" value="N">
                                            No
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label ></label>
                                        <div class="controls">
                                            <button type="submit" class="btn btn-success">Save user</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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

        $("#frm_add_user").validate({
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
                        url: base_url + "check-admin-user-email",
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
                    remote: "Username is already exist."
                }
            }
        });
    });
</script>