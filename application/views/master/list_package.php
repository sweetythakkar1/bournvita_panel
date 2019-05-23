<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $title; ?></h3>
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
                                    <th>Package Name</th>
                                    <th>Price</th>
                                    <th>SMS Limit</th>
                                    <th>E-mail Limit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($app_package as $val):
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $val['title']; ?></td>
                                        <td>$<?php echo $val['price']; ?></td>
                                        <td><?php echo $val['sms']; ?></td>
                                        <td><?php echo $val['email']; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('update-package/' . $val['package_id']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-edit text-success m-r-10"></i> </a>
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
                    $form_attrs = array("class" => "form-horizontal", "id" => "delete_category", "name" => "delete_category");
                    echo form_open("admin/delete-category-action", $form_attrs);
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
