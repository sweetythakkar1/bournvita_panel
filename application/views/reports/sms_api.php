<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update SMS API</h4>
                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_add_user", "name" => "frm_add_user");
                        echo form_open_multipart("sms-api", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >API <span class="text-danger">*</span></label>
                                    <textarea style="font-size: 22px;line-height: 35px;" class="form-control" id="sms_api_url" name="sms_api_url" placeholder="" rows="10"><?php echo isset($app_users['sms_api_url']) ? $app_users['sms_api_url'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit"  value="Submit" class="btn btn-success" style="margin-top: 25px;">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
</div>