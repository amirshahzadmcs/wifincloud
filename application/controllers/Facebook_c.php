<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Facebook_c extends CI_Controller { 
    function __construct() { 
        parent::__construct(); 
         
        // Load facebook oauth library 
        $this->load->library('social_login_lib'); 
    } 
     
    public function index(){ 
        //$this->social_login->social_uth("facebook");
        //$this->social_login->social_uth("google");
		$social_media_name =  $this->uri->segment('2');
		$social_data  = $this->social_login_lib->social_uth($social_media_name);
		
		if( isset($social_data->email) ){
			
			$email = $social_data->email;
			$name = $social_data->firstName." ".$social_data->lastName;
			
		}else{
			
		}
	} 	
}


