<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domains_model extends MY_Model {

	public $table = 'domains';

	public function __construct()
	{
		parent::__construct();
	}
    
    public function check()
	{
		$machine_name = !empty(get('machine_name')) ? get('machine_name') : false;
		$notId = !empty($this->input->get('notId')) ? $this->input->get('notId') : 0;

		if($machine_name)
			$exists = count($this->domains_model->getByWhere([
					'domain_db_name' => $email,
					'id !=' => $notId,
				])) > 0 ? true : false;


		echo $exists ? 'false' : 'true';
	}

	function getDomainById($domainId){
		return $this->db->get_where($this->table, ['id' => $domainId] , 1, 0)->result();
	}
	
	function is_active_domain($domain_db_name){
		return $this->db->get_where($this->table, ['status' => 1 , "domain_db_name" =>  $domain_db_name])->result();
	}
	
	public function getByUserId($uid){
		
		$whereArg = ['users_id' => $uid];
		return $this->db->get_where($this->table, $whereArg)->result();
	}
	function getDomains($user_id){
		return $this->db->get_where( $this->$table , ['user_id' => $user_id] )->result();
	}

	function getAllDomains(){  
		return $this->db->get( 'domains' )->result();
	}
	
	function getAllLogs(){ 
		$globelDomain = $this->session->userdata('globelDomain');	
		switch_db($globelDomain->domain_db_name);
		$this->db->from('activity_logs');
		return $this->db->get()->result();
	}

	function addDomainSetting( $domainTitle , $data ){
		
		$fp = fopen("assets/domains/".$domainTitle.'/'.$domainTitle.'_timer.json', 'w');
		fwrite($fp, json_encode($data));
		fclose($fp);
	}
	
	function get_domains(){
		
		$config = array();
		$config["base_url"] = base_url();
		$config['reuse_query_string'] = true;
		$config['allow_get_array'] = true;
		
		$config["per_page"] = 10;
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
		$domain_count = count($this->getAllDomains());
		
		$config["total_rows"] = $domain_count;
		$config["uri_segment"] = 1;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(1)) ? $this->uri->segment(1) : 0;
		$links = $this->pagination->create_links();
		
		$this->db->limit( $config["per_page"] , $page);
		$this->db->order_by("id", "DESC");
		$domains = $this->db->get( 'domains' )->result();
		
		return array("links" => $links , "domains" => $domains);
	}
	
	
	public function store_all_dashboad_info_in_file($domain_db_name = "" , $domain_id = ""){

		$dashboad_array = array();
		if( empty( $domain_db_name ) ){

			$domains = $this->db->get("domains")->result();
			foreach(  $domains as $domain){
				
				$dashboad_array = $this->dashboar_all_info( $domain->domain_db_name , $domain->id );
				save_dashboard_info( $domain_db_name , $dashboad_array );
			}
		}else{
			$dashboad_array = $this->dashboar_all_info( $domain_db_name , $domain_id );
			save_dashboard_info( $domain_db_name , $dashboad_array );
		}
		return true;
	}
	
	public function dashboar_all_info($domain_db_name , $domain_id){
		//switching to db 
		switch_db($domain_db_name);

		$dashboad_array['month_names'] = $this->subscribers_model->month_names();
		
		$dashboad_array['all_new_by_day'] = $this->subscribers_model->all_new_by_day();
		$dashboad_array['get_returning_by_day'] = $this->subscribers_model->all_returning_by_day();
		$dashboad_array['days_name_by_date'] = days_name_by_date();
		
		$dashboad_array['returnig_by_month'] = $this->subscribers_model->all_returning_by_months();
		$dashboad_array['all_new_by_months'] = $this->subscribers_model->all_new_by_months();
		
		$dashboad_array['devices'] = $this->subscribers_model->get_all_devices();
			
		//setting up the url and page segment 
		$dashboad_array['subscribers_list'] = $this->subscribers_model->getSubscribers(5, 0);
		$dashboad_array['subscribers_count'] = $this->subscribers_model->countAll();

		//counting today's entries
		$curr_date = date('Y-m-d');
		$yesterday_date = date('Y-m-d', strtotime( "yesterday" ));
		
		//returning subscribers today
		$subscribers_returning_today =  $this->subscribers_model->get_returning_by_day($curr_date);
		$dashboad_array['subscribers_returning_today'] = $subscribers_returning_today; // full data of returning subscribers
		$dashboad_array['subscribers_returning_today_count'] = $subscribers_returning_today;
		
		// total count of new subscribers yesterday
		$dashboad_array['subscribers_new_yesterday_count'] = count($this->subscribers_model->getByWhere(array('registered_on>=' => $yesterday_date,'registered_on<' => $curr_date )));
		$dashboad_array['subscribers_returning_yesterday_count'] = count($this->login_history_model->getGroupBy(array('login_time>='=> $yesterday_date, 'login_time<'=> $curr_date, 'login_count>' => '1'), 'login_history_detail.subscriber_id'));
		$dashboad_array['subscribers_today_count'] = count($this->subscribers_model->getByWhere(array( 'registered_on>='=> $curr_date)));
		
		//top 10 returning subscribers 
		$dashboad_array['top_returning'] = $this->subscribers_model->getTopSubscribers(10);

		$all_new_subs =  $this->login_history_model->getByWhere(array('login_count=' => '1'));
		$all_returning_subs =  $this->login_history_model->getByWhere(array('login_count>' => '1'));
	
		$dashboad_array['last_returning'] = $this->login_history_model->last_returning_subscriber(array('login_count>' => '1')); // last 4 returnig susbciber
		
		$dashboad_array['all_new_subs'] = count($all_new_subs); // full data of returning subscribers
		$dashboad_array['all_returning_subs'] = count($all_returning_subs); // full data of returning subscribers

		//print_r($dashboad_array['subscribers_list']);
		//switching to parent db 
		switch_db(default_db_name());

		//business statistics
		//accesspoint_get_check($domain)
		$dashboad_array['access_points'] = accesspoint_get_check($domain_id);
		$dashboad_array['locations_check'] = locations_get_check($domain_id);
		$dashboad_array['last_refresh'] = date("Y-m-d H:i:s");
		
		return $dashboad_array;
	}
	
}
