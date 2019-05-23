<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Random List</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr no#</th>
                                        <th>Date</th>
                                        <th>Mobile</th>
                                        <th>Circle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($results as $val):
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($val['Create_Date'])); ?></td>
                                            <td><?php echo $val['Number']; ?></td>
                                            <td><?php echo $val['Circle']; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br/>   

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
</div>
