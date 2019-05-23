<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_login_user();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $type = $this->session->userdata('role');
    }

    public function index() {
        $id = $this->session->userdata('id');
        $where = "created_by=" . $id;
        $data['title'] = 'Create Message';
        $data['app_contact'] = $this->common_model->getData('app_contact', '*', $where);
        $data['main_content'] = $this->load->view('message/message', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function message_log() {
        $id = $this->session->userdata('id');
        $where = "client_id=" . $id;
        $data['title'] = 'Message Log';
        $data['app_message_master'] = $this->common_model->getData('app_message_master', '*', $where, "", "created_date desc");
        $data['main_content'] = $this->load->view('message/message_log', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function message_details($message_id) {
        $message_id = (int) $message_id;
        $id = $this->session->userdata('id');

        $app_message_master = $this->common_model->getData('app_message_master', '*', 'message_id=' . $message_id . " AND client_id=" . $id);
        if (count($app_message_master) > 0):
            $where = "message_id=" . $message_id . " AND client_id=" . $id;
            $data['title'] = 'Message Details';
            $join = array(
                array(
                    'table' => 'app_contact',
                    'condition' => 'app_contact.contact_id=app_message_log.contact_id',
                    'jointype' => 'inner'
                )
            );

            $data['app_message_log'] = $this->common_model->getData('app_message_log', 'app_message_log.*,app_contact.first_name,app_contact.last_name,app_contact.email,app_contact.phone', $where, $join);
            $data['app_users'] = $this->common_model->getData('app_users', '*', 'user_id=' . $id)[0];
            $data['app_message_master'] = $app_message_master[0];
            $data['main_content'] = $this->load->view('message/message_details', $data, TRUE);
            $this->load->view('index', $data);
        else:
            $this->session->set_flashdata('msg', "Invalid request.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('message-log');
        endif;
    }

    public function message_send_action() {
        $id = $this->session->userdata('id');
        $sms_error_count = 0;
        $email_error_count = 0;
        $contact_user = $this->input->post('contact_users[]');
        $type = '';
        $message = $this->input->post('message', true);
        $status_sms = $this->input->post('status_sms');
        $status_email = $this->input->post('status_email');
        $message_subject = $this->input->post('message_subject');
        $total_user_to_send = count($contact_user);

        if ($total_user_to_send > 0):
            if ($status_sms == 'S'):
                $total_sms_available = $this->db->query("SELECT sms_send FROM app_users WHERE user_id=" . $id)->row_array();
                if ($total_sms_available['sms_send'] < $total_user_to_send) {
                    $err_msg = "You don't have enough sms credit to send message. <a href=" . base_url('upgrade') . ">Upgrader your subscription.</a>";
                    $this->session->set_flashdata('msg', $err_msg);
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('manage-contacts');
                }
                $type = 'S';
            endif;

            if ($status_email == 'E'):
                $total_sms_available = $this->db->query("SELECT email_send FROM app_users WHERE user_id=" . $id)->row_array();
                if ($total_sms_available['email_send'] < $total_user_to_send) {
                    $err_msg = "You don't have enough email credit to send message. <a href=" . base_url('upgrade') . ">Upgrader your subscription.</a>";
                    $this->session->set_flashdata('msg', $err_msg);
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('manage-contacts');
                }
                $type = 'E';
            endif;

            if ($status_sms == 'S' && $status_email == 'E'):
                $total_sms_available = $this->db->query("SELECT sms_send,email_send FROM app_users WHERE user_id=" . $id)->row_array();
                if (($total_sms_available['email_send'] < $total_user_to_send) && ($total_sms_available['sms_send'] < $total_user_to_send)) {
                    $err_msg = "You don't have enough  sms and email credit to send message. <a href=" . base_url('upgrade') . ">Upgrader your subscription.</a>";
                    $this->session->set_flashdata('msg', $err_msg);
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('manage-contacts');
                }
                $type = 'SE';
            endif;

            $app_message_master['created_date'] = date('Y-m-d H:i:s');
            $app_message_master['type'] = $type;
            $app_message_master['message'] = $message;
            $app_message_master['subject'] = isset($message_subject) ? $message_subject : "";
            $app_message_master['total_user'] = count($contact_user);
            $app_message_master['client_id'] = $id;
            $app_message_master_id = $this->common_model->insert($app_message_master, 'app_message_master');
            if ($app_message_master_id) {
                foreach ($contact_user as $val):
                    $contact_user_data = get_contact_by_id($val);
                    $client_user_data = get_user_by_id($id);

                    if ($status_sms == 'S'):
                        //send sms
                        $app_message_log['contact_id'] = $val;
                        $app_message_log['message_id'] = $app_message_master_id;
                        $app_message_log['client_id'] = $id;
                        $app_message_log['message_type'] = $type;
                        $app_message_log['sms_content'] = $message;
                        $app_message_log['email_content'] = $message;
                        $app_message_log['created_date'] = date('Y-m-d H:i:s');

                        $msg_data['from'] = TELNYX_FROM;
                        $msg_data['to'] = $contact_user_data['phone'];
                        $msg_data['body'] = $message;
                        $msg_data['delivery_status_webhook_url'] = base_url();

                        $ch = curl_init();
                        $curlConfig = array(
                            CURLOPT_URL => "https://sms.telnyx.com/messages",
                            CURLOPT_HTTPHEADER => array('Content-Type: application/json', "x-profile-secret:" . TELNYX_SECRET),
                            CURLOPT_POST => true,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POSTFIELDS => json_encode($msg_data)
                        );
                        curl_setopt_array($ch, $curlConfig);
                        $result = json_decode(curl_exec($ch));
                        if (isset($result->success) && $result->success == FALSE) {
                            $sms_error_count++;
                            $app_message_log['sms'] = $result->message;
                        }
                        curl_close($ch);

                        $app_message_log_id = $this->common_model->insert($app_message_log, 'app_message_log');
                        $this->db->query("UPDATE app_users SET sms_send=sms_send-1 WHERE user_id=" . $id);

                    endif;

                    if ($status_email == 'E'):
                        //send email
                        $app_message_log['contact_id'] = $val;
                        $app_message_log['message_id'] = $app_message_master_id;
                        $app_message_log['client_id'] = $id;
                        $app_message_log['message_type'] = $type;
                        $app_message_log['sms_content'] = $message;
                        $app_message_log['email_content'] = $message;
                        $app_message_log['created_date'] = date('Y-m-d H:i:s');

                        $email_data['URL'] = isset($url) ? $url : "";
                        $email_data['CLIENT'] = isset($client_user_data['first_name']) ? $client_user_data['first_name'] : "";
                        $email_data['MESSAGE'] = $message;
                        $email_data['USER'] = $contact_user_data['first_name'] . " " . $contact_user_data['last_name'];
                        $html = $this->load->view('email-template/message', $email_data, true);

                        $subject = get_CompanyName() . ", You have received new message from " . $client_user_data['first_name'];
                        $define_param['to_name'] = $contact_user_data['first_name'] . " " . $contact_user_data['last_name'];
                        $define_param['to_email'] = $contact_user_data['email'];
                        $email_status = $this->sendmail->send($define_param, $message_subject, $html);
                        if ($email_status == false) {
                            $app_message_log['email'] = 'Unable to send email.';
                            $email_error_count++;
                        }

                        $app_message_log_id = $this->common_model->insert($app_message_log, 'app_message_log');
                        $this->db->query("UPDATE app_users SET email_send=email_send-1 WHERE user_id=" . $id);
                    endif;

                    if ($status_sms == 'S' && $status_email == 'E'):
                        //send sms and email

                        $app_message_log['contact_id'] = $val;
                        $app_message_log['message_id'] = $app_message_master_id;
                        $app_message_log['client_id'] = $id;
                        $app_message_log['message_type'] = $type;
                        $app_message_log['sms_content'] = $message;
                        $app_message_log['email_content'] = $message;
                        $app_message_log['created_date'] = date('Y-m-d H:i:s');

                        $msg_data['from'] = TELNYX_FROM;
                        $msg_data['to'] = $contact_user_data['phone'];
                        $msg_data['body'] = $message;
                        $msg_data['delivery_status_webhook_url'] = base_url();

                        //send sms
                        $ch = curl_init();
                        $curlConfig = array(
                            CURLOPT_URL => "https://sms.telnyx.com/messages",
                            CURLOPT_HTTPHEADER => array('Content-Type: application/json', "x-profile-secret:" . TELNYX_SECRET),
                            CURLOPT_POST => true,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POSTFIELDS => json_encode($msg_data)
                        );
                        curl_setopt_array($ch, $curlConfig);
                        $result = json_decode(curl_exec($ch));
                        if (isset($result->success) && $result->success == FALSE) {
                            $sms_error_count++;
                            $app_message_log['sms'] = $result->message;
                        }
                        curl_close($ch);

                        //send email
                        $email_data['URL'] = isset($url) ? $url : "";
                        $email_data['CLIENT'] = isset($client_user_data['first_name']) ? $client_user_data['first_name'] : "";
                        $email_data['MESSAGE'] = $message;
                        $email_data['USER'] = $contact_user_data['first_name'] . " " . $contact_user_data['last_name'];
                        $html = $this->load->view('email-template/message', $email_data, true);

                        $subject = get_CompanyName() . ", You have received new message from " . $client_user_data['first_name'];
                        $define_param['to_name'] = $contact_user_data['first_name'] . " " . $contact_user_data['last_name'];
                        $define_param['to_email'] = $contact_user_data['email'];
                        $email_status = $this->sendmail->send($define_param, $message_subject, $html);
                        if ($email_status == false) {
                            $app_message_log['email'] = 'Unable to send email.';
                            $email_error_count++;
                        }

                        $app_message_log_id = $this->common_model->insert($app_message_log, 'app_message_log');
                        $this->db->query("UPDATE app_users SET sms_send=sms_send-1 WHERE user_id=" . $id);
                        $this->db->query("UPDATE app_users SET email_send=email_send-1 WHERE user_id=" . $id);
                    endif;
                endforeach;



                $this->session->set_flashdata('msg', "Message has been sent successfully.");
                $this->session->set_flashdata('msg_class', 'success');
                if ($sms_error_count > 0) {
                    $this->session->set_flashdata('msg', $sms_error_count . " sms failed to send.");
                    $this->session->set_flashdata('msg_class', 'failure');
                }
                if ($email_error_count > 0) {
                    $this->session->set_flashdata('msg', $sms_error_count . " email failed to send.");
                    $this->session->set_flashdata('msg_class', 'failure');
                }
                redirect('manage-contacts');
            } else {
                $this->session->set_flashdata('msg', "Unable to send message");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('manage-contacts');
            }
        else:
            $err_msg = "Please select at least one user to send message.";
            $this->session->set_flashdata('msg', $err_msg);
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('manage-contacts');
        endif;
    }

    public function message_view_modal($param) {
        $id = (int) $param;
        $data['id'] = $id;

        $data['app_message_master'] = $this->common_model->getData('app_message_master', '*', 'message_id=' . $id)[0];

        $join = array(
            array(
                'table' => 'app_contact',
                'condition' => 'app_contact.contact_id=app_message_log.contact_id',
                'jointype' => 'inner'
            )
        );

        $data['app_message_log'] = $this->common_model->getData('app_message_log', 'app_message_log.*,app_contact.first_name,app_contact.phone,app_contact.last_name,app_contact.email,app_contact.business_name', 'message_id=' . $id, $join);

        echo $this->load->view('message/message_view_modal', $data, TRUE);
    }

}
