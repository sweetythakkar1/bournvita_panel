<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('common_model');
        date_default_timezone_set(get_time_zone());
    }

    public function miscall() {
        $get_site_setting = $this->db->query("SELECT * FROM app_site_setting WHERE id=1")->row_array();
        $from = isset($_GET['from']) ? $_GET['from'] : "";
        $to = isset($_GET['to']) ? $_GET['to'] : "";
        $fileid = isset($_GET['fileid']) ? $_GET['fileid'] : "";
        $user_token = isset($_GET['user_token']) ? trim($_GET['user_token']) : "";
        $circle = isset($_GET['circle']) ? trim($_GET['circle']) : "";
        $flow = isset($_GET['flow']) ? trim($_GET['flow']) : "";


        if (isset($user_token) && $user_token != "") {

            $get_users = $this->db->query("SELECT user_id FROM app_users WHERE token='" . $user_token . "'")->row_array();


            $userID = $get_users['user_id'];
            if (isset($userID) && $userID != "") {
                if (isset($from) && $from != "") {
                    if (isset($to) && $to != "") {
                        if (isset($fileid) && $fileid != "") {
                            if (isset($fileid) && $fileid != "") {
                                if (isset($flow) && $flow != "") {
                                    //call API
                                    $url = 'https://voiceconnect.tanla.com/apiv1/gettoken/';
                                    $params = array(
                                        'key' => $get_site_setting['tanla_api'],
                                        'secret' => $get_site_setting['tanla_secret']
                                    );

                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                    $result = curl_exec($ch);

                                    if (curl_errno($ch)) {
                                        echo 'Curl error: ' . curl_error($ch);
                                    }
                                    if (curl_errno($ch) !== 0) {
                                        error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
                                    }

                                    curl_close($ch);
                                    $json = json_decode($result, true);
                                    $vToken = $json["token"];
                                    if (isset($vToken) && $vToken != "") {
                                        $url = 'https://voiceconnect.tanla.com/apiv1/makecall/';
                                        $params = array(
                                            'token' => $vToken,
                                            'to' => $to,
                                            'dnd' => 0,
                                            'recording' => 1,
                                            'refid' => $from,
                                        );
                                        $params['flow'] = $fileid;

                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_POST, 1);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                                        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                        $result = curl_exec($ch);

                                        curl_close($ch);
                                        $json = json_decode($result, true);

                                        $res_status = isset($json['status']) ? $json['status'] : "";
                                        $res_message = isset($json['message']) ? $json['message'] : "";

                                        $get_users_report_id = $this->db->query("SELECT report_id FROM app_miscall_data WHERE `to`='" . $to . "'")->row_array();
                                        if (isset($get_users_report_id['report_id']) && $get_users_report_id['report_id'] > 0):
                                            $app_miscall_data['status'] = "Already Exist";
                                        else:
                                            $app_miscall_data['status'] = "Valid";
                                        endif;

                                        $app_miscall_data['response_id'] = isset($json['data']['id']) ? $json['data']['id'] : 0;
                                        $app_miscall_data['user_token'] = $user_token;
                                        $app_miscall_data['user_id'] = $userID;
                                        $app_miscall_data['from'] = $from;
                                        $app_miscall_data['to'] = $to;

                                        $app_miscall_data['message'] = $res_status;

                                        $app_miscall_data['fileid'] = $fileid;
                                        $app_miscall_data['response'] = $result;
                                        $app_miscall_data['circle'] = isset($circle) ? $circle : "";
                                        $app_miscall_data['created_date'] = date('Y-m-d H:i:s');

                                        $this->db->insert("app_miscall_data", $app_miscall_data);

                                        if (isset($json['status']) && $json['status'] < 0) {
                                            $err['message'] = $json['message'];
                                            echo json_encode($err);
                                        } else {
                                            $err['message'] = "Your request has been processed successfully.";
                                            $err['data'] = $json;
                                            echo json_encode($err);
                                        }
                                    } else {
                                        $err['message'] = "Unable to generate token.";
                                        echo json_encode($err);
                                    }
                                } else {
                                    $err['message'] = "Flow id  is required";
                                    echo json_encode($err);
                                }
                            } else {
                                $err['message'] = "File id  is required";
                                echo json_encode($err);
                            }
                        } else {
                            $err['message'] = "To  is required";
                            echo json_encode($err);
                        }
                    } else {
                        $err['message'] = "From is required";
                        echo json_encode($err);
                    }
                } else {
                    $err['message'] = "Invalid user token is required";
                    echo json_encode($err);
                }
            } else {
                $err['message'] = "User token is required";
                echo json_encode($err);
            }
        }
    }

    public function send_sms() {

        $from = isset($_GET['from']) ? $_GET['from'] : "";
        $to = isset($_GET['to']) ? $_GET['to'] : "";
        $user_token = isset($_GET['user_token']) ? trim($_GET['user_token']) : "";
        $circle = isset($_GET['circle']) ? trim($_GET['circle']) : "";
        $operator = isset($_GET['operator']) ? trim($_GET['operator']) : "";


        if (isset($user_token) && $user_token != "") {

            $get_users = $this->db->query("SELECT * FROM app_users WHERE token='" . $user_token . "'")->row_array();
            $userID = $get_users['user_id'];
            if (isset($userID) && $userID != "") {
                if (isset($to) && $to != "") {

                    $get_users_report_id = $this->db->query("SELECT report_id FROM app_miscall_data WHERE `to`='" . $to . "'")->row_array();
                    if (isset($get_users_report_id['report_id']) && $get_users_report_id['report_id'] > 0):
                        $app_miscall_data['status'] = "Already Exist";
                    else:
                        $app_miscall_data['status'] = "Valid";
                    endif;

                    if (isset($get_users['sms_api_url']) && $get_users['sms_api_url'] != "") {
                        $url = str_replace('NUMBER', trim($to), $get_users['sms_api_url']);

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

                        $app_miscall_data['user_token'] = $user_token;
                        $app_miscall_data['user_id'] = $userID;
                        $app_miscall_data['from'] = $from;
                        $app_miscall_data['to'] = $to;
                        $app_miscall_data['record_type'] = 'SMS';
                        $app_miscall_data['circle'] = isset($circle) ? $circle : "";
                        $app_miscall_data['operator'] = isset($operator) ? $operator : "";
                        $app_miscall_data['created_date'] = date('Y-m-d H:i:s');
                        $this->db->insert("app_miscall_data", $app_miscall_data);

                        $err['message'] = "Your request has been processed successfully.";
                        echo json_encode($err);
                    } else {
                        $err['message'] = "No Api to send sms.";
                        echo json_encode($err);
                    }
                } else {
                    $err['message'] = "To is required";
                    echo json_encode($err);
                }
            } else {
                $err['message'] = "User token is required";
                echo json_encode($err);
            }
        } else {
            $err['message'] = "User token is required";
            echo json_encode($err);
        }
    }

    function cdr_notification() {

        $dats = "";
        if (isset($_REQUEST)) {
            $dats = file_get_contents('php://input');
        }

        $app_miscall_data['details'] = $dats;

        $this->db->insert("app_cdr_notification", $app_miscall_data);
    }

}
