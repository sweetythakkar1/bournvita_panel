<?php
Class Content_model extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "tbl_users";
        $this->primary_key = "id";
    }

    function insert($tbl = '', $data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->insert($tbl, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($tbl = '', $data = array(), $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where, false, false);
        $res = $this->db->update($tbl, $data);
        $rs = $this->db->affected_rows();
        return $rs;
    }

    function get_by_field($table, $field, $value) {
        $this->db->where($field, $value);
        $q = $this->db->get($table);
        $data = $q->result_array();
        return $data;
    }

    function get_device_id($id = null) {
        $this->db->select('device_id');
        $this->db->from('tbl_user');
        //$this->db->where('tbl_users.status', 'A');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_device_id_not_in($id) {
        $this->db->select('tbl_users.*,tbl_login_master.device_id,tbl_login_master.user_id,tbl_login_master.device_type');
        $this->db->from('tbl_users');
        $this->db->join('tbl_login_master', 'tbl_users.id=tbl_login_master.user_id');
        $this->db->where('tbl_users.status', 'A');
        $this->db->where('tbl_users.push_notification', "1");
        $this->db->where_not_in('tbl_users.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getData($tbl = '', $fields, $condition = '', $join_ary = array(), $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }
        $this->db->select($fields, FALSE);
        if (is_array($join_ary) && count($join_ary) > 0) {
            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
        }
        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        if (trim($groupby) != '') {
            $this->db->group_by($groupby);
        }
        if (trim($having) != '') {
            $this->db->having($having, FALSE);
        }
        if ($orderby != '' && is_array($paging_array) && count($paging_array) == "0") {
            $this->db->order_by($orderby, FALSE);
        }
        if (trim($climit) != '') {
            $this->db->limit($climit);
        }
        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }
        $list_data = $this->db->get()->result_array();
        return $list_data;
    }

    function delete($tbl = '', $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where);
        $this->db->delete($tbl);
        return 'deleted';
    }

    function getSingleRow($tbl = '', $fields, $condition = '') {
        if ($fields == '') {
            $fields = "*";
        }
        $this->db->select($fields, FALSE);

        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }
        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        $list_data = $this->db->get()->row_array();
        return $list_data;
    }

    function check_username($email) {
        $this->db->where('email', $email);
        $this->db->from("tbl_users");

        $list_data = $this->db->get()->row_array();
        if (is_array($list_data) && count($list_data) > 0) {
            $this->errorCode = 1;
        } else {
            $this->errorCode = 0;
            $this->errorMessage = 'Email not registered with system.';
        }

        $error['ID'] = $list_data['id'];
        $error['Firstname'] = $list_data['first_name'];
        $error['Lastname'] = $list_data['last_name'];
        $error['Email'] = $list_data['email'];
        $error['errorCode'] = $this->errorCode;
        $error['errorMessage'] = $this->errorMessage;
        return $error;
    }

}
