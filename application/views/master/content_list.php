<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Manage Content</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
        </div>
    </div>
      <style>
        .dataTables_filter {
            float: left !important;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <?php include APPPATH . '/views/notification.php'; ?>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($site_data as $val):
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucfirst($val->title); ?></td>
                                        <td><?php echo date('m/d/Y H:i', strtotime($val->updated_date)); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('admin/update-content/' . $val->content_id) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-edit text-success m-r-10"></i> </a>
                                        </td>

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
