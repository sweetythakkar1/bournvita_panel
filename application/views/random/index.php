<?php
$limit = $this->input->get('limit');
?><div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Random Generate</h4>

                        <?php
                        $form_attr = array("class" => "form-horizontal", "id" => "frm_search_download", "method" => "GET", "name" => "frm_search_download");
                        echo form_open_multipart("reports/random", $form_attr);
                        ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Limit <span class="text-danger">*</span></label>
                                    <input type="number" min="1" id="limit" name="limit" value="<?php echo $limit; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="hidden" name="random" value="Y"/>
                                    <input type="submit"  value="Random" class="btn btn-success" style="margin-top: 25px;">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr no#</th>
                                        <th>Date</th>
                                        <th>Mobile</th>
                                        <th>Circle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (isset($results) && count($results) > 0):
                                        foreach ($results as $val):
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($val['Create_Date'])); ?></td>
                                                <td><?php echo $val['Number']; ?></td>
                                                <td><?php echo isset($val['Circle']) ? $val['Circle'] : "-"; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br/>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
</div>