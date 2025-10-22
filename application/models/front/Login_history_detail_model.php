<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_history_detail_model extends MY_Model {

	public $table = 'login_history_detail';

	public function __construct()
	{
		parent::__construct();
	}
    
    
	public function getGroupBy($whereArg, $group_by){
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->db->group_by($group_by); 
		$this->db->join('login_history', 'login_history.subscriber_id = login_history_detail.subscriber_id');

		return $this->db->get_where($this->table, $whereArg)->result();
		
		// SELECT `subscriber_id` FROM `login_history_detail` WHERE `login_time` >= CURDATE() GROUP BY `subscriber_id`

	  }
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */