<?php
$start_date = $this->input->get("start_date");
$end_date = $this->input->get("end_date");
?>
<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">OBD Calls Reports</h4>

                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_search_download", "name" => "frm_search_download");
                        echo form_open_multipart("reports/download_imported_export", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Start Date <span class="text-danger">*</span></label>
                                    <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >End Date <span class="text-danger">*</span></label>
                                    <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-radio form-radio-flat"  style="margin-top: 25px;">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="export_type" id="export_type_all" value="A">
                                        All
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-radio form-radio-flat" style="margin-top: 25px;">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" checked=""  name="export_type" id="export_type_unique" value="U">
                                        Unique
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="submit"  value="Download" class="btn btn-success" style="margin-top: 25px;">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr no#</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Mobile</th>
                                        <th>Audio File</th>

                                        <th>Text</th>
                                        <th>Duration</th>
                                        <th>DTMF</th>
                                        <th>Operator</th>
                                        <th>Circle</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = $start_from;
                                    $start = 0;
                                    foreach ($results as $val):
                                        $uses = app_users_by_id($val['user_id']);
                                        ?>
                                        <tr>
                                            <td><?php echo $i + $start; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($val['created_date'])); ?></td>
                                            <td><?php echo date("H:i:s", strtotime($val['created_date'])); ?></td>
                                            <td><?php echo $val['to']; ?></td>
                                            <td>
                                                <?php if (isset($val['recurl']) && $val['recurl'] != ""): ?>
                                                    <audio controls>
                                                        <source src="<?php echo $val['recurl']; ?>" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo isset($val['audio_msg_text']) ? $val['audio_msg_text'] : "-"; ?></td>
                                            <td><?php echo isset($val['duration']) ? $val['duration'] : "-"; ?></td>
                                            <td><?php echo isset($val['dtmfdetail']) ? $val['dtmfdetail'] : "-"; ?></td>
                                            <td><?php echo isset($val['operator']) ? $val['operator'] : "-"; ?></td>
                                            <td><?php echo isset($val['circle']) ? $val['circle'] : "-"; ?></td>
                                            <td><a href="<?php echo site_url('obd-details/' . $val['report_id']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-eye text-success m-r-10"></i> </a></td>
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
    function search_button() {
        $("#frm_search_download").attr("action", "<?php echo base_url('obd'); ?>");
        $("#frm_search_download").attr("method", "GET");
        if ($("#frm_search_download").valid()) {
            $("#frm_search_download").submit();
        }
    }
</script>