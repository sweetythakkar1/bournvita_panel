<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_login_user();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->load->model('model_support');
    }

//    site setting
    public function email_setting() {
        if (check_login_type()) {
            $data['title'] = 'Email Settings';
            $data['email_data'] = $this->common_model->getData('app_email_setting', '*')[0];
            $data['main_content'] = $this->load->view('email_setting', $data, TRUE);
            $this->load->view('index', $data);
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function update_email() {
        if (check_login_type()) {
            $token = $this->session->userdata('token');

            $this->form_validation->set_rules('smtp_host', '', 'required');
            $this->form_validation->set_rules('smtp_username', '', 'required');
            $this->form_validation->set_rules('smtp_password', '', 'required');
            $this->form_validation->set_rules('smtp_port', '', 'required');
            $this->form_validation->set_rules('smtp_secure', '', 'required');
            $this->form_validation->set_rules('email_from_name', '', 'required');
            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');

            if ($this->form_validation->run() == false) {
                $this->email_setting();
            } else {
                $data['smtp_host'] = $this->input->post('smtp_host', true);
                $data['smtp_password'] = $this->input->post('smtp_password', true);
                $data['smtp_username'] = $this->input->post('smtp_username', true);
                $data['smtp_port'] = $this->input->post('smtp_port', true);
                $data['smtp_secure'] = $this->input->post('smtp_secure', true);
                $data['email_from_name'] = $this->input->post('email_from_name', true);
                $data = $this->security->xss_clean($data);
                $this->common_model->update($data, 1, 'app_email_setting');
                $this->session->set_flashdata('msg', "Email updated successfully.");
                $this->session->set_flashdata('msg_class', "success");
                redirect(base_url('email-setting'));
            }
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function site_setting() {
        if (check_login_type()) {
            $upd_id = $this->session->userdata('id');
            $token = $this->session->userdata('token');

            $data['title'] = 'Site Settings';
            $data['site_data'] = $this->common_model->getData('app_site_setting', '*')[0];
            $data['main_content'] = $this->load->view('site_setting', $data, TRUE);
            $this->load->view('index', $data);
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function update_site() {
        if (check_login_type()) {
            $this->form_validation->set_rules('site_name', '', 'required');
            $this->form_validation->set_rules('site_phone', '', 'required');
            $this->form_validation->set_rules('company_address', '', 'required');
            $this->form_validation->set_rules('site_email', '', 'required');
            $this->form_validation->set_rules('time_zone', '', 'required');
            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');

            if ($this->form_validation->run() == false) {
                $this->site_setting();
            } else {
                $data['site_name'] = $this->input->post('site_name', true);
                $data['site_phone'] = $this->input->post('site_phone', true);
                $data['company_address'] = $this->input->post('company_address', true);
                $data['site_email'] = $this->input->post('site_email', true);
                $data['fb_link'] = $this->input->post('fb_link', true);
                $data['insta_link'] = $this->input->post('instagram_link', true);
                $data['google_link'] = $this->input->post('google_link', true);
                $data['linkdin_link'] = $this->input->post('linkdin_link', true);
                $data['time_zone'] = $this->input->post('time_zone', true);
                $data['tanla_secret'] = $this->input->post('tanla_secret', true);
                $data['tanla_api'] = $this->input->post('tanla_api', true);
                $data['sms_key'] = $this->input->post('sms_key', true);
                $data['sms_sender'] = $this->input->post('sms_sender', true);

                $old_logo = $this->input->post('old_image');
                $old_favicon = $this->input->post('old_icon');
                if (isset($_FILES['site_logo']["name"]) && $_FILES['site_logo']["name"] != "") {
                    $uploadPath = 'assets/upload/user_media';
                    $logo_tmp_name = $_FILES["site_logo"]["tmp_name"];
                    $logo_temp = explode(".", $_FILES["site_logo"]["name"]);
                    $logo_name = uniqid();
                    $new_logo_name = $logo_name . '.' . end($logo_temp);
                    move_uploaded_file($logo_tmp_name, "$uploadPath/$new_logo_name");
                    $this->load->library('image_lib');
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $uploadPath . '/' . $new_logo_name;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 241;
                    $config['height'] = 61;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    if ($this->image_lib->resize()) {
                        $data['site_logo'] = $logo_name . "_thumb." . end($logo_temp);
                    }

                    if (isset($old_logo) && $old_logo != "") {
                        if (file_exists(FCPATH . 'assets/upload/user_media/' . $old_logo)) {
                            unlink(FCPATH . 'assets/upload/user_media/' . $old_logo);
                        }
                    }
                }
                if (isset($_FILES['fevicon_icon']["name"]) && $_FILES['fevicon_icon']["name"] != "") {
                    $uploadPath = 'assets/upload/user_media';
                    $tmp_name = $_FILES["fevicon_icon"]["tmp_name"];
                    $temp = explode(".", $_FILES["fevicon_icon"]["name"]);
                    $newfilename = (uniqid()) . '.' . end($temp);
                    move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                    $data['favicon'] = $newfilename;

                    if (isset($old_favicon) && $old_favicon != "") {
                        if (file_exists(FCPATH . 'assets/upload/user_media/' . $old_favicon)) {
                            unlink(FCPATH . 'assets/upload/user_media/' . $old_favicon);
                        }
                    }
                }

                $data = $this->security->xss_clean($data);
                $this->common_model->update($data, 1, 'app_site_setting');
                $this->session->set_flashdata('msg', "Site setting updated successfully.");
                $this->session->set_flashdata('msg_class', "success");
                redirect(base_url('site-setting'));
            }
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function manage_content() {
        if (check_login_type()) {
            $upd_id = $this->session->userdata('id');
            $token = $this->session->userdata('token');

            $request_data = array(
                'user_id' => $upd_id
            );
            $request_data = $this->security->xss_clean($request_data);
            $request_data = json_encode($request_data);
            $res = json_decode(api_request(API_URL . 'admin/get_content_list', $request_data, $token));
            if (isset($res->status) && $res->status == true) {
                $data['title'] = 'Manage Content';
                $data['site_data'] = $res->data_array;
                $data['main_content'] = $this->load->view('admin/master/content_list', $data, TRUE);
                $path = FCPATH . UPLOAD_PATH . '/sitesetting/';
                $this->load->view('index', $data);
            } else {
                $this->session->set_flashdata('msg', $res->message);
                $this->session->set_flashdata('msg_class', 'failure');
                redirect(base_url('dashboard'));
            }
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function update_content($content_id) {
        if (check_login_type()) {
            $upd_id = $this->session->userdata('id');
            $token = $this->session->userdata('token');

            $request_data = array(
                'user_id' => $upd_id,
                'content_id' => $content_id
            );
            $request_data = $this->security->xss_clean($request_data);
            $request_data = json_encode($request_data);
            $res = json_decode(api_request(API_URL . 'admin/get_content_by_id', $request_data, $token));
            if (isset($res->status) && $res->status == true) {
                $data['title'] = 'Manage Content';
                $data['site_data'] = (array) $res->data;
                $data['main_content'] = $this->load->view('admin/master/content_update', $data, TRUE);
                $this->load->view('index', $data);
            } else {
                $this->session->set_flashdata('msg', $res->message);
                $this->session->set_flashdata('msg_class', 'failure');
                redirect(base_url('manage-content'));
            }
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function update_content_action() {
        $upd_id = $this->session->userdata('id');
        $token = $this->session->userdata('token');
        $content_id = $this->input->post('content_id');

        $this->form_validation->set_rules('title', '', 'required|trim');
        $this->form_validation->set_rules('description', '', 'required|trim');
        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');

        if ($this->form_validation->run() == false) {
            $this->update_content($content_id);
        } else {
            $data['user_id'] = $upd_id;
            $data['content_id'] = $content_id;
            $data['title'] = $this->input->post('title', true);
            $data['description'] = $this->input->post('description', true);

            $data = $this->security->xss_clean($data);
            $data = json_encode($data);
            $res = json_decode(api_request(API_URL . 'admin/update_content', $data, $token));

            if (isset($res->status) && $res->status == true) {
                $this->session->set_flashdata('msg', $res->message);
                $this->session->set_flashdata('msg_class', "success");
                redirect(base_url('admin/manage-content'));
            } else {
                $this->session->set_flashdata('msg', $res->message);
                $this->session->set_flashdata('msg_class', 'failure');
                redirect(base_url('admin/manage-content'));
            }
        }
    }

}
