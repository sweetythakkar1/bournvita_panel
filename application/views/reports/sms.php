<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">SMS Report</h4>
                        <?php if (count($results) > 0): ?>
                            <a class="btn btn-primary" href="<?php echo base_url('reports/sms_export'); ?>">Export</a>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr no#</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Mobile</th>
                                        <th>Text</th>
                                        <th>Operator</th>
                                        <th>Circle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $i = $start_from;
                                    $start = 0;
                                    foreach ($results as $val):
                                        $uses = app_users_by_id($val['user_id']);
                                        ?>
                                        <tr>
                                            <td><?php echo $i + $start; ?></td>
                                            <td><?php echo date('m-d-Y', strtotime($val['created_date'])); ?></td>
                                            <td><?php echo date('H:i:s', strtotime($val['created_date'])); ?></td>
                                            <td><?php echo $val['mobile']; ?></td>
                                            <td><?php echo $val['message']; ?></td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br/>   
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
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
                    echo form_open("delete-user-action", $form_attrs);
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
<script>
    function set_delete_value(id) {
        $("#delete_id").val(id);
    }
</script>