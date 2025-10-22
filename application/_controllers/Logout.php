<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!is_logged()){
			redirect('login','refresh');
		}

	}

	public function index()
	{

		$this->activity_model->add("User: ".logged('name').' Logged Out');
		$this->session->sess_destroy();
		unset( $_SESSION['globelDomain'] );
		$this->users_model->logout();

		redirect('login','refresh');

	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/Admin/Logout.php */