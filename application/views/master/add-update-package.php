<?php
$package_id = isset($app_package['package_id']) ? $app_package['package_id'] : set_value('package_id');
$title = isset($app_package['title']) ? $app_package['title'] : set_value('title');
$price = isset($app_package['price']) ? $app_package['price'] : set_value('price');
$sms = isset($app_package['sms']) ? $app_package['sms'] : set_value('sms');
$email = isset($app_package['email']) ? $app_package['email'] : set_value('email');
?>
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $title; ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php include APPPATH . '/views/notification.php'; ?>
            <div class="card card-outline-info">
                <div class="card-body">
                    <?php
                    $form_attr = array("class" => "form-horizontal", "id" => "category_form", "name" => "category_form");
                    echo form_open("add-package-action", $form_attr);
                    ?>
                    <input id="category_id" type="hidden" name="package_id" value="<?php echo $package_id; ?>" />
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Title<span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" required="" class="form-control"  value="<?php echo $title; ?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">price<span class="text-danger">*</span></label>
                                    <input type="number" min="1" id="price" name="price" required="" class="form-control"  value="<?php echo $price; ?>">
                                    <?php echo form_error('price'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">sms<span class="text-danger">*</span></label>
                                    <input type="number" min="1" id="sms" name="sms" required="" class="form-control"  value="<?php echo $sms; ?>">
                                    <?php echo form_error('sms'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">email<span class="text-danger">*</span></label>
                                    <input type="number" min="1" id="email" name="email" required="" class="form-control"  value="<?php echo $email; ?>">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                        </div>
                        <!-- CSRF token -->
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                        <hr>
                        <div class="row">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3"></label>
                                <div class="controls">
                                    <button type="submit" class="btn btn-success">Submit</button>
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
