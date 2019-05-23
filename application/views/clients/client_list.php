<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Client</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
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
            <p><b>Total Clients: <?php echo isset($client) ? $client : 0 ?></b></p>
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo site_url('add-client') ?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add New Client</a>
                    <div class="table-responsive">
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Profile</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Last Login</th>
                                        <th>Subscription</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($client_data as $val):
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($val['first_name']) . " " . ucfirst($val['last_name']); ?></td>
                                            <td><?php echo $val['email']; ?></td>
                                            <td><?php echo $val['phone']; ?></td>
                                            <td>
                                                <?php
                                                $preview_image = "";
                                                if (isset($val['profile_image']) && $val['profile_image'] != "") {
                                                    if (file_exists(FCPATH . 'assets/upload/user_media/' . $val['profile_image'])) {
                                                        $preview_image = base_url('assets/upload/user_media/' . $val['profile_image']);
                                                    } else {
                                                        $preview_image = base_url('assets/img/no_image.gif');
                                                    }
                                                } else {
                                                    $preview_image = base_url('assets/img/no_image.gif');
                                                }
                                                ?>
                                                <img src="<?php echo $preview_image; ?>" class="img-circle" width="50" height="50"/>
                                            </td>
                                            <td>
                                                <?php if ($val['status'] == "I"): ?>
                                                    <div class="label label-table label-danger">Inactive</div>
                                                <?php else: ?>
                                                    <div class="label label-table label-success">Active</div>
                                                <?php endif ?>
                                            </td>

                                            <td><?php echo date('m/d/Y H:i', strtotime($val['created_date'])); ?></td>
                                            <td><?php echo ($val['last_login'] != '0000-00-00 00:00:00') ? date('m/d/Y H:i', strtotime($val['last_login'])) : "-"; ?></td>
                                            <td><a class="btn btn-info btn-sm" href="<?php echo site_url('manage-subscription/' . $val['user_id']) ?>">Manage Subscription</a></td>
                                            <td>
                                                <a href="<?php echo site_url('update-client/' . $val['user_id']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-edit text-success m-r-10"></i> </a>
                                                <a id="delete" data-toggle="modal" data-target="#confirm_delete" href="#" onclick="set_delete_value('<?php echo $val['user_id'] ?>')"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>
                                                <?php if ($val['status'] == "A"): ?>
                                                    <a href="<?php echo site_url('update-client-status/inactive/' . $val['user_id']) ?>"  data-toggle="tooltip" data-original-title="Inactive"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                                <?php else: ?>
                                                    <a href="<?php echo site_url('update-client-status/active/' . $val['user_id']) ?>" data-toggle="tooltip" data-original-title="Active"> <i class="fa fa-check text-info m-r-10"></i> </a>
                                                <?php endif ?>
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
