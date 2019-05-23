<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $title; ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php include APPPATH . '/views/notification.php'; ?>
        </div>
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30"> 
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="avatar-view" title="" id="vProfileImg">
                                <?php
                                $preview_image = "";
                                if (isset($app_users['profile_image']) && $app_users['profile_image'] != "") {
                                    if (file_exists(FCPATH . 'assets/upload/user_media/' . $app_users['profile_image'])) {
                                        $preview_image = base_url('assets/upload/user_media/' . $app_users['profile_image']);
                                    } else {
                                        $preview_image = base_url('assets/img/no_image.gif');
                                    }
                                } else {
                                    $preview_image = base_url('assets/img/no_image.gif');
                                }
                                ?>
                                <img src="<?php echo $preview_image; ?>" id="image_preview"  alt="photo" class="img-circle" width="150"></a>
                            </div>
                        </div>   
                        <h4 class="card-title m-t-10"><?php echo $app_users['first_name'] . " " . $app_users['last_name'] ?></h4>
                    </center>
                </div>
                <div>
                    <hr> 
                </div>
                <div class="card-body">
                    <small class="text-muted">Email address </small><h6><?php echo $app_users['email']; ?></h6>
                    <small class="text-muted p-t-30 db">Phone</small><h6><?php echo $app_users['phone']; ?></h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h2><strong><?php echo $title; ?></strong></h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <?php if ($app_message_master['type'] == 'S') { ?>
                                        <th>Phone</th>
                                    <?php } elseif ($app_message_master['type'] == 'E') { ?>
                                        <th>Email</th>
                                    <?php } elseif ($app_message_master['type'] == 'SE') { ?>
                                        <th>Email</th>
                                        <th>Phone</th>
                                    <?php } ?>
                                    <th>Type</th>
                                    <th>Sent On</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($app_message_log as $val):
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $val['first_name'] . " " . $val['last_name']; ?></td>
                                        <?php if ($app_message_master['type'] == 'S') { ?>
                                            <td><?php echo $val['phone']; ?></td>
                                        <?php } elseif ($app_message_master['type'] == 'E') { ?>
                                            <td><?php echo $val['email']; ?></td>
                                        <?php } elseif ($app_message_master['type'] == 'SE') { ?>
                                            <td><?php echo $val['email']; ?></td>
                                            <td><?php echo $val['phone']; ?></td>
                                        <?php } ?>
                                        <td>
                                            <?php if ($val['message_type'] == "S") { ?>
                                                <div class="label label-table label-warning">SMS</div>
                                            <?php } elseif ($val['message_type'] == "E") { ?>
                                                <div class="label label-table label-success">Email</div>
                                            <?php } elseif ($val['message_type'] == "SE") { ?>
                                                <div class="label label-table label-info">SMS & Email</div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo ($val['created_date'] != '0000-00-00 00:00:00') ? date('m/d/Y H:i', strtotime($val['created_date'])) : "-"; ?></td>
                                        <td><?php echo $val['sms']; ?></td>
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
</div>
</div>