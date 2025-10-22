<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Domains extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        ifPermissions('domains_list');
        $this->page_data['domains'] = $this->domains_model->get();
        $this->page_data['page']->title = 'Domains management';
        $this->page_data['page']->menu = 'domains';
        $this->page_data['page']->submenu = 'domainslist';
        $this->load->view('domains/list', $this->page_data);
    }
    function setDomainName() {
        ifPermissions('manage_own_domain');
        $domainId = $this->input->post('domainSelector');
        $domains = $this->domains_model->getDomainById($domainId);
        if (isset($domains[0]->id)) {
            $globelDomain = (object)['domainName' => ucfirst($domains[0]->domain_name), 'users_id' => $domains[0]->users_id, 'domainId' => $domains[0]->id, 'domain_db_name' => $domains[0]->domain_db_name, 'username' => logged('username'), 'userId' => logged('id'), 'userName' => logged('name'), ];
            $this->session->set_userdata('globelDomain', $globelDomain);
        }
        $url = $this->input->post('url');
        redirect($url);
    }
    function domainSetting() {

        ifPermissions('manage_own_domain');
        $globelDomain = $this->session->userdata('globelDomain');
        $this->page_data['intervelSetting'] = getDomainSetting($globelDomain->domain_db_name, 'intervelSetting');
        $this->page_data['domains'] = $this->domains_model->get();
        $this->page_data['current_tab'] = (isset($_SESSION["current_tab"]))? $_SESSION["current_tab"] : "";

        switch_db($globelDomain->domain_db_name);
        $this->page_data['ratings'] = $this->ratings_model->get();
        switch_db(default_db_name());
        
        $this->page_data['page']->title = 'Domains management';
        $this->page_data['page']->menu = 'domains';
        $this->page_data['page']->submenu = 'domainSetting';
        $this->load->view('domains/domainSetting', $this->page_data);
        $this->session->unset_userdata('successMes');
    }
    
    function addSetting() {
		
        if ($this->input->post('session_interval_time') && $this->input->post('returning_interval_time')) {
            
            $this->session_interval_time = post('session_interval_time');
            $this->returning_interval_time = post('returning_interval_time');
            $this->block_time_interval = post('block_time_interval');
            $this->domainUseName = post('domainUseName');
            $this->brand = post('brand');
            $api_name = post('api_name');
            $this->api_secret_code = post('api_secret_code');
            $this->api_key = post('api_key');

            $this->api_checkbox = post('api_checkbox');
            $this->email_checkbox = post('email_checkbox');
            
            $this->star_checkbox = post('star_checkbox');
            $this->default_country = post('default_country');

            $this->api_from = post('api_from');
            $this->age_group = post('age_group');
            $this->age_dob = post('age_dob');
            $this->age_gender = post('age_gender');
            $this->subs_country = post('subs_country');
            if (!empty($this->age_group)) $this->age_group = "enable";
            if (!empty($this->age_dob)) $this->age_dob = "enable";
            if (!empty($this->age_gender)) $this->age_gender = "enable";
            if (!empty($this->subs_country)) $this->subs_country = "enable";
            $facebook_login = (empty(post('facebook_login'))) ? "disabled" : "enabled";
            $insta_login = (empty(post('insta_login'))) ? "disabled" : "enabled";
            $linkedin_login = (empty(post('linkedin_login'))) ? "disabled" : "enabled";
            $google_login = (empty(post('google_login'))) ? "disabled" : "enabled";
            $yahoo_login = (empty(post('yahoo_login'))) ? "disabled" : "enabled";
            $twitter_login = (empty(post('twitter_login'))) ? "disabled" : "enabled";
			$login_form = (empty(post('login_form'))) ? "disabled" : "enabled";
			
            $globelDomain = $this->session->userdata('globelDomain');
            //selecting values & switching the db
            $intervelSetting = getDomainSetting($globelDomain->domain_db_name, 'intervelSetting');
            switch_db($globelDomain->domain_db_name);

            if (!empty($this->api_checkbox)) {
                $this->api_checkbox = true;
            } else {
                $this->api_checkbox = false;
            }

            if (!empty($this->email_checkbox)) {
                $this->email_checkbox = true;
            } else {
                $this->email_checkbox = false;
            }
            
            //images handler
            if (!empty($_FILES['domain_logo']['name'])) {
                $path = $_FILES['domain_logo']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $this->uploadlib->initialize(['file_name' => $globelDomain->domain_db_name . '_logo' . '.' . $ext]);
                $machine_name = $globelDomain->domain_db_name;
                $file_path = '/domains/' . $machine_name . '/';
                $image = $this->uploadlib->uploadImage('domain_logo', $file_path);
                
            }
            //uploading domain images for gallery
            //domain_image1
            if (!empty($_FILES['domain_image1']['name'])) {
                $path = $_FILES['domain_image1']['name'];
                ///$ext = pathinfo($path, PATHINFO_EXTENSION);
                $ext = 'jpg';
                $this->uploadlib->initialize(['file_name' => $globelDomain->domain_db_name . '_gallery' . '1' . '.' . $ext]);
                $machine_name = $globelDomain->domain_db_name;
                $file_path = '/domains/' . $machine_name . '/';
                $image = $this->uploadlib->uploadImage('domain_image1', $file_path);
            }
            //domain_image2
            if (!empty($_FILES['domain_image2']['name'])) {
                $path = $_FILES['domain_image2']['name'];
                //$ext = pathinfo($path, PATHINFO_EXTENSION);
                $ext = 'jpg';
                $this->uploadlib->initialize(['file_name' => $globelDomain->domain_db_name . '_gallery' . '2' . '.' . $ext]);
                $machine_name = $globelDomain->domain_db_name;
                $file_path = '/domains/' . $machine_name . '/';
                $image = $this->uploadlib->uploadImage('domain_image2', $file_path);
            }
            //domain_image3
            if (!empty($_FILES['domain_image3']['name'])) {
                $path = $_FILES['domain_image3']['name'];
                //$ext = pathinfo($path, PATHINFO_EXTENSION);
                $ext = 'jpg';
                $this->uploadlib->initialize(['file_name' => $globelDomain->domain_db_name . '_gallery' . '3' . '.' . $ext]);
                $machine_name = $globelDomain->domain_db_name;
                $file_path = '/domains/' . $machine_name . '/';
                $image = $this->uploadlib->uploadImage('domain_image3', $file_path);
            }
            $this->api_array = array("api_secret_code" => $this->api_secret_code, "api_key" => $this->api_key,);
            $data = array( 
                    'session_interval_time' => ($this->session_interval_time > 60) ? $this->session_interval_time : 60, 
                    'returning_interval_time' => ($this->returning_interval_time > 60) ? $this->returning_interval_time : 60, 
                    'block_time_interval' => (empty($this->block_time_interval)) ? 0 : $this->block_time_interval, 
                    'brand' => $this->brand, 
                    'api_active' => $api_name, 
                    'api_active_status' => $this->api_checkbox,
                    'email_checkbox' => $this->email_checkbox,
                    'star_checkbox' => $this->star_checkbox,
                    'default_country' => $this->default_country,
                );
            $data["additional_fields"] = array("age_group" => $this->age_group, "age_dob" => $this->age_dob, "age_gender" => $this->age_gender, "subs_country" => $this->subs_country);
            $data["social_media"] = array("facebook" => $facebook_login, "insta" => $insta_login, "linkedin" => $linkedin_login, "yahoo" => $yahoo_login, "google" => $google_login, "twitter" => $twitter_login);
            $data["login_form"] = $login_form;
			
			
            if (isset($intervelSetting->MONTY)) {
                $data['MONTY'] = $intervelSetting->MONTY;
            }
            if (isset($intervelSetting->twilio)) {
                $data['twilio'] = $intervelSetting->twilio;
            }
            if ($api_name == 'MONTY') {
                $data['MONTY'] = array("api_secret_code" => $this->api_secret_code, "api_key" => $this->api_key, "api_from" => $this->api_from,);
            }
            if ($api_name == 'twilio') {
                $data['twilio'] = array("api_secret_code" => $this->api_secret_code, "api_key" => $this->api_key, "api_from" => $this->api_from,);
            }
			
            $data['emailConfiguration'] = array(
                "host_name" => post('host_name'),
                "username" => post('username'),
                "password" => post('password'),
                "port_number" => post('port_number'),
                "from_email" => post('from_email'),

         );

            if (saveDomainSetting($this->domainUseName, 'intervelSetting', $data)) {
				$overwrite_domain_term = post("overwrite_domain_term");
				
				if($overwrite_domain_term == "checked"){
				set_domain_meta( $globelDomain->domainId , "domain_terms" , str_replace('&nbsp;', ' ', htmlentities( post('terms_and_conditions') )) );
                }else{
					unset_domain_meta( $globelDomain->domainId , "domain_terms" );
				}
				add_log("Updated domain setting of (" . $globelDomain->domainName . ") updated by user: " . $globelDomain->userName, $globelDomain);
                $this->session->set_flashdata('successMes', '<div class="alert alert-success" role="alert">Your Domain Setting has been successfully saved </div> ');
                redirect(base_url() . 'domains/domainSetting');
            }
        } else {
            redirect(base_url() . 'domains/domainSetting');
        }
    }

    function smsapiStatus() {
        $status = get('status');
        $globelDomain = $this->session->userdata('globelDomain');
        $intervelSetting = getDomainSetting($globelDomain->domain_db_name, 'intervelSetting');
        $data = array();
        if ($status == 'Enabled') {
            $data = array('session_interval_time' => (isset($intervelSetting->session_interval_time)) ? $intervelSetting->session_interval_time : 60, 'returning_interval_time' => (isset($intervelSetting->returning_interval_time)) ? $intervelSetting->returning_interval_time : 300, 'block_time_interval' => (isset($intervelSetting->block_time_interval)) ? $intervelSetting->block_time_interval : 60, 'brand' => (isset($intervelSetting->brand)) ? $intervelSetting->brand : "", 'api_active' => (isset($intervelSetting->api_name)) ? $intervelSetting->api_name : false, 'api_active_status' => true,);
            if (isset($intervelSetting->MONTY)) {
                $data['MONTY'] = array("api_secret_code" => $intervelSetting->MONTY->api_secret_code, "api_key" => $intervelSetting->MONTY->api_key, "api_from" => $intervelSetting->MONTY->api_from,);
            }
            if (isset($intervelSetting->twilio)) {
                $data['twilio'] = array("api_secret_code" => $intervelSetting->twilio->api_secret_code, "api_key" => $intervelSetting->twilio->api_key, "api_from" => $intervelSetting->twilio->api_from,);
            }
        } else {
            $data = array('session_interval_time' => (isset($intervelSetting->session_interval_time)) ? $intervelSetting->session_interval_time : 60, 'returning_interval_time' => (isset($intervelSetting->returning_interval_time)) ? $intervelSetting->returning_interval_time : 300, 'block_time_interval' => (isset($intervelSetting->block_time_interval)) ? $intervelSetting->block_time_interval : 60, 'brand' => (isset($intervelSetting->brand)) ? $intervelSetting->brand : "", 'api_active' => (isset($intervelSetting->api_name)) ? $intervelSetting->api_name : false, 'api_active_status' => false,);
            if (isset($intervelSetting->MONTY)) {
                $data['MONTY'] = array("api_secret_code" => $intervelSetting->MONTY->api_secret_code, "api_key" => $intervelSetting->MONTY->api_key, "api_from" => $intervelSetting->MONTY->api_from,);
            }
            if (isset($intervelSetting->twilio)) {
                $data['twilio'] = array("api_secret_code" => $intervelSetting->twilio->api_secret_code, "api_key" => $intervelSetting->twilio->api_key, "api_from" => $intervelSetting->twilio->api_from,);
            }
        }
        $globelDomain = $this->session->userdata('globelDomain');
        add_log("API " . ucfirst($status) . " of  (" . $globelDomain->domainName . ") updated by user: " . $globelDomain->userName, $globelDomain);
        saveDomainSetting($globelDomain->domain_db_name, 'intervelSetting', $data);
    }
    function changeCode() {
        $api_name = get('api_name');
        $globelDomain = $this->session->userdata('globelDomain');
        $intervelSetting = getDomainSetting($globelDomain->domain_db_name, 'intervelSetting');
        if ($api_name == 'MONTY' && isset($intervelSetting->MONTY)) {
            echo json_encode($intervelSetting->MONTY);
        } elseif ($api_name == 'twilio' && isset($intervelSetting->twilio)) {
            echo json_encode($intervelSetting->twilio);
        } else {
            echo json_encode(array('session_interval_time' => '', 'returning_interval_time' => ''));
        }
    }
    public function add() {
        ifPermissions('add_domains');
        $this->load->view('domains/add', $this->page_data);
    }
    public function save() {
        ifPermissions('add_domains');
        postAllowed();
        $machine_name = post('machine_name');
        if (check_domain(post('machine_name'))) {
            $machine_name = $machine_name . '_' . rand(10, 9999);
        }
        $id = $this->domains_model->create(['domain_name' => ucfirst(post('name')), 'domain_db_name' => $machine_name, 'no_of_locations' => post('locations'), 'no_of_ap' => post('access_points'), 'approved' => post('approval_domain'), 'users_id' => post('owner_role'), 'status' => (int)post('status'), ]);
        //calling function to create a database for this domain
        $db_default = default_db_name();
        //loading the db helper
        $this->load->helper('domain_db');
        create_domain_db($machine_name, $db_default);
        $structure = 'assets/domains/' . $machine_name;
        $structure_uploads = 'uploads/domains/' . $machine_name;
        $old = umask(0);
        if (!file_exists($structure)) {
            if (!@mkdir($structure, 0755, true)) {
                die('Failed to create folders...');
            }
        }
        if (!file_exists($structure_uploads)) {
            if (!@mkdir($structure_uploads, 0775, true)) {
                die('Failed to create folders...');
            }
        }
        umask($old);
        $globelDomain = $this->session->userdata('globelDomain');
        add_log("New domain $" . $id . " created by user: " . $globelDomain->userName, $globelDomain);
        $this->session->set_flashdata('alert-type', 'success');
        $this->session->set_flashdata('alert', 'New Domain Created Successfully');
        redirect('domains');
    }
    public function view($id) {
        ifPermissions('users_view');
        $this->page_data['User'] = $this->users_model->getById($id);
        $this->page_data['User']->role = $this->roles_model->getByWhere(['id' => $this->page_data['User']->role]) [0];
        $this->page_data['User']->activity = $this->activity_model->getByWhere(['user' => $id], ['order' => ['id', 'desc']]);
        $this->load->view('users/view', $this->page_data);
    }
    function activity_logs() {
        ifPermissions('manage_own_domain');
        $ip = !empty(get('ip')) ? urldecode(get('ip')) : false;
        $user = !empty(get('user')) ? urldecode(get('user')) : false;
        $this->page_data['page']->title = 'Domains management';
        $this->page_data['page']->menu = 'activity_log_list';
        $arg = [];
        $globelDomain = $this->session->userdata('globelDomain');
        if ($ip) $arg['ip_address'] = $ip;
        if ($user) $arg['user'] = $user;
        $this->page_data['page']->menu = 'domains';
        $this->page_data['page']->submenu = 'adminDomainsLogs';
        switch_db($globelDomain->domain_db_name);
        $this->load->model('activity_logs_model');
        $this->page_data['activity_logs'] = array_reverse($this->activity_logs_model->getAllLogs());
        switch_db(default_db_name());
        $this->page_data['filter_ip'] = $ip;
        $this->page_data['filter_user'] = $user;
        $this->load->view('domains/activity_logs/list', $this->page_data);
    }
    public function activityView($id) {
        ifPermissions('manage_own_domain');
        $globelDomain = $this->session->userdata('globelDomain');
        switch_db($globelDomain->domain_db_name);
        $this->page_data['activity'] = $this->activity_model->getById($id);
        switch_db(default_db_name());
        if (user_type($globelDomain->userId)) {
            $this->page_data['page']->menu = 'domains';
            $this->page_data['page']->submenu = 'adminDomainsLogs';
        } else {
            $this->page_data['page']->menu = 'domainLogs';
        }
        $this->load->view('domains/activity_logs/view', $this->page_data);
    }
    public function edit($id) {
        ifPermissions('manage_own_domain');
        $get_domain = $this->domains_model->getById($id);
        $this->page_data['disableDomains'] = 'disabled';
        $this->page_data['page']->title = 'Domains management';
        $this->page_data['page']->menu = 'domains';
        $this->page_data['page']->submenu = 'domainslist';
        //checking if this domain belongs to current user
        if ($get_domain->users_id != logged("id") && logged("role") != 1) {
            ifPermissions('not_allowed');
        } else {
            $this->page_data['domain'] = $get_domain;
            $this->load->view('domains/edit', $this->page_data);
        }
    }
    public function update($id) {
        ifPermissions('manage_own_domain');
        postAllowed();
        $owner_role = post('owner_role');
        if ($owner_role == '') {
            $owner_role = logged("id");
        } else {
            $owner_role = post('owner_role');
        }
        $data = ['domain_name' => post('name'), 'users_id' => $owner_role, 'status' => (int)post('status'), ];
        //only allowed for super admin
        if (logged("role") == 1) {
            $data['no_of_locations'] = post('locations');
            $data['no_of_ap'] = post('access_points');
            $data['approved'] = post('approval_domain');
            $data['email_expiry'] = post('domain_expiry_email');
            $data['emails_to_send'] = post('emails_to_send');

            if(isset($_POST['license_activation_date']) && !is_null($_POST['license_activation_date'])) {
                $date_activation = DateTime::createFromFormat('d/m/Y', post('license_activation_date'));
                if ($date_activation instanceof DateTime) {
                    $data['license_activation_date'] = $date_activation->format('Y-m-d H:i:s');
                }
            }
            if(isset($_POST['license_expiry_date'])&& !is_null($_POST['license_expiry_date'])) {
                
                $date_expiry = DateTime::createFromFormat('d/m/Y', post('license_expiry_date'));
                if ($date_expiry instanceof DateTime) {
                    $data['license_expiry_date'] = $date_expiry->format('Y-m-d H:i:s');
                }
            }
            //print_r($_POST['license_activation_date']);
            //print_r($data);
            //exit();
        }

        $id = $this->domains_model->update($id, $data);
        $globelDomain = $this->session->userdata('globelDomain');
		$this->set_domain_as_demo( );
        add_log("Domain update #" . $id . " updated by user: " . $globelDomain->userName , $globelDomain);
        $this->session->set_flashdata('alert-type', 'success');
        $this->session->set_flashdata('alert', 'Domain has been Updated Successfully');
        redirect('domains');
    }
    public function check() {
        $machine_name = !empty(get('machine_name')) ? get('machine_name') : false;
        $notId = !empty($this->input->get('notId')) ? $this->input->get('notId') : 0;
        if ($machine_name) $exists = count($this->domains_model->getByWhere(['domain_db_name' => $machine_name, 'id !=' => $notId, ])) > 0 ? true : false;
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
    public function change_status($id) {
        $globelDomain = $this->session->userdata("globelDomain");
		$status = get("status") == "true" ? "enabled" : "disabled";
		$this->domains_model->update($id, ['status' => get('status') == 'true' ? 1 : 0]);
		add_log(
            "Status " .
                $status .
                " of domain #" .
                $id .
                " change by user (" .
                $globelDomain->userName .
                ") under domain (" .
                $globelDomain->domainName .
                ")",
            $globelDomain
        );
		
        echo 'done';
    }
    public function send_test_sms() {
        $phone_number = get("number");
        $api_name = get("api_name");
        $api_key = get("api_key");
        $api_from = get("from");
        $api_secret_code = get("api_secret_code");
        $text = "This is test SMS from \n WiFinCloud";
        if (empty($phone_number) || !is_numeric($phone_number)) {
            echo json_encode(array("error" => error_message("Please enter valid phone number")));
            die();
        }
        if ($api_name == "twilio") {
            if (send_test_sms($api_secret_code, $api_key, $api_from, $phone_number, $text)) {
                echo json_encode(array("success" => success_message("Message has been sent successfully")));
            } else {
                echo json_encode(array("error" => error_message("There was some error please check your detail")));
            }
        } else {
            echo json_encode(array("error" => error_message("Please choose API and its valid detail")));
        }
    }
    public function admin_preview() {
        $preview = "";
        $location_id = "";
        if (isset($_GET['wificloud'])) {
            $preview = decryption($_GET['wificloud']);
            
            if (isset($_GET['location_id'])) $location_id = $_GET['location_id'];
            
        } else {
            redirect(base_url() . 'domains/domainSetting', 'refresh');
        }
        $globelDomain = $this->session->userdata('globelDomain');
        $domain_setting = getDomainSetting($globelDomain->domain_db_name, 'intervelSetting');
        
		if (isset($domain_setting->additional_fields)) $this->page_data['additional_fields'] = $domain_setting->additional_fields;
        switch_db($globelDomain->domain_db_name);
        
		$this->page_data['intervelSetting'] = $domain_setting;
        $this->page_data['preview'] = $preview;
        $this->page_data['location_id'] = $location_id;
        $this->load->view('front/include/header', $this->page_data);
        $this->load->view('front/view/form', $this->page_data);
        $this->load->view('front/include/footer', $this->page_data);
    }
    public function set_domain_as_demo( ) {
        $meta_value = post("domain_as_demo");
        $globelDomain = $this->session->userdata('globelDomain');
        if (logged("role") == 1 && $meta_value == "domain_as_demo") {
            $domain_id = $globelDomain->domainId;
            $meta_key = "domain_as_demo";
            if (set_domain_meta($domain_id, $meta_key, "demo")) {
                echo json_encode(array("success" => "Domain set as demo"));
                add_log("Set domain as demo : (" . $globelDomain->domainName . ") Updated by User: " . $globelDomain->userName, $globelDomain);
            } else {
                echo json_encode(array("error" => "yes"));
            }
        } else if (logged("role") == 1 && $meta_value == "remove") {
            unset_domain_meta($globelDomain->domainId, "domain_as_demo");
            echo json_encode(array("success" => "Remove domain as demo"));
            $globelDomain = $this->session->userdata('globelDomain');
            add_log("Remove domain as demo : (" . $globelDomain->domainName . ") Updated by User: " . $globelDomain->userName, $globelDomain);
        } else {
            echo json_encode(array("error" => "yes"));
        }
    }
	
	function set_tab_active(){
		$_SESSION["current_tab"] = (isset($_GET['current']))? $_GET['current'] : "";
	}
}
