<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crone extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('common_model');
        date_default_timezone_set(get_time_zone());
        //$this->index();
        //$this->cdr_report();
    }
    
    public function update_cricle_oprator(){
        $this->db->query("UPDATE app_miscall_data INNER JOIN app_circles ON app_miscall_data.circle=app_circles.CircleId SET app_miscall_data.circle=app_circles.CircleName");
        
        $this->db->query("UPDATE app_miscall_data INNER JOIN app_operators ON app_miscall_data.operator=app_operators.OperatorId SET app_miscall_data.operator=app_operators.OperatorName");
        
        $app_crone_check['type'] = "Circle Operator";
        $app_crone_check['created_date'] = date("Y-m-d H:i:s");
        $this->db->insert('app_crone_check', $app_crone_check);
    }

    public function index() {
        // first get data of previous entry
        $this->db->query("UPDATE app_miscall_data INNER JOIN app_circles ON app_miscall_data.circle=app_circles.CircleId SET app_miscall_data.circle=app_circles.CircleName");
        $date_query = $this->db->query("SELECT created_date FROM app_miscall_data WHERE record_type='Long Code' order by created_date desc LIMIT 1")->result_array();

        if (isset($date_query) && count($date_query) > 0):

            $otherdb = $this->load->database('otherdb', TRUE);
            $sel1 = "SELECT * FROM user_api_details WHERE user_api_details.date >'" . $date_query[0]['created_date'] . "' AND uid=10";
            $date_query_two = $otherdb->query($sel1)->result_array();

            if (count($date_query_two) > 0):
                foreach ($date_query_two as $row) {
                    //get user name from app table
                    $user_master = $otherdb->query("SELECT * FROM user_master WHERE uid=" . $row['uid'])->row_array();
                    $uname = isset($user_master['uname']) ? trim($user_master['uname']) : "";

                    //get user id from existing table
                    $users = $this->db->query("SELECT * FROM app_users WHERE email='" . $uname . "'")->row_array();
                    $user_id = isset($users['user_id']) ? $users['user_id'] : 0;

                    //check condition
                    $message_data['userid'] = $user_id;
                    $message_data['uname'] = $uname;
                    $message_data['user_service'] = $row['user_service'];
                    $message_data['service_type'] = $row['service_type'];
                    $message_data['mobile_no'] = $row['mobile_no'];
                    $message_data['date'] = $row['date'];
                    $message_data['user_message'] = $row['user_message'];

                    $this->check_condition($message_data);
                }
            endif;
        else:
            $otherdb = $this->load->database('otherdb', TRUE);
            $sel1 = "SELECT * FROM user_api_details  WHERE uid=10";
            $res1s = $otherdb->query($sel1)->result_array();

            foreach ($res1s as $row) {

                $user_master = $otherdb->query("SELECT * FROM user_master WHERE uid=" . $row['uid'])->row_array();
                $uname = isset($user_master['uname']) ? trim($user_master['uname']) : "";

                //get user id from existing table
                $users = $this->db->query("SELECT * FROM app_users WHERE email='" . $uname . "'")->row_array();
                $user_id = isset($users['user_id']) ? $users['user_id'] : 0;


                //check condition
                $message_data['userid'] = $user_id;
                $message_data['uname'] = $uname;
                $message_data['user_service'] = $row['user_service'];
                $message_data['service_type'] = $row['service_type'];
                $message_data['mobile_no'] = $row['mobile_no'];
                $message_data['date'] = $row['date'];
                $message_data['user_message'] = $row['user_message'];
                $this->check_condition($message_data);
            }
        endif;
    }

    function check_condition($data) {
        if ($data['userid'] > 0) {
            $status = "";
            $sms_code_value = 0;
            $message_sent = "";
            
            
            if($data['userid']==19){
                 $message_sent = "Thanks for sharing the excuses in Bournvita Biscuits No More Excuses Contest We will get back to you if you are shortlisted Visit bournvitabiscuits.com for TC";
                $this->send_messages($data['mobile_no'], $message_sent);
                $status = "Valid";
            }
            

            $user_api_details['user_id'] = $data['userid'];
            $user_api_details['message'] = $data['user_message'];
//            $user_api_details['message_sent'] = $message_sent;
            $user_api_details['to'] = $data['mobile_no'];
            $user_api_details['created_date'] = $data['date'];
            $user_api_details['status'] = $status;
            $user_api_details['record_type'] = 'Long Code';

            $this->db->insert('app_miscall_data', $user_api_details);
        }
    }


function send_messages($to, $message) {
    $CI = & get_instance();
    $CI->db->select('sms_key,sms_sender');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->row_array();
    $sms_key = $user_data['sms_key'];
    $sms_sender = $user_data['sms_sender'];

    //$to = str_replace('+', '', $to);
    $message = str_replace('&', '%26', $message);
    $url = "http://sms.webozindia.in/api/v3/?method=sms&api_key=A8493f89cf6cf24e6b3b55cdc38f886bf&to=" . $to . "&sender=BOURNV&message=". $message;
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

    function cdr_report() {
        $report_data = $this->db->query("select * from app_cdr_notification where 1 limit 25")->result_array();

        foreach ($report_data as $val):
            $data1 = json_decode($val['details']);
            foreach ($data1 as $res):
                $update_batch = array();
                foreach ($res->data as $val2):
                    $id = isset($val2->id) ? $val2->id : "";
                    $cdr_data = array();
                    $cdr_data['response_id'] = isset($val2->id) ? $val2->id : "";
                    $cdr_data['calltype'] = isset($val2->calltype) ? $val2->calltype : "";
                    $cdr_data['namedtmf'] = isset($val2->namedtmf) ? $val2->namedtmf : "";
                    $cdr_data['pulse'] = isset($val2->pulse) ? $val2->pulse : "";
                    $cdr_data['duration'] = isset($val2->duration) ? $val2->duration : "";
                    $cdr_data['operator'] = isset($val2->operator) ? $val2->operator : "";
                    $cdr_data['namedtmf1'] = isset($val2->namedtmf1) ? $val2->namedtmf1 : "";
                    $cdr_data['statuscode'] = isset($val2->statuscode) ? $val2->statuscode : "";
                    $cdr_data['cli'] = isset($val2->cli) ? $val2->cli : "";
                    $cdr_data['recordingid'] = isset($val2->recordingid) ? $val2->recordingid : "";
                    $cdr_data['template'] = isset($val2->template) ? $val2->template : "";
                    $cdr_data['circle'] = isset($val2->circle) ? $val2->circle : "";
                    $cdr_data['delivery_status'] = isset($val2->status) ? $val2->status : "";
                    $cdr_data['recurl'] = isset($val2->recurl) ? $val2->recurl : "";
                    $cdr_data['retries'] = isset($val2->retries) ? $val2->retries : "";
                    $cdr_data['callid'] = isset($val2->callid) ? $val2->callid : "";
                    $cdr_data['cdrtype'] = isset($val2->cdrtype) ? $val2->cdrtype : "";
                    $cdr_data['dtmf'] = isset($val2->dtmf) ? $val2->dtmf : "";
                    $cdr_data['lastaudio'] = isset($val2->lastaudio) ? $val2->lastaudio : "";
                    $cdr_data['endtime'] = isset($val2->endtime) ? $val2->endtime : "";
                    $cdr_data['refid'] = isset($val2->refid) ? $val2->refid : "";
                    $cdr_data['name'] = isset($val2->name) ? $val2->name : "";
                    $cdr_data['accid'] = isset($val2->accid) ? $val2->accid : "";
                    $cdr_data['networkcode'] = isset($val2->networkcode) ? $val2->networkcode : "";
                    $cdr_data['dtmfdetail'] = isset($val2->dtmfdetail) ? $val2->dtmfdetail : "";
                    $cdr_data['refcallid'] = isset($val2->refcallid) ? $val2->refcallid : "";
                    $cdr_data['audio'] = isset($val2->audio) ? $val2->audio : "";

                    array_push($update_batch, $cdr_data);
                endforeach;
                $up_res = $this->db->update_batch('app_miscall_data', $update_batch, 'response_id');
                $app_crone_check['type'] = "CDR UPDATE";
                $app_crone_check['created_date'] = date("Y-m-d H:i:s");
                $this->db->insert('app_crone_check', $app_crone_check);
            endforeach;
            $this->db->delete('app_cdr_notification', array('id' => $val['id']));
        endforeach;
    }

}
