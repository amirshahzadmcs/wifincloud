<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->page_data['page']->title = 'Forms management';
		$this->page_data['page']->menu = 'forms';
	}

	public function index()
	{
        $curr_db = $this->db->database;
        
		ifPermissions('forms_list');
        $domain = !empty(get('domains')) ? urldecode(get('domains')) : false;
        $arg = [];
		if($domain){
			$arg['id'] = $domain;
        
            $selected_domain = $this->domains_model->getById($domain);
            if($selected_domain->users_id != logged("id")  && logged("role") != 1){
                ifPermissions('not_allowed');
                return;
            }
            
            //switching to db 
            switch_db($selected_domain->domain_db_name);
            
            $this->page_data['locations_list'] = $this->locations_model->get();
            
            //switching to parent db 
            switch_db($curr_db);
            
            
        }
        $this->load->view('panel/locations/list', $this->page_data);
	}

	public function add()
	{
		ifPermissions('add_location');
        //$curr_db = $this->db->database;
        
        $domain = !empty(get('domains')) ? urldecode(get('domains')) : false;
        if($domain){
            $selected_domain = $this->domains_model->getById($domain);
            if(!isset($selected_domain)){
                ifPermissions('not_allowed');
                return;
            }
            //if not allowed to update this domain or its locations
            if($selected_domain->users_id != logged("id")  && logged("role") != 1){
                ifPermissions('not_allowed');
                return;
            }
        $this->load->view('panel/locations/add', $this->page_data);
        }else{
            redirect('panel/locations');
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
        switch_db('nwifi');
        
        

		$this->activity_model->add('New location '.$id.' added by User:'.logged('name'), logged('id') .' under domain ' . $domain_id );

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
            switch_db('nwifi');
            
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
        
        switch_db('nwifi');
		$this->activity_model->add("Location #$id (" . $data['location_name'] .") Updated by User: ".logged('name'));

		$this->session->set_flashdata('alert-type', 'success');
		$this->session->set_flashdata('alert', 'Location has been Updated Successfully');
		
        redirect('panel/locations?domains=' . $domain_id);
	}

	public function check()
	{
		$machine_name = !empty(get('machine_name')) ? get('machine_name') : false;
		$notId = !empty($this->input->get('notId')) ? $this->input->get('notId') : 0;

		if($machine_name)
			$exists = count($this->domains_model->getByWhere([
					'domain_db_name' => $machine_name,
					'id !=' => $notId,
				])) > 0 ? true : false;


		echo $exists ? 'false' : 'true';
	}

//	public function delete($id)
//	{
//
//		ifPermissions('users_delete');
//
//		if($id!==1 && $id!=logged($id)){ }else{
//			redirect('/','refresh');
//			return;
//		}
//
//		$id = $this->users_model->delete($id);
//
//		$this->activity_model->add("User #$id Deleted by User:".logged('name'));
//
//		$this->session->set_flashdata('alert-type', 'success');
//		$this->session->set_flashdata('alert', 'User has been Deleted Successfully');
//		
//		redirect('users');
//
//	}

	public function change_status($id, $domain_id)
	{
        
        switch_db_by_domain_id($domain_id);
        
		$this->locations_model->update($id, ['status' => get('status') == 'true' ? 1 : 0 ]);
        //switching the db back
        switch_db('nwifi');
		echo 'done';
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */