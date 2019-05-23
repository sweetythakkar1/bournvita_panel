<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_login_user();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->load->model('model_support');
    }

    public function index() {
        $id = $this->session->userdata('id');
        $data['title'] = "Dashboard";

        $circle_data = $this->db->query("SELECT IF(circle IS NULL,'Other',(circle)) as circle,COUNT(circle) as circle_cnt,(created_date) FROM `app_miscall_data` WHERE date(created_date)='" . date('Y-m-d') . "' AND user_id=" . $id . " GROUP BY circle")->result_array();

        $data_array[] = array('Circle', 'Number');
        foreach ($circle_data as $k => $val) {
            $c_value = ($val['circle'] != "") ? $val['circle'] : "Other";
            $data_array[] = array($c_value, $val['circle_cnt']);
        }



        $unique_no = $this->db->query("select COUNT(DISTINCT(`to`)) as unique_no from app_miscall_data WHERE user_id=" . $id . " AND  record_type='Miscall'")->row_array();
        $all_data_cnt = $this->db->query("select COUNT(`to`) as all_data_cnt from app_miscall_data WHERE user_id=" . $id . " AND  record_type='Miscall'")->row_array();

        $latest_app_miscall_data_date = $this->db->query("select created_date from app_miscall_data where  record_type='Miscall' AND user_id=" . $id . " order by created_date desc LIMIT 1")->row_array();
        $latest_app_sms_data_date = $this->db->query("select created_date from app_miscall_data where record_type='SMS' AND user_id=" . $id . " order by created_date desc LIMIT 1")->row_array();

        $data['obd_count_today'] = $this->db->query("select count(user_id) as total_obd from app_miscall_data where record_type='Miscall' AND  user_id=" . $id . " AND date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $data['obd_count'] = $this->db->query("select count(user_id) as total_obd from app_miscall_data where  record_type='Miscall' AND  user_id=" . $id . " order by created_date desc LIMIT 1")->row_array();

        $data['sms_count_today'] = $this->db->query("select count(user_id) as total_sms from app_miscall_data where record_type='SMS' AND  user_id=" . $id . " AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $data['sms_count'] = $this->db->query("select count(user_id) as total_sms from app_miscall_data where record_type='SMS' AND  user_id=" . $id . " order by created_date desc LIMIT 1")->row_array();

        $data['total_long_code_today'] = $this->db->query("select count(user_id) as total_long_code_today from app_miscall_data where record_type='Long Code' AND  user_id=" . $id . " AND  date(created_date)='" . date('Y-m-d') . "' ")->row_array();
        $data['total_long_code'] = $this->db->query("select count(user_id) as total_long_code from app_miscall_data where record_type='Long Code' AND  user_id=" . $id . " order by created_date desc LIMIT 1")->row_array();

        //get sms unique cnt
        $sms_unique_count = $this->db->query("select COUNT(DISTINCT(`to`)) as unique_no from app_miscall_data WHERE user_id=" . $id . " AND  record_type='SMS' AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $sms_all_count = $this->db->query("select COUNT(`to`) as all_data_cnt from app_miscall_data WHERE user_id=" . $id . " AND  record_type='SMS' AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();

        //get long code unique count
        $unique_no = $this->db->query("select COUNT(DISTINCT(`to`)) as unique_no from app_miscall_data WHERE user_id=" . $id . " AND  record_type='Miscall' AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $all_data_cnt = $this->db->query("select COUNT(`to`) as all_data_cnt from app_miscall_data WHERE user_id=" . $id . " AND  record_type='Miscall' AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();

        //get sms unique cnt
        $long_code_unique_count = $this->db->query("select COUNT(DISTINCT(`to`)) as unique_no from app_miscall_data WHERE user_id=" . $id . " AND  record_type='Long Code' AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $long_code_all_count = $this->db->query("select COUNT(`to`) as all_data_cnt from app_miscall_data WHERE user_id=" . $id . " AND  record_type='Long Code' AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();


        //get summary unique cnt
        $summary_unique_count = $this->db->query("select COUNT(DISTINCT(`to`)) as unique_no from app_miscall_data WHERE user_id=" . $id . " AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $summary_all_count = $this->db->query("select COUNT(`to`) as all_data_cnt from app_miscall_data WHERE user_id=" . $id . " AND  date(created_date)='" . date('Y-m-d') . "'")->row_array();
        $summary_todayl_count = $this->db->query("select COUNT(`to`) as all_data_cnt from app_miscall_data WHERE user_id=" . $id)->row_array();
        $data['summary_unique_count'] = (int) ($summary_unique_count['unique_no']);
        $data['summary_all_data'] = (int) ($summary_all_count['all_data_cnt']);
        $data['summary_todayl_count'] = $summary_todayl_count;



        $data['circle_data'] = $circle_data;
        $data['latest_app_miscall_data_date'] = $latest_app_miscall_data_date['created_date'];
        $data['latest_app_sms_data_date'] = $latest_app_miscall_data_date['created_date'];

        $data['unique_no'] = isset($unique_no['unique_no']) ? (int) $unique_no['unique_no'] : 0;
        $data['all_data_cnt'] = isset($all_data_cnt['all_data_cnt']) ? (int) $all_data_cnt['all_data_cnt'] : 0;
        $data['dup_data_cnt'] = (int) ((int) $all_data_cnt['all_data_cnt'] - (int) $unique_no['unique_no']);

        $data['long_code_dup_data'] = (int) ((int) $long_code_all_count['all_data_cnt'] - (int) $long_code_unique_count['unique_no']);
        $data['long_code_all_data'] = (int) ($long_code_all_count['all_data_cnt']);
        $data['long_code_unique_no'] = (int) ($long_code_unique_count['unique_no']);

        $data['sms_dup_data'] = (int) ((int) $sms_all_count['all_data_cnt'] - (int) $sms_unique_count['unique_no']);
        $data['sms_all_data'] = (int) ($sms_all_count['all_data_cnt']);
        $data['sms_unique_data'] = (int) ($sms_unique_count['unique_no']);


        $data['html_circle_string'] = $data_array;
        $data['summary_dup_data'] = (int) ((int) $summary_all_count['all_data_cnt'] - (int) $summary_unique_count['unique_no']);

        $data['main_content'] = $this->load->view('home', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function short_code() {
        $data['title'] = 'Short code';
        $data['page_title'] = 'Short code';

        $data['main_content'] = $this->load->view('short_code', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function system_log() {
        $join = array(
            array(
                "table" => "app_users",
                "condition" => "app_users.user_id=app_log_history.user_id",
                "jointype" => "INNER"),
        );

        $data = array();
        $data['page_title'] = 'Manage System Log';
        $data['title'] = 'System Log';
        if (check_login_type()):
            $data['all_log'] = $this->common_model->getData('app_log_history', 'app_log_history.*,app_users.first_name,app_users.last_name', '', $join);
        else:
            $data['all_log'] = $this->common_model->getData('app_log_history', 'app_log_history.*,app_users.first_name,app_users.last_name', 'app_log_history.user_id=' . $this->session->userdata('id'), $join);
        endif;

        $data['main_content'] = $this->load->view('system-log', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function backup() {
        if (check_login_type()) {
            $fileName = 'db_backup' . date("Ymd_Hi") . '.zip';
            $this->load->dbutil();
            $backup = & $this->dbutil->backup();
            $this->load->helper('file');
            write_file(FCPATH . '/downloads/' . $fileName, $backup);
            $this->load->helper('download');
            force_download($fileName, $backup);
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function profile() {
        $id = $this->session->userdata('id');
        $where = "user_id='$id'";
        $data['admin'] = $this->common_model->getData('app_users', '*', $where)[0];
        $data['title'] = 'My Profile';
        $data['main_content'] = $this->load->view('admin_profile', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function admin_profile_save() {
        $upd_id = $this->session->userdata('id');
        /* Request Method */
        $token = $this->session->userdata('token');

        $id = $this->input->post('user_id');
        $this->form_validation->set_rules('first_name', '', 'trim|required');
        $this->form_validation->set_rules('last_name', '', 'trim|required');
        $this->form_validation->set_rules('email', '', 'required|trim|valid_email');
        $this->form_validation->set_rules('required', 'This field is required');
        if ($this->form_validation->run() == FALSE) {
            $this->profile($id);
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'street' => $this->input->post('street', TRUE),
                'city' => $this->input->post('city', TRUE),
                'state' => $this->input->post('state', TRUE),
                'zip_code' => $this->input->post('zip_code', TRUE),
                'updated_date' => date('Y-m-d H:i:s'),
            );
            $where = "user_id='$upd_id'";
            $this->common_model->update_data($data, $where, 'app_users');
            $this->session->set_flashdata('msg', "Profile updated successfully.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('profile/');
        }
    }

    public function admin_password_change_form() {
        $data['title'] = 'Change Password';
        $data['main_content'] = $this->load->view('change_password', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function admin_change_password() {
        $upd_id = $this->session->userdata('id');

        $this->form_validation->set_rules('admin_old_password', '', 'trim|required');
        $this->form_validation->set_rules('admin_new_password', '', 'trim|required');
        $this->form_validation->set_rules('admin_confirm_password', '', 'trim|required|matches[admin_new_password]');

        $this->form_validation->set_message('required', 'This Field Is Required');

        if ($this->form_validation->run() == FALSE) {
            $this->admin_password_change_form();
        } else {
            $old_password = $this->input->post('admin_old_password', true);
            $upd_admin_password['password'] = md5($this->input->post('admin_confirm_password', true));

            $where = "password = '" . md5($old_password) . "' AND user_id='$upd_id'";
            $check_old_password = $this->model_support->getData('app_users', '*', '', $where);

            if (count($check_old_password) > 0) {
                //password match then update password
                $where = "user_id='$upd_id'";
                $this->model_support->update('app_users', $upd_admin_password, $where);
                $this->session->set_flashdata('msg', 'Your Password Updated Succesfully');
                $this->session->set_flashdata('msg_class', 'success');
                redirect('profile');
            } else {
                $this->session->set_flashdata('msg', 'Please Enter Correct  Old Password');
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('profile');
            }
        }
    }

    function admin_profile_image_save() {
        $user_id = $this->session->userdata('id');
        $profile_old_image = $this->input->post('profile_old_image');
        if (isset($_FILES['image']["name"]) && $_FILES['image']["name"] != "") {

            $uploadPath = 'assets/upload/user_media';
            $tmp_name = $_FILES["image"]["tmp_name"];
            $temp = explode(".", $_FILES["image"]["name"]);
            $newfilename = (uniqid()) . '.' . end($temp);
            move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
            $data['profile_image'] = $newfilename;

            $where = "user_id='$user_id'";
            $this->common_model->update_data($data, $where, 'app_users');

            if (isset($profile_old_image) && $profile_old_image != "") {
                if (file_exists(FCPATH . 'assets/upload/user_media/' . $profile_old_image)) {
                    @unlink(FCPATH . 'assets/upload/user_media/' . $profile_old_image);
                }
            }
            $this->session->set_flashdata('msg', 'Your Profile Image Updated Succesfully');
            $this->session->set_flashdata('msg_class', 'success');
            redirect('profile/');
        }
    }

    public function check_supply_admin_email() {
        $id = (int) $this->input->post('id', true);
        $email = trim($this->input->post('email', TRUE));
        if (isset($id) && $id > 0) {
            $where = "email='$email' AND type='SA' AND user_id!='$id'";
        } else {
            $where = "email='$email' AND type='SA'";
        }
        $check_title = $this->common_model->getData("app_users", "email", $where);
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

}
