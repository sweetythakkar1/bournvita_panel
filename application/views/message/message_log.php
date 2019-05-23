<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Message Log</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php include APPPATH . '/views/notification.php'; ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 25px;">No</th>
                                    <th  style="width: 200px;">Date Sent</th>
                                    <th>Subject</th>
                                    <th style="width: 25px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($app_message_master as $val):
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ($val['created_date'] != '0000-00-00 00:00:00') ? date('d F', strtotime($val['created_date'])) : "-"; ?></td>
                                        <td><?php echo $val['subject']; ?></td>
                                        <td class="text-center"><a data-id="<?php echo $val['message_id']; ?>" onclick="get_view_modal(this)" href="#"><i class="fa fa-expand text-success m-r-10"></i> </a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Content -->
</div>

<div class="modal fade" id="confirm_delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-body">
                    <?php
                    $form_attrs = array("class" => "form-horizontal", "id" => "delete_user", "name" => "delete_user");
                    echo form_open("delete-client-action", $form_attrs);
                    ?>
                    <input id="delete_id" type="hidden" name="delete_id" value=""/>
                    Are you sure want to delete? <br> <hr>

                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="send_message_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Message</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-body" id="send_message_modal_body">

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (e) {

    });

    function get_view_modal($this) {
        var id = $($this).attr('data-id');

        $.ajax({
            url: '<?php echo base_url('message_view_modal/'); ?>' + id,
            type: 'POST',
            data: {csrf_test_name: csrf_token},
            success: function (data) {
                $("#send_message_modal_body").html(data);
                $("#send_message_modal").modal('show');
            }
        });
    }
</script>