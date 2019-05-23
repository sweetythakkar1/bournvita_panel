<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload Report File</h4>
                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_add_user", "name" => "frm_add_user");
                        echo form_open_multipart("upload-request-file-action", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >File <span class="text-danger">*</span></label>
                                    <input type="file" id="type" name="type" value="" class="form-control" required>
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
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