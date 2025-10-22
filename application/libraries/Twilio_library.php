<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  =======================================
 *  Author     : Amir shahzad
 *  License    : Protected
 *  Email      : amir.shahzad.mcs@gmail.com
 *  =======================================
 */
//require_once APPPATH."/third_party/twilio/autoload.php";
require_once APPPATH."third_party/Twilio/autoload.php";

use Twilio\Rest\Client;
class Twilio_library{
    
	function  twilio_send_sms($api_secret_code  , $api_key , $api_from , $phone_number ,  $body){
		
		try {
			$client = new Client($api_secret_code, $api_key);
			$client->messages->create( $phone_number , 	[ 'from' => $api_from , 'body' => $body ] );
			return true;
		} catch ( Twilio\Exceptions\RestException $e ) {
			return false;
		}
	}
	
	
	function send_twilio_sms( $sms_detail , $change_number = false ){
		
		$code = substr(str_shuffle("0123456789"), 0, 5);
		$code_expire_time = date("H:i:s", strtotime(date("H:i:s") . " +5 minutes"));
		$code_send_time = date("H:i:s");
		 $CI = & get_instance();
		 $domain_setting = getDomainSetting( $_SESSION['dname'] , 'intervelSetting' );
		
		$phone_number = (isset($sms_detail->phone_number))? $sms_detail->phone_number : $sms_detail;

		$send_sms_detail = array();
		
		// if normal login send then this if condition will be run and send sms to user or if user want to resend OTP
		$count_acount = (isset($sms_detail->code_count))? $sms_detail->code_count : 0;
		if( !$change_number ){
			$send_sms_detail = (object)array(
					"name" 			=> $sms_detail->name, 
					"phone_number" 	=> $sms_detail->phone_number, 
					"device" 		=> $sms_detail->device, 
					"email" 		=> $sms_detail->email, 
					"code" 			=> $code, 
					"ip" 			=> get_client_ip(), 
					"is_block" 		=> false, 
					"code_count" 	=>  $count_acount+1,
					"code_expire_time" 	=> $code_expire_time, 
					"code_send_time" 	=> $code_send_time, 
					"is_send" 			=> false,
			);
		}else{
			
			// when user click on chnage the number button this else condition will be run
			
			$sms_session = $CI->session->userdata('sms_verification_detail');
			
			$send_sms_detail = (object)array(
					"name" 			=> $sms_session->name, 
					"phone_number" 	=> $sms_detail,
					"device" 		=> $sms_session->device, 
					"email" 		=> $sms_session->email, 
					"code" 			=> $code,
					"ip" 			=> get_client_ip(), 
					"is_block" 		=> false, 
					"code_count" 	=> $sms_session->code_count +1,
					"code_expire_time" 	=> $code_expire_time, 
					"code_send_time" 	=> $code_send_time, 
					"is_send" 			=> false,
			);
		}
		
		$body 				= "Your OTP for Wi-Fi is ". $code ."\n Enjoy free internet.";
		$api_secret_code 	= $domain_setting->twilio->api_secret_code;
        $api_key 			= $domain_setting->twilio->api_key;
        $api_from 			= $domain_setting->twilio->api_from;
		
		if($this->twilio_send_sms($api_secret_code , $api_key , $api_from , $phone_number , $body)){
			
			sms_count('twillio');
			$send_sms_detail->is_send 	= true;
			unset_unwanted_session();
			$CI->session->set_userdata('sms_verification_detail', $send_sms_detail); 
			redirect(base_url() . 'f/subscriber/login_verification', 'refresh');
			
		}else{
			
			$CI->session->set_flashdata('successMes' , '<div class="alert alert-danger" role="alert">OPT has not been send. Please contact administration.</div> ');
			redirect(base_url().'f/subscriber/loginForm','refresh');
		}
	}
	
}
?>