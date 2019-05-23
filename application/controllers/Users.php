<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_login_user();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $type = $this->session->userdata('role');
        if ($type == 'A') {
            redirect(base_url('dashboard'));
        }
    }

//    site setting
    public function user_list() {
        $where = "type!='SA'";
        $data['title'] = 'Manage User';
        $data['admin_data'] = $this->common_model->getData('app_users', '*', $where);
        $data['main_content'] = $this->load->view('admin-user/list', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function add_user() {
        if (check_login_type()) {
            $data['title'] = 'Add User';
            $data['main_content'] = $this->load->view('admin-user/add-update', $data, TRUE);
            $this->load->view('index', $data);
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function update_user($id) {

//        $upd_id = $this->session->userdata('id');
//        $token = $this->session->userdata('token');
        if (check_login_type()) {
            $where = "user_id='$id'";
            $data['title'] = 'Update User';
            $data['admin_data'] = $this->common_model->getData('app_users', '*', $where)[0];
            $data['main_content'] = $this->load->view('admin-user/add-update', $data, TRUE);
            $this->load->view('index', $data);
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function add_user_action() {
        $user_id = (int) $this->input->post('user_id');
        $token = $this->session->userdata('token');

        /* Validation */
        $this->form_validation->set_rules('first_name', '', 'required|trim');
        $this->form_validation->set_rules('last_name', '', 'required|trim');
        $this->form_validation->set_rules('email', 'Username', 'required|trim|is_unique[app_users.email.user_id.' . $user_id . ']');
        $this->form_validation->set_rules('phone', '', 'required|trim|is_unique[app_users.phone.user_id.' . $user_id . ']');

        if ($user_id == 0):
            $this->form_validation->set_rules('password', '', 'required|trim');
        endif;
        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');
        if ($this->form_validation->run() == false) {
            if (isset($user_id) && $user_id > 0) {
                $this->update_user($user_id);
            } else {
                $this->add_user();
            }
        } else {
            $profile_old_image = $this->input->post('profile_image_old');
            if (isset($_FILES['profile_image']["name"]) && $_FILES['profile_image']["name"] != "") {

                if (isset($profile_old_image) && $profile_old_image != "") {
                    if (file_exists(FCPATH . 'assets/upload/user_media/' . $profile_old_image)) {
                        @unlink(FCPATH . 'assets/upload/user_media/' . $profile_old_image);
                    }
                }

                $uploadPath = 'assets/upload/user_media';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $profile_old_image = $newfilename;
            }

            if (isset($user_id) && $user_id > 0) {
                $data = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'type' => $this->input->post('type', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'is_allow_obd_miscall' => $this->input->post('is_allow_obd_miscall', TRUE),
                    'is_allow_long_code' => $this->input->post('is_allow_obd_sms', TRUE),
                    'is_allow_sms' => $this->input->post('is_allow_sms', TRUE),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'allow_report_download' => $this->input->post('allow_report_download'),
                    'profile_image' => isset($profile_old_image) ? $profile_old_image : ''
                );
                $where = "user_id='$user_id'";
                $this->common_model->update_data($data, $where, 'app_users');
                $this->session->set_flashdata('msg', "User updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $this->load->helper('string');
                $password = $this->input->post('password', TRUE);
                $data = array(
                    'token' => uniqid(),
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'password' => md5($password),
                    'phone' => $this->input->post('phone', TRUE),
                    'type' => $this->input->post('type', TRUE),
                    'created_date' => date('Y-m-d H:i:s'),
                    'profile_image' => isset($profile_old_image) ? $profile_old_image : ''
                );
                $Insert_id = $this->common_model->insert($data, 'app_users');
                $html = '';

                if ($Insert_id != '') {
                    $name = ucfirst($this->input->post('first_name')) . " " . ucfirst($this->input->post('last_name'));
                    $admin_user_email = $this->input->post('email');
                    // Header
                    $html .= '<table class="table-responsive" align="center" cellspacing = "0" cellpadding = "0" style = "width: 50%;" bgcolor = "#ffffff" >
                        <tr>
                            <td style = "background-color:#ffffff; padding-top: 15px;">
                                <center>
                                <table class="table-responsive" align="center" style = "margin: 0 auto;width: 90%;" cellspacing = "0" cellpadding = "0">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                                <br>
                                               Hi ' . $name . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:center; color: #6f6f6f; font-size: 18px;">
                                               Your account created successfully.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                    $html .= '<br><center>';
                    $html .= '<table class="table-responsive" style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                    $html .= '<tr>';
                    $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Your login credential  detail given below.</b></div></td>';
                    $html .= '</tr>';

                    $html .= '<tr>';
                    $html .= '<th style="border:1px solid #27aa90;">field </th>';
                    $html .= '<th style="border:1px solid #27aa90;">details</th>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    $html .= '<td style="border:1px solid #27aa90;">email</td>';
                    $html .= '<td style="border:1px solid #27aa90;">' . $admin_user_email . '</td>';
                    $html .= '</tr> ';
                    $html .= '<tr>';
                    $html .= '<td style="border:1px solid #27aa90;">password</td>';
                    $html .= '<td style="border:1px solid #27aa90;">' . $password . '</td>';
                    $html .= '</tr> ';
                    $html .= '</table>
                    </center>';
                    $html .= '</td>
                        </tr>
                    </table>';
                    $subject = "Account creation";
                    $define_param['to_name'] = $name;
                    $define_param['to_email'] = $admin_user_email;
                    $this->sendmail->send($define_param, $subject, $html);

                    $this->session->set_flashdata('msg', "User insert successfully");
                    $this->session->set_flashdata('msg_class', 'success');
                }
            }
            redirect('manage-user');
        }
    }

    public function delete_user_action() {
        if (check_login_type()) {
            $user_id = $this->input->post('delete_id');
            $upd_id = $this->session->userdata('id');
            $token = $this->session->userdata('token');
            $del_image = $this->common_model->getdata('app_users', 'profile_image', 'user_id=' . $user_id);
            if (isset($del_image) && count($del_image) > 0) {
                if (file_exists(FCPATH . 'assets/upload/user_media/' . $del_image[0]['profile_image'])) {
                    @unlink(FCPATH . 'assets/upload/user_media/' . $del_image[0]['profile_image']);
                }
            }
            $this->common_model->delete_user_role($user_id, 'app_users');
            $this->session->set_flashdata('msg', "User deleted successfully.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('manage-user');
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function update_user_status($value, $id) {
        if (check_login_type()) {
            $upd_id = $this->session->userdata('id');
            $token = $this->session->userdata('token');

            $status = "";

            if ($value == 'inactive') {
                $status = "I";
            } else {
                $status = "A";
            }
            $where = "user_id='$id'";
            $data['status'] = $status;
            $data['admin_data'] = $this->common_model->update_data($data, $where, 'app_users');
            redirect('manage-user');
        } else {
            $this->session->set_flashdata('msg', 'You have no rights to view this page');
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard');
        }
    }

    public function check_admin_user_email() {
        $id = (int) $this->input->post('id', true);
        $email = trim($this->input->post('email', TRUE));
        if (isset($id) && $id > 0) {
            $where = "email='$email' AND type='A' AND user_id!='$id'";
        } else {
            $where = "email='$email' AND type='A'";
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
