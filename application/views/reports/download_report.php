<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Download report</h4>
                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_add_user", "name" => "frm_add_user");
                        echo form_open_multipart("download-report-action", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Start Date <span class="text-danger">*</span></label>
                                    <input type="date" id="start_date" name="start_date" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >End Date <span class="text-danger">*</span></label>
                                    <input type="date" id="end_date" name="end_date" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit"  value="Download" class="btn btn-success" style="margin-top: 25px;">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Import Data</h4>
        <?php
        $form_attr = array("class" => "form-horizontal", "id" => "frm_add_user", "name" => "frm_add_user");
        echo form_open_multipart("import-mobile-action", $form_attr);
        ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label >File <span class="text-danger">*</span></label>
                                            <input type="file" id="type" name="type" value="" class="form-control" required>
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
                </div>-->
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Download Request</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr no#</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Download File</th>
                                    <th>Requested Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start = 1;
                                foreach ($app_download_report as $val):
                                    ?>
                                    <tr>
                                        <td><?php echo $start; ?></td>
                                        <td><?php echo date("m-d-Y", strtotime($val['start_date'])); ?></td>
                                        <td><?php echo date("m-d-Y", strtotime($val['end_date'])); ?></td>

                                        <?php if ($val['status'] == 'P') { ?>
                                            <td>Processing</td>
                                        <?php } else { ?>
                                            <td>Completed</td>
                                        <?php } ?>

                                        <?php if (isset($val['download_file']) && $val['download_file'] != ""): ?>
                                            <td><a href="<?php echo $val['download_file']; ?>" download><i class="fa fa-download"></i></a></td>
                                                <?php else: ?>
                                            <td>-</td>
                                        <?php endif; ?>
                                        <td><?php echo date("m-d-Y H:i:s", strtotime($val['created_date'])); ?></td>
                                    </tr>
                                    <?php
                                    $start++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
</div>