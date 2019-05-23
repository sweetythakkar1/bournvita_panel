<?php
$status = set_value('status');
$message = set_value('message');
?>
<style>
    .btn-group label{
        color: #000 !important;
    }
</style>
<link href="<?php echo base_url('assets/css/inbox.css'); ?>" rel="stylesheet">
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Message</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('message'); ?>">Manage Client</a></li>
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
                    $form_attr = array("class" => "form-horizontal", "id" => "add_message_form", "name" => "add_message_form");
                    echo form_open_multipart("send-message-action", $form_attr);
                    ?>
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Contact <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <a class="btn btn-primary" href="#"  data-toggle="collapse" data-target="#pid_block_2" aria-expanded="true" aria-controls="collapse1">Contact's</a>
                                        <div id="pid_block_2" class="collapse col-md-12" aria-labelledby="heading1" data-parent="#accordion">
                                            <hr/>
                                            <div class="table-responsive">
                                                <table id="listing_of_contact" class="table table-inbox table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($app_contact as $val): ?>
                                                            <tr class="">
                                                                <td class="inbox-small-cells">
                                                                    <input type="checkbox" name="contact_user[]" value="<?php echo $val['contact_id'] ?>" class="mail-checkbox">
                                                                </td>
                                                                <td class="view-message dont-show"><?php echo $val['first_name'] . " " . $val['last_name'] ?></td>
                                                                <td class="view-message"><?php echo $val['email']; ?></td>
                                                                <td class="view-message"><?php echo $val['phone']; ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php echo form_error('contact_user'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Message <span class="text-danger">*</span></label>
                                    <div class="col-md-9 controls">
                                        <textarea placeholder="Enter your message here..." onkeyup="countChar(this)" id="message" name="message" rows="10" class="form-control"><?php echo isset($message) ? $message : ""; ?></textarea>
                                        <?php echo form_error('message'); ?>
                                        <span id="charNum">(Characters Left 500)</span>
                                    </div>

                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Message Type <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input name="status" type="radio" value="S" <?php echo ($status == 'S') ? "checked=''" : "checked"; ?>  class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">SMS</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input name="status" type="radio" <?php echo ($status == 'E') ? "checked=''" : ""; ?> value="E" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Email</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input name="status" type="radio" <?php echo ($status == 'SE') ? "checked=''" : ""; ?> value="SE" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">SMS & Email</span>
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
                                        <button type="submit" class="btn btn-success">Send</button>
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
<link href="<?php echo base_url('assets/js/bootstrap-multiselect.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/bootstrap-multiselect.js'); ?>"></script>
<script>
                                            $("#contact_user").multiselect({
                                                includeSelectAllOption: true,
                                                enableClickableOptGroups: true,
                                                enableFiltering: true
                                            });
                                            function countChar(val) {
                                                const limit = 500;
                                                var len = val.value.length;

                                                if (len > limit) {
                                                    val.value = val.value.substring(0, limit);
                                                } else {
                                                    $('#charNum').text('(Characters Left ' + (limit - len) + ')');
                                                }
                                            }

                                            $(document).ready(function () {
                                                $('#listing_of_contact').DataTable({
                                                    dom: 'Bfrtip',
                                                    "order": [[1, 'asc']],
                                                    columnDefs: [{orderable: false, targets: [0]}]
                                                });
                                                $("#add_message_form").validate({
                                                    rules: {
                                                        contact_user: {
                                                            required: true
                                                        },
                                                        message: {
                                                            required: true
                                                        },
                                                    }
                                                });
                                            });
</script>