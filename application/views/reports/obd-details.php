<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">OBD Call Details</h4>
                        <a href="<?php echo base_url('obd'); ?>" class="btn btn-primary btn-circle pull-right"><i class="fa fa-backward"></i></a><br/>
                        <table class="table table-striped">
                            <tr>
                                <td>Sr No</td>
                                <td><?php echo $results['report_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td><?php echo date("m-d-Y", strtotime($results['created_date'])); ?></td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td><?php echo date("H:i:s", strtotime($results['created_date'])); ?></td>
                            </tr>
                            <tr>
                                <td>Source</td>
                                <td><?php echo $results['from']; ?></td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td><?php echo isset($results['to']) ? $results['to'] : "-"; ?></td>
                            </tr>
                            <tr>
                                <td>Text</td>
                                <td><?php echo isset($results['audio_msg_text']) ? $results['audio_msg_text'] : ""; ?></td>
                            </tr>
                            <tr>
                                <td>duration</td>
                                <td><?php echo isset($results['duration']) ? $results['duration'] : 0; ?></td>
                            </tr>
                            <tr>
                                <td>operator</td>
                                <td><?php echo isset($results['operator']) ? $results['operator'] : "-"; ?></td>
                            </tr>
                            <tr>
                                <td>Circle</td>
                                <td><?php echo isset($results['circle']) ? $results['circle'] : "-"; ?></td>
                            </tr>
                            <tr>
                                <td>recurl</td>
                                <td>
                                    <?php if (isset($results['recurl']) && $results['recurl'] != ""): ?>
                                        <audio controls>
                                            <source src="<?php echo $results['recurl']; ?>" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>pulse</td>
                                <td><?php echo isset($results['pulse']) ? $results['pulse'] : 0; ?></td>
                            </tr>
                        </table>
                        <br/>   
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('role') == "E"): ?>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Audio Text</h4>
                            <?php
                            $form_attr = array("class" => "pt-5", "id" => "login-form", "name" => "login-form", "method" => "post");
                            echo form_open_multipart(site_url('reports/save_audio_msg_text'), $form_attr);
                            ?>
                            <input id="report_id" type="hidden" name="report_id" value="<?php echo $results['report_id']; ?>" />
                            <div class="form-group">
                                <label for="audio_msg_text">Text</label>
                                <textarea required="" class="form-control" id="audio_msg_text" name="audio_msg_text" placeholder="Text"><?php echo trim($results['audio_msg_text']); ?></textarea>
                                <?php echo form_error('audio_msg_text'); ?>
                            </div>
                            <div class="form-group">
                                <div class="mt-5 col-md-2">
                                    <button class="btn btn-block btn-success btn-lg font-weight-medium" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- partial -->
</div>