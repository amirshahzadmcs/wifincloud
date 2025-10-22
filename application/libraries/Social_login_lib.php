<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
/** 
 * @package     CodeIgniter 
 * @category    Libraries 
 * @version     3.0 
 */ 
 
// Include the autoloader provided in the SDK 
require_once APPPATH .'third_party/Auth/autoload.php';  
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

class Social_login_lib{
	
	public function __construct(){  }
	
	function social_uth(  ){
		
		$CI =& get_instance();
		$configs = get_session('social_login_session');
		if(!empty($configs)){
			
			$app_id 			= $configs['app_id'];
			$logged_via 		= $configs['logged_via'];
			$app_secret 		= $configs['app_secret'];
			$social_media_name 	= $configs['social_media_name'];
			
			$social_media_name = ucfirst(strtolower($social_media_name));
			
			$config = [
				'callback' => "https://localhost/wifi/social_login",
				'providers' => [
					$social_media_name => [ 
						'enabled' => true, 
						'keys' => [
							'id' => $app_id , 
							'secret' => $app_secret 
						], 
					] 	
				],
			];

			try {
				$hybridauth = new Hybridauth($config);

				$adapter = $hybridauth->authenticate( $social_media_name );

				$tokens = $adapter->getAccessToken();
				//$CI->session->unset_userdata('social_login_session');
				return ['user_info' => $adapter->getUserProfile() , 'logged_via' => $logged_via ];
				$adapter->disconnect();
			} catch (\Exception $e) {
				 echo $e->getMessage();
				 die("empty");
				redirect(base_url()."f/subscriber/loginForm");
			}
		}else{

			die("empty");
			redirect(base_url()."f/subscriber/loginForm");
		}
	}
}
?>