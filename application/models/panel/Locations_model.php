<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations_model extends MY_Model {

	public $table = 'locations';

	public function __construct()
	{
		parent::__construct(); 
	}
    
	
	function get_location_by_id($location_id){
		return $this->db->get_where( 'locations' , ['id' => $location_id])->first_row();
	}
	
	function is_active_location($location_id){
		return $this->db->get_where( 'locations' , ['id' => $location_id , "status" => 1])->first_row();
	}
	
	function get_location_name($location_id){
		$data =  $this->db->get_where( 'locations' , ['id' => $location_id , "status" => 1])->first_row();
		if(isset($data->location_name)) return $data->location_name;
		return false;
	}
    
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */