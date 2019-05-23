<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Download Request</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr no#</th>
                                    <th>Username</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Download File</th>
                                    <th>Requested Date</th>
                                    <th>Upload File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start = 1;
                                foreach ($app_download_report as $val):
                                    ?>
                                    <tr>
                                        <td><?php echo $start; ?></td>
                                        <td><?php echo $val['first_name'] . " " . $val['last_name']; ?></td>
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
                                        <td><a href="<?php echo site_url('upload-request-file/' . $val['id']) ?>" data-toggle="tooltip" data-original-title="Active"> <i class="fa fa-upload text-info m-r-10"></i> </a></td>
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