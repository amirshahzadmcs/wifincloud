<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->page_data['page']->title = 'Locations management';
		$this->page_data['page']->menu = 'locations';
		
	}
	

	public function index()
	{
        
		
		ifPermissions('locations_list');
		$globelDomain = $this->session->userdata('globelDomain'); 
		if(!empty($globelDomain)){

  
            if($globelDomain->users_id != logged("id")  && logged("role") != 1){
                ifPermissions('not_allowed');
                return;
            } 
            switch_db($globelDomain->domain_db_name);
            
            $this->page_data['locations_list'] = $this->locations_model->get();
            
            //switching to parent db 
            switch_db(default_db_name());
            
        }
        $this->load->view('panel/locations/list', $this->page_data);
	}

	public function add()
	{
		ifPermissions('add_location');
        
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
		

		$globelDomain = $this->session->userdata('globelDomain');
		add_log('New location #'.$id.' added by User: '. $globelDomain->userName .' under domain ' . $domain_id , $globelDomain );
		switch_db(default_db_name());
		$this->session->set_flashdata('alert-type', 'success');
		$this->session->set_flashdata('alert', 'New Location Created Successfully');
		
		redirect('panel/locations/?domains='.$domain_id );

	}
    
    public function edit($id, $domain_id)
	{
		ifPermissions('manage_own_domain');
        $globelDomain = $this->session->userdata('globelDomain');

        $get_domain = $this->domains_model->getById($domain_id);
		$this->page_data['disableDomains'] = 'disabled';
        //checking if this domain belongs to current user
        if($get_domain->users_id != logged("id") && logged("role") != 1){
            ifPermissions('not_allowed');
            return;
        }else{
            switch_db_by_domain_id($get_domain->id);
            $get_location = $this->locations_model->getById($id);
            
			
            $this->page_data['location_image_status'] = get_location_image_status( $get_location->id );
			
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
        
		$this->page_data['disableDomains'] = 'disabled';
		$data = [
			'location_name' => post('name'),
			'location_address' => post('address'),
			'location_coordinates' => post('location_coordinates'),
			'status' => (int) post('status'),
		];
		
		//images handler 
		if (!empty($_FILES['domain_logo']['name'])) {
			
			
			$path = $_FILES['domain_logo']['name']; 
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$this->uploadlib->initialize([
				'file_name' => getCurrentDomain('domain_db_name') . '_logo'.'.'.$ext 
			]);
			
			$file_path = '/domains/'. getCurrentDomain('domain_db_name') .'/'.$id.'/';

			$image = $this->uploadlib->uploadImage('domain_logo', $file_path);
				
			if($image['status']){
			}else{
			}
		}

		//uploading domain images for gallery 
		//domain_image1
		if (!empty($_FILES['domain_image1']['name'])) {
			
			$path = $_FILES['domain_image1']['name']; 
			//$ext = pathinfo($path, PATHINFO_EXTENSION); 
			$ext = 'jpg';
			$this->uploadlib->initialize([
				'file_name' => getCurrentDomain('domain_db_name') . '_gallery' . '1' .'.'.$ext 
			]);
			
			$machine_name = getCurrentDomain('domain_db_name');
			$file_path = '/domains/'. $machine_name .'/'.$id.'/';
			$image = $this->uploadlib->uploadImage('domain_image1', $file_path);
				
			if($image['status']){
			}else{
			}
		}
		//domain_image2
		if (!empty($_FILES['domain_image2']['name'])) {

			
			$path = $_FILES['domain_image2']['name']; 
			//$ext = pathinfo($path, PATHINFO_EXTENSION);
			$ext = 'jpg';
			$this->uploadlib->initialize([
				'file_name' => getCurrentDomain('domain_db_name') . '_gallery' . '2' .'.'.$ext 
			]);
			
			$machine_name = getCurrentDomain('domain_db_name');
			$file_path = '/domains/'. $machine_name .'/'.$id.'/';
			
			$image = $this->uploadlib->uploadImage('domain_image2', $file_path);
				
			if($image['status']){
			}else{
			}
		}
		//domain_image3
		if (!empty($_FILES['domain_image3']['name'])) {
			
			$path = $_FILES['domain_image3']['name']; 
			//$ext = pathinfo($path, PATHINFO_EXTENSION);
			$ext = 'jpg';
			$this->uploadlib->initialize([
				'file_name' => getCurrentDomain('domain_db_name') . '_gallery' . '3' .'.'.$ext 
			]);
			
			$machine_name = getCurrentDomain('domain_db_name');
			$file_path = '/domains/'. $machine_name .'/'.$id.'/';
			
			$image = $this->uploadlib->uploadImage('domain_image3', $file_path);
				
			if($image['status']){
			}else{
			}
		}
		
		if(isset( $_POST['landing_page_status'] )){
			$status = "enable";
		}else{
			$status = "disbale";
		}
		$globelDomain = $this->session->userdata('globelDomain');
		
		$file_array = getDomainSetting( $globelDomain->domain_db_name , "location_image_status" );
		
		$curren_update_record = update_location_image_status($file_array , $id , array("status" => $status , "location_id" => $id ));
		
		saveDomainSetting( $globelDomain->domain_db_name , "location_image_status" , $curren_update_record  );
		$overwrite_domain_term = post("overwrite_domain_term");
		
		
		
		$id = $this->locations_model->update($id, $data);
        
        switch_db(default_db_name());
		
		if($overwrite_domain_term){
			$location_term = post("location_terms");
			set_domain_meta( $globelDomain->domainId , "location_terms" , $location_term , $id);
		}else{
			unset_domain_meta( $globelDomain->domainId , "location_terms" , $id);
		}
		
		add_log("Location update #$id (" . $data['location_name'] .") Updated by User: ".$globelDomain->userName , $globelDomain );
        

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
        
		$status =  (get('status') == 'true') ? 'enabled' : 'disabled';

		$globelDomain = $this->session->userdata('globelDomain');
		add_log('Status '.$status.' of location #'.$id.' change by User ('. $globelDomain->userName .') under domain (' . $globelDomain->domainName .')' , $globelDomain );
        

        //switching the db back
        switch_db(default_db_name());
		echo 'done';
	}
	
	public function save_location_setting()
	{ 
		
	}
	
}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */