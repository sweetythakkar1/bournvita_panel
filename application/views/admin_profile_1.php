<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $title; ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <?php include APPPATH . '/views/notification.php'; ?>
        </div>
        <?php
        foreach ($admin as $admin_data):
            if (isset($admin_data['profile_image']) && $admin_data['profile_image']) {
                if (file_exists(FCPATH . 'assets/upload/user_media/' . $admin_data['profile_image'])) {
                    $preview_image = base_url('assets/upload/user_media/' . $admin_data['profile_image']);
                } else {
                    $preview_image = base_url('assets/admin/images/users/1.jpg');
                }
            } else {
                $preview_image = base_url('assets/admin/images/users/1.jpg');
            }
            ?>
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="m-t-30"> 
                            <h4 class="card-title m-t-10"><?php echo $admin_data['first_name'] . " " . $admin_data['last_name'] ?> </h4>
                            <h6 class="card-subtitle"><?php echo ($admin_data['type'] == "SA") ? "Super Admin" : "Admin"; ?> </h6>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $form_attr = array("class" => "form-horizontal form-material", "id" => "admin_profile_image_save", "name" => "admin_profile_image_save");
                                echo form_open_multipart("profile-image-save", $form_attr);
                                ?>
                                <input type="hidden" id="profile_old_image" name="profile_old_image" value="<?php echo $admin_data['profile_image']; ?>"/>
                                <input type="file" id="image" onchange="readURL(this)" name="image" class="form-control"  style="<?php echo ($preview_image != '') ? 'display:none' : ''; ?>" >
                                <button type="button" id="cancel" class="btn btn-danger" style="display:none; margin-top: 0.3em;"><i class="fa fa-times"></i></button>

                                <div class="avatar-view" title="" id="vProfileImg">
                                    <img src="<?php echo $preview_image; ?>" id="image_preview"  alt="photo" class="img-responsive" width="150">
                                    <hr/>
                                    <button type="button" id="change" class="btn btn-success"><i class="fa fa-repeat"></i></button>
                                </div>

                                <?php echo form_close(); ?>
                            </div>   

                        </center>
                    </div>
                    <div>
                        <hr> 
                    </div>
                    <div class="card-body"> <small class="text-muted">Email address </small>
                        <h6><?php echo $admin_data['email']; ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                        <h6><?php echo $admin_data['phone']; ?></h6> <small class="text-muted p-t-30 db">Address</small>
                        <h6><?php echo ($admin_data['street'] != "") ? $admin_data['street'] : ""; ?></h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h2><strong><?php echo $title; ?></strong></h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $form_attr = array("class" => "form-horizontal form-material", "id" => "admin_form", "name" => "admin_form");
                        echo form_open("profile-save", $form_attr);
                        ?>
                        <input  type="hidden" id="user_id" name="user_id" value="<?php echo ($admin_data['user_id']) ? $admin_data['user_id'] : set_value('user_id'); ?>"/>
                        <div class="form-group">
                            <label class="col-md-12">First Name</label>
                            <div class="col-md-12">
                                <input type="text" id="first_name" name="first_name"  class="form-control form-control-line" value="<?php echo $admin_data['first_name']; ?>">
                                <?php echo form_error('first_name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Last Name</label>
                            <div class="col-md-12">
                                <input type="text" id="last_name" name="last_name" class="form-control form-control-line" value="<?php echo $admin_data['last_name']; ?>">
                                <?php echo form_error('last_name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email"  id="email" name="email" class="form-control form-control-line" name="email" id="example-email" value="<?php echo $admin_data['email']; ?>">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Phone No</label>
                            <div class="col-md-12">
                                <input type="text" id="phone" name="phone" class="form-control form-control-line" value="<?php echo $admin_data['phone']; ?>">
                                <?php echo form_error('phone'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Street</label>
                            <div class="col-md-12">
                                <input type="text" id="street" name="street" class="form-control form-control-line" value="<?php echo $admin_data['street']; ?>">
                                <?php echo form_error('street'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">City</label>
                            <div class="col-md-12">
                                <input type="text" id="city" name="city" class="form-control form-control-line" value="<?php echo $admin_data['city']; ?>">
                                <?php echo form_error('city'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">State</label>
                            <div class="col-md-12">
                                <input type="text" id="state" name="state" class="form-control form-control-line" value="<?php echo $admin_data['state']; ?>">
                                <?php echo form_error('state'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Zip Code</label>
                            <div class="col-md-12">
                                <input type="text" id="zip_code" name="zip_code" class="form-control form-control-line" value="<?php echo $admin_data['zip_code']; ?>">
                                <?php echo form_error('zip_code'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit">Update Profile</button>
                                <!--<button class="btn btn-success" onclick="updateProfile(this)">Update Profile</button>-->
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Column -->

</div>
<!-- Row -->
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<script>
    site_url = '<?php echo base_url(); ?>';
//    function updateProfile(e) {
//        var id = $("#admin_id").val();
//        $.ajax({
//            type: 'post',
//            url: site_url + 'update-admin/' + id,
//            data: $("#admin_form").serialize(),
//            success: function (data) {
//                if (data == "success") {
//                    window.location.reload();
//                } else {
//                    window.location.reload();
//                }
//
//            }
//        });
//    }

    function readURL(input) {
        var id = $(input).attr("id");
        var image = '#' + id;
        //alert(image);
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            var reader = new FileReader();
        reader.onload = function (e) {
            $('#image_preview').attr('src', e.target.result);
            $('#image_preview,#vProfileImg').css('display', "block");
            $("#admin_profile_image_save").submit();
        }
        reader.readAsDataURL(input.files[0]);
    }
    $(document).ready(function (e) {
        $('#change').click(function () {
            $('#image').show();
            $('#vProfileImg').hide();
            $('#cancel').show();
            $('#change').hide();
            $('#hiddenval').val('0');
        });

        $('#cancel').click(function () {
            $('#image').hide();
            $('#vProfileImg').show();
            $('#cancel').hide();
            $('#change').show();
            $('#hiddenval').val('1');
        });
    });
    $(document).ready(function () {

        $("#admin_form").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                state: {
                    required: true
                },
                phone: {
                    required: true
                },
                street: {
                    required: true
                },
                city: {
                    required: true
                },
                zip_code: {
                    required: true
                },
                email: {
                    required: true,
                    remote: {
                        url: base_url + "check-supply-admin-email",
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