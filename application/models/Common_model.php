<?php

class Common_model extends CI_Model {

    //-- insert function
    public function insert($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //-- edit function
    function edit_option($action, $id, $table) {
        $this->db->where('id', $id);
        $this->db->update($table, $action);
        return;
    }

    //-- update function
    function update($action, $id, $table) {
        $this->db->where('id', $id);
        $res = $this->db->update($table, $action);
        $rs = $this->db->affected_rows();
        return $rs;
    }

    //-- update function
    function update_data($action, $id, $table) {
        $this->db->where($id);
        $res = $this->db->update($table, $action);
        return $res;
    }

    //-- delete function
    function delete($id, $table) {
        $this->db->delete($table, array('id' => $id));
        return;
    }

    //-- user role delete function
    function delete_user_role($id, $table) {
        $this->db->delete($table, array('user_id' => $id));
        return;
    }

    //-- select function
    function select($table) {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- select by id
    function select_option($id, $table) {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- check user role power
    function check_power($type) {
        $this->db->select('ur.*');
        $this->db->from('admin_user_role ur');
        $this->db->where('ur.user_id', $this->session->userdata('id'));
        $this->db->where('ur.action', $type);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function check_email($email) {
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function check_exist_power($id) {
        $this->db->select('*');
        $this->db->from('admin_user_power');
        $this->db->where('power_id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //-- get all power
    function get_all_power($table) {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('power_id', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- get logged user info
    function get_user_info() {
        $this->db->select('u.*');
        $this->db->select('c.name as country_name');
        $this->db->from('admin_user u');
        $this->db->join('country c', 'c.id = u.country', 'LEFT');
        $this->db->where('u.id', $this->session->userdata('id'));
        $this->db->order_by('u.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    function get_count_by_type($user_id, $type) {
        $this->db->select('count(report_id) as total_count');
        $this->db->from('app_miscall_data');
        $this->db->where('user_id', $user_id);
        $this->db->where('record_type', $type);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    //-- get single user info
    function get_single_user_info($id) {
        $this->db->select('u.*');
        $this->db->select('c.name as country_name');
        $this->db->from('admin_user u');
        $this->db->join('country c', 'c.id = u.country', 'LEFT');
        $this->db->where('u.id', $id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
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

    //-- get single user info
    function get_user_role($id) {
        $this->db->select('ur.*');
        $this->db->from('admin_user_role ur');
        $this->db->where('ur.user_id', $id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- get all users 
    function get_all_user() {
        $this->db->select('*');
        $this->db->from('users');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- get all jobs
    function get_all_jobs() {
        $this->db->select('*');
        $this->db->from('jobs');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- count active, inactive and total user
    function get_user_total() {
        $this->db->select('*');
        $this->db->select('count(*) as total');
        $this->db->select('(SELECT count(admin_user.id)
                            FROM admin_user 
                            WHERE (admin_user.status = 1)
                            )
                            AS active_user', TRUE);

        $this->db->select('(SELECT count(admin_user.id)
                            FROM admin_user 
                            WHERE (admin_user.status = 0)
                            )
                            AS inactive_user', TRUE);

        $this->db->select('(SELECT count(admin_user.id)
                            FROM admin_user 
                            WHERE (admin_user.role = "admin")
                            )
                            AS admin', TRUE);

        $this->db->from('admin_user');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    //-- image upload function with resize option
    function upload_image($max_size) {

        //-- set upload path
        $config['upload_path'] = "./assets/images/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '92000';
        $config['max_width'] = '92000';
        $config['max_height'] = '92000';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload("photo")) {


            $data = $this->upload->data();

            //-- set upload path
            $source = "./assets/images/" . $data['file_name'];
            $destination_thumb = "./assets/images/thumbnail/";
            $destination_medium = "./assets/images/medium/";
            $main_img = $data['file_name'];
            // Permission Configuration
            chmod($source, 0777);

            /* Resizing Processing */
            // Configuration Of Image Manipulation :: Static
            $this->load->library('image_lib');
            $img['image_library'] = 'GD2';
            $img['create_thumb'] = TRUE;
            $img['maintain_ratio'] = TRUE;

            /// Limit Width Resize
            $limit_medium = $max_size;
            $limit_thumb = 200;

            // Size Image Limit was using (LIMIT TOP)
            $limit_use = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'];

            // Percentase Resize
            if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                $percent_medium = $limit_medium / $limit_use;
                $percent_thumb = $limit_thumb / $limit_use;
            }

            //// Making THUMBNAIL ///////
            $img['width'] = $limit_use > $limit_thumb ? $data['image_width'] * $percent_thumb : $data['image_width'];
            $img['height'] = $limit_use > $limit_thumb ? $data['image_height'] * $percent_thumb : $data['image_height'];

            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_thumb-' . floor($img['width']) . 'x' . floor($img['height']);
            $img['quality'] = ' 100%';
            $img['source_image'] = $source;
            $img['new_image'] = $destination_thumb;

            $thumb_nail = $data['raw_name'] . $img['thumb_marker'] . $data['file_ext'];
            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear();

            ////// Making MEDIUM /////////////
            $img['width'] = $limit_use > $limit_medium ? $data['image_width'] * $percent_medium : $data['image_width'];
            $img['height'] = $limit_use > $limit_medium ? $data['image_height'] * $percent_medium : $data['image_height'];

            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_medium-' . floor($img['width']) . 'x' . floor($img['height']);
            $img['quality'] = '100%';
            $img['source_image'] = $source;
            $img['new_image'] = $destination_medium;

            $mid = $data['raw_name'] . $img['thumb_marker'] . $data['file_ext'];
            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear();

            //-- set upload path
            $images = 'assets/images/medium/' . $mid;
            $thumb = 'assets/images/thumbnail/' . $thumb_nail;
            unlink($source);

            return array(
                'images' => $images,
                'thumb' => $thumb
            );
        } else {
            echo "Failed! to upload image";
        }
    }

}
