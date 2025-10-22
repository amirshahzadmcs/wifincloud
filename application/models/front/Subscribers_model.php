<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers_model extends MY_Model {

	public $table = 'subscribers';

	public function __construct()
	{
		parent::__construct();
	}
    
	/**
	  * Get Data from table with pagination
	  *
	  * @return array Data
	  * $limit is the limit to collect data in one iteration
	  * start is the row id to start the collection from
	  */
	  public function getSubscribers($limit, $start)
	  {
		$this->db->limit($limit, $start);
		$this->db->join('login_history', 'subscribers.id = login_history.subscriber_id');
		$this->db->join('subscribers_meta', 'subscribers.id = subscribers_meta.subscriber_id', 'left'); // Left join for optional country info
		$this->db->select('subscribers.id ,subscribers.sms_verified , subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , login_history.login_count , subscribers_meta.subs_country');
		//$this->db->group_by('subscribers.id' , "DESC");
		$this->db->order_by("subscribers.id", "DESC");
		return $this->db->get($this->table)->result();
	  }

	  public function getAllSubscribers()
	  {
		$this->db->join('login_history', 'subscribers.id = login_history.subscriber_id');
		$this->db->select('subscribers.id  ,subscribers.sms_verified, subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , login_history.login_count');
		$this->db->group_by('subscribers.id' , "DESC");
		$this->db->order_by("subscribers.id", "DESC");
		  return $this->db->get($this->table)->result();
	  }
	
	
	  public function getAllSubscribersCsv()
	  {
		$this->db->join('login_history', 'subscribers.id = login_history.subscriber_id');
		$this->db->join('login_history_detail', "subscribers.id = login_history_detail.subscriber_id");
		$this->db->join('locations', "locations.id = login_history_detail.location_id ");
		$this->db->join('subscribers_meta', 'subscribers.id = subscribers_meta.subscriber_id'); // Join with subscribers_meta table
		$this->db->select('subscribers.id  ,subscribers.sms_verified, subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , locations.location_name , login_history.login_count, subscribers_meta.subs_country');
		$this->db->group_by('subscribers.id' , "DESC");
		$this->db->order_by("subscribers.id", "DESC");
		  return $this->db->get($this->table)->result();
	  }

	
	function export_record($record , $fileName){

		$filename = $fileName.'-'.date("Y-m-d h:i:sa").".csv";
		$fp = fopen('php://output', 'w');
		
		$header = [ "Subscriber Name" , 'Email' , 'Phone' , 'Location' , 'Status' , 'Registered On' , 'Last Visited Time', 'Country' ] ;
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);
		foreach( $record as $data ){
			$status = ($data->status == '1')? 'Active' : 'Blocked';
			if(empty($data->name)){
				continue;
			}
			$country = get_country_name($data->subs_country); // Get country name
			$header = [ $data->name , $data->email , $data->phone , $data->location_name , $status , $data->registered_on , $data->last_login_time , $country ];
			@fputcsv($fp, $header);
		}
		
	}
	function allLocations(){
		return $this->db->get('locations')->result();
	}
	


	function getSubscribersByfilterCount(  $registered_on_start , $registered_on_end,  $last_visited_start , $last_visited_end , $status , $location){
		
		if(!empty($last_visited_start) && strtotime($last_visited_start) == strtotime($last_visited_end)){
			$this->db->where("subscribers.id = login_history.subscriber_id AND login_history.last_login_time LIKE '%". $last_visited_end."%'" );
		}elseif(!empty($last_visited_end)){
			$this->db->where("subscribers.id = login_history.subscriber_id AND login_history.last_login_time >= '". $last_visited_start ."' AND login_history.last_login_time <= '". $last_visited_end ."'"  );	
		}else{
			$this->db->where("subscribers.id = login_history.subscriber_id"  );
		}
		
		$this->db->where( "subscribers.id = login_history_detail.subscriber_id");
		$this->db->where( "login_history_detail.location_id = locations.id");
		
		if($status == '1' || $status == '0') $this->db->where('subscribers.status', $status);
		if(!empty($location)) $this->db->where_in('locations.location_name', $location);

		if( !empty( $registered_on_start ) && strtotime($registered_on_start) == strtotime($registered_on_end) ){
			$this->db->like('subscribers.registered_on', $registered_on_start);
		}elseif( !empty( $registered_on_start ) ){
			$this->db->where('subscribers.registered_on >=', $registered_on_start);
			$this->db->where('subscribers.registered_on <=', $registered_on_end);
		}
		
		$this->db->group_by('subscribers.id' , "DESC");
		$this->db->select('subscribers.id  ,subscribers.sms_verified, subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , locations.location_name , login_history.login_count');
		$this->db->order_by("subscribers.id", "DESC");
		return count($this->db->get("subscribers , login_history , locations ,  login_history_detail")->result());	
	}
	//-----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	function getSubscribersByfilter(  $limit, $start ,$registered_on_start , $registered_on_end,  $last_visited_start , $last_visited_end  , $status , $location){
		
		if( !empty($limit) ){
			$this->db->limit($limit, $start);
		}
		
		if(!empty($last_visited_start) && strtotime($last_visited_start) == strtotime($last_visited_end)){
			$this->db->where("subscribers.id = login_history.subscriber_id AND login_history.last_login_time LIKE '%". $last_visited_end."%'" );
		}elseif(!empty($last_visited_end)){
			$this->db->where("subscribers.id = login_history.subscriber_id AND login_history.last_login_time >= '". $last_visited_start ."' AND login_history.last_login_time <= '". $last_visited_end ."'"  );	
		}else{
			$this->db->where("subscribers.id = login_history.subscriber_id"  );
		}
		
		$this->db->where( "subscribers.id = login_history_detail.subscriber_id");
		$this->db->where( "login_history_detail.location_id = locations.id");
		
		if($status == '1' || $status == '0') $this->db->where('subscribers.status', $status);
		if(!empty($location)) $this->db->where_in('locations.location_name', $location);

		if( !empty( $registered_on_start ) && strtotime($registered_on_start) == strtotime($registered_on_end) ){
			$this->db->like('subscribers.registered_on', $registered_on_start);
		}elseif( !empty( $registered_on_start ) ){
			$this->db->where('subscribers.registered_on >=', $registered_on_start);
			$this->db->where('subscribers.registered_on <=', $registered_on_end);
		}
		$this->db->join('subscribers_meta', 'subscribers.id = subscribers_meta.subscriber_id');

		$this->db->group_by('subscribers.id' , "DESC");
		$this->db->select('subscribers.id ,subscribers.sms_verified , subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , locations.location_name , login_history.login_count, subscribers_meta.subs_country');
		$this->db->order_by("subscribers.id", "DESC");
		return $this->db->get("subscribers , login_history , locations ,  login_history_detail")->result();	
		
	}
	
	
	
	//---------------------------------------------------------------------------------------------------------------------------
	function getSubscribersByDate($startDate , $endDate){

		$this->db->join('login_history', "subscribers.id = login_history.subscriber_id AND login_history.last_login_time >= '".$startDate ."' AND login_history.last_login_time <= '".$endDate."'"  );
		$this->db->join('login_history_detail', "subscribers.id = login_history_detail.subscriber_id");
		$this->db->join('locations', "login_history_detail.location_id = locations.id");
		$this->db->select('subscribers.id  ,subscribers.sms_verified, subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , locations.location_name , login_history.login_count');
		$this->db->group_by('subscribers.id' , "DESC");
		$this->db->order_by("subscribers.id", "DESC");
		return $this->db->get($this->table)->result();	
	}
	
	
	  /**
	  * Get Data from table with pagination and filters
	  *
	  * @return array Data
	  * $limit is the limit to collect data in one iteration
	  * start is the row id to start the collection from
	  */
	  public function getSubscribersWhere($limit, $start, $where)
	  {
		  $this->db->limit($limit, $start);
		  $this->db->join('login_history', 'subscribers.id = login_history.subscriber_id');
		  $this->db->join('login_history_detail', "subscribers.id = login_history_detail.subscriber_id");
		  $this->db->join('locations', "login_history_detail.location_id = locations.id");
		  $this->db->where($where);
		  $this->db->select('subscribers.id , subscribers.name , subscribers.email , subscribers.phone , subscribers.status , subscribers.registered_on , login_history.last_login_time , locations.location_name , login_history.login_count');
		  $this->db->group_by('subscribers.id' , "DESC");
			$this->db->order_by("subscribers.id", "DESC");
		  return $this->db->get($this->table)->result();
	  }

	  /**
	  * Get Data from table with latest subscribers
	  *
	  * @return array Data
	  * $limit is the limit to collect data in one iteration
	  * start is the row id to start the collection from
	  */
	  public function getTopSubscribers($limit)
	  {
		  $this->db->limit($limit);
		  $this->db->join('login_history', 'subscribers.id = login_history.subscriber_id');
		  $this->db->where(array('login_history.login_count>' => '1', 'subscribers.status' => '1'));
		  $this->db->order_by("login_history.login_count", "DESC");
		  return $this->db->get($this->table)->result();
	  }

	  /**
	  * Get subscribers last visited location
	  *
	  * @return array Data
	  * $limit is the limit to collect data in one iteration
	  * start is the row id to start the collection from
	  */
	  public function getSubscribersLastLocation($id)
	  {
		  $this->db->limit(1);
		  $this->db->order_by('subscriber_id',"DESC");
		  return $this->db->get($this->table)->result();
	  }
	
	function get_subscriber_login_detail_count($id){
		$this->db->select('login_history_detail.* ,locations.*');
		$this->db->from('login_history_detail');
		$this->db->join('locations' , "login_history_detail.location_id = locations.id");
		$this->db->where("login_history_detail.subscriber_id" , $id);
		return $this->db->get()->result();
	}
	function get_subscriber_login_detail( $limit, $start , $id){
		$this->db->limit($limit, $start);
		$this->db->select('login_history_detail.* ,locations.*');
		$this->db->from('login_history_detail');
		$this->db->join('locations' , "login_history_detail.location_id = locations.id");
		$this->db->where("login_history_detail.subscriber_id" , $id);
		return $this->db->get()->result();
	}
	
	
	// function get_all_devices(){
	// 	$this->db->order_by("device_type", "DESC");
	// 	 $data =  $this->db->get("subscribers_meta")->result();
		
	// 	$array_name = array();
	// 	$device_count = array();
	// 	$device = "";
	// 	$count  = 1;
	// 	$index = -1;
	// 	foreach($data as $value){
	// 		if(  $value->device_type == ""){
	// 			$value->device_type = "Other";
	// 		}
	// 		if(!in_array($value->device_type, $array_name)){
	// 			array_push($array_name, $value->device_type);
	// 			$device = $value->device_type;
	// 			$count = 1;
	// 			$index ++;
	// 		}
	// 		if( $device ==  $value->device_type ){
	// 			$device_count[ $index ] = $count++;
	// 		}
	// 	}
	// 	return array("name" => $array_name , "counts" =>$device_count );
	// }

	function get_all_devices(){

		
		$this->db->distinct();
		$this->db->select('device_type, COUNT(*) as total_devices');
		$this->db->order_by('total_devices', "DESC");
		$this->db->group_by('device_type');

		$data =  $this->db->get("subscribers_meta")->result();
		
	   $array_name = array();
	   $device_count = array();
	   
		foreach($data as $single_record){
		   if(  $single_record->device_type == ""){
			   $single_record->device_type = "Other";
		   }
		   $array_name[] = $single_record->device_type;
		   $device_count[] = (int) $single_record->total_devices;
		}
	   $array_name = array_values($array_name);
	   $device_count= array_values($device_count);
	   return array("name" => $array_name , "counts" => $device_count );
   }
	
	function get_new_by_moth($month){
		$date = (object) get_first_and_end_date_new($month);
		$this->db->select('*');
		$this->db->from('subscribers');
		$this->db->like("registered_on" , $date->start);
		return $this->db->get()->num_rows();
	}
	
	function get_returning_by_moth($month){
		
		$date = (object) get_first_and_end_date($month);
		$this->db->select('login_history_detail.*');
		$this->db->from('login_history_detail');
		$this->db->join('login_history' , "login_history.subscriber_id = login_history_detail.subscriber_id");
		$this->db->where("login_history.login_count >" , 1);
		$this->db->where("login_history_detail.login_time >=" , $date->start);
		$this->db->where("login_history_detail.login_time <=" , $date->last);
		$this->db->group_by('login_history_detail.subscriber_id' , "DESC");
		return $this->db->get()->num_rows();
	}
	
	
	function all_new_by_months(){
		
		$month = date('m');
		$total_returning = array();
		for($i = 1; $i<=$month; $i++){
			$total_returning[]= $this->get_new_by_moth($i);
		}
		return $total_returning;
	}
	
	function all_returning_by_months(){
		
		$month = date('m');
		$total_returning = array();
		for($i = 1; $i<=$month; $i++){
			$total_returning[]= $this->get_returning_by_moth($i);
		}
		return $total_returning;
	}
	
	function month_names(){
		$months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October',  'November',  'December' );
		$month = date('m');
		$total_months = array();
		for($i = 1; $i<=$month; $i++){
			$total_months[] = $months[$i];
		}
		return $total_months;
	}
	
	function get_returning_by_day($date){
		$this->db->select('login_history_detail.*');
		$this->db->from('login_history_detail');
		$this->db->join('login_history' , "login_history.subscriber_id = login_history_detail.subscriber_id");
		$this->db->where("login_history.login_count >" , 1);
		$this->db->like("login_history_detail.login_time" , $date);
		$this->db->group_by('login_history_detail.subscriber_id' , "DESC");
		return $this->db->get()->num_rows();
	}
	
	function get_rew_by_day($date){
		$this->db->select('*');
		$this->db->from('subscribers');
		$this->db->like("registered_on" , $date);
		return $this->db->get()->num_rows();
	}
	
	function all_returning_by_day(){
		$days = getLastNDays(7, 'Y-m-d');
		$total_months = array();
		for($i = 0; $i<=count($days)-1; $i++){
			$total_months[]= $this->get_returning_by_day(str_replace('"' , '' , $days[$i]));
		}
		return $total_months;
	}
	
	function all_new_by_day(){
		$days = getLastNDays(7, 'Y-m-d');
		$total_months = array();
		for($i = 0; $i<=count($days)-1; $i++){
			$total_months[]= $this->get_rew_by_day(str_replace('"' , '' , $days[$i]));
		}
		return $total_months;
	}
	
}

/* End of file Domains_model.php */
/* Location: ./application/models/Domains_model.php */