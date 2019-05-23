<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include APPPATH . 'third_party/PHPMailer/class.phpmailer.php';
include APPPATH . "third_party/PHPMailer/class.smtp.php";

class Sendmail {

    public function send($toparam = array(), $subject, $html_body, $attachment = NULL) {
        $mail_dara = array();
        $CI = & get_instance();

        get_CompanyName();

        $CI = & get_instance();
        $CI->db->select('*', FALSE);
        $CI->db->from('app_email_setting');
        $email_datat = $CI->db->get()->row_array();

        $smtp_host = isset($email_datat['smtp_host']) ? $email_datat['smtp_host'] : "";
        $smtp_username = isset($email_datat['smtp_username']) ? $email_datat['smtp_username'] : "";
        $smtp_password = isset($email_datat['smtp_password']) ? $email_datat['smtp_password'] : "";
        $smtp_port = isset($email_datat['smtp_port']) ? $email_datat['smtp_port'] : 0;
        $smtp_secure = isset($email_datat['smtp_secure']) ? $email_datat['smtp_secure'] : "";
        $email_from_name = isset($email_datat['email_from_name']) ? $email_datat['email_from_name'] : "";

        $MY_SITE_EMAIL = get_site_setting('site_email');
        $MY_SITE_PHONE = get_site_setting('site_phone');

        $CI = & get_instance();
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        // $mail->SMTPDebug = 2;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = $smtp_secure;
        $mail->Port = $smtp_port;
        $mail->From = $smtp_username;
        $mail->FromName = $email_from_name;

        if (isset($toparam) && count($toparam) > 0) {
            $to_email = $toparam['to_email'];
            $to_name = $toparam['to_name'];
        }

        $mail->addAddress($to_email, $to_name);
        if ($attachment != NULL) {
            $mail->addAttachment($attachment);
        }

        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html_body;

        $mail_dara['email'] = $to_email;
        $mail_dara['name'] = $to_name;
        $mail_dara['content'] = $html_body;
        $mail_dara['created_date'] = date('Y-m-d H:i:s');

        if (!$mail->send()) {
            $mail_dara['status'] = 'Not Sent';
            $mail_dara['details'] = $mail->ErrorInfo;
            $CI->db->insert('app_email_log', $mail_dara);
            return false;
        } else {
            $mail_dara['details'] = "";
            $mail_dara['status'] = 'Sent';
            $CI->db->insert('app_email_log', $mail_dara);
            return true;
        }
    }

}
