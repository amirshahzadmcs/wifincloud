<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Social_login extends CI_Controller { 
    function __construct() { 
        parent::__construct(); 
         
        // Load facebook oauth library 
        $this->load->library('social_login_lib'); 
    } 
     
    public function index(){ 
		
		if( isset($_SESSION["social_login_session"]) )
			unset($_SESSION["social_login_session"]);

		$social_media_name =  $this->uri->segment('2');
		// this function configer session of user detail
		get_social_media_configration( $social_media_name  );

		$social_data  = $this->social_login_lib->social_uth( );
		
		if( isset($social_data['user_info']) ){
			
			$user_info =  $social_data['user_info'];
			$logged_via =  $social_data['logged_via'];
			
			$email = $user_info->email;
			$name = $user_info->firstName." ".$user_info->lastName;
			unset($_SESSION["social_login_session"]);
			subscriber_login( $name , $email , 0, '' , $logged_via );
		}else{
			redirect(base_url()."f/subscriber/loginForm");
		}
	}	
}


