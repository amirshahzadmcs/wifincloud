<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->page_data['page']->title = 'Reports management';
		$this->page_data['page']->menu = 'reports';		
	}


	public function index()
	{
		
		ifPermissions('reporting');
		unset($_SESSION['filterRecord']);
        $domain = !empty(get('domains')) ? urldecode(get('domains')) : false;
        $arg = [];
		
		//if the domain parameter is empty on url. 
		$globelDomain = $this->session->userdata('globelDomain');
		
		$this->page_data['domain_id'] = $globelDomain->domainId;
		if($globelDomain->domainId){
			$arg['id'] = $domain;
        
            if($globelDomain->users_id != logged("id")  && logged("role") != 1){
                ifPermissions('not_allowed');
                return;
            } 
            
            //switching to db 
            switch_db($globelDomain->domain_db_name);
            $allRedocrd = array();
			$config = array();

			$config["base_url"] = base_url() . "panel/reports";
			$config['reuse_query_string'] = true;
			$config['allow_get_array'] = true;
			
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

			//setting up the url and page segment 
			$registered_on = $this->input->get('registered_on_check');
			$last_visited = trim($this->input->get('last_visited_check'));
			$status = $this->input->get('status_check');
			$location = $this->input->get('location_check');
			if(isset($location[0])){
				$location = (!empty($location[0]) )? explode(",",$location[0]) : "";
			}
			
			if( !empty($registered_on) || !empty($status) ||  $status == '0' || !empty($location) || !empty($last_visited) ){
		
			
				$status_count = $date_count = 0;
				$this->page_data['dateFilter'] = true;
				$registered_on_array = explode("_" , trim($registered_on));

				$registered_on_start = (isset( $registered_on_array[0] ))? str_replace(" " , "" , $registered_on_array[0]) : ""; 
				$registered_on_end = (isset( $registered_on_array[1] ))?  str_replace(" " , "" , $registered_on_array[1]) : ""; 
				$this->page_data['registered_on'] = array('start' => $registered_on_start , 'end' => $registered_on_end);

				$last_visited_array = explode("_" , $last_visited);

				$last_visited_start = (isset( $last_visited_array[0] ))?  str_replace(" " , "" , $last_visited_array[0]) : ""; 
				$last_visited_end = (isset( $last_visited_array[1] ))?  str_replace(" " , "" , $last_visited_array[1]) : ""; 
				$this->page_data['last_visited'] = array('start' => $last_visited_start , 'end' => $last_visited_end);
			
				

				$config["total_rows"] = $this->subscribers_model->getSubscribersByfilterCount($registered_on_start , $registered_on_end ,$last_visited_start , $last_visited_end , $status , $location );
	
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$this->page_data["links"] = $this->pagination->create_links();

				$allRedocrd = $this->subscribers_model->getSubscribersByfilter( $config["per_page"], $page, $registered_on_start , $registered_on_end ,$last_visited_start , $last_visited_end , $status , $location );
				//echo "<pre>"; print_r($config["total_rows"] );die();
			//	echo "<pre>"; print_r($allRedocrd );die();
				
				$this->page_data['subscribers_list'] = $allRedocrd;
				$this->page_data['isAdvanceFilter'] = true;
				
			}else{

				$config["total_rows"] = $this->subscribers_model->countAll();
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$this->page_data["links"] = $this->pagination->create_links();
				

				$allRedocrd = $this->subscribers_model->getSubscribers($config["per_page"], $page);
				$this->page_data['subscribers_list'] = $allRedocrd;
            
			}
			$this->page_data["locations"] = $this->subscribers_model->allLocations();
			//switching to parent db 
            
        }
		switch_db(default_db_name());
		
        $this->load->view('panel/reports/list', $this->page_data);
	}
	
	function exportCsv(){
		$config['cookie_secure'] = false;
		$domainsRes = $this->session->userdata('globelDomain');
		$domainName = $domainsRes->domain_db_name;
		switch_db($domainsRes->domain_db_name);
		
		$registered_on = $this->input->get('registered_on_check1');
		$last_visited = trim($this->input->get('last_visited_check1'));
		$status = $this->input->get('status_check1');
		$location = $this->input->get('location_check1');
		if(isset($location[0])){
			$location = (!empty($location[0]) )? explode(",",$location[0]) : "";
		}
		
		
		if( !empty($registered_on) || !empty($status) ||  $status == '0' || !empty($location) || !empty($last_visited) ){
				
				$status_count = $date_count = 0;
				$this->page_data['dateFilter'] = true;
				$registered_on_array = explode("_" , trim($registered_on));

				$registered_on_start = (isset( $registered_on_array[0] ))? str_replace(" " , "" , $registered_on_array[0]) : ""; 
				$registered_on_end = (isset( $registered_on_array[1] ))?  str_replace(" " , "" , $registered_on_array[1]) : ""; 
				$this->page_data['registered_on'] = array('start' => $registered_on_start , 'end' => $registered_on_end);

				$last_visited_array = explode("_" , $last_visited);

				$last_visited_start = (isset( $last_visited_array[0] ))?  str_replace(" " , "" , $last_visited_array[0]) : ""; 
				$last_visited_end = (isset( $last_visited_array[1] ))?  str_replace(" " , "" , $last_visited_array[1]) : ""; 
				$this->page_data['last_visited'] = array('start' => $last_visited_start , 'end' => $last_visited_end);
				
				switch_db($domainsRes->domain_db_name);
				
				$filterRecord = $this->subscribers_model->getSubscribersByfilter( "", "", $registered_on_start , $registered_on_end ,$last_visited_start , $last_visited_end , $status , $location );
				
				
				
				$this->subscribers_model->export_record($filterRecord , $domainName);
				$globelDomain = $this->session->userdata('globelDomain');
				add_log("Report downloaded of  (" . $globelDomain->domainName .") downloaded by User: ". $globelDomain->userName, $globelDomain );

				redirect('/panel/reports', 'refresh');
				
		}else{
	
			switch_db(default_db_name());
			if($domainsRes->users_id != logged("id")  && logged("role") != 1){
				ifPermissions('not_allowed');
				return;
			}
			switch_db($domainsRes->domain_db_name);
			$allData = $this->subscribers_model->getAllSubscribersCsv();
			$this->subscribers_model->export_record($allData , $domainName);

			$globelDomain = $this->session->userdata('globelDomain');
			add_log("Report downloaded of  (" . $globelDomain->domainName .") downloaded by User: ". $globelDomain->userName, $globelDomain );
			
			//redirect('/panel/reports', 'refresh');
			
		}
	}


	public function save()
	{
		ifPermissions('add_location');
		postAllowed();
        
        $domain_id = post('domain_id');
        
        switch_db_by_domain_id($domain_id);
        
		$id = $this->locations_model->create([
			'location_name' => post('name'),
			'location_address' => post('address'),
			'location_coordinates' => post('coordinates'),
			'status' => (int) post('status'),
		]);
        
        //switching the db back
		
		$globelDomain = $this->session->userdata('globelDomain');
		add_log("New location Created  (" . $domainsRes->domainName .") created by User: ". $domainsRes->userName, $globelDomain );
		 		
        switch_db(default_db_name());


		$this->session->set_flashdata('alert-type', 'success');
		$this->session->set_flashdata('alert', 'New Location Created Successfully');
		

		redirect('panel/locations/?domains='.$domain_id );

	}
    
    public function edit($id, $domain_id)
	{
		ifPermissions('manage_own_domain');
        
        $get_domain = $this->domains_model->getById($domain_id);
        
        //checking if this domain belongs to current user
        if($get_domain->users_id != logged("id") && logged("role") != 1){
            ifPermissions('not_allowed');
            return;
        }else{
            switch_db_by_domain_id($get_domain->id);
            $get_location = $this->locations_model->getById($id);
            
            $this->page_data['location'] = $get_location;
            $this->page_data['domain_id'] = $get_domain->id;
            switch_db(default_db_name());
            
            $this->load->view('panel/locations/edit', $this->page_data);
            //switching the db back
            
        } 
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

	public function update($id)
	{

		ifPermissions('edit_location'); 
		postAllowed();
        
        $domain_id = post('domain_id');
        switch_db_by_domain_id($domain_id);
        
        
		$data = [
			'location_name' => post('name'),
			'location_address' => post('address'),
			'location_coordinates' => post('coordinates'),
			'status' => (int) post('status'),
		];

		$id = $this->locations_model->update($id, $data);
        
		$globelDomain = $this->session->userdata('globelDomain');
		add_log("Location #$id (" . $data['location_name'] .") Updated by User: ".$domainsRes->userName, $globelDomain );
		 	

		$this->session->set_flashdata('alert-type', 'success');
		$this->session->set_flashdata('alert', 'Location has been Updated Successfully');
		
        redirect('panel/locations?domains=' . $domain_id);
	}

	public function change_status($id, $domain_id)
	{
  
        switch_db_by_domain_id($domain_id);
		$this->subscribers_model->update($id, ['status' => get('status') == 'true' ? 1 : 0 ]);
		$status = get('status') == 'true' ? 'enable' : 'disable';
		$globelDomain = $this->session->userdata('globelDomain');
		add_log("Subscriber status ". $status ." agains domain: (" . $globelDomain->domainName .") subscriber id: ". $id ." Updated by User: ". $globelDomain->userName , $globelDomain );
        //switching the db back
        switch_db(default_db_name());
		echo 'done';
	}
	function get_subscriber_login_detail($id){
		
		ifPermissions('reporting');
		if(!empty($id)){
			$globelDomain = $this->session->userdata('globelDomain');
			switch_db($globelDomain->domain_db_name);
			$name = $_GET['name'];
			
			$data = "";

			 $allRedocrd = array();
			$config = array();
			$config["base_url"] = base_url() . "panel/reports/get_subscriber_login_detail/".$id;
			$config['reuse_query_string'] = true;
			$config['allow_get_array'] = true;
			$config["per_page"] = 10;
			$config["uri_segment"] = 5;
			$config['attributes'] = array('class' => 'loginDetail');
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
			$config['cur_tag_open'] = '<li class="active"><a class="" href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			
			$config["total_rows"] = count($this->subscribers_model->get_subscriber_login_detail_count($id));
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			$links = $this->pagination->create_links();
			$allRedocrd = $this->subscribers_model->get_subscriber_login_detail($config["per_page"], $page , $id);
			
			foreach($allRedocrd as $row){
				
				$chanal = "";
				if( $row->channel_id == '1' ){ $chanal = "Direct"; } 
				$data .= '<tr >
							<td>'.$row->location_name.'</td>
							<td>'.$row->location_address.'</td>
							<td>'.$row->login_time.'</td>
							<td>'.$chanal.'</td>
						</tr>'; 
			}
			if(!empty($allRedocrd)){
				echo '<div class="modal-header">
						<h5 class="modal-title">'.$name.'</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					<div class="modal-body">
						 <div class="table-responsive">
							<table class="table table-xs">
								<thead>
								   <tr>
									  <th>Locations Name</th>
									  <th>Address</th>
									  <th>Login Time</th>
									  <th>Channel</th>
								   </tr>
								</thead>
								<tbody class="">
								   '.$data.'
								</tbody>
							 </table>
							  <div class="datatable-footer">
								<div class="dataTables_paginate paging_simple_numbers"> '.$links.'	</div>
							 </div>
						 </div>
					</div>';
			}
			switch_db(default_db_name());
		}
	}
}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */