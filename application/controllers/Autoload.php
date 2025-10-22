<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autoload extends MY_Controller {

	public function index()
	{
		
		//getting current user id
		$uid = logged("id");
		$globelDomain = $this->session->userdata('globelDomain');
		

		//print_r($selected_domain);
		//checking if a domain is associated with the current user

		$domain_id = $globelDomain->domainId;

		ifPermissions('reporting');
		$domain = $domain_id;
		$arg = [];
			$arg['id'] = $domain;				
			
		//switching to db 
		switch_db($globelDomain->domain_db_name);

		$this->page_data['month_names'] = $this->subscribers_model->month_names();
		$this->page_data['all_returning_by_day'] = $this->subscribers_model->all_returning_by_day();
		
		
		$this->page_data['all_new_by_day'] = $this->subscribers_model->all_new_by_day();
		$this->page_data['get_returning_by_day'] = $this->subscribers_model->all_returning_by_day();
		$this->page_data['days_name_by_date'] = days_name_by_date();
		
		$this->page_data['returnig_by_month'] = $this->subscribers_model->all_returning_by_months();
		$this->page_data['all_new_by_months'] = $this->subscribers_model->all_new_by_months();
		
		$this->page_data['devices'] = $this->subscribers_model->get_all_devices();
			
		//setting up the url and page segment 
		$config = array();
		$config["base_url"] = base_url() . "panel/reports";
		$config['reuse_query_string'] = true;
		$config['allow_get_array'] = true;
		$subscribers_count = $this->subscribers_model->countAll();
		
		
		$config["total_rows"] = $subscribers_count;
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->page_data["links"] = $this->pagination->create_links();
		$this->page_data['subscribers_list'] = $this->subscribers_model->getSubscribers($config["per_page"], $page);
		$this->page_data['subscribers_count'] = $subscribers_count;

		//counting today's entries
		$curr_date = date('Y-m-d');
		$yesterday_date = date('Y-m-d', strtotime( "yesterday" ));
		
		//returning subscribers today
		$subscribers_returning_today =  $this->subscribers_model->get_returning_by_day($curr_date);
		$this->page_data['subscribers_returning_today'] = $subscribers_returning_today; // full data of returning subscribers
		$this->page_data['subscribers_returning_today_count'] = $subscribers_returning_today;
		
		// total count of new subscribers yesterday
		$this->page_data['subscribers_new_yesterday_count'] = count($this->subscribers_model->getByWhere(array('registered_on>=' => $yesterday_date,'registered_on<' => $curr_date )));

		 
		$this->page_data['subscribers_returning_yesterday_count'] = count($this->login_history_model->getGroupBy(array('login_time>='=> $yesterday_date, 'login_time<'=> $curr_date, 'login_count>' => '1'), 'login_history_detail.subscriber_id'));

		
		$this->page_data['subscribers_today_count'] = count($this->subscribers_model->getByWhere(array( 'registered_on>='=> $curr_date)));
		

		//top 10 returning subscribers 
		$this->page_data['top_returning'] = $this->subscribers_model->getTopSubscribers(10);

		$all_new_subs =  $this->login_history_model->getByWhere(array('login_count=' => '1'));
		$all_returning_subs =  $this->login_history_model->getByWhere(array('login_count>' => '1'));
	
		$this->page_data['last_returning'] = $this->login_history_model->last_returning_subscriber(array('login_count>' => '1')); // last 4 returnig susbciber
		
		$this->page_data['all_new_subs'] = count($all_new_subs); // full data of returning subscribers
		$this->page_data['all_returning_subs'] = count($all_returning_subs); // full data of returning subscribers

		//print_r($this->page_data['subscribers_list']);
		//switching to parent db 
		switch_db(default_db_name());

		//business statistics
		//accesspoint_get_check($domain)
		$this->page_data['access_points'] = accesspoint_get_check($domain);
		$this->page_data['locations_check'] = locations_get_check($domain);

		
		$domainsData = $this->domains_model->get_domains();
		$this->page_data['links'] = $domainsData['links'];
		$this->page_data['domainss'] = $domainsData['domains'];
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */