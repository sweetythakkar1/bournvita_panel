<?php
$content_id = isset($site_data['content_id']) ? $site_data['content_id'] : set_value('content_id');
$title = isset($site_data['title']) ? $site_data['title'] : set_value('title');
$description = isset($site_data['description']) ? $site_data['description'] : set_value('description');
?>

<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Update Content</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('admin/manage-content'); ?>">Home</a></li>
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
                    $form_attr = array("class" => "form-horizontal", "id" => "update_content", "name" => "update_content");
                    echo form_open_multipart("update-content-action", $form_attr);
                    ?>
                    <input id="content_id" type="hidden" name="content_id" value="<?php echo $content_id; ?>" />
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Title <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" required="">
                                        <?php echo form_error('title'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Content <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">

                                        <textarea id="description" class="form-control" required="" name="description">
                                            <?php echo $description; ?>
                                        </textarea>
                                        <?php echo form_error('description'); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>


                        <!-- CSRF token -->
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3"></label>
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Submit</button>
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
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>