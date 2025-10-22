<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    function saveDomainSetting( $domain_db_name , $settingName , $SettingContentInArray ){
		
        /**
         * $domain_db_name -> Domain id mean current login domain
        *
        *  $settingName -> Make uniqe name of setting 
        *
        *  $SettingContentInArray -> Mean save all setting data 
        *   Setting formate : [ "Settingkey1" => 'Setting Value' , "Settingkey2" => 'Setting Value2'];
        *
        *   All Setting Names array
        *   [ intervelSetting  ]
        *
        */
        
		if( empty( $domain_db_name ) or  empty( $settingName ) or  empty( $SettingContentInArray ) ) return false;
		
		$fileName = "assets/domains/".$domain_db_name.'/'.$domain_db_name.'_settings.json';

        if (!file_exists("assets/domains/".$domain_db_name)) {
            @mkdir("assets/domains/".$domain_db_name, 0777, true);
        }

		if( !file_exists($fileName) ) fopen($fileName, 'w');

        $fileData = array();
        $file = @fopen($fileName, "r");
        if(filesize($fileName) > 0){
            $fileData =  @fread($file,filesize($fileName));
        }
        
        if(empty($fileData)){
            $fileData[$settingName] = $SettingContentInArray;
        }else{
            $fileData = json_decode($fileData);
            $fileData->$settingName = $SettingContentInArray;
        }
        fclose($file);
        
        $file = @fopen($fileName, "w");
        @fwrite($file, json_encode( $fileData ));
        @fclose($file);
        return true;

	}
	
	function getDomainSetting( $domain_db_name , $settingName ){
		
        /**
        *   $domain_db_name -> Domain id mean current login domain
        *
        *   $settingName -> Make uniqe name of setting 
        *   Return value is array
        */

		if( empty( $domain_db_name ) or  empty( $settingName ) ) return false; 
		
        $fileName = "assets/domains/".$domain_db_name.'/'.$domain_db_name.'_settings.json';
		if( file_exists($fileName) ){
			
			$fileData = array();
			$file = @fopen($fileName, "r");
			if(filesize($fileName) > 0){
				$fileData =  @fread($file,filesize($fileName));
			}
			if(empty($fileData)){
				return array();
			}else{
                $fileData = json_decode($fileData);
				if(!empty( $fileData->$settingName )){
					return $fileData->$settingName;
				}else{
					return array();
				}
			}
			fclose($file); 
		}else{
            
            return array();
        }
    }

    function getCurrentDomain($index){

        $CI =& get_instance();
        $domainInfo = $CI->session->userdata('globelDomain');
        if(isset($domainInfo->$index)){ return $domainInfo->$index; }else{ return false; }
    
    }

    function is_set_domainSetting(){
        $CI =& get_instance();
        $domainInfo = $CI->session->userdata('globelDomain');
        if(!isset($domainInfo->domain_db_name)){
            redirect(base_url().'logout','refresh');
        }
    } 

    function check_domain($domain_db_name){
        $CI =& get_instance();
        switch_db(default_db_name());
        $domainInfo = $CI->db->where("domain_db_name" , $domain_db_name)->get("domains")->result();
        if(isset($domainInfo[0]->id)){
            return true;
        }else{
            false;
        }
    }

    if (!function_exists('licenceDateLeft')) {
        function licenceDateLeft($date) {

            $currentDate = new DateTime();
            $targetDate = new DateTime($date);
            $interval = $currentDate->diff($targetDate);
            $daysLeft = $interval->format('%R%a'); // Total days difference
            
            $sign = substr($daysLeft, 0, 1); // Get the sign (+ or -)
            $days = substr($daysLeft, 1); // Get the numeric value of days

            if( $sign == '+' ){
                $daysLeft = 2 + $days;
            }elseif($sign == '-' && $days == 0){
                $daysLeft = 1 + (int)$days;
                
            }else{
                $daysLeft = "-".$days;
            }
            return $daysLeft;
        }
    }
    

    if (!function_exists('licenceDateColor')) {
        function licenceDateColor($date) {

            $daysLeft = licenceDateLeft($date);
            $isExpired = false;

            $color = "";
            if ($daysLeft > 30) {
                $color = 'success';
                $date = 'will expire on '.$date;
            } elseif ($daysLeft <= 30 && $daysLeft > 15) {
                $color = 'success'; // Original color
                $date = 'will expire in '.$daysLeft.' days';
            } elseif ($daysLeft <= 15 && $daysLeft > 7) {
                $color = 'warning'; // Original color
                $date = 'will expire in '.$daysLeft.' days';
            } elseif ($daysLeft <= 7 && $daysLeft > 0) {
                $color = 'danger';
                $date = 'will expire in '.$daysLeft.' days';
            } elseif ($daysLeft == 0) {
                $color = 'danger';
                $date = 'has expired';
                $daysLeft = "expired";
                $isExpired = true;
            } else {
                $color = 'danger';
                $daysLeft = abs($daysLeft);
                $date = 'has expired '.$daysLeft.' days ago';
                $daysLeft = "expired";
                $isExpired = true;
            }

            return [ 'date' => $date , 'color' => $color , 'figer' => $daysLeft , 'isExpired' => $isExpired];
        }
    }

?>