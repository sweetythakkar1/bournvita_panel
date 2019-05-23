<?php

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function edit_option_md5($action, $id, $table) {
        $this->db->where('md5(id)', $id);
        $this->db->update($table, $action);
        return;
    }

    const CONSUMERS = 'app_users';
    const SALT_PREFIX = 'mAunrbX7zXA';
    const SALT_SUFFIX = 'P3bcV38L';

    public function authentication($data) {
        $this->db->select('*');
        $this->db->from(self::CONSUMERS);
        $where = "email='" . $data['email'] . "' AND password = '" . md5($data['password']) . "'";
        $this->db->where($where);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $userdata = array(
                'id' => $row->user_id,
                'is_login' => true,
                'role' => $row->type,
                'token' => $row->token
            );
            $this->session->set_userdata($userdata);
            system_log_insert($row->user_id, 'Login to account.');
            return TRUE;
        } else {
            return false;
        }
    }

    public function register_consumer($consumer_data) {
        $this->load->helper('string');
        $data = array(
            'platform_id' => '21',
            'staff_id' => '0',
            'title' => $consumer_data['title'],
            'first_name' => $consumer_data['first_name'],
            'last_name' => $consumer_data['last_name'],
            'address' => $consumer_data['address'],
            'city' => $consumer_data['city'],
            'state' => $consumer_data['state'],
            'country' => $consumer_data['country'],
            'post_code' => $consumer_data['post_code'],
            'signature' => strtoupper(random_string('alnum', '12')),
            'date_of_birth' => $consumer_data['year'] . '-' . $consumer_data['month'] . '-' . $consumer_data['date'],
            'email' => $consumer_data['email'],
            'password' => md5(self::SALT_PREFIX . $consumer_data['password'] . self::SALT_SUFFIX),
            'mobile_phone' => $consumer_data['mobile_phone'],
            'phone' => $consumer_data['phone'],
            'allowed_linked_devices' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'registered_from' => 'Web'
        );

        $query = $this->db->insert(self::CONSUMERS, $data);
        return $query;
        print_r($data);
        exit;
    }

    //-- check post email
    public function check_email($email) {
        $this->db->select('*');
        $this->db->from('app_users');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    // check valid user by id
    public function validate_id($id) {
        $this->db->select('*');
        $this->db->from('app_users');
        $this->db->where('md5(id)', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //-- check valid user
    function validate_user() {

        $this->db->select('*');
        $this->db->from('app_users');
        $this->db->where('email', $this->input->post('email'));
        $this->db->where('password', md5($this->input->post('password')));
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}
