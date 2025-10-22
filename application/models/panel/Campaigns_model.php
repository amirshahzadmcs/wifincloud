<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Campaigns_model extends MY_Model
{

	public $table = 'campaigns';

	public function __construct()
	{
		parent::__construct();
	}

	public function active_campaign()
	{
		
		$currentDatetime = date('Y-m-d H:i:s');
		
		$sql = "SELECT * FROM campaigns
        WHERE start_datetime <= ? 
        AND end_datetime >= ? 
        AND campaign_status = 1
		LIMIT 1"; // Limit to one record
		
		$query = $this->db->query($sql, array($currentDatetime, $currentDatetime));
		$active_campaigns = $query->row_array();
		if(empty($active_campaigns)){
			return '0';
		}else{
			// Fetch the first result as an associative array
			return $active_campaigns;
		}
	}
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */