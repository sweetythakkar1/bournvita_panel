<?php
$site_name = get_site_setting('site_name');
$upd_id = $this->session->userdata('id');
$login_user = get_user_details($upd_id);
?>
<!-- partial -->

<div class="main-panel">
    <div class="content-wrapper">
        <?php include APPPATH . '/views/notification.php'; ?>

        <?php if ($login_user['is_allow_obd_miscall'] == "Y" || $login_user['is_allow_sms'] == "Y" || $login_user['is_allow_long_code'] == "Y"): ?>
            <div class="row">
                <?php if ($login_user['is_allow_obd_miscall'] == "Y"): ?>
                    <div class="col-md-4 grid-margin">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Voice</h4>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="wrapper">
                                            <h5 class="mb-1">Today</h5>
                                            <h4 class="mb-1"><strong><?php echo isset($obd_count_today['total_obd']) ? $obd_count_today['total_obd'] : 0; ?></strong></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <div class="wrapper">
                                            <h5 class="mb-1">Total</h5>
                                            <h4 class="mb-1"><strong><?php echo isset($obd_count['total_obd']) ? $obd_count['total_obd'] : 0; ?></strong></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($login_user['is_allow_sms'] == "Y"): ?>
                    <div class="col-md-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Message</h4>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="wrapper">
                                            <h5 class="mb-1">Today</h5>
                                            <h4 class="mb-1"><strong><?php echo isset($sms_count_today['total_sms']) ? $sms_count_today['total_sms'] : 0; ?></strong></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <div class="wrapper">
                                            <h5 class="mb-1">Total</h5>
                                            <h4 class="mb-1"><strong><?php echo isset($sms_count['total_sms']) ? $sms_count['total_sms'] : 0; ?> </strong></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($login_user['is_allow_long_code'] == "Y"): ?>
                    <div class="col-md-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">SMS</h4>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="wrapper">
                                            <h5 class="mb-1">Today</h5>
                                            <h4 class="mb-1"><strong><?php echo isset($total_long_code_today['total_long_code_today']) ? $total_long_code_today['total_long_code_today'] : 0; ?></strong></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <div class="wrapper">
                                            <h5 class="mb-1">Total</h5>
                                            <h4 class="mb-1"><strong><?php echo isset($total_long_code['total_long_code']) ? $total_long_code['total_long_code'] : 0; ?></strong></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-4 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Summary</h4>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="wrapper">
                                        <h5 class="mb-1">Today</h5>
                                        <h4 class="mb-1"><strong><?php echo isset($summary_all_data) ? $summary_all_data : 0; ?></strong></h4>
                                    </div>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <div class="wrapper">
                                        <h5 class="mb-1">Total</h5>
                                        <h4 class="mb-1"><strong><?php echo isset($summary_todayl_count['all_data_cnt']) ? $summary_todayl_count['all_data_cnt'] : 0; ?> </strong></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($login_user['is_allow_obd_miscall'] == "Y" || $login_user['is_allow_sms'] == "Y" || $login_user['is_allow_long_code'] == "Y"): ?>
            <?php if ($login_user['is_allow_obd_miscall'] == "Y"): ?>
                <div class="row">
                    <div class="col-lg-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Unique Mobile</h4>
                                <div class="google-chart-container">
                                    <div id="voice_unique_chart" class="google-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($login_user['is_allow_long_code'] == "Y"): ?>
                    <div class="col-lg-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Unique SMS</h4>
                                <div class="google-chart-container">
                                    <div id="lc_unique_chart" class="google-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($login_user['is_allow_sms'] == "Y"): ?>
                    <div class="col-lg-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Unique Message</h4>
                                <div class="google-chart-container">
                                    <div id="sms_unique_chart" class="google-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-lg-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Unique Summary</h4>
                            <div class="google-chart-container">
                                <div id="summary_unique_chart" class="google-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Circle Report</h4>
                        <div class="google-chart-container d-flex align-items-center justify-content-center h-100">
                            <div id="Bar-charts" class="google-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(draw_voice);
    google.charts.setOnLoadCallback(draw_sms);
    google.charts.setOnLoadCallback(draw_lc);
    google.charts.setOnLoadCallback(draw_summary);

    function draw_voice() {
        var data = google.visualization.arrayToDataTable([
            ['Number', 'Hours per Day'],
            ['Unique',<?php echo $unique_no; ?>],
            ['Duplicate', <?php echo $dup_data_cnt; ?>]
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#76C1FA', '#63CF72', '#F36368', '#FABA66'],
            chartArea: {
                width: 500
            },
        };

        var Donutchart = new google.visualization.PieChart(document.getElementById('voice_unique_chart'));
        Donutchart.draw(data, options);
    }
    function draw_sms() {
        var data = google.visualization.arrayToDataTable([
            ['Number', 'Hours per Day'],
            ['Unique',<?php echo $sms_unique_data; ?>],
            ['Duplicate', <?php echo $sms_dup_data; ?>]
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#76C1FA', '#63CF72', '#F36368', '#FABA66'],
            chartArea: {
                width: 500
            },
        };

        var Donutchart = new google.visualization.PieChart(document.getElementById('sms_unique_chart'));
        Donutchart.draw(data, options);
    }
    function draw_lc() {
        var data = google.visualization.arrayToDataTable([
            ['Number', 'Hours per Day'],
            ['Unique',<?php echo $long_code_unique_no; ?>],
            ['Duplicate', <?php echo $long_code_dup_data; ?>]
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#76C1FA', '#63CF72', '#F36368', '#FABA66'],
            chartArea: {
                width: 500
            },
        };

        var Donutchart = new google.visualization.PieChart(document.getElementById('lc_unique_chart'));
        Donutchart.draw(data, options);
    }
    function draw_summary() {
        var data = google.visualization.arrayToDataTable([
            ['Number', 'Hours per Day'],
            ['Unique',<?php echo $summary_unique_count; ?>],
            ['Duplicate', <?php echo $summary_dup_data; ?>]
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#76C1FA', '#63CF72', '#F36368', '#FABA66'],
            chartArea: {
                width: 500
            },
        };

        var Donutchart = new google.visualization.PieChart(document.getElementById('summary_unique_chart'));
        Donutchart.draw(data, options);
    }

    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.arrayToDataTable(<?php echo json_encode($html_circle_string, JSON_NUMERIC_CHECK) ?>);

        var options = {
            title: '',
            legend: {
                position: 'none'
            },
            colors: ['#76C1FA'],
            chartArea: {
                width: 401
            },
            hAxis: {
                ticks: [-1, -0.75, -0.5, -0.25, 0, 0.25, 0.5, 0.75, 1]
            },
            bar: {
                gap: 0
            },
            histogram: {
                bucketSize: 0.02,
                maxNumBuckets: 200,
                minValue: -1,
                maxValue: 1
            }
        };

        var chart = new google.charts.Bar(document.getElementById('Bar-charts'));
        chart.draw(data, options);
    }
</script>