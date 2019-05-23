<?php

function api_request($url, $data, $token = 0) {
    $token = isset($token) ? $token : 0;
    $ch = curl_init();
    $curlConfig = array(
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json', "token:$token"),
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $data
    );
    curl_setopt_array($ch, $curlConfig);
    $result = curl_exec($ch);
    //print_r($result);exit;
    curl_close($ch);
    return ($result);
}

function slugify($str) {
    $search = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
    $str = str_ireplace($search, $replace, strtolower(trim($str)));
    $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
    $str = str_replace(' ', '-', $str);
    return preg_replace('/\-{2,}/', '-', $str);
}

function get_CompanyName() {
    $CI = & get_instance();
    $CI->db->select('site_name');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    return $user_data['site_name'];
}

function get_user_by_id($id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_users');
    $where = "user_id=" . $id;
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    return $user_data;
}

function get_contact_by_id($id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_contact');
    $where = "contact_id=" . $id;
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    return $user_data;
}

function app_users_by_id($id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_users');
    $where = "user_id=" . $id;
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    return $user_data;
}

function get_package_by_id($id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_package');
    $where = "package_id=" . $id;
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    return $user_data;
}

function get_time_zone() {
    $CI = & get_instance();
    $CI->db->select('time_zone');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 && $user_data[0]['time_zone'] != '' ? $user_data[0]['time_zone'] : 'Asia/Kolkata';
}

function tz_list() {
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zones_array;
}

function get_site_setting($field) {
    $CI = & get_instance();
    $qyery_system = $CI->db->query("SELECT " . $field . " FROM app_site_setting WHERE id=1");
    $system_data = $qyery_system->row_array();
    return isset($system_data[$field]) ? $system_data[$field] : "";
}

function get_channel_by_id($id) {
    $CI = & get_instance();
    $qyery_system = $CI->db->query("SELECT * FROM app_channels WHERE id=" . $id);
    $system_data = $qyery_system->row_array();
    return $system_data;
}

function system_log_insert($user_id, $details) {
    $CI = & get_instance();
    $data['user_id'] = $user_id;
    $data['details'] = $details;
    $data['created_date'] = date('Y-m-d H:i:s');
    $CI->db->insert('app_log_history', $data);
}

function get_user_details($id) {
    $CI = & get_instance();
    $qyery = $CI->db->query("SELECT * FROM app_users WHERE user_id=" . $id);
    $users = $qyery->row_array();
    return $users;
}

function get_user_details_by_listing_id($id) {
    $CI = & get_instance();
    $qry = "SELECT app_users.*,app_listing.status as app_listing_status,app_listing.no_of_item,app_listing.created_date as listing_created_date,app_category.category_title ";
    $qry .= "FROM app_users ";
    $qry .= "INNER JOIN app_listing ON app_listing.created_by=app_users.user_id ";
    $qry .= "INNER JOIN app_category ON app_listing.category_id=app_category.category_id ";
    $qry .= "WHERE app_listing.listing_id=" . $id;

    $qyery = $CI->db->query($qry);
    $users = $qyery->row_array();
    return $users;
}

function get_system_details() {
    $CI = & get_instance();
    $qyery = $CI->db->query("SELECT * FROM app_site_setting WHERE id=1");
    $users = $qyery->row_array();
    return $users;
}

function get_logo() {
    $CI = & get_instance();
    $qyery = $CI->db->query("SELECT site_logo FROM app_site_setting WHERE id=1");
    $site_logo = $qyery->row_array();

    if (isset($site_logo['site_logo']) && $site_logo['site_logo'] != "") {
        if (file_exists(FCPATH . 'assets/upload/user_media/' . $site_logo['site_logo'])) {
            return base_url('assets/upload/user_media/' . $site_logo['site_logo']);
        } else {
            return base_url('assets/images/favicon.png');
        }
    } else {
        return base_url('assets/images/logo.svg');
    }
}

function get_fevicon() {
    $CI = & get_instance();
    $qyery = $CI->db->query("SELECT favicon FROM app_site_setting WHERE id=1");
    $site_logo = $qyery->row_array();
    if (isset($site_logo['favicon']) && $site_logo['favicon'] != "") {
        if (file_exists(FCPATH . 'assets/upload/user_media/' . $site_logo['favicon'])) {
            return base_url('assets/upload/user_media/' . $site_logo['favicon']);
        } else {
            return base_url('assets/img/favicon.png');
        }
    } else {
        return base_url('assets/img/favicon.png');
    }
}

function send_message($to, $message) {
    $CI = & get_instance();
    $CI->db->select('sms_key,sms_sender');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    $sms_key = $user_data['sms_key'];
    $sms_sender = $user_data['sms_sender'];

    $to = str_replace('+', '', $to);
    $message = str_replace('&', '%26', $message);
    $url = "http://sms.webozindia.in/api/v3/?method=sms&api_key=" . $sms_key . "&to=" . $to . "&sender=" . $sms_sender . "&message=" . $message;
    $ch = curl_init();
    $curlConfig = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => ''
    );
    curl_setopt_array($ch, $curlConfig);
    $result = curl_exec($ch);
    curl_close($ch);
    return true;
}

function cleanString($string) {
    $res = preg_replace("/[^a-zA-Z0-9]/", "", $string);
    $res = str_replace(' ', '', $res);
    return $res;
}
