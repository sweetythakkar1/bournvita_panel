<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('common_model');
        date_default_timezone_set(get_time_zone());
    }

    public function index() {
        $is_login = $this->session->userdata('is_login');
        if (isset($is_login) && $is_login == 1) {
            redirect('dashboard');
        } else {
            $data = array();
            $data['page'] = 'Login';
            $this->load->view('login', $data);
        }
    }

    public function login_action() {
        if ($_POST) {
            $this->form_validation->set_rules('user_name', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['page'] = 'Login';
                $this->load->view('login');
            } else {
                $data = array(
                    'email' => $this->input->post('user_name'),
                    'password' => $this->input->post('password')
                );
                $data = $this->security->xss_clean($data);
                $query = $this->login_model->authentication($data);
               
                if ($query) {
                    $upd_id = $this->session->userdata('id');
                    $datas = array(
                        'last_login' => date("Y-m-d H:i:s")
                    );

                    $wheres = "user_id=" . $upd_id;
                    $this->common_model->update_data($datas, $wheres, 'app_users');

                    $this->session->set_flashdata('msg', "You have logged in successfully.");
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('msg', "Your login credential is invalid.");
                    $this->session->set_flashdata('msg_class', 'failure');
                    $this->load->view('login');
                }
            }

            $query = $this->login_model->validate_user();
        } else {
            $data['title'] = 'Login';
            $this->load->view('login', $data);
        }
    }

    function logout() {
        $this->session->sess_destroy();
        $data = array();
        $data['page'] = 'logout';
        $this->load->view('login', $data);
    }

    function recover() {
        $is_login = $this->session->userdata('is_login');
        if (isset($is_login) && $is_login == 1) {
            redirect('dashboard');
        }
        $data = array();
        $data['page'] = 'Forgot Password';
        $this->load->view('recover', $data);
    }

    function reset_password($token) {
        $data['page'] = 'reset_password';
        $data['token'] = $token;
        $this->load->view('reset_password', $data);
    }

    public function forgot_password() {
        $this->form_validation->set_rules('email', '', 'required|trim|valid_email');
        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');
        if ($this->form_validation->run() == false) {
            $this->recover();
        } else {
            $email = $this->input->post('email', TRUE);
            $where = "email='$email'";
            $check_email = $this->common_model->getData('app_users', '*', $where)[0];
            if (isset($check_email) && count($check_email) > 0) {
                $user_id = $check_email['user_id'];
                $user_email = $check_email['email'];
                $user_name = ucfirst($check_email['first_name']) . " " . ucfirst($check_email['last_name']);

                $encid = $this->general->encryptData($user_id);
                $encemail = $this->general->encryptData($user_email);
                $url = base_url("reset-password/" . $encid . "/" . $encemail);

                $update['reset_password_check'] = 0;
                $update['reset_password_requested_date'] = date("Y-m-d H:i:S");
                $where_id = "user_id='$user_id'";
                $this->common_model->update_data($update, $where_id, "app_users");
                // Header
                $email_data['URL'] = $url;
                $email_data['USER'] = $user_name;
                $html = $this->load->view('email-template/forgot_password', $email_data, true);

                $subject = get_CompanyName() . ", Reset Password";
                $define_param['to_name'] = $user_name;
                $define_param['to_email'] = $user_email;
                $this->sendmail->send($define_param, $subject, $html);

                $this->session->set_flashdata('msg', "Reset password link has been sent on your registered email.");
                $this->session->set_flashdata('msg_class', 'success');
                redirect('Auth');
            } else {
                redirect('recover/');
            }
        }
    }

    //show reset password 
    public function reset_password_admin($id_ency = '', $email_ency = '') {
        $id_ency = $this->uri->segment(2);
        $email_ency = $this->uri->segment(3);

        $id = (int) $this->general->decryptData($id_ency);
        $email = $this->general->decryptData($email_ency);
        $admin_data = $this->common_model->getData("app_users", "*", "user_id='" . $id . "' AND email='" . $email . "'")[0];
        if (isset($admin_data) && count($admin_data) > 0 && !empty($admin_data)) {
            $h_id = $admin_data['user_id'];
            $add_min = date("Y-m-d H:i:s", strtotime($admin_data['reset_password_requested_date'] . "+1 hour"));
            if ($add_min > date("Y-m-d H:i:s")) {
                if ($admin_data['reset_password_check'] != 1) {
                    $data['title'] = "Reset Password";
                    $data['user_id'] = $id;
                    $this->load->view('reset_password', $data);
                } else {
                    $this->session->set_flashdata('msg', "Reset password link has been expired. Please try again.");
                    $this->session->set_flashdata('msg_class', "failure");
                    redirect('forgot-password');
                }
            } else {
                $this->session->set_flashdata('msg', "Reset password link has been expired. Please try again.");
                $this->session->set_flashdata('msg_class', "failure");
                redirect('forgot-password');
            }
        } else {
            $this->session->set_flashdata('msg', 'Invalid request');
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
    }

    public function reset_password_action() {

        $user_id = $this->input->post('user_id');
        $this->form_validation->set_rules('password', '', 'required|trim');
        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');
        if ($this->form_validation->run() == false) {
            $this->reset_password($token);
        } else {
            $data = array(
                'password' => md5($this->input->post('password', TRUE)),
            );
            $where_id = "user_id='$user_id'";
            $update_id = $this->common_model->update_data($data, $where_id, "app_users");
            if (isset($update_id) && $update_id != '') {
                $this->session->set_flashdata('msg', 'Password reset successfully.');
                $this->session->set_flashdata('msg_class', 'success');
                redirect('auth');
            } else {
                $this->session->set_flashdata('msg', 'Password not reset');
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('recover');
            }
        }
    }

    public function register() {
        $data['title'] = 'Register';
        $this->load->view('register', $data);
    }

    public function register_action() {

        $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[app_users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[app_users.phone.user_id]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('state', 'State', 'required|trim');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required|trim');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required|trim');
        $this->form_validation->set_rules('cvc', 'CVC', 'required|trim');
        $this->form_validation->set_rules('month', 'Month', 'required|trim');
        $this->form_validation->set_rules('year', 'Year', 'required|trim');

        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');
        $start_date = date('Y-m-d H:i:s');
        $membership_till = date('Y-m-d H:i:s', strtotime('+7 day'));
        if ($this->form_validation->run() == false) {
            $this->register();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'password' => md5($this->input->post('password', TRUE)),
                'type' => 'C',
                'sms_send' => 1,
                'email_send' => 1,
                'membership_till' => $membership_till,
                'status' => 'E'
            );


            //check for paypal credit card details
            $sta = '{
                    "number": ' . $this->input->post('card_number', TRUE) . ',
                    "type":' . $this->input->post('payment_type', TRUE) . ',
                    "expire_month"' . $this->input->post('month', TRUE) . ',
                    "expire_year": ' . $this->input->post('year', TRUE) . ',
                    "first_name":' . $this->input->post('first_name', TRUE) . ',
                    "last_name":' . $this->input->post('last_name', TRUE) . ',
                    "billing_address": {
                      "line1": ' . $this->input->post('billing_address', TRUE) . ',
                      "city": ' . $this->input->post('city', TRUE) . ',
                      "postal_code": ' . $this->input->post('card_number', TRUE) . ',
                      "state":' . $this->input->post('cvc', TRUE) . ',
                      "phone":' . $this->input->post('phone', TRUE) . ',
                    }
                  }';

            $ch = curl_init();
            $curlConfig = array(
                CURLOPT_URL => PAYPAL_API . "vault/credit-cards/",
                CURLOPT_HTTPHEADER => array('Content-Type: application/json', "Authorization: Bearer " . PAYPAL_ACCESS_TOKEN),
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $sta
            );
            curl_setopt_array($ch, $curlConfig);
            $result = json_decode(curl_exec($ch));

            echo "<pre>";
            print_r($result);
            exit;


            $app_users_id = $this->common_model->insert($data, "app_users");
            if ($app_users_id) {


                //start payment




                $encid = $this->general->encryptData($app_users_id);
                $encemail = $this->general->encryptData($this->input->post('email', TRUE));
                $url = base_url('verify/' . $encid . "/" . $encemail);
                $name = ($this->input->post('first_name', TRUE)) . " " . ($this->input->post('last_name', TRUE));
                $hidenuseremail = $this->input->post('email', TRUE);
                // Header
                $email_data['VERIFY_URL'] = $url;
                $email_data['USER'] = $name;
                $html = $this->load->view('email-template/account_verification', $email_data, true);

                $subject = $name . ", Please verify your email address.";
                $define_param['to_name'] = $name;
                $define_param['to_email'] = $hidenuseremail;
                $send = $this->sendmail->send($define_param, $subject, $html);

                $this->session->set_flashdata('msg', 'You account has been created. Activation email has been sent on your registered email.');
                $this->session->set_flashdata('msg_class', 'success');
                redirect('auth');
            } else {
                $this->session->set_flashdata('msg', 'Unable to register');
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('register');
            }
        }
    }

    public function verify_customer($encid, $encemail) {
        $id = (int) $this->general->decryptData($encid);
        $email = $this->general->decryptData($encemail);
        $cust_data = $this->common_model->getData("app_users", "*", "user_id='" . $id . "' AND email='" . $email . "'");
        if (count($cust_data) > 0) {
            if ($cust_data[0]['status'] == 'E') {
                $this->common_model->update_data(array('status' => 'A'), "user_id=" . $id, 'app_users');

                $customer_name = $cust_data[0]['first_name'] . " " . $cust_data[0]['last_name'];
                $customer_email = $cust_data[0]['email'];

                $email_data['USER'] = $customer_name;
                $html = $this->load->view('email-template/thank_you', $email_data, true);

                $subject = get_CompanyName() . ", Account Registration";
                $define_param['to_name'] = $customer_name;
                $define_param['to_email'] = $customer_email;

                $send = $this->sendmail->send($define_param, $subject, $html);
                $this->session->set_flashdata('msg_class', "success");
                $this->session->set_flashdata('msg', "Your account has been verified successfully.");
                redirect('login');
            } else {
                $this->session->set_flashdata('msg_class', "failure");
                $this->session->set_flashdata('msg', "You have already verified your account.");
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', "Invalid request.");
            redirect('login');
        }
    }

}
