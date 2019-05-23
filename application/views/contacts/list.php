<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Contact List</h3>
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

            <div class="card">
                <div class="card-body">

                    <a href="#" onclick="contact_select_for_msg()"  class="btn btn-info pull-right "><i class="fa fa-plus"></i> Create Message</a>
                    <a href="<?php echo site_url('add-contact') ?>" class="btn btn-primary m-r-10 pull-right"><i class="fa fa-plus"></i> Add a Contact</a>

<!--                    <a href="#" onclick="remove_all()" class="btn btn-danger pull-left"><i class="fa fa-plus"></i> Delete All</a>-->
                    <div class="table-responsive m-t-40">
                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "remove_contact_lis", "name" => "remove_contact_lis");
                        echo form_open("remove-contact-action", $form_attr);
                        ?>
                        <table id="listing_of_contact" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all_delete" name="select_all_delete" value="A" /> Select All</th>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Business</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($app_contact as $val):
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="contact_select_for_msg" id="selectfordelete" data-id="<?php echo $val['contact_id']; ?>" data-phone="<?php echo $val['phone']; ?>" data-email="<?php echo $val['email']; ?>" data-name="<?php echo ucfirst($val['first_name']) . " " . ucfirst($val['last_name']); ?>" name="selectfordelete[]" value="<?php echo $val['contact_id']; ?>"/>
                                        </td>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucfirst($val['first_name']) . " " . ucfirst($val['last_name']); ?></td>
                                        <td><?php echo $val['email']; ?></td>
                                        <td><?php echo $val['phone']; ?></td>
                                        <td><?php echo $val['business_name']; ?></td>
                                        <td>
                                            <?php if ($val['status'] == "I"): ?>
                                                <div class="label label-table label-danger">Inactive</div>
                                            <?php else: ?>
                                                <div class="label label-table label-success">Active</div>
                                            <?php endif ?>
                                        </td>
                                        <td><?php echo date('m/d/Y H:i', strtotime($val['created_date'])); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('update-contact/' . $val['contact_id']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-edit text-success m-r-10"></i> </a>
                                            <a id="delete" data-toggle="modal" data-target="#confirm_delete" href="#" onclick="set_delete_value('<?php echo $val['contact_id'] ?>')"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>
                                            <?php if ($val['status'] == "A"): ?>
                                                <a href="<?php echo site_url('update-contact-status/inactive/' . $val['contact_id']) ?>"  data-toggle="tooltip" data-original-title="Inactive"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                            <?php else: ?>
                                                <a href="<?php echo site_url('update-contact-status/active/' . $val['contact_id']) ?>" data-toggle="tooltip" data-original-title="Active"> <i class="fa fa-check text-info m-r-10"></i> </a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                        <?php echo form_close(); ?>
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
                    $form_attrs = array("class" => "form-horizontal", "id" => "delete_contact", "name" => "delete_contact");
                    echo form_open("delete-contact-action", $form_attrs);
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

<div class="modal fade" id="send_message_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Message</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-body">
                    <?php
                    $form_attrs = array("class" => "form-horizontal", "id" => "message_send_action", "name" => "message_send_action");
                    echo form_open("send-message-action", $form_attrs);
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-right"><span id="total_contact_cnt" >0</span> Contact Selected</label>
                                <div  style="height: 150px;overflow-y: scroll">
                                    <table  class="table">
                                        <tbody  id="contact_list_ids"></tbody>
                                    </table>
                                </div>
                            </div>
                            <a class="btn btn-danger pull-right" href="#" onclick="remove_contact_select_for_msg(this)">Remove Selected</a>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-right">Message Subject</label>
                                <input type="text" id="message_subject" placeholder="Message Subject" required=""  name="message_subject" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-right">Message</label>
                                <textarea id="message" class="form-control" placeholder="Message" required="" name="message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-right">Message Type</label>
                                <div class="form-check">
                                    <label class="custom-control custom-checkbox">
                                        <input name="status_sms" id="status_sms" checked="" type="checkbox" value="S"  class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Text Message</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input name="status_email" id="status_email" type="checkbox" value="E" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">E-mail</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (e) {
        $("#status_sms").click(function () {
            var ischecked = $(this).is(':checked');
            if (ischecked) {
                //$("#message_subject").val("");
                //$("#message_subject").attr("disabled", true);
            } else {
                //$("#message_subject").val("");
                //$("#message_subject").attr("disabled", false);

            }
        });
        $("#status_email").click(function () {
            var ischecked = $(this).is(':checked');
            if (ischecked) {
                $("#message_subject").val("");
                $("#message_subject").attr("disabled", false);
                $("#message_subject").attr("required", true);
            } else {
                $("#message_subject").val("");
                $("#message_subject").attr("disabled", false);
                //$("#message_subject").attr("required", false);
            }
        });
    });


//functions 
    function remove_all() {
        var numberOfChecked = $('input:checkbox:checked').length;
        if (numberOfChecked) {
            $("#remove_contact_lis").submit();
        } else {
            alert("Please select at least one contact to delete.");
        }
    }

    function contact_select_for_msg() {
        var sList = "";
        var total_contact_cnt = 0;
        $('.contact_select_for_msg').each(function () {
            if ($(this).val() != 'A' && $(this).val() != "") {
                if (this.checked) {
                    var name = $(this).data('name');
                    var email = $(this).data('email');
                    var phone = $(this).data('phone');
                    var id = $(this).data('id');
                    sList += "<tr class='tr" + total_contact_cnt + "'>";
                    sList += "<td><input type='checkbox' data-id=" + total_contact_cnt + " class='selected_contact_class'/> " + name + "";
                    sList += "<input type='hidden' data-id=" + total_contact_cnt + " value=" + id + " name='contact_users[]'/></td>";
                    sList += "<td>" + email + "</td>";
                    sList += "<td>" + phone + "</td>";
                    sList += "</tr>";
                    total_contact_cnt++;
                }
            }
        });
        if (total_contact_cnt == 0) {
            alert("Please select at least one user to send message.");
        } else {
            $("#total_contact_cnt").text(total_contact_cnt);
            $("#contact_list_ids").html(sList);
            $("#send_message_modal").modal("show");
        }
    }
    $("#select_all_delete").click(function () {
        $('.contact_select_for_msg').prop('checked', this.checked);
    });
    function remove_contact_select_for_msg($this) {
        $('.selected_contact_class').each(function () {
            var total_contact_cnt = parseInt($("#total_contact_cnt").text());
            if ($(this).val() != 'A' && $(this).val() != "") {
                if (this.checked) {
                    var id = $(this).data('id');
                    $('.tr' + id).remove();
                    $("#total_contact_cnt").text(total_contact_cnt - 1)
                }
            }
        });
    }

    $(document).ready(function () {
        $('#listing_of_contact').DataTable({
            dom: 'Bfrtip',
            "order": [[1, 'asc']],
            columnDefs: [{orderable: false, targets: [0]}]
        });
    });
</script>