<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

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
    public function contact_list() {
        $id = $this->session->userdata('id');
        $where = "created_by=" . $id;
        $data['title'] = 'Contact List';
        $data['app_contact'] = $this->common_model->getData('app_contact', '*', $where);
        $data['main_content'] = $this->load->view('contacts/list', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function add_contact() {
        $data['title'] = 'Add Contact';
        $data['main_content'] = $this->load->view('contacts/contact_add_update', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function update_contact($id) {
        $id = (int) $id;
        if ($id > 0):
            $where = "contact_id='$id'";
            $data['title'] = 'Update Contact Details';
            $data['app_contact'] = $this->common_model->getData('app_contact', '*', $where)[0];
            $data['main_content'] = $this->load->view('contacts/contact_add_update', $data, TRUE);
            $this->load->view('index', $data);
        else:
            redirect(base_url());
        endif;
    }

    public function add_contact_action() {
        $id = $this->session->userdata('id');

        $contact_id = $this->input->post('contact_id');
        /* Validation */
        $this->form_validation->set_rules('first_name', '', 'required|trim');
        $this->form_validation->set_rules('last_name', '', 'required|trim');
        $this->form_validation->set_rules('email', '', 'required|trim|valid_email|callback_email_check');
        $this->form_validation->set_rules('phone', '', 'required|trim|callback_phone_check');
        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<div class="error alert alert-warning">', '</div>');
        if ($this->form_validation->run() == false) {
            if (isset($contact_id) && $contact_id > 0) {
                $this->update_contact($contact_id);
            } else {
                $this->add_contact();
            }
        } else {
            if (isset($contact_id) && $contact_id > 0) {
                $data = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'business_name' => $this->input->post('business_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                );
                $where = "contact_id='$contact_id'";
                $this->common_model->update_data($data, $where, 'app_contact');
                $this->session->set_flashdata('msg', "Contact details updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $this->load->helper('string');
                $password = random_string('alnum', 8);
                $data = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'business_name' => $this->input->post('business_name', TRUE),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $id
                );
                $Insert_id = $this->common_model->insert($data, 'app_contact');
                $this->session->set_flashdata('msg', "Contact details insert successfully");
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('manage-contacts');
        }
    }

    public function delete_contact_action() {
        $contact_id = $this->input->post('delete_id');
        $upd_id = $this->session->userdata('id');
        $res = $this->db->query("DELETE FROM app_contact WHERE contact_id=" . $contact_id . " AND created_by=" . $upd_id);
        if ($res) {
            $this->session->set_flashdata('msg', "Contact details deleted successfully.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('manage-contacts');
        } else {
            $this->session->set_flashdata('msg', "You are not allowed to delete this contact.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('manage-contacts');
        }
    }

    public function remove_contact_list() {

        $upd_id = $this->session->userdata('id');

        $selectfordelete = $this->input->post("selectfordelete[]");
        $delete_count = 0;
        foreach ($selectfordelete as $val):
            $res = $this->db->query("DELETE FROM app_contact WHERE contact_id=" . $val . " AND created_by=" . $upd_id);
            if ($res) {
                $delete_count++;
            }
        endforeach;
        $this->session->set_flashdata('msg', $delete_count . " Contacts details deleted successfully.");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('manage-contacts');
    }

    public function update_contact_status($value, $id) {
        $upd_id = $this->session->userdata('id');
        $token = $this->session->userdata('token');

        $status = "";

        if ($value == 'inactive') {
            $status = "I";
        } else {
            $status = "A";
        }
        $where = "contact_id='$id'";
        $data['status'] = $status;
        $data['admin_data'] = $this->common_model->update_data($data, $where, 'app_contact');
        $this->session->set_flashdata('msg', "Contact details status updated.");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('manage-contacts');
    }

    public function email_check($str) {
        $id = $this->session->userdata('id');
        $contact_id = (int) $this->input->post('contact_id', TRUE);
        $email = $this->input->post('email', TRUE);
        if ($contact_id == 0):
            //add time
            $qry = $this->db->query("SELECT contact_id FROM app_contact WHERE email='" . $email . "' AND created_by=" . $id)->result_array();
            if (count($qry) == 0) {
                return TRUE;
            } else {
                $this->form_validation->set_message('email_check', 'Email is already in use.');
                return FALSE;
            }
        else:
            //edit time
            $qry = $this->db->query("SELECT contact_id FROM app_contact WHERE email='" . $email . "' AND created_by=" . $id . " AND contact_id!=" . $contact_id)->result_array();
            if (count($qry) == 0) {
                return TRUE;
            } else {
                $this->form_validation->set_message('email_check', 'Email is already in use.');
                return FALSE;
            }
        endif;
    }

    public function phone_check($str) {
        $id = $this->session->userdata('id');
        $contact_id = (int) $this->input->post('contact_id', TRUE);
        $phone = $this->input->post('phone', TRUE);
        if ($contact_id == 0):
            //add time
            $qry = $this->db->query("SELECT contact_id FROM app_contact WHERE phone='" . $phone . "' AND created_by=" . $id)->result_array();
            if (count($qry) == 0) {
                return TRUE;
            } else {
                $this->form_validation->set_message('phone_check', 'Phone number is already in use.');
                return FALSE;
            }
        else:
            //edit time
            $qry = $this->db->query("SELECT contact_id FROM app_contact WHERE phone='" . $phone . "' AND created_by=" . $id . " AND contact_id!=" . $contact_id)->result_array();
            if (count($qry) == 0) {
                return TRUE;
            } else {
                $this->form_validation->set_message('phone_check', 'Phone number is already in use.');
                return FALSE;
            }
        endif;
    }

}
