<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification {

    public function ios($data = array()) {
        date_default_timezone_set('Asia/Kolkata');
        $CI = & get_instance();
        try {

            if (isset($data['device_id']) != "" && $data['device_id'] != NULL) {
                $title = "Push Notification " . MY_SITE_NAME;
                $icon = "";
                $ar = array('title' => MY_SITE_NAME, 'icon' => $icon, 'desc' => $title);
                $ctx = stream_context_create();

                $print = false;

                if (IS_WEB_LIVE) {
                    stream_context_set_option($ctx, 'ssl', 'local_cert', APPPATH . 'third_party/' . PUSH_LIVE_NAME);
                    stream_context_set_option($ctx, 'ssl', 'passphrase', APPPATH . 'third_party/' . PUSH_LIVE_PASSPHRASE);
                    $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                } else {
                    stream_context_set_option($ctx, 'ssl', 'local_cert', APPPATH . 'third_party/' . PUSH_DEV_NAME);
                    stream_context_set_option($ctx, 'ssl', 'passphrase', APPPATH . 'third_party/' . PUSH_DEV_PASSPHRASE);
                    $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                }
                if (!$fp) {
                    return FALSE;
                } else {

                    $device_id = isset($data['device_id']) ? $data['device_id'] : "";
                    $notification_title = isset($data['notification_title']) ? $data['notification_title'] : "";
                    $details = isset($data['details']) ? trim($data['details']) : "";
                    $user_id = isset($data['user_id']) ? trim($data['user_id']) : "";
                    $post_id = isset($data['post_id']) ? trim($data['post_id']) : "";
                    $created_on = isset($data['created_on']) ? trim($data['created_on']) : date('Y-m-d H:i:s');
                    $transporter_id = isset($data['transporter_id']) ? trim($data['transporter_id']) : "";
                    $user_type = isset($data['user_type']) ? trim($data['user_type']) : "";







                    $amount = isset($data['amount']) ? trim($data['amount']) : "";
                    $status = isset($data['status']) ? trim($data['status']) : "";
                    $notification_for = isset($data['notification_for']) ? trim($data['notification_for']) : "";

                    $final_post_vehicle_array = array();
                    $CI->db->select('*');
                    $CI->db->from('tbl_post_vehicle_type_count');
                    $CI->db->where('post_id', $post_id);
                    $vehicle_coun_query = $CI->db->get();
                    $vehicle_coun_data = $vehicle_coun_query->result();

                    $CI->db->select('*');
                    $CI->db->from('tbl_post');
                    $CI->db->where('post_id', $post_id);
                    $tbl_post_coun_query = $CI->db->get();
                    $tbl_post_coun_data = $tbl_post_coun_query->row_array();

                    $title = isset($tbl_post_coun_data['title']) ? $tbl_post_coun_data['title'] : "";
                    $pickup = isset($tbl_post_coun_data['pickup']) ? $tbl_post_coun_data['pickup'] : "";
                    $drop_off = isset($tbl_post_coun_data['drop_off']) ? $tbl_post_coun_data['drop_off'] : "";
                    $location = isset($tbl_post_coun_data['location']) ? $tbl_post_coun_data['location'] : "";
                    $description = isset($tbl_post_coun_data['description']) ? $tbl_post_coun_data['description'] : "";

                    foreach ($vehicle_coun_data as $datas):
                        $tbl_post_vehicle_type_count = array();
                        $tbl_post_vehicle_type_count['vehicle_type'] = $datas->vehicle_type;
                        $tbl_post_vehicle_type_count['vehicle_count'] = $datas->vehicle_count;
                        array_push($final_post_vehicle_array, $tbl_post_vehicle_type_count);
                    endforeach;

                    //Get Transporter Details
                    $CI->db->select('*');
                    $CI->db->from('tbl_user');
                    $CI->db->where('user_id', $user_id);
                    $tbl_user_query = $CI->db->get();
                    $tbl_user_data = $tbl_user_query->row_array();

                    $user_first_name = isset($tbl_user_data['first_name']) ? $tbl_user_data['first_name'] : "";
                    $user_last_name = isset($tbl_user_data['last_name']) ? $tbl_user_data['last_name'] : "";
                    $user_image_name = isset($tbl_user_data['image_name']) ? $tbl_user_data['image_name'] : "";
                    $user_image_path = isset($tbl_user_data['image_path']) ? $tbl_user_data['image_path'] : "";
                    $user_wallet = isset($tbl_user_data['mywallet']) ? $tbl_user_data['mywallet'] : 0;

                    //Get User Details
                    $CI->db->select('*');
                    $CI->db->from('tbl_user');
                    $CI->db->where('user_id', $transporter_id);
                    $tbl_trans_query = $CI->db->get();
                    $tbl_trans_data = $tbl_trans_query->row_array();

                    $trans_first_name = isset($tbl_trans_data['first_name']) ? $tbl_trans_data['first_name'] : "";
                    $trans_last_name = isset($tbl_trans_data['last_name']) ? $tbl_trans_data['last_name'] : "";
                    $trans_image_name = isset($tbl_trans_data['image_name']) ? $tbl_trans_data['image_name'] : "";
                    $trans_image_path = isset($tbl_trans_data['image_path']) ? $tbl_trans_data['image_path'] : "";
                    $transporter_wallet = isset($tbl_trans_data['mywallet']) ? $tbl_trans_data['mywallet'] : 0;
                    $rating = isset($tbl_trans_data['rating']) ? $tbl_trans_data['rating'] : "";
                    $mywallet = 0;
                    if ($user_type == 'U') {
                        $mywallet = $user_wallet;
                    } else {
                        $mywallet = $transporter_wallet;
                    }

                    $body['aps'] = array(
                        'alert' => $notification_title,
                        'Badge' => 'desiredNumber',
                        'data' => $notification_title,
                        'user_id' => $user_id,
                        'notification_title' => $notification_title,
                        'post_id' => $post_id,
                        'transporter_id' => $transporter_id,
                        'user_type' => $user_type,
                        'user_first_name' => $user_first_name,
                        'user_last_name' => $user_last_name,
                        'user_image_name' => $user_image_name,
                        'user_image_path' => $user_image_path,
                        'amount' => $amount,
                        'server' => true,
                        'user_wallet' => (string) $user_wallet,
                        'transporter_wallet' => (string) $transporter_wallet,
                        'transporter_first_name' => $trans_first_name,
                        'transporter_last_name' => $trans_last_name,
                        'transporter_image_name' => $trans_image_name,
                        'transporter_image_path' => $trans_image_path,
                        'rating' => $rating,
                        'status' => $status,
                        'mywallet' => $mywallet,
                        'notification_for' => $notification_for,
                        'vehicle_type_count' => $final_post_vehicle_array,
                        'title' => $title,
                        'pickup' => $pickup,
                        'drop_off' => $drop_off,
                        'location' => $location,
                        'description' => $description,
                        'created_on' => $created_on,
                        'sound' => 'default'
                    );
                    // Encode the payload as JSON
                    $payload = json_encode($body);
                    // Build the binary notification
                    $msg = chr(0) . pack('n', 32) . pack('H*', $device_id) . pack('n', strlen($payload)) . $payload;

                    // Send it to the server
                    $result_notification = fwrite($fp, $msg, strlen($msg));

                    $log_data['user_id'] = $user_id;
                    $log_data['push_type'] = $user_type;
                    $log_data['device_id'] = $device_id;
                    $log_data['details'] = $details;
                    $log_data['result'] = $result_notification;
                    $log_data['created_on'] = date("Y-m-m H:i:s");
                    $CI->db->insert('tbl_push_log', $log_data);
                    $insert_id = $CI->db->insert_id();
                    //print_r($result_notification);exit;

                    fclose($fp);

                    return true;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            ECHO $e->getMessage();
            exit;
            return false;
        }
    }

    function android($device_id = '', $message = 'Notification', $extra = array()) {
        $result = '';
        if ($device_id != '') {
            $apiKey = ANDROID_NOTIFICATION_KEY;

            // Replace with real client registration IDs
            $registrationIDs = array($device_id);

            // Set POST variables
            $url = 'https://android.googleapis.com/gcm/send';

            $data1 = array("message" => $message);
            $data = array_merge($data1, $extra);

            $fields = array(
                'registration_ids' => $registrationIDs,
                'data' => $data,
            );

            $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
            );

            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //     curl_setopt($ch, CURLOPT_POST, true);
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
            $result = curl_exec($ch);

            //pr($result);exit;
            $f = fopen($this->CI->config->item('site_path') . 'public/upload/android.html', 'a+');
            fwrite($f, '<br/>' . date('Y-m-d H:i:s') . '<br/>');
            fwrite($f, print_r($registrationIDs, true) . '<br/>');
            fwrite($f, print_r($data, true));
            fwrite($f, print_r($result, true));
            fwrite($f, '<br/>');
            fclose($f);

            // Close connection
            curl_close($ch);
        }

        return $result;
    }

}
