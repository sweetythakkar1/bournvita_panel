<?php
$sms_check = "";
$email_check = "";
if (isset($app_message_master['type']) && $app_message_master['type'] == 'S'):
    $sms_check = "checked=''";
endif;

if (isset($app_message_master['type']) && $app_message_master['type'] == 'E'):
    $email_check = "checked=''";
endif;

if (isset($app_message_master['type']) && $app_message_master['type'] == 'SE'):
    $sms_check = "checked=''";
    $email_check = "checked=''";
endif;
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label text-right"><span id="total_contact_cnt" ><?php echo count($app_message_log); ?></span> Contact Selected</label>
            <div  style="height: 150px;overflow-y: scroll">
                <table  class="table">
                    <tbody >
                        <?php foreach ($app_message_log as $val): ?>
                            <tr>
                                <td><?php echo $val['first_name'] . " " . $val['last_name']; ?></td>
                                <td><?php echo $val['email']; ?></td>
                                <td><?php echo $val['phone']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label text-right">Message Subject</label>
            <input type="text" id="message_subject"  placeholder="Message Subject" required=""  name="message_subject" value="<?php echo isset($app_message_master['subject']) ? $app_message_master['subject'] : ""; ?>" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label text-right">Message</label>
            <textarea id="message" class="form-control" placeholder="Message" required="" name="message"><?php echo isset($app_message_master['message']) ? $app_message_master['message'] : ""; ?></textarea>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label text-right">Message Type</label>
            <div class="form-check">
                <label class="custom-control custom-checkbox">
                    <input name="status_sms" id="status_sms" <?php echo $sms_check; ?> type="checkbox" value="S"  class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Text Message</span>
                </label>
                <label class="custom-control custom-checkbox">
                    <input name="status_email" id="status_email"  <?php echo $email_check; ?>  type="checkbox" value="E" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">E-mail</span>
                </label>
            </div>
        </div>
    </div>
</div>