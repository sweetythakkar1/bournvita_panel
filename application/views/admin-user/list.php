<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a href="<?php echo site_url('add-user') ?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add New User</a>
                        <h4 class="card-title">Manage Users</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Token</th>
                                        <th>Username</th>
                                        <th>Profile</th>
                                        <th>Role</th>
                                        <th>Created Date</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($admin_data as $val):
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($val['first_name']) . " " . ucfirst($val['last_name']); ?></td>
                                            <td><?php echo $val['token']; ?> <a href="javascript:void(0)" onclick="copy('<?php echo $val['token']; ?>')" class="btn btn-info btn-sm" style="padding: 2px;font-size: 12px;">Copy</a></td>
                                            <td><?php echo $val['email']; ?></td>
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
                                                <?php if ($val['type'] == "A") { ?>
                                                    <div class="label label-table label-success">Admin</div>
                                                <?php } elseif ($val['type'] == "E") { ?>
                                                    <div class="label label-table label-success">Executive</div>
                                                <?php } elseif ($val['type'] == "U") { ?>
                                                    <div class="label label-table label-success">User</div>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo date('m/d/Y h:i', strtotime($val['created_date'])); ?></td>
                                            <td><?php echo ($val['last_login'] != '0000-00-00 00:00:00') ? date('m/d/Y h:i', strtotime($val['last_login'])) : "-"; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('update-user/' . $val['user_id']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-edit text-success m-r-10"></i> </a>
                                                <a id="delete" data-toggle="modal" data-target="#confirm_delete" href="#" onclick="set_delete_value('<?php echo $val['user_id'] ?>')"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>
                                                <?php if ($val['status'] == "A"): ?>
                                                    <a href="<?php echo site_url('update-user-status/inactive/' . $val['user_id']) ?>"  data-toggle="tooltip" data-original-title="Inactive"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                                <?php else: ?>
                                                    <a href="<?php echo site_url('update-user-status/active/' . $val['user_id']) ?>" data-toggle="tooltip" data-original-title="Active"> <i class="fa fa-check text-info m-r-10"></i> </a>
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
    function copy(text) {
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input)
        return result;
    }
</script>