<?php
$start_date = $this->input->get("start_date");
$end_date = $this->input->get("end_date");
$mobile = $this->input->get("mobile");

$export_typeval = $this->input->get("export_type");
$export_type = (isset($export_typeval) && $export_typeval != "") ? $this->input->get("export_type") : "A";
?>
<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">SMS Report</h4> Total Record :  <?php echo isset($total_rows) ? $total_rows : 0; ?>
                        <hr/>

                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_search_download", "name" => "frm_search_download");
                        echo form_open_multipart("reports/long_code_export", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Mobile</label>
                                    <input type="text" id="mobile" name="mobile" value="<?php echo $mobile; ?>" class="form-control">
                                </div>
                            </div>
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
                            <div class="col-md-2" style="margin-top: -8px;">
                                <label >Type</label>
                                <select class="form-control" id="export_type" name="export_type">
                                    <option value="A" <?php echo ($export_type == 'A') ? "selected='selected'" : ""; ?>>All</option>
                                    <option value="U" <?php echo ($export_type == 'U') ? "selected='selected'" : ""; ?>>Unique</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit"  value="Download" class="btn btn-success" style="margin-top: 25px;">
                                    <input type="button" onclick="search_button()"  value="Search" class="btn btn-primary" style="margin-top: 25px;">
                                    <a  class="btn btn-info btn-xs"  href="<?php echo base_url("long-code"); ?>" style="margin-top: 25px;"><i class="fa fa-refresh"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th  style="width: 90px;">Sr no#</th>
                                        <th  style="width: 118px;">Date</th>
                                        <th  style="width: 118px;">Time</th>
                                        <th  style="width: 118px;">Mobile</th>
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
                                            <td><?php echo date('d/m/Y', strtotime($val['created_date'])); ?></td>
                                            <td><?php echo date('H:i:s', strtotime($val['created_date'])); ?></td>
                                            <td><?php echo $val['to']; ?></td>
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
    function search_button() {
        $("#frm_search_download").attr("action", "<?php echo base_url('long-code'); ?>");
        $("#frm_search_download").attr("method", "GET");
        if ($("#frm_search_download").valid()) {
            $("#frm_search_download").submit();
        }
    }
</script>