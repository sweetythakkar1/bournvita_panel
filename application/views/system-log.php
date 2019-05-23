<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">System Log</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">System Log</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Activity</th>
                                    <th>Activity Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_log as $val):
                                    ?>
                                    <tr>

                                        <td><?php echo $val['log_id'] ?></td>
                                        <td><?php echo ucfirst($val['first_name']) . " " . ucfirst($val['first_name']); ?></td>
                                        <td><?php echo $val['details']; ?></td>
                                        <td><?php echo date('m/d/Y H:i A', strtotime($val['created_date'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
