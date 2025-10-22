<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
/** 
 * Facebook PHP SDK v5 for CodeIgniter 3.x 
 * 
 * Library for Facebook PHP SDK v5. It helps the user to login with their Facebook account 
 * in CodeIgniter application. 
 * 
 * This library requires the Facebook PHP SDK v5 and it should be placed in libraries folder. 
 * 
 * It also requires social configuration file and it should be placed in the config directory. 
 * 
 * @package     CodeIgniter 
 * @category    Libraries 
 * @author      CodexWorld 
 * @license     http://www.codexworld.com/license/ 
 * @link        http://www.codexworld.com 
 * @version     3.0 
 */ 
 
// Include the autoloader provided in the SDK 
require_once APPPATH .'third_party/Auth/autoload.php';  
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

class Social_login{
	
	public function __construct(){  }
	
	function social_uth( $social_media_name ){
		
		$social_config = get_configration( $social_media_name );
		
		$social_media_name = ucfirst(strtolower($social_media_name));
		
		$config = [
			'callback' => "https://localhost/wifi/facebook_c",
			'providers' => [
				$social_media_name => [ 
					'enabled' => true, 
					'keys' => [
						'id' => $social_config['app_id'], 
						'secret' => $social_config['app_secret'] 
					], 
				] 	
			],
		];
		
		try {
			$hybridauth = new Hybridauth($config);

			$adapter = $hybridauth->authenticate( $social_media_name );

			// $adapter = $hybridauth->authenticate('Google');
			// $adapter = $hybridauth->authenticate('Facebook');
			// $adapter = $hybridauth->authenticate('Twitter');

			$tokens = $adapter->getAccessToken();
			$userProfile = $adapter->getUserProfile();
			
			echo "<pre>";
			print_r($tokens);
			print_r($userProfile);
			
			echo "</pre>";
			$adapter->disconnect();
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
}
?>