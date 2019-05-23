<?php
$type = $this->session->userdata('role');
?>
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php include APPPATH . '/views/notification.php'; ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="<?php echo base_url('manage-contacts'); ?>">
                <div class="card">
                    <div class="d-flex flex-row">
                        <div class="p-10 bg-success">
                            <h3 class="text-white box m-b-0"><i class="fa fa-user-circle fa-2x"></i></h3></div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-info"><?php echo isset($contacts) ? $contacts : 0; ?></h3>
                            <h5 class="text-muted m-b-0">Total Contacts</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>