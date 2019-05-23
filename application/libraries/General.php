<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

Class General {

    protected $CI;
    public $orderBook;

    function __construct() {
        $this->CI = & get_instance();
        $this->orderBook = array();
    }

    public static function encrypt_decrypt($action, $string) {
        $output = false;

        $key = '@2g';

        // initialization vector
        $iv = md5(md5($key));

        if ($action == 'encrypt') {
            $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
            $output = str_replace('\0', '', addslashes(rtrim($output, "")));
        }

        return trim($output, "=");
    }

    function encrypt($sData, $sKey = '@2g') {
        $sResult = '';
        for ($i = 0; $i < strlen($sData); $i++) {
            $sChar = substr($sData, $i, 1);
            $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
            $sChar = chr(ord($sChar) + ord($sKeyChar));
            $sResult .= $sChar;
        }
        return $this->encode_base64($sResult);
    }

    function decrypt($sData, $sKey = '@2g') {
        $sResult = '';
        $sData = $this->decode_base64($sData);
        for ($i = 0; $i < strlen($sData); $i++) {
            $sChar = substr($sData, $i, 1);
            $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
            $sChar = chr(ord($sChar) - ord($sKeyChar));
            $sResult .= $sChar;
        }
        return $sResult;
    }

    function encode_base64($sData) {
        $sBase64 = trim(base64_encode($sData), '=');
        return strtr($sBase64, '+/', '-_');
    }

    function decode_base64($sData) {
        $sBase64 = strtr($sData, '-_', '+/');
        return base64_decode($sBase64);
    }

    function createfolder($path) {
        $site_path = $this->CI->config->item('upload_path');
        $res = '';
        $pathfolder = @explode("/", str_replace($site_path, "", $path));
        $realpath = "";
        for ($p = 0; $p < count($pathfolder); $p++) {
            if ($pathfolder[$p] != '') {
                $realpath = $realpath . $pathfolder[$p] . "/";
                $makefolder = $site_path . "/" . $realpath;
                if (!is_dir($makefolder)) {
//                    $makefolder = @mkdir($makefolder, 0777);
//                    @chmod($makefolder, 0777);

                    $oldUmask = umask(0);
                    $res = @mkdir($makefolder, 0777);
                    @chmod($makefolder, 0777);
                    umask($oldUmask);
                }
            }
        }

        return $res;
    }

    function encryptData($input) {
        $output = trim(base64_encode(base64_encode($input)), '==');
        $output = $this->encrypt($input);
        //$output = $this->encrypt_decrypt('encrypt', $input);
        
        return $output;
    }

    function decryptData($input) {
        $output = base64_decode(base64_decode($input));
        $output = $this->decrypt($input);
        //$output = $this->encrypt_decrypt('decrypt', $input);
        return $output;
    }

    function SendEmail($mess, $data) {
        $html = '';
        if ($mess != '' && $mess != NULL) {
            $html .= '<tr>';
            $html .= '<td align="center"><h3 style="font-family: HelveticaNeue-Bold;font-size: 24px;color: #4A4A4A;letter-spacing: 0;line-height: 30px;margin-top:25px;">' . $mess . '</h3>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        if (!empty($data) && $data != NULL) {
            $html .= '<tr>
                        <table style="border: 1px solid black;width:100%">';
            foreach ($data as $value) {
                $html .= '<tr>
                              <td style="border: 1px solid gray;">' . $value . '</td>
                          </tr>';
            }
            $html .= '</table>
                       </tr>';
        }
        return $html;
    }

    function save_notification($values) {
        date_default_timezone_set('Asia/Kolkata');
        $CI = & get_instance();
        $data = array(
            'transporter_id' => isset($values['transporter_id']) ? $values['transporter_id'] : 0,
            'post_id' => isset($values['post_id']) ? $values['post_id'] : 0,
            'amount' => isset($values['amount']) ? $values['amount'] : 0,
            'user_wallet' => isset($values['user_wallet']) ? $values['user_wallet'] : 0,
            'transporter_wallet' => isset($values['transporter_wallet']) ? $values['transporter_wallet'] : 0,
            'status' => isset($values['status']) ? $values['status'] : 0,
            'user_id' => isset($values['user_id']) ? $values['user_id'] : 0,
            'user_type' => isset($values['user_type']) ? $values['user_type'] : "U",
            'details' => isset($values['details']) ? $values['details'] : "",
            'notification_for' => isset($values['notification_for']) ? $values['notification_for'] : "",
            'notification_title' => isset($values['notification_title']) ? $values['notification_title'] : "",
            'created_on' => isset($values['created_on']) ? $values['created_on'] : date('Y-m-d H:i:s'),
        );


        $CI->db->select('notification_id');
        $CI->db->from('tbl_notification');
        //$CI->db->where('transporter_id', $values['transporter_id']);
        $CI->db->where('user_id', $values['user_id']);
        $CI->db->where('post_id', $values['post_id']);
        $CI->db->where('user_type', $values['user_type']);
        $query = $CI->db->get();
        $results = $query->result_array();

        if (count($results) > 0) {
            //$CI->db->where('transporter_id', $values['transporter_id']);
            $CI->db->where('user_id', $values['user_id']);
            $CI->db->where('post_id', $values['post_id']);
            $CI->db->where('user_type', $values['user_type']);
            $CI->db->update('tbl_notification', $data);
            return TRUE;
        } else {
            $id = $CI->db->insert("tbl_notification", $data);
            if ($id) {
                return $id;
            } else {
                return false;
            }
        }
    }

}
