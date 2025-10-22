<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->page_data['page']->title = 'Exports management';
		$this->page_data['page']->menu = 'export';
		
	}
	

	public function index()
	{
		
		ifPermissions('reporting');
        $domain = !empty(get('domains')) ? urldecode(get('domains')) : false;
        $arg = [];

		//if the domain parameter is empty on url. 
		// single domain owner handle: 
		if(empty(get('domains'))){
			$domainsRes = $this->domains_model->getByUserId(logged("id"));
            $count_domain = count($domainsRes);
			if($count_domain == 1){
				//redirect('panel/reports/?domains='.$domain_id );
				//print_r($domainsRes);
				$domain = $domainsRes[0]->id; 
			}
		}
		if($domain){
			$this->page_data['domain_id'] = $domain;
			$arg['id'] = $domain;
        
            $selected_domain = $this->domains_model->getById($domain);
            if($selected_domain->users_id != logged("id")  && logged("role") != 1){
                ifPermissions('not_allowed');
                return;
            }
            
            //switching to db 
            switch_db($selected_domain->domain_db_name);
            
			//setting up the url and page segment 
			$config = array();
			$config["base_url"] = base_url() . "panel/reports";
			$config['reuse_query_string'] = true;
			$config['allow_get_array'] = true;
			$config["total_rows"] = $this->subscribers_model->countAll();
			$config["per_page"] = 20;
			$config["uri_segment"] = 3;
			
			//pagination styles configuration 
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';

			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '‹';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';

			$config['next_link'] = '›';
        	$config['next_tag_open'] = '<li>';
        	$config['next_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="#">';
        	$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li>';
        	$config['num_tag_close'] = '</li>';

			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['first_link'] = false;
        	$config['last_link'] = false;
	


			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$this->page_data["links"] = $this->pagination->create_links();

			$where_filter = array(

			);
			$this->page_data['subscribers_list'] = $this->subscribers_model->getSubscribersWhere($config["per_page"], $page, $where_filter);
            //print_r($this->page_data['subscribers_list']);
			//switching to parent db 
            switch_db(default_db_name());
        
        }
        $this->load->view('panel/export/list', $this->page_data);
	}

	

	

    
	public function view($id)
	{

		ifPermissions('users_view');

		$this->page_data['User'] = $this->users_model->getById($id);
		$this->page_data['User']->role = $this->roles_model->getByWhere([
			'id'=> $this->page_data['User']->role
		])[0];
		$this->page_data['User']->activity = $this->activity_model->getByWhere([
			'user'=> $id
		], [ 'order' => ['id', 'desc'] ]);
		$this->load->view('users/view', $this->page_data);

	}

	
	public function change_status($id, $domain_id)
	{
        
        switch_db_by_domain_id($domain_id);
        
		$this->subscribers_model->update($id, ['status' => get('status') == 'true' ? 1 : 0 ]);
        //switching the db back
        switch_db(default_db_name());
		echo 'done';
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */