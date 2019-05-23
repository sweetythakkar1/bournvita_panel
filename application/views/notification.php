<?php
$msg = $this->session->flashdata('msg');
$msg_class = $this->session->flashdata('msg_class');
?>
<?php if (isset($msg_class) && $msg_class == "success"): ?>
    <div class="alert alert-success delete_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $msg; ?> &nbsp;
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>
<?php endif; ?>


<?php if (isset($msg_class) && $msg_class == "failure"): ?>
    <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $msg; ?> &nbsp;
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>
<?php endif; ?>