<?php
$user_id = isset($admin['user_id']) ? $admin['user_id'] : set_value('user_id');
$first_name = isset($admin['first_name']) ? $admin['first_name'] : set_value('first_name');
$last_name = isset($admin['last_name']) ? $admin['last_name'] : set_value('last_name');
$email = isset($admin['email']) ? $admin['email'] : set_value('email');
$password = isset($admin['password']) ? $admin['password'] : set_value('password');
$phone = isset($admin['phone']) ? $admin['phone'] : set_value('phone');
$status = isset($admin['status']) ? $admin['status'] : set_value('status');
$profile_image = isset($admin['profile_image']) ? $admin['profile_image'] : set_value('profile_image');

$preview_image = "";
if (isset($profile_image) && $profile_image != "") {
    if (file_exists(FCPATH . 'assets/upload/user_media/' . $admin['profile_image'])) {
        $preview_image = base_url('assets/upload/user_media/' . $admin['profile_image']);
    } else {
        $preview_image = base_url('assets/img/no_image.gif');
    }
} else {
    $preview_image = base_url('assets/img/no_image.gif');
}
?>
<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row user-profile">
            <div class="col-lg-4 side-left d-flex align-items-stretch">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body avatar">
                                <h4 class="card-title">Info</h4>
                                <img src="<?php echo $preview_image; ?>" alt="<?php echo $first_name . " " . $last_name; ?>">
                                <p class="name"><?php echo $first_name . " " . $last_name; ?></p>
                                <a class="d-block text-center text-dark" href="#"><?php echo $email; ?></a>
                                <a class="d-block text-center text-dark" href="#"><?php echo $phone; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 stretch-card">
                        <div class="card">
                            <div class="card-body overview">
                                <ul class="achivements">
                                    <li><p>34</p><p>Projects</p></li>
                                    <li><p>23</p><p>Task</p></li>
                                    <li><p>29</p><p>Completed</p></li>
                                </ul>
                                <div class="wrapper about-user">
                                    <h4 class="card-title mt-4 mb-3">About</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam consectetur ex quod.</p>
                                </div>
                                <div class="info-links">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 side-right stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Details</h4>
                            <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-expanded="true">Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar">Avatar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security">Security</a>
                                </li>
                            </ul>
                        </div>
                        <div class="wrapper">
                            <hr>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                    <?php
                                    $form_attr = array("id" => "admin_profile_image_save", "name" => "admin_profile_image_save");
                                    echo form_open_multipart("profile-save", $form_attr);
                                    ?>
                                    <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                                    <input id="admin_id" type="hidden" name="admin_id" value="<?php echo (int) $user_id; ?>" />
                                    <input id="type" type="hidden" name="type" value="A" />
                                    <input id="token" type="hidden" name="token" value="<?php echo $this->session->userdata('token'); ?>" />
                                    <div class="form-group">
                                        <label for="name">First Name</label>
                                        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control" required>
                                        <?php echo form_error('first_name'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" required>
                                        <?php echo form_error('last_name'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required class="form-control">
                                        <?php echo form_error('phone'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"  value="<?php echo $email; ?>" class="form-control" required>
                                        <?php echo form_error('email'); ?>
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                    </form>
                                </div><!-- tab content ends -->
                                <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                                    <div class="wrapper mb-5 mt-4">
                                        <span class="badge badge-warning text-white">Note : </span>
                                        <p class="d-inline ml-3 text-muted">Image size is limited to not greater than 1MB .</p>
                                    </div>
                                    <?php
                                    $form_attr = array("class" => "form-horizontal form-material", "id" => "admin_profile_image_save", "name" => "admin_profile_image_save");
                                    echo form_open_multipart("profile-image-save", $form_attr);
                                    ?>
                                    <input type="file" class="dropify" name="image" data-max-file-size="1mb" data-default-file="<?php echo base_url('assets/img/no_image.gif'); ?>"/>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                    <?php
                                    $attr_chang_pass = array('id' => "changePassForm", 'accept-charset' => "utf-8");
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
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
</div>
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