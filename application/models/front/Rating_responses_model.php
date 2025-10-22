<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating_responses_model extends MY_Model {

	public $table = 'rating_responses';

	public function __construct()
	{
		parent::__construct(); 
	}
    public function answersCountByCid($campaign_id)
	{
		$this->db->where('campaign_id', $campaign_id);
		return $this->db->count_all_results($this->table);
	}

	public function getFilteredAnswersByCid($limit, $start, $campaign_id)
	{
		if( !empty($limit) ){
			$this->db->limit($limit, $start);
		}
		$this->db->where('campaign_id', $campaign_id);
		return $this->db->get($this->table)->result();
	}
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */