<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Accesspoints extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page_data["page"]->title = "Accesspoints management";
        $this->page_data["page"]->menu = "accesspoints";
    }

    public function index()
    {
        ifPermissions("access_point_list");
		
        $globelDomain = $this->session->userdata("globelDomain");
        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }

            switch_db($globelDomain->domain_db_name);

            $accesspoints = $this->accesspoint_model->get();
            $this->page_data[ "accesspoints_list" ]  = $accesspoints;
            //switching to parent db
			$this->page_data[ "location_list" ] = $this->locations_model->get();
			$this->page_data[ "used_accesspoints" ] = count($accesspoints);
            switch_db(default_db_name());
			$this->page_data[ "allow_accesspoints" ]  = $this->accesspoint_model->get_domain_info($globelDomain->domainId);
        }
		
        $this->load->view("panel/accesspoints/list", $this->page_data);
    }

    public function add()
    {
        ifPermissions("add_access_point");
        //$curr_db = $this->db->database;

        $domain = !empty(get("domains")) ? urldecode(get("domains")) : false;
        if ($domain) {
            $selected_domain = $this->domains_model->getById($domain);
            if (!isset($selected_domain)) {
                ifPermissions("not_allowed");
                return;
            }
            //if not allowed to update this domain or its locations
            if (
                $selected_domain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            $this->load->view("panel/accesspoints/add", $this->page_data);
        } else {
            redirect("panel/locations");
        }
    }

    public function save()
    {
        ifPermissions("add_access_point");
        postAllowed();

        $domain_id = post("domain_id");
        $location_id = post("location");

        switch_db_by_domain_id($domain_id);

        $id = $this->accesspoint_model->create([
            "device_mac" => post("mac_address"),
            "location_id" => post("location"),
            "status" => (int) post("status"),
        ]);

        //switching the db back
        switch_db(default_db_name());

        $globelDomain = $this->session->userdata("globelDomain");
        add_log(
            "New Access Point #" .
                $id .
                " added by User:" .
                $globelDomain->domainName .
                " under location " .
                $location_id,
            $globelDomain
        );

        $this->session->set_flashdata("alert-type", "success");
        $this->session->set_flashdata(
            "alert",
            "New access point added successfully"
        );

        redirect("panel/accesspoints/?domains=" . $domain_id);
    }

    public function edit($id, $domain_id)
    {
        ifPermissions("edit_access_points");
        $this->page_data["disableDomains"] = "disabled";
        $get_domain = $this->domains_model->getById($domain_id);

        //checking if this domain belongs to current user
        if ($get_domain->users_id != logged("id") && logged("role") != 1) {
            ifPermissions("not_allowed");
            return;
        } else {
            switch_db_by_domain_id($get_domain->id);
            $get_accesspoint = $this->accesspoint_model->getById($id);

            $this->page_data["accesspoint"] = $get_accesspoint;
            $this->page_data["domain_id"] = $get_domain->id;
            //switching the db back
            switch_db(default_db_name());

            $this->load->view("panel/accesspoints/edit", $this->page_data);
        }
    }

    public function view($id)
    {
        ifPermissions("users_view");

        $this->page_data["User"] = $this->users_model->getById($id);
        $this->page_data["User"]->role = $this->roles_model->getByWhere([
            "id" => $this->page_data["User"]->role,
        ])[0];
        $this->page_data["User"]->activity = $this->activity_model->getByWhere(
            [
                "user" => $id,
            ],
            ["order" => ["id", "desc"]]
        );
        $this->load->view("users/view", $this->page_data);
    }

    public function update($id)
    {
        ifPermissions("edit_access_points");
        postAllowed();

        $domain_id = post("domain_id");
        switch_db_by_domain_id($domain_id);

        $data = [
            "device_mac" => post("mac_address"),
            "location_id" => post("location"),
            "status" => (int) post("status"),
        ];

        $id = $this->accesspoint_model->update($id, $data);

        $globelDomain = $this->session->userdata("globelDomain");
        add_log( "Accesspoint #$id updated by User:" . $globelDomain->domainName, $globelDomain   );
        
		switch_db(default_db_name());

        $this->session->set_flashdata("alert-type", "success");
        $this->session->set_flashdata(
            "alert",
            "Access point has been updated successfully"
        );

        redirect("panel/accesspoints?domains=" . $domain_id);
    }

    public function delete($id, $domain_id)
    {
        ifPermissions("delete_access_points");

        //		if($id!==1 && $id!=logged($id)){ }else{
        //			redirect('/','refresh');
        //			return;
        //		}

        switch_db_by_domain_id($domain_id);

        $id = $this->accesspoint_model->delete($id);

        $globelDomain = $this->session->userdata("globelDomain");
        add_log(
            "Accesspoint #$id deleted by user:" . $globelDomain->domainName,
            $globelDomain
        );

        $this->session->set_flashdata("alert-type", "success");
        $this->session->set_flashdata(
            "alert",
            "Access point has been deleted successfully"
        );

        redirect("panel/accesspoints/?domains=" . $domain_id);
    }

    public function change_status($id, $domain_id)
    {
        switch_db_by_domain_id($domain_id);

        $this->accesspoint_model->update($id, [
            "status" => get("status") == "true" ? 1 : 0,
        ]);

        $status = get("status") == "true" ? "enabled" : "disabled";

        $globelDomain = $this->session->userdata("globelDomain");
        add_log(
            "Status " .
                $status .
                " of accesspoints #" .
                $id .
                " change by user (" .
                $globelDomain->userName .
                ") under domain (" .
                $globelDomain->domainName .
                ")",
            $globelDomain
        );

        //switching the db back
        switch_db(default_db_name());
        echo "done";
    }
	
	public function import_csv_check(){
		
		ifPermissions("edit_access_points");
        postAllowed();
		if(isset($_SESSION['access_points_records'])) unset($_SESSION['access_points_records']);
		if( isset( $_POST[ 'location' ] ) && isset( $_FILES['csv_access_points'] ) ){
			
			$domain_id = post("domain_id");
			$location = post("location");
			
			$tmpName = $_FILES['csv_access_points']['tmp_name'];
			$csvAsArray = array_map('str_getcsv', file($tmpName));
			$csvAsArray = $this->count_access_points($csvAsArray , $location);
			
			$total_csv_access_points =  count($csvAsArray);
			
			$domain_info = $this->accesspoint_model->get_domain_info($domain_id);
			$allow_access_points = $domain_info->no_of_ap;
			
			switch_db_by_domain_id($domain_id);
			
			$total_used_access_points = $this->accesspoint_model->get_total_access_points();
			$total_pedding_access_point_space = $allow_access_points - $total_used_access_points;
			
			if( $total_csv_access_points > $total_pedding_access_point_space ){
				
				$csrfName = $this->security->get_csrf_token_name();
                $csrfHash = $this->security->get_csrf_hash();
				
				$error = 'You have allowed '.$allow_access_points.' access points and you have already used '.$total_used_access_points.'. Now your pendding space '.$total_pedding_access_point_space.' and you are trying to add '.$total_csv_access_points.' access points. Please contact your administrator for more access points or remove some unwanted access points.';
				$error = warning_message($error);
				echo json_encode(array( 
							"error" => $error ,
							"csrfName" =>$csrfName,
							"csrfHash" =>$csrfHash,
						)
					);
			
			}else{
				
				$access_point_content = info_message("You are importing ".$total_csv_access_points." access points and you have total pedding space ".$total_pedding_access_point_space);
				
				$csrfName = $this->security->get_csrf_token_name();
                $csrfHash = $this->security->get_csrf_hash();
				$_SESSION['access_points_records'] = $csvAsArray;
				echo json_encode(array( 
							"confirm" => "You have stored total $total_csv_access_points new eccess points." , "content" => $access_point_content,
							"csrfName" =>$csrfName,
							"csrfHash" =>$csrfHash,
						)
				);
			}
			switch_db(default_db_name());
		}
	}
	
	public function import_access_points(){
		$globelDomain = $this->session->userdata("globelDomain");
		switch_db($globelDomain->domain_db_name);
		if(isset( $_SESSION['access_points_records'] )){
			$access_points = $_SESSION['access_points_records'];
			$repeated = $this->accesspoint_model->add_access_points($access_points);
			
			$globelDomain = $this->session->userdata('globelDomain');
			add_log(
				"New access points using csv added by User:" .
					$globelDomain->domainName,
				$globelDomain
			);
			
			unset($_SESSION['access_points_records']);
			if(empty($repeated)){
				
				$success = success_message('Your access points has been successfully stored.');
				
			}else{
				$success = success_message('Your access points has been successfully stored.').'
				
				<h5>These access points are already exists</h5>	
				<table class="table">
				  <thead>
					<tr>
					  <th scope="col">Mac address</th>
					  <th scope="col">Location</th>
					</tr>
				  </thead>
				  <tbody>';
				foreach($repeated as $row){
					
					$mac_accress = $row['device_mac'];
					$location_id = $row['location_id'];
					$location = $this->locations_model->get_location_by_id($location_id);
					
					$success .= '
					<tr>
					  <td>'.$mac_accress.'</td>
					  <td>'.$location->location_name.'</td>
					</tr>
				  ';
				}
				$success .= '</tbody>
				</table>';
				
			}
			
			echo json_encode(array( 
							"success" => $success,
							"repeated" => "yes"
						)
				);
		}
		switch_db(default_db_name());
	}
	public function count_access_points( $access_points_csv_array , $location_id ){
		//switch_db_by_domain_id($domain_id);
		
		switch_db(default_db_name());
		$count = 0;
		$access_points_list = array();
		foreach( $access_points_csv_array as $row ){
			
			if( $count >= 1 ){
				if( !empty($row[0]) ){
					array_push($access_points_list , array( "device_mac" => $row[0] , "location_id" => $location_id , "status" => 1 ));
				}
			}
			$count++;
		}
		return $access_points_list;
	}
}



/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
