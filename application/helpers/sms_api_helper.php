<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');




function send_twillio_sms($redirect = ''){
    
        $CI = & get_instance();
        $CI->load->library('twilio_library');
        //use Twilio\Rest\Client;
        $domain_setting = getDomainSetting( $_SESSION['dname'] , 'intervelSetting' );
        $sms_verification_detail =  $CI->session->userdata('sms_verification_detail');
        $name = $sms_verification_detail->name; 
        $phone_number = $sms_verification_detail->phone_number;
        $code = $sms_verification_detail->code;
        $email = $sms_verification_detail->email;
        $code_expire_time = $sms_verification_detail->code_expire_time;
        $code_send_time = $sms_verification_detail->code_send_time;
        $is_send = $sms_verification_detail->is_send;
        $code_count = $sms_verification_detail->code_count;
        $ip = $sms_verification_detail->ip;
        $device = $sms_verification_detail->device;
        $api_detail = $domain_setting->twilio;

        $api_secret_code = $api_detail->api_secret_code;
        $api_key = $api_detail->api_key;
        $api_from = $api_detail->api_from;
        $body = "Your OTP for Wi-Fi is ".$sms_verification_detail->code."\n Enjoy free internet.";

    if($CI->twilio_library->twilio($api_secret_code , $api_key , $api_from , $phone_number , $body)){
            sms_count('twillio');
            $send_sms_detail = (object)array(
                "name" => $name,
                "phone_number" => $phone_number,
                "email" => $email,
                "code" => $code,
                "device" => $device,
                "ip" => get_client_ip(),
                "is_block" => false,
                "code_count" => 1+(int)$code_count,
                "code_expire_time" => $code_expire_time,
                "code_send_time" => $code_send_time,
                "is_send" => true,
            );
        
        $CI->session->set_userdata('sms_verification_detail', $send_sms_detail); 
        if(!empty($redirect)){
            redirect(base_url().'f/subscriber/loginForm','refresh');
        }
    }else{
        unset ($_SESSION["is_change_phone"]);
        unset ($_SESSION["sms_block"]);
        unset ($_SESSION["sms_verification_detail"]);
        $CI->session->set_flashdata('successMes' , '<div class="alert alert-danger" role="alert">OPT has not been send. Please contact administration.</div> ');
        redirect(base_url().'f/subscriber/loginForm','refresh');
    }

}
    function send_monty_sms(){
        
        $domain_setting = getDomainSetting( $_SESSION['dname'] , 'intervelSetting' );
        $sms_verification_detail =  $CI->session->userdata('sms_verification_detail');
        $name = $sms_verification_detail->name; 
        $phone_number = $sms_verification_detail->phone_number;
        $code = $sms_verification_detail->code;
        $email = $sms_verification_detail->email;
        $code_expire_time = $sms_verification_detail->code_expire_time;
        $code_send_time = $sms_verification_detail->code_send_time;
        $is_send = $sms_verification_detail->is_send;
        $code_count = $sms_verification_detail->code_count;
        $ip = $sms_verification_detail->ip;
        $device = $sms_verification_detail->device;
        
        $api_detail = $domain_setting->MONTY;

        $api_secret_code = $api_detail->api_secret_code;
        $api_key = $api_detail->api_key;
        $api_from = $api_detail->api_from;
                    
        monty_api( $api_secret_code , $api_key , $name , $phone_number , $body ); 
        sms_count('monty');
        $send_sms_detail = (object)array(
            "name" => $name,
            "phone_number" => $phone_number,
            "email" => $email,
            "code" => $code,
            "device" => $device,
            "ip" => get_client_ip(),
            "is_block" => false,
            "code_count" => 1+(int)$code_count,
            "code_expire_time" => $code_expire_time,
            "code_send_time" => $code_send_time,
            "is_send" => true,
        );
        $CI->session->set_userdata('sms_verification_detail', $send_sms_detail);
    }

    function if_sms_not_send_redirect(){
        unset ($_SESSION["is_change_phone"]);
        unset ($_SESSION["sms_block"]);
        unset ($_SESSION["sms_verification_detail"]);
        $CI->session->set_flashdata('successMes' , '<div class="alert alert-danger" role="alert">OPT has not been send. Please contact administration.</div> ');
        redirect(base_url().'f/subscriber/loginForm','refresh');
        unset ($_SESSION["successMes"]);
    }
	
	
	function send_test_sms( $api_secret_code , $api_key , $api_from , $phone_number , $text ){
		$CI = & get_instance();
        
        $CI->load->library('twilio_library');
		if($CI->twilio_library->twilio_send_sms($api_secret_code , $api_key , $api_from , $phone_number , $text)){
			return true;
        }else{
			return false;
		}
		
	}
	
	
	
?>