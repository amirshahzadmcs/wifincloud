<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_logs_model extends MY_Model {

	public $table = 'activity_logs';

	public function __construct()
	{
		parent::__construct();
		// $this->table_key = 'id';
		// $this->addSample();
	}

	function getAllLogs(){ 
		return $this->db->get('activity_logs')->result();
	}

}

/* End of file Settings_model.php */
/* Location: ./application/models/Settings_model.php */