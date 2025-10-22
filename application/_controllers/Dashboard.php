<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index()
	{
		
		$globelDomain = $this->session->userdata('globelDomain');
		if(!isset($globelDomain->domainName)){
			//getting current user id
			$uid = logged("id");
			$domains = array();
			if( logged('role') == '1' ){
				$domains = $this->domains_model->getAllDomains();
			}else{
				$domains = $this->domains_model->getByUserId(logged("id"));
			}
			
			if(isset($domains[0]->id)){
				$globelDomain = (object)[ 
								'domainName' 	=>  $domains[0]->domain_name , 
								'domainId' 		=> $domains[0]->id,
								'users_id' 		=> $domains[0]->users_id,
								'domain_db_name' => $domains[0]->domain_db_name,
								'username' 		=> logged('username'),
								'userId' 		=> logged('id'),
								'role' 			=> logged('role'),
								'userName' 		=> logged('name'),
				];
				$this->session->set_userdata('globelDomain', $globelDomain);
			}
		}
		
		

			//print_r($selected_domain);
			//checking if a domain is associated with the current user
			if($globelDomain->userId != logged("id")  && logged("role") != 1){
				ifPermissions('not_allowed');
				return;
			}else{
				$domain_id = $globelDomain->domainId;

				ifPermissions('reporting');
				if($domain_id){
					
					$dashboard_info = get_dashboard_info(  $globelDomain->domain_db_name);
					
					// if user login first time login and file not exist then first load data in file then load file 
					if( !isset( $dashboard_info->last_refresh ) ){
						$this->domains_model->store_all_dashboad_info_in_file( $globelDomain->domain_db_name , $globelDomain->domainId );
						$dashboard_info = get_dashboard_info(  $globelDomain->domain_db_name);
					}
					
					$this->page_data['last_refresh'] = $dashboard_info->last_refresh;
					$this->page_data['month_names'] = $dashboard_info->month_names;
					switch_db($globelDomain->domain_db_name);
					
					$this->page_data['all_new_by_day'] = $this->subscribers_model->all_new_by_day();
					$this->page_data['get_returning_by_day'] = $this->subscribers_model->all_returning_by_day();
					
					$this->page_data['days_name_by_date'] = $dashboard_info->days_name_by_date;
					
					$this->page_data['returnig_by_month'] = $dashboard_info->returnig_by_month;
					$this->page_data['all_new_by_months'] = $dashboard_info->all_new_by_months;
					
					$this->page_data['devices'] = $dashboard_info->devices;
					
					$this->page_data['subscribers_list'] = $dashboard_info->subscribers_list;
					$this->page_data['subscribers_count'] = $dashboard_info->subscribers_count;
					
					$this->page_data['subscribers_returning_today'] = $dashboard_info->subscribers_returning_today;
					$this->page_data['subscribers_returning_today_count'] = $dashboard_info->subscribers_returning_today_count;
					
					$this->page_data['subscribers_new_yesterday_count'] =  $dashboard_info->subscribers_new_yesterday_count;
					
					$this->page_data['subscribers_returning_yesterday_count'] =  $dashboard_info->subscribers_returning_yesterday_count;
					$this->page_data['subscribers_today_count'] =  $dashboard_info->subscribers_today_count;
					
					$this->page_data['top_returning'] =  $dashboard_info->top_returning;
					
					$this->page_data['last_returning'] = $dashboard_info->last_returning;
					$this->page_data['all_new_subs'] =  $dashboard_info->all_new_subs;
					$this->page_data['all_returning_subs'] =  $dashboard_info->all_returning_subs;
					switch_db(default_db_name());
					$this->page_data['access_points'] =  $dashboard_info->access_points;
					$this->page_data['locations_check'] =  $dashboard_info->locations_check;
					
				}
			}
		// if login super and then show this page
		$this->load->view('includes/header',  $this->page_data);
		if( logged('role') == '1' ){
			
			$domainsData = $this->domains_model->get_domains();
			$this->page_data['links'] = $domainsData['links'];
			$this->page_data['domainss'] = $domainsData['domains'];
			$this->load->view('domain-dashboard', $this->page_data);
		}
		//print_r($this->page_data['subscribers_list']);
		$this->load->view('dashboard', $this->page_data);
	}
	
	public function fresh_dashboard_data(){
		$globelDomain = $this->session->userdata('globelDomain');
		if(isset( $globelDomain->domain_db_name )){
			
			if($this->domains_model->store_all_dashboad_info_in_file( $globelDomain->domain_db_name , $globelDomain->domainId )){
				echo "done";
			}
			
		}else{
			redirec(base_url());
		}
	}
	
	public function cron_job(){
		$this->domains_model->store_all_dashboad_info_in_file();
	}
	
}
