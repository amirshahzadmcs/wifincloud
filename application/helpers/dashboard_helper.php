<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    function save_dashboard_info( $domain_db_name , $content_array ){
		
        /**
         * $domain_db_name -> Domain id mean current login domain
        *
        *  $key_name -> Make uniqe name of setting 
        *
        *  $content_array -> Mean save all setting data 
        *   Setting formate : [ "Settingkey1" => 'Setting Value' , "Settingkey2" => 'Setting Value2'];
        *
        *   All Setting Names array
        *   [ intervelSetting  ]
        *
        */
        
		if( empty( $domain_db_name ) or empty( $content_array ) ) return false;
		
		$fileName = "assets/domains/".$domain_db_name.'/'.$domain_db_name.'_dashboard_info.json';

        if (!file_exists("assets/domains/".$domain_db_name)) {
            @mkdir("assets/domains/".$domain_db_name, 0777, true);
        }

		if( !file_exists($fileName) ) fopen($fileName, 'w');

       /*  $fileData = array();
        $file = @fopen($fileName, "r");
        if(filesize($fileName) > 0){
            $fileData =  @fread($file,filesize($fileName));
        } */
        
        /* if(empty($fileData)){
            $fileData[$key_name] = $content_array;
        }else{
            $fileData = json_decode($fileData);
            $fileData->$key_name = $content_array;
        } */
        //fclose($file);
        
        $file = @fopen($fileName, "w");
        @fwrite($file, json_encode( $content_array ));
        @fclose($file);
        return true;

	}
	
	function get_dashboard_info( $domain_db_name , $key_name = "" ){
		
        /**
        *   $domain_db_name -> Domain id mean current login domain
        *
        *   $key_name -> Make uniqe name of setting 
        *   Return value is array
        */

		if( empty( $domain_db_name ) ) return array(); 
		
        $fileName = "assets/domains/".$domain_db_name.'/'.$domain_db_name.'_dashboard_info.json';
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

				if(!empty( $key_name )){
					return $fileData->$key_name;
				}else{
					return $fileData;
				}
			}
			fclose($file); 
		}else{
            
            return array();
        }
    }
	
?>