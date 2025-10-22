<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function error_404()
	{
		$this->load->view('error/404', $this->page_data);
	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/Admin/Logout.php */