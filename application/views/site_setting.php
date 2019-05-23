<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Site Setting</h4>
                        <?php
                        $form_attr = array("class" => "form-horizontal form-material", "id" => "frm_site_form", "name" => "frm_site_form");
                        echo form_open_multipart("update-site", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Site Name : <small class="required">*</small></label>
                                    <div class="col-md-12">
                                        <input type="text" id="site_name" name="site_name"  class="form-control form-control-line" value="<?php echo $site_data['site_name']; ?>">
                                        <?php echo form_error('site_name'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Site Phone :<small class="required">*</small></label>
                                    <div class="col-md-12">
                                        <input type="text" id="site_phone" name="site_phone" class="form-control form-control-line" value="<?php echo $site_data['site_phone']; ?>">
                                        <?php echo form_error('site_phone'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Address :<small class="required">*</small></label>
                                    <div class="col-md-12">
                                        <input type="text" id="company_address" name="company_address"  class="form-control form-control-line" value="<?php echo $site_data['company_address']; ?>" />
                                        <?php echo form_error('company_address'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Site Email : <small class="required">*</small></label>
                                    <div class="col-md-12">
                                        <input type="text" id="site_email" name="site_email" class="form-control form-control-line" value="<?php echo $site_data['site_email']; ?>">
                                        <?php echo form_error('site_email'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Facebook Link :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="fb_link" name="fb_link" placeholder="https://www.example.com" class="form-control form-control-line" value="<?php echo $site_data['fb_link']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Instagram Link : </label>
                                    <div class="col-md-12">
                                        <input type="text" id="instagram_link" name="instagram_link" placeholder="https://www.example.com"  class="form-control form-control-line" value="<?php echo $site_data['insta_link']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Google+ Link :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="google_link" name="google_link" placeholder="https://www.example.com" class="form-control form-control-line" value="<?php echo $site_data['google_link']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Linkdin Link : </label>
                                    <div class="col-md-12">
                                        <input type="text" id="linkdin_link" name="linkdin_link" placeholder="https://www.example.com"  class="form-control form-control-line" value="<?php echo $site_data['linkdin_link']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Time Zone:</label>
                                    <div class="col-md-12">
                                        <select id="time_zone" name="time_zone" class="form-control">
                                            <?php foreach (tz_list() as $t) { ?>
                                                <option value="<?php echo $t['zone']; ?>" <?php echo $site_data['time_zone'] == $t['zone'] ? 'selected' : ''; ?>><?php echo $t['diff_from_GMT'] . ' - ' . $t['zone']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_input(array('type' => 'hidden', 'name' => 'old_image', 'id' => 'old_image', 'value' => $site_data['site_logo'])); ?>
                                    <label class="col-md-12">Select Logo : <small class="required">*</small> </label>
                                    <div class="col-md-6 mb-3">
                                        <?php
                                        if ($site_data['site_logo'] != '' && file_exists(FCPATH . USER_MEDIA . $site_data['site_logo'])) {
                                            $logo_img = base_url() . USER_MEDIA . $site_data['site_logo'];
                                        } else {
                                            $logo_img = base_url() . NO_USER_PATH;
                                        }
                                        ?>
                                        <img id="imageurl"  class="img" src="<?php echo $logo_img; ?>" alt="Image" height="100">
                                    </div>
                                    <div class="file-field">
                                        <div class="btn btn-primary btn-sm">
                                            <span>Select image</span>
                                            <input onchange="readURL(this)" id="imageurl"   type="file" name="site_logo" accept="image/x-png,image/gif,image/jpeg,image/png"  extension="jpg|png|gif|jpeg" />
                                        </div>
                                        <div class="file-path-wrapper" >
                                            <input class="file-path form-control validate readonly" readonly type="text" placeholder="upload logo" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="col-md-12">Favicon Icon :</label>
                                    <?php echo form_input(array('type' => 'hidden', 'name' => 'old_icon', 'id' => 'old_icon', 'value' => $site_data['favicon'])); ?>
                                    <div class="col-md-6 mb-3">
                                        <div class=" d-inline-block position-relative">
                                            <?php
                                            if ($site_data['favicon'] != '' && file_exists(FCPATH . USER_MEDIA . $site_data['favicon'])) {
                                                $favicon_img = base_url() . USER_MEDIA . $site_data['favicon'];
                                            } else {
                                                $favicon_img = base_url() . NO_USER_PATH;
                                            }
                                            ?>
                                            <img id="imageurl2"  class="img"  src="<?php echo $favicon_img; ?>" alt="Image" height="100">
                                        </div>
                                    </div>
                                    <div class="file-field ">
                                        <div class="btn btn-primary btn-sm">
                                            <span >Select Image</span>
                                            <input onchange="readURL2(this)"  id="imageurl2"   type="file" name="fevicon_icon" accept="jpg|png|gif|jpeg|image/x-ico,image/x-icon,image/vnd-microsoft.icon"/>
                                        </div>
                                        <div class="file-path-wrapper" >
                                            <input class="file-path form-control validate readonly" readonly type="text" placeholder="upload your file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Tanla API Key :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="tanla_api" name="tanla_api" placeholder="Key" class="form-control form-control-line" value="<?php echo $site_data['tanla_api']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Tanla API Sectet : </label>
                                    <div class="col-md-12">
                                        <input type="text" id="tanla_secret" name="tanla_secret" placeholder="Secret"  class="form-control form-control-line" value="<?php echo $site_data['tanla_secret']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">SMS API Key :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="sms_key" name="sms_key" placeholder="API Key" class="form-control form-control-line" value="<?php echo $site_data['sms_key']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">SMS Sender: </label>
                                    <div class="col-md-12">
                                        <input type="text" id="sms_sender" name="sms_sender" placeholder="SMS Sender"  class="form-control form-control-line" value="<?php echo $site_data['sms_sender']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success" >Update</button>
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
    // Profile Image On Click Function 
    function readURL(input) {
        var id = $(input).attr("id");
        var image = '#' + id;
        //alert(image);
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            var reader = new FileReader();
        reader.onload = function (e) {
            $('img' + image).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    // Icon Image On Click Function 
    function readURL2(input) {
        var id = $(input).attr("id");
        var icon = '#' + id;
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "ico" || ext == "x-ico" || ext == "x-icon" || ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            var reader = new FileReader();
        reader.onload = function (e) {
            $('img' + icon).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }


</script>


