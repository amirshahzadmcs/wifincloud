<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accesspoint_model extends MY_Model {

	public $table = 'ap_devices';

	public function __construct()
	{
		parent::__construct();
	}
    
	
	public function get_domain_info( $domain_id ){
		return $this->db->get_where( 'domains' , ['id' => $domain_id])->first_row();
	}
	
	public function get_total_access_points(){
		return $this->db->get( 'ap_devices')->num_rows();
	}
	
	public function add_access_points( $access_points ){
		$repeated = array();
		foreach($access_points as $row){
			$db_access_point = $this->is_exist_access_point( $row['device_mac'] );
			if( empty( $db_access_point ) ){
				$this->db->insert('ap_devices', array( "device_mac" => $row['device_mac'],  "location_id" => $row['location_id']  ) );
			}else{
				array_push($repeated , $row);
			}
		}
		return $repeated;
	}
	
	public function is_exist_access_point( $mac_address ){
		return $this->db->get_where( 'ap_devices' , ['device_mac' => $mac_address])->row();
	}
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */