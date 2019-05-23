<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    const export_per_page = 2500;

    public function __construct() {
        parent::__construct();
        check_login_user();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $type = $this->session->userdata('role');
        $this->load->library('pagination');
        set_time_limit(0);

        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '-1');
    }

    public function obd() {
        $id = $this->session->userdata('id');
        $start_date = $this->input->get("start_date");
        $end_date = $this->input->get("end_date");
        $mobile = $this->input->get("mobile");
        $export_type = $this->input->get("export_type");

        $where = "user_id=" . $id . " AND record_type='Miscall'";
        if (isset($start_date) && $start_date != "" && isset($end_date) && $end_date != ""):
            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";
        endif;

        if (isset($mobile) && $mobile != ""):
            $where .= " AND `to`='" . $mobile . "' ";
        endif;

        $config = array();
        $config["base_url"] = base_url() . "reports/obd";

        if ($export_type == 'U') {
            $total_rows = $this->db->query("select (`to`) as total_obd from app_miscall_data where " . $where . " GROUP BY `to`")->result_array();
            $total_record_data = count($total_rows);
        } else {
            $total_row = $this->db->query("select count(user_id) as total_obd from app_miscall_data where " . $where . "   order by created_date desc LIMIT 1")->row_array();
            $total_record_data = $total_row['total_obd'];
        }


        $config["total_rows"] = $total_record_data;
        $data["total_rows"] = $total_record_data;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = true;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="active page-link"  href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $offset = 0;
        if ($this->uri->segment(3)) {
            $page = (int) ($this->uri->segment(3));
            $offset = ($page - 1);
        } else {
            $page = 0;
        }


        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['title'] = 'OBD Report';

        if ($page == 0) {
            $page1 = 1;
            $start_from = ($page1 - 1) * $config["per_page"] + 1;
        } else {
            $start_from = ($page - 1) * $config["per_page"] + 1;
        }

        $data['start_from'] = $start_from;
        if ($export_type == 'U') {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to` order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        } else {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        }

        $data['main_content'] = $this->load->view('reports/obd', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function summary_report() {
        $id = $this->session->userdata('id');
        $start_date = $this->input->get("start_date");
        $end_date = $this->input->get("end_date");
        $mobile = $this->input->get("mobile");
        $export_type = $this->input->get("export_type");

        $where = "user_id=" . $id;
        if (isset($start_date) && $start_date != "" && isset($end_date) && $end_date != ""):
            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";
        endif;

        if (isset($mobile) && $mobile != ""):
            $where .= " AND `to`='" . $mobile . "' ";
        endif;



        $config = array();
        $config["base_url"] = base_url() . "reports/summary_report";

        if ($export_type == 'U') {
            $total_rows = $this->db->query("select (`to`) as total_obd from app_miscall_data where " . $where . " GROUP BY `to`")->result_array();
            $total_record_data = count($total_rows);
        } else {
            $total_row = $this->db->query("select count(user_id) as total_obd from app_miscall_data where " . $where . "   order by created_date desc LIMIT 1")->row_array();
            $total_record_data = $total_row['total_obd'];
        }

        $config["total_rows"] = $total_record_data;
        $data["total_rows"] = $total_record_data;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = true;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="active page-link"  href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $offset = 0;
        if ($this->uri->segment(3)) {
            $page = (int) ($this->uri->segment(3));
            $offset = ($page - 1);
        } else {
            $page = 0;
        }

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['title'] = 'Summary Report';

        if ($page == 0) {
            $page1 = 1;
            $start_from = ($page1 - 1) * $config["per_page"] + 1;
        } else {
            $start_from = ($page - 1) * $config["per_page"] + 1;
        }

        $data['start_from'] = $start_from;

        if ($export_type == 'U') {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to` order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        } else {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        }

        $data['main_content'] = $this->load->view('reports/summary_report', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function sms_all() {
        $id = $this->session->userdata('id');
        $start_date = $this->input->get("start_date");
        $end_date = $this->input->get("end_date");
        $mobile = $this->input->get("mobile");
        $export_type = $this->input->get("export_type");

        $where = "user_id=" . $id . " AND record_type='SMS'";
        if (isset($start_date) && $start_date != "" && isset($end_date) && $end_date != ""):
            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";
        endif;


        if (isset($mobile) && $mobile != ""):
            $where .= " AND `to`='" . $mobile . "' ";
        endif;


        $config = array();
        $config["base_url"] = base_url() . "reports/sms_all";

        if ($export_type == 'U') {
            $total_row = $this->db->query("select COUNT(DISTINCT(`to`)) as total_obd from app_miscall_data where " . $where . " GROUP BY `to` order by created_date desc LIMIT 1")->row_array();
        } else {
            $total_row = $this->db->query("select count(user_id) as total_obd from app_miscall_data where " . $where . "   order by created_date desc LIMIT 1")->row_array();
        }

        $config["total_rows"] = $total_row['total_obd'];
        $data["total_rows"] = $total_row['total_obd'];
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = true;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="active page-link"  href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $offset = 0;
        if ($this->uri->segment(3)) {
            $page = (int) ($this->uri->segment(3));
            $offset = ($page - 1);
        } else {
            $page = 0;
        }
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['title'] = 'Message';

        if ($page == 0) {
            $page1 = 1;
            $start_from = ($page1 - 1) * $config["per_page"] + 1;
        } else {
            $start_from = ($page - 1) * $config["per_page"] + 1;
        }

        $data['start_from'] = $start_from;
        if ($export_type == 'U') {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to` order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        } else {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        }
        $data['main_content'] = $this->load->view('reports/sms-all', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function long_code() {
        $id = $this->session->userdata('id');
        $start_date = $this->input->get("start_date");
        $end_date = $this->input->get("end_date");
        $mobile = $this->input->get("mobile");
        $export_type = $this->input->get("export_type");

        $where = "user_id=" . $id . " AND record_type='Long Code'";
        if (isset($start_date) && $start_date != "" && isset($end_date) && $end_date != ""):
            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";
        endif;

        if (isset($mobile) && $mobile != ""):
            $where .= " AND `to`='" . $mobile . "' ";
        endif;

        $config = array();
        $config["base_url"] = base_url() . "reports/long_code";



        if ($export_type == 'U') {
            $total_rows = $this->db->query("select (`to`) as total_obd from app_miscall_data where " . $where . " GROUP BY `to`")->result_array();
            $total_record_data = count($total_rows);
        } else {
            $total_row = $this->db->query("select count(user_id) as total_sms from app_miscall_data where " . $where . "   order by created_date desc LIMIT 1")->row_array();
            $total_record_data = $total_row['total_sms'];
        }


        $config["total_rows"] = $total_record_data;
        $data["total_rows"] = $total_record_data;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = true;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="active page-link"  href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $offset = 0;
        if ($this->uri->segment(3)) {
            $page = (int) ($this->uri->segment(3));
            $offset = ($page - 1);
        } else {
            $page = 0;
        }

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['title'] = 'SMS';

        if ($page == 0) {
            $page1 = 1;
            $start_from = ($page1 - 1) * $config["per_page"] + 1;
        } else {
            $start_from = ($page - 1) * $config["per_page"] + 1;
        }

        $data['start_from'] = $start_from;
        if ($export_type == 'U') {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to` order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        } else {
            $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " order by created_date desc LIMIT " . $config["per_page"] . " OFFSET " . ($config["per_page"] * $offset))->result_array();
        }

        $data['main_content'] = $this->load->view('reports/long_code', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function obd_details($param) {
        $data['results'] = $this->db->query("SELECT * FROM app_miscall_data WHERE report_id=" . $param)->row_array();
        $data['main_content'] = $this->load->view('reports/obd-details', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function save_audio_msg_text() {
        $report_id = $this->input->post('report_id');
        $audio_msg_text = $this->input->post('audio_msg_text');

        $datas['audio_msg_text'] = $audio_msg_text;
        $wheres = "report_id=" . $report_id;

        $this->common_model->update_data($datas, $wheres, 'app_miscall_data');
        $this->session->set_flashdata('msg', "Audio text has been saved successfully.");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('obd');
    }

    public function obd_export() {
        $per_page_data = self::export_per_page;
        $id = $this->session->userdata('id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $export_type = $this->input->post('export_type');
        $mobile = $this->input->post("mobile");

        if ($end_date < $start_date) {
            $this->session->set_flashdata('msg', "End date must be greater or equal to start date..");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('obd');
        } else {
            $where = "user_id=" . $id . " AND record_type='Miscall'";

            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";

            if (isset($mobile) && $mobile != ""):
                $where .= " AND `to`='" . $mobile . "' ";
            endif;

            if ($export_type == 'U'):
                $qry = "SELECT count(DISTINCT(`to`)) as cnt FROM app_miscall_data WHERE " . $where;
            else:
                $qry = "SELECT count(`to`) as cnt FROM app_miscall_data WHERE " . $where;
            endif;

            $results_cnt = $this->db->query($qry)->row_array();

            if (isset($results_cnt['cnt']) && $results_cnt['cnt'] > 0) {

                $total_record = $results_cnt['cnt'];
                $total_page = ceil($total_record / $per_page_data);

                $delimiter = ",";
                $filename = "report.csv";
                //create a file pointer
                $f = fopen('php://memory', 'w');

                //set column headers
                $fields = array('Date', 'Time', 'Mobile No', 'Text', 'Duration', 'DTMF', 'Operator', 'Circle');
                fputcsv($f, $fields, $delimiter);


                for ($i = 1; $i <= $total_page; $i++):
                    if ($i == 1):
                        $offset = 0;
                    else:
                        $offset = ($per_page_data * ($i - 1));
                    endif;

                    if ($export_type == 'U'):
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to`  LIMIT " . $offset . "," . $per_page_data)->result_array();
                    else:
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " LIMIT " . $offset . "," . $per_page_data)->result_array();
                    endif;

                    if (count($results) > 0) {
                        foreach ($results as $val):
                            $lineData = array(date("d-M-y", strtotime($val['created_date'])), date("H:i:s", strtotime($val['created_date'])), $val['to'], $val['audio_msg_text'], $val['duration'], $val['dtmfdetail'], $val['operator'], $val['circle']);
                            fputcsv($f, $lineData, $delimiter);
                        endforeach;
                    }
                endfor;

                //move back to beginning of file
                fseek($f, 0);
                //set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                //output all remaining data on a file pointer
                fpassthru($f);
            }else {
                $this->session->set_flashdata('msg', "No record found.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('obd');
            }
        }
    }

    public function sms_export() {
        $per_page_data = self::export_per_page;
        $id = $this->session->userdata('id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $export_type = $this->input->post('export_type');
        $mobile = $this->input->post("mobile");

        if ($end_date < $start_date) {
            $this->session->set_flashdata('msg', "End date must be greater or equal to start date..");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('sms-all');
        } else {
            $where = "user_id=" . $id . " AND record_type='SMS'";

            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";

            if (isset($mobile) && $mobile != ""):
                $where .= " AND `to`='" . $mobile . "' ";
            endif;

            if ($export_type == 'U'):
                $qry = "SELECT count(DISTINCT(`to`)) as cnt FROM app_miscall_data WHERE " . $where;
            else:
                $qry = "SELECT count(`to`) as cnt FROM app_miscall_data WHERE " . $where;
            endif;

            $results_cnt = $this->db->query($qry)->row_array();

            if (isset($results_cnt['cnt']) && $results_cnt['cnt'] > 0) {

                $total_record = $results_cnt['cnt'];
                $total_page = ceil($total_record / $per_page_data);

                $delimiter = ",";
                $filename = "sms.csv";
                //create a file pointer
                $f = fopen('php://memory', 'w');

                //set column headers
                $fields = array('Date', 'Time', 'Mobile No', 'Text', 'Duration', 'DTMF', 'Operator', 'Circle');
                fputcsv($f, $fields, $delimiter);


                for ($i = 1; $i <= $total_page; $i++):
                    if ($i == 1):
                        $offset = 0;
                    else:
                        $offset = ($per_page_data * ($i - 1));
                    endif;

                    if ($export_type == 'A'):
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to`  LIMIT " . $offset . "," . $per_page_data)->result_array();
                    else:
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " LIMIT " . $offset . "," . $per_page_data)->result_array();
                    endif;

                    if (count($results) > 0) {
                        foreach ($results as $val):
                            $lineData = array(date("d-M-y", strtotime($val['created_date'])), date("H:i:s", strtotime($val['created_date'])), $val['to'], $val['audio_msg_text'], $val['duration'], $val['dtmfdetail'], $val['operator'], $val['circle']);
                            fputcsv($f, $lineData, $delimiter);
                        endforeach;
                    }
                endfor;

                //move back to beginning of file
                fseek($f, 0);
                //set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                //output all remaining data on a file pointer
                fpassthru($f);
            }else {
                $this->session->set_flashdata('msg', "No record found.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('sms-all');
            }
        }
    }

    public function long_code_export() {
        $per_page_data = self::export_per_page;
        $id = $this->session->userdata('id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $export_type = $this->input->post('export_type');
        $mobile = $this->input->post("mobile");

        if ($end_date < $start_date) {
            $this->session->set_flashdata('msg', "End date must be greater or equal to start date..");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('long-code');
        } else {
            $where = "user_id=" . $id . " AND record_type='Long Code'";

            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";

            if (isset($mobile) && $mobile != ""):
                $where .= " AND `to`='" . $mobile . "' ";
            endif;

            if ($export_type == 'U'):
                $qry = "SELECT count(DISTINCT(`to`)) as cnt FROM app_miscall_data WHERE " . $where;
            else:
                $qry = "SELECT count(`to`) as cnt FROM app_miscall_data WHERE " . $where;
            endif;

            $results_cnt = $this->db->query($qry)->row_array();

            if (isset($results_cnt['cnt']) && $results_cnt['cnt'] > 0) {

                $total_record = $results_cnt['cnt'];
                $total_page = ceil($total_record / $per_page_data);

                $delimiter = ",";
                $filename = "long_code.csv";
                //create a file pointer
                $f = fopen('php://memory', 'w');

                //set column headers
                $fields = array('Date', 'Time', 'Mobile No', 'Text', 'Duration', 'DTMF', 'Operator', 'Circle');
                fputcsv($f, $fields, $delimiter);


                for ($i = 1; $i <= $total_page; $i++):
                    if ($i == 1):
                        $offset = 0;
                    else:
                        $offset = ($per_page_data * ($i - 1));
                    endif;

                    if ($export_type == 'U'):
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . "  GROUP BY `to`  LIMIT " . $offset . "," . $per_page_data)->result_array();
                    else:
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " LIMIT " . $offset . "," . $per_page_data)->result_array();
                    endif;

                    if (count($results) > 0) {
                        foreach ($results as $val):
                            $lineData = array(date("d-M-y", strtotime($val['created_date'])), date("H:i:s", strtotime($val['created_date'])), $val['to'], $val['message'], $val['duration'], $val['dtmfdetail'], $val['operator'], $val['circle']);
                            fputcsv($f, $lineData, $delimiter);
                        endforeach;
                    }
                endfor;

                //move back to beginning of file
                fseek($f, 1);
                //set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                //output all remaining data on a file pointer
                fpassthru($f);
            }else {
                $this->session->set_flashdata('msg', "No record found.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('long-code');
            }
        }
    }

    public function summary_report_export() {
        $per_page_data = self::export_per_page;
        $id = $this->session->userdata('id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $export_type = $this->input->post('export_type');
        $mobile = $this->input->post("mobile");

        if ($end_date < $start_date) {
            $this->session->set_flashdata('msg', "End date must be greater or equal to start date..");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('summary-report');
        } else {
            $where = "user_id=" . $id;

            $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";

            if (isset($mobile) && $mobile != ""):
                $where .= " AND `to`='" . $mobile . "' ";
            endif;

            if ($export_type = 'U'):
                $qry = "SELECT count(DISTINCT(`to`)) as cnt FROM app_miscall_data WHERE " . $where;
            else:
                $qry = "SELECT count(`to`) as cnt FROM app_miscall_data WHERE " . $where;
            endif;

            $results_cnt = $this->db->query($qry)->row_array();

            if (isset($results_cnt['cnt']) && $results_cnt['cnt'] > 0) {

                $total_record = $results_cnt['cnt'];
                $total_page = ceil($total_record / $per_page_data);

                $delimiter = ",";
                $filename = "summary_report.csv";
                //create a file pointer
                $f = fopen('php://memory', 'w');

                //set column headers
                $fields = array('Date', 'Time', 'Mobile No', 'Text', 'Duration', 'DTMF', 'Operator', 'Circle');
                fputcsv($f, $fields, $delimiter);


                for ($i = 1; $i <= $total_page; $i++):
                    if ($i == 1):
                        $offset = 0;
                    else:
                        $offset = ($per_page_data * ($i - 1));
                    endif;

                    if ($export_type == 'U'):
                        $results = $this->db->query("SELECT DISTINCT(`to`),ANY_VALUE(circle) as circle,ANY_VALUE(operator) as  operator,ANY_VALUE(audio_msg_text),ANY_VALUE(dtmfdetail),ANY_VALUE(duration),ANY_VALUE(created_date) as created_date FROM app_miscall_data WHERE " . $where . "  GROUP BY `to`  LIMIT " . $offset . "," . $per_page_data)->result_array();
                    else:
                        $results = $this->db->query("SELECT * FROM app_miscall_data WHERE " . $where . " LIMIT " . $offset . "," . $per_page_data)->result_array();
                    endif;

                    if (count($results) > 0) {
                        foreach ($results as $val):
                            $lineData = array(date("d-M-y", strtotime($val['created_date'])), date("H:i:s", strtotime($val['created_date'])), $val['to'], $val['audio_msg_text'], $val['duration'], $val['dtmfdetail'], $val['operator'], $val['circle']);
                            fputcsv($f, $lineData, $delimiter);
                        endforeach;
                    }
                endfor;

                //move back to beginning of file
                fseek($f, 0);
                //set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                //output all remaining data on a file pointer
                fpassthru($f);
            }else {
                $this->session->set_flashdata('msg', "No record found.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('summary-report');
            }
        }
    }

    public function download_report() {
        $id = $this->session->userdata('id');
        $login_user = get_user_details($id);

        if ($login_user['allow_report_download'] == 1):
            $app_download_report = $this->common_model->getdata('app_download_report', '*', 'user_id=' . $id);
            $data['title'] = "Download Report";
            $data['app_download_report'] = $app_download_report;
            $data['main_content'] = $this->load->view('reports/download_report', $data, TRUE);
            $this->load->view('index', $data);
        else:
            $this->session->set_flashdata('msg', "You don't have rights to view this.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        endif;
    }

    public function download_request() {
        $id = $this->session->userdata('id');
        $app_download_report = $this->db->query("select app_users.first_name,app_users.last_name,app_download_report.* from app_download_report inner join app_users ON app_users.user_id=app_download_report.user_id")->result_array();

        $data['title'] = "Download Report Request";
        $data['app_download_report'] = $app_download_report;
        $data['main_content'] = $this->load->view('reports/download_request', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function upload_request_file($id) {
        $data['title'] = "Upload File";
        $data['id'] = $id;
        $data['main_content'] = $this->load->view('reports/upload_file', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function upload_request_file_action() {
        $id = $this->input->post('id', TRUE);
        if (isset($_FILES['type']["name"]) && $_FILES['type']["name"] != "") {

            $uploadPath = 'assets/upload/report';
            $tmp_name = $_FILES["type"]["tmp_name"];
            $temp = explode(".", $_FILES["type"]["name"]);
            $newfilename = (uniqid()) . '.' . end($temp);
            move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
            $file = base_url($uploadPath . "/" . $newfilename);

            $where = "id=" . $id;
            $datas['status'] = "C";
            $datas['download_file'] = $file;
            $this->common_model->update_data($datas, $where, 'app_download_report');
            $this->session->set_flashdata('msg', "File has been uploaded.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect("download-request");
        }
    }

    public function download_report_action() {
        $id = $this->session->userdata('id');
        $data = array(
            'user_id' => $id,
            'start_date' => $this->input->post('start_date', TRUE),
            'end_date' => $this->input->post('end_date', TRUE),
            'created_date' => date("Y-m-d H:i:s"),
        );

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if ($end_date < $start_date) {
            $this->session->set_flashdata('msg', "End date must be greater or equal to start date..");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('download-report');
        } else {
            $Insert_id = $this->common_model->insert($data, 'app_download_report');
            if ($Insert_id > 0) {
                $this->session->set_flashdata('msg', "Download report will be available within 24hr.");
                $this->session->set_flashdata('msg_class', 'success');
                redirect("download-report");
            }
        }
    }

    public function download_report_action_old() {
        if ($_POST) {
            $per_page_data = 2500;
            $id = $this->session->userdata('id');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');

            if ($end_date < $start_date) {
                $this->session->set_flashdata('msg', "End date must be greater or equal to start date..");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('download-report');
            } else {

                $where = "user_id=" . $id;
                $where .= " AND date(created_date) >= '" . $start_date . "' AND  date(created_date)<='" . $end_date . "'";
                $results_cnt = $this->db->query("SELECT count(DISTINCT(`to`)) as cnt FROM app_miscall_data WHERE " . $where)->row_array();
                $total_record = $results_cnt['cnt'];
                $total_page = ceil($total_record / $per_page_data);

                $delimiter = ",";
                $filename = "report.csv";
                //create a file pointer
                $f = fopen('php://memory', 'w');

                //set column headers
                $fields = array('Mobile No', 'Circle', 'Operator');
                fputcsv($f, $fields, $delimiter);


                for ($i = 1; $i <= $total_page; $i++):
                    if ($i == 1):
                        $offset = 0;
                    else:
                        $offset = ($per_page_data * ($i - 1));
                    endif;

                    $results = $this->db->query("SELECT DISTINCT(`to`),circle,operator FROM app_miscall_data WHERE " . $where . "  LIMIT " . $offset . "," . $per_page_data)->result_array();
                    if (count($results) > 0) {
                        foreach ($results as $val):
                            $lineData = array($val['to'], $val['circle'], $val['operator']);
                            fputcsv($f, $lineData, $delimiter);
                        endforeach;
                    }
                endfor;

                //move back to beginning of file
                fseek($f, 0);
                //set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                //output all remaining data on a file pointer
                fpassthru($f);
            }
        }
    }

    public function import_mobile_action() {
        $id = $this->session->userdata('id');
        $this->load->library('excel');
        if (isset($_FILES["type"]["name"])) {
            $path = $_FILES["type"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $datas = 0;
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $phone = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $circel = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $results_cnt = $this->db->query("SELECT count(`to`) as cnt FROM app_unique_mobile WHERE `to`='" . $phone . "'")->row_array();

                    if ($results_cnt['cnt'] > 0):
                        $app_miscall_data['status'] = "Already Exist";
                    else:
                        $app_miscall_data['status'] = "Valid";
                    endif;
                    $app_miscall_data['to'] = $phone;
                    $app_miscall_data['user_id'] = $id;
                    $app_miscall_data['circle'] = isset($circel) ? $circel : "";
                    $app_miscall_data['created_date'] = date('Y-m-d', strtotime($worksheet->getCellByColumnAndRow(0, $row)->getValue()));
                    $this->db->insert("app_unique_mobile", $app_miscall_data);
                    $datas++;
                }
            }
            $this->session->set_flashdata('msg', $datas . " record has been imported.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('download-report');
        }
    }

    public function sms_api() {
        $id = $this->session->userdata('id');
        if (!empty($_POST)) {
            $sms_api_url = $this->input->post('sms_api_url');
            $where = "user_id=" . $id;
            $dataup['sms_api_url'] = $sms_api_url;
            $this->common_model->update_data($dataup, $where, 'app_users');

            $this->session->set_flashdata('msg', "API updated");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('sms-api');
        }

        $data = array();
        $data['page'] = 'SMS API';

        $app_users = $this->db->query("SELECT * FROM app_users WHERE `user_id`=" . $id)->row_array();
        $data['app_users'] = $app_users;
        $data['main_content'] = $this->load->view('reports/sms_api', $data, TRUE);
        $this->load->view('index', $data);
    }

}
