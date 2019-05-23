<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include APPPATH . 'third_party/init.php';

Class Stripepayment {

    public function charge($data) {
        $CI = & get_instance();
        //Setup Payment and card details
        $number = isset($data['card_number']) ? $data['card_number'] : "4111 1111 1111 1111";
        $exp_month = isset($data['expiry_month']) ? $data['expiry_month'] : 01;
        $exp_year = isset($data['expiry_year']) ? $data['expiry_year'] : 2020;
        $cvc = isset($data['cvv']) ? $data['cvv'] : 123;
        $amount = $data['amount'];
        $description = isset($data['description']) ? $data['description'] : MY_SITE_NAME . " Payment";
        $amount_final = $amount * 100;

        $stripe = array(
            'secret_key' => STRIPE_SECRET_KEY,
            'publishable_key' => STRIPE_PUBLISHABLE_KEY
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        try {
            $token = \Stripe\Token::create(array(
                        "card" => array(
                            "number" => $number,
                            "exp_month" => $exp_month,
                            "exp_year" => $exp_year,
                            "cvc" => $cvc
                        )
            ));

            $message = "";
            if (isset($token['id'])) {
                $charge = \Stripe\Charge::create(array('source' => $token['id'], 'description' => $description, 'amount' => $amount_final, 'currency' => 'usd'));
                if (isset($charge['status']) && $charge['status'] == "succeeded") {
                    return $charge;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function validate_card($data) {
        //Setup Payment and card details
        $number = isset($data['card_number']) ? $this->seoUrl($data['card_number']) : "4242424242424242";
        $exp_month = isset($data['expiry_month']) ? $data['expiry_month'] : "01";
        $exp_year = isset($data['expiry_year']) ? $data['expiry_year'] : "20";
        $cvc = isset($data['cvv']) ? $data['cvv'] : "123";

        $stripe = array(
            'secret_key' => STRIPE_SECRET_KEY,
            'publishable_key' => STRIPE_PUBLISHABLE_KEY
        );

        try {
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
            $tokens = \Stripe\Token::create(array(
                        "card" => array(
                            "number" => $number,
                            "exp_month" => $exp_month,
                            "exp_year" => $exp_year,
                            "cvc" => $cvc
                        )
            ));
            if (isset($tokens['id'])) {
                return true;
            } else {
                return false;
            }
        }
        //catch exception
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function seoUrl($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", "", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "", $string);
        return $string;
    }

}
