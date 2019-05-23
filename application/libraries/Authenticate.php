<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Authenticate {

    protected $CI;

    function __construct() {
        $this->CI = &get_instance();
    }

    function check_login() {
        $flag = false;
        if ($this->CI->session->userdata('login')) {
            $flag = true;
        }
        return $flag;
    }

}
