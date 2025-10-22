<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_history_model extends MY_Model {

	public $table = 'login_history';

	public function __construct()
	{
		parent::__construct();
	} 
    /**
	  * Get today's subscribers 
	  *
	  * @return array Data
	  * $limit is the limit to collect data in one iteration
	  * start is the row id to start the collection from
	  */
	  public function countWhere($whereArg)
	  {
		  return $this->db->get_where($this->table, $whereArg)->result();
		  //return $this->db->count_all_results();
		  //return $this->result()->num_rows;
		  //return $this->db->num_rows();
	  }
	
	
	 function get_new_subscribers_count(){
		$this->db->join('login_history_detail', "subscribers.id = login_history_detail.subscriber_id");
		$this->db->select('*');
		$this->db->from('subscribers');
		$this->db->where('login_history_detail.login_count  =',1);
		return $this->db->get($this->table)->num_rows();	
	}
	  
	  
	  public function getGroupBy($whereArg, $group_by){
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->db->group_by($group_by); 
		$this->db->join('login_history_detail', 'login_history.subscriber_id = login_history_detail.subscriber_id');

		return $this->db->get_where($this->table, $whereArg)->result();
		
		// SELECT `subscriber_id` FROM `login_history_detail` WHERE `login_time` >= CURDATE() GROUP BY `subscriber_id`

	  }
	  
	  public function last_returning_subscriber($whereArg){
		$this->db->limit(4);
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->db->group_by('login_history_detail.subscriber_id'); 
		$this->db->join('login_history_detail', 'login_history.subscriber_id = login_history_detail.subscriber_id');
		$this->db->join('subscribers', 'subscribers.id = login_history.subscriber_id');
		return $this->db->get_where($this->table, $whereArg)->result();
		// SELECT `subscriber_id` FROM `login_history_detail` WHERE `login_time` >= CURDATE() GROUP BY `subscriber_id`
	  }
    
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */