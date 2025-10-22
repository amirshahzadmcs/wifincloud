<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller
{

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
		if ($globelDomain->domainId) {
			$arg['id'] = $domain;

			if ($globelDomain->users_id != logged("id") && logged("role") != 1) {
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
			$last_visited = $this->input->get('last_visited_check');
			$last_visited = ($last_visited !== null) ? trim($last_visited) : '';

			$status = $this->input->get('status_check');
			$location = $this->input->get('location_check');
			if (isset($location[0])) {
				$location = (!empty($location[0])) ? explode(",", $location[0]) : "";
			}

			if (!empty($registered_on) || !empty($status) || $status == '0' || !empty($location) || !empty($last_visited)) {


				$status_count = $date_count = 0;
				$this->page_data['dateFilter'] = true;
				$registered_on_array = explode("_", trim($registered_on));

				$registered_on_start = (isset($registered_on_array[0])) ? str_replace(" ", "", $registered_on_array[0]) : "";
				$registered_on_end = (isset($registered_on_array[1])) ? str_replace(" ", "", $registered_on_array[1]) : "";
				$this->page_data['registered_on'] = array('start' => $registered_on_start, 'end' => $registered_on_end);

				$last_visited_array = explode("_", $last_visited);

				$last_visited_start = (isset($last_visited_array[0])) ? str_replace(" ", "", $last_visited_array[0]) : "";
				$last_visited_end = (isset($last_visited_array[1])) ? str_replace(" ", "", $last_visited_array[1]) : "";
				$this->page_data['last_visited'] = array('start' => $last_visited_start, 'end' => $last_visited_end);



				$config["total_rows"] = $this->subscribers_model->getSubscribersByfilterCount($registered_on_start, $registered_on_end, $last_visited_start, $last_visited_end, $status, $location);


				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$this->page_data["links"] = $this->pagination->create_links();

				$allRedocrd = $this->subscribers_model->getSubscribersByfilter($config["per_page"], $page, $registered_on_start, $registered_on_end, $last_visited_start, $last_visited_end, $status, $location);

				$this->page_data['subscribers_list'] = $allRedocrd;
				$this->page_data['isAdvanceFilter'] = true;

			} else {

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

	function exportCsv()
	{
		$config['cookie_secure'] = false;
		$domainsRes = $this->session->userdata('globelDomain');
		$domainName = $domainsRes->domain_db_name;
		switch_db($domainsRes->domain_db_name);

		$registered_on = $this->input->get('registered_on_check1');
		$last_visited = trim($this->input->get('last_visited_check1'));
		$status = $this->input->get('status_check1');
		$location = $this->input->get('location_check1');
		if (isset($location[0])) {
			$location = (!empty($location[0])) ? explode(",", $location[0]) : "";
		}

		if (!empty($registered_on) || !empty($status) || $status == '0' || !empty($location) || !empty($last_visited)) {

			$status_count = $date_count = 0;
			$this->page_data['dateFilter'] = true;
			$registered_on_array = explode("_", trim($registered_on));

			$registered_on_start = (isset($registered_on_array[0])) ? str_replace(" ", "", $registered_on_array[0]) : "";
			$registered_on_end = (isset($registered_on_array[1])) ? str_replace(" ", "", $registered_on_array[1]) : "";
			$this->page_data['registered_on'] = array('start' => $registered_on_start, 'end' => $registered_on_end);

			$last_visited_array = explode("_", $last_visited);

			$last_visited_start = (isset($last_visited_array[0])) ? str_replace(" ", "", $last_visited_array[0]) : "";
			$last_visited_end = (isset($last_visited_array[1])) ? str_replace(" ", "", $last_visited_array[1]) : "";
			$this->page_data['last_visited'] = array('start' => $last_visited_start, 'end' => $last_visited_end);

			switch_db($domainsRes->domain_db_name);

			$filterRecord = $this->subscribers_model->getSubscribersByfilter("", "", $registered_on_start, $registered_on_end, $last_visited_start, $last_visited_end, $status, $location);


			$this->subscribers_model->export_record($filterRecord, $domainName);
			$globelDomain = $this->session->userdata('globelDomain');
			add_log("Report downloaded of  (" . $globelDomain->domainName . ") downloaded by User: " . $globelDomain->userName, $globelDomain);

			redirect('/panel/reports', 'refresh');

		} else {

			switch_db(default_db_name());
			if ($domainsRes->users_id != logged("id") && logged("role") != 1) {
				ifPermissions('not_allowed');
				return;
			}
			switch_db($domainsRes->domain_db_name);
			$allData = $this->subscribers_model->getAllSubscribersCsv();
			$this->subscribers_model->export_record($allData, $domainName);

			$globelDomain = $this->session->userdata('globelDomain');
			add_log("Report downloaded of  (" . $globelDomain->domainName . ") downloaded by User: " . $globelDomain->userName, $globelDomain);

			//redirect('/panel/reports', 'refresh');

		}
	}

	public function edit($id, $domain_id)
	{
		ifPermissions('manage_own_domain');

		$get_domain = $this->domains_model->getById($domain_id);

		//checking if this domain belongs to current user
		if ($get_domain->users_id != logged("id") && logged("role") != 1) {
			ifPermissions('not_allowed');
			return;
		} else {
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
			'id' => $this->page_data['User']->role
		])[0];
		$this->page_data['User']->activity = $this->activity_model->getByWhere([
			'user' => $id
		], ['order' => ['id', 'desc']]);
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
		add_log("Location #$id (" . $data['location_name'] . ") Updated by User: " . $domainsRes->userName, $globelDomain);


		$this->session->set_flashdata('alert-type', 'success');
		$this->session->set_flashdata('alert', 'Location has been Updated Successfully');

		redirect('panel/locations?domains=' . $domain_id);
	}

	public function change_status($id, $domain_id)
	{

		switch_db_by_domain_id($domain_id);
		$this->subscribers_model->update($id, ['status' => get('status') == 'true' ? 1 : 0]);
		$status = get('status') == 'true' ? 'enable' : 'disable';
		$globelDomain = $this->session->userdata('globelDomain');
		add_log("Subscriber status " . $status . " agains domain: (" . $globelDomain->domainName . ") subscriber id: " . $id . " Updated by User: " . $globelDomain->userName, $globelDomain);
		//switching the db back
		switch_db(default_db_name());
		echo 'done';
	}
	function get_subscriber_login_detail($id)
	{

		ifPermissions('reporting');
		if (!empty($id)) {
			$globelDomain = $this->session->userdata('globelDomain');
			switch_db($globelDomain->domain_db_name);
			$name = $_GET['name'];

			$data = "";

			$allRedocrd = array();
			$config = array();
			$config["base_url"] = base_url() . "panel/reports/get_subscriber_login_detail/" . $id;
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
			$allRedocrd = $this->subscribers_model->get_subscriber_login_detail($config["per_page"], $page, $id);
			$subscriber_meta = $this->subscribers_meta_model->getByWhere(array('subscriber_id' => $id));


			foreach ($allRedocrd as $row) {

				$chanal = "";
				if ($row->channel_id == '1') {
					$chanal = "Direct";
				}
				$data .= '<tr >
							<td>' . $row->location_name . '</td>
							<td>' . $row->location_address . '</td>
							<td>' . $row->login_time . '</td>
							<td>' . $chanal . '</td>
						</tr>';
			}
			if (!empty($allRedocrd)) {
				$countries = array(
					"AF" => "Afghanistan",
					"AX" => "Aland Islands",
					"AL" => "Albania",
					"DZ" => "Algeria",
					"AS" => "American Samoa",
					"AD" => "Andorra",
					"AO" => "Angola",
					"AI" => "Anguilla",
					"AQ" => "Antarctica",
					"AG" => "Antigua And Barbuda",
					"AR" => "Argentina",
					"AM" => "Armenia",
					"AW" => "Aruba",
					"AU" => "Australia",
					"AT" => "Austria",
					"AZ" => "Azerbaijan",
					"BS" => "Bahamas",
					"BH" => "Bahrain",
					"BD" => "Bangladesh",
					"BB" => "Barbados",
					"BY" => "Belarus",
					"BE" => "Belgium",
					"BZ" => "Belize",
					"BJ" => "Benin",
					"BM" => "Bermuda",
					"BT" => "Bhutan",
					"BO" => "Bolivia",
					"BA" => "Bosnia And Herzegovina",
					"BW" => "Botswana",
					"BV" => "Bouvet Island",
					"BR" => "Brazil",
					"IO" => "British Indian Ocean Territory",
					"BN" => "Brunei Darussalam",
					"BG" => "Bulgaria",
					"BF" => "Burkina Faso",
					"BI" => "Burundi",
					"KH" => "Cambodia",
					"CM" => "Cameroon",
					"CA" => "Canada",
					"CV" => "Cape Verde",
					"KY" => "Cayman Islands",
					"CF" => "Central African Republic",
					"TD" => "Chad",
					"CL" => "Chile",
					"CN" => "China",
					"CX" => "Christmas Island",
					"CC" => "Cocos (Keeling) Islands",
					"CO" => "Colombia",
					"KM" => "Comoros",
					"CG" => "Congo",
					"CD" => "Congo, Democratic Republic",
					"CK" => "Cook Islands",
					"CR" => "Costa Rica",
					"CI" => "Cote D'Ivoire",
					"HR" => "Croatia",
					"CU" => "Cuba",
					"CY" => "Cyprus",
					"CZ" => "Czech Republic",
					"DK" => "Denmark",
					"DJ" => "Djibouti",
					"DM" => "Dominica",
					"DO" => "Dominican Republic",
					"EC" => "Ecuador",
					"EG" => "Egypt",
					"SV" => "El Salvador",
					"GQ" => "Equatorial Guinea",
					"ER" => "Eritrea",
					"EE" => "Estonia",
					"ET" => "Ethiopia",
					"FK" => "Falkland Islands (Malvinas)",
					"FO" => "Faroe Islands",
					"FJ" => "Fiji",
					"FI" => "Finland",
					"FR" => "France",
					"GF" => "French Guiana",
					"PF" => "French Polynesia",
					"TF" => "French Southern Territories",
					"GA" => "Gabon",
					"GM" => "Gambia",
					"GE" => "Georgia",
					"DE" => "Germany",
					"GH" => "Ghana",
					"GI" => "Gibraltar",
					"GR" => "Greece",
					"GL" => "Greenland",
					"GD" => "Grenada",
					"GP" => "Guadeloupe",
					"GU" => "Guam",
					"GT" => "Guatemala",
					"GG" => "Guernsey",
					"GN" => "Guinea",
					"GW" => "Guinea-Bissau",
					"GY" => "Guyana",
					"HT" => "Haiti",
					"HM" => "Heard Island &amp; Mcdonald Islands",
					"VA" => "Holy See (Vatican City State)",
					"HN" => "Honduras",
					"HK" => "Hong Kong",
					"HU" => "Hungary",
					"IS" => "Iceland",
					"IN" => "India",
					"ID" => "Indonesia",
					"IR" => "Iran, Islamic Republic Of",
					"IQ" => "Iraq",
					"IE" => "Ireland",
					"IM" => "Isle Of Man",
					"IL" => "Israel",
					"IT" => "Italy",
					"JM" => "Jamaica",
					"JP" => "Japan",
					"JE" => "Jersey",
					"JO" => "Jordan",
					"KZ" => "Kazakhstan",
					"KE" => "Kenya",
					"KI" => "Kiribati",
					"KR" => "Korea",
					"KW" => "Kuwait",
					"KG" => "Kyrgyzstan",
					"LA" => "Lao People's Democratic Republic",
					"LV" => "Latvia",
					"LB" => "Lebanon",
					"LS" => "Lesotho",
					"LR" => "Liberia",
					"LY" => "Libyan Arab Jamahiriya",
					"LI" => "Liechtenstein",
					"LT" => "Lithuania",
					"LU" => "Luxembourg",
					"MO" => "Macao",
					"MK" => "Macedonia",
					"MG" => "Madagascar",
					"MW" => "Malawi",
					"MY" => "Malaysia",
					"MV" => "Maldives",
					"ML" => "Mali",
					"MT" => "Malta",
					"MH" => "Marshall Islands",
					"MQ" => "Martinique",
					"MR" => "Mauritania",
					"MU" => "Mauritius",
					"YT" => "Mayotte",
					"MX" => "Mexico",
					"FM" => "Micronesia, Federated States Of",
					"MD" => "Moldova",
					"MC" => "Monaco",
					"MN" => "Mongolia",
					"ME" => "Montenegro",
					"MS" => "Montserrat",
					"MA" => "Morocco",
					"MZ" => "Mozambique",
					"MM" => "Myanmar",
					"NA" => "Namibia",
					"NR" => "Nauru",
					"NP" => "Nepal",
					"NL" => "Netherlands",
					"AN" => "Netherlands Antilles",
					"NC" => "New Caledonia",
					"NZ" => "New Zealand",
					"NI" => "Nicaragua",
					"NE" => "Niger",
					"NG" => "Nigeria",
					"NU" => "Niue",
					"NF" => "Norfolk Island",
					"MP" => "Northern Mariana Islands",
					"NO" => "Norway",
					"OM" => "Oman",
					"PK" => "Pakistan",
					"PW" => "Palau",
					"PS" => "Palestinian Territory, Occupied",
					"PA" => "Panama",
					"PG" => "Papua New Guinea",
					"PY" => "Paraguay",
					"PE" => "Peru",
					"PH" => "Philippines",
					"PN" => "Pitcairn",
					"PL" => "Poland",
					"PT" => "Portugal",
					"PR" => "Puerto Rico",
					"QA" => "Qatar",
					"RE" => "Reunion",
					"RO" => "Romania",
					"RU" => "Russian Federation",
					"RW" => "Rwanda",
					"BL" => "Saint Barthelemy",
					"SH" => "Saint Helena",
					"KN" => "Saint Kitts And Nevis",
					"LC" => "Saint Lucia",
					"MF" => "Saint Martin",
					"PM" => "Saint Pierre And Miquelon",
					"VC" => "Saint Vincent And Grenadines",
					"WS" => "Samoa",
					"SM" => "San Marino",
					"ST" => "Sao Tome And Principe",
					"SA" => "Saudi Arabia",
					"SN" => "Senegal",
					"RS" => "Serbia",
					"SC" => "Seychelles",
					"SL" => "Sierra Leone",
					"SG" => "Singapore",
					"SK" => "Slovakia",
					"SI" => "Slovenia",
					"SB" => "Solomon Islands",
					"SO" => "Somalia",
					"ZA" => "South Africa",
					"GS" => "South Georgia And Sandwich Isl.",
					"ES" => "Spain",
					"LK" => "Sri Lanka",
					"SD" => "Sudan",
					"SR" => "Suriname",
					"SJ" => "Svalbard And Jan Mayen",
					"SZ" => "Swaziland",
					"SE" => "Sweden",
					"CH" => "Switzerland",
					"SY" => "Syrian Arab Republic",
					"TW" => "Taiwan",
					"TJ" => "Tajikistan",
					"TZ" => "Tanzania",
					"TH" => "Thailand",
					"TL" => "Timor-Leste",
					"TG" => "Togo",
					"TK" => "Tokelau",
					"TO" => "Tonga",
					"TT" => "Trinidad And Tobago",
					"TN" => "Tunisia",
					"TR" => "Turkey",
					"TM" => "Turkmenistan",
					"TC" => "Turks And Caicos Islands",
					"TV" => "Tuvalu",
					"UG" => "Uganda",
					"UA" => "Ukraine",
					"AE" => "United Arab Emirates",
					"GB" => "United Kingdom",
					"US" => "United States",
					"UM" => "United States Outlying Islands",
					"UY" => "Uruguay",
					"UZ" => "Uzbekistan",
					"VU" => "Vanuatu",
					"VE" => "Venezuela",
					"VN" => "Viet Nam",
					"VG" => "Virgin Islands, British",
					"VI" => "Virgin Islands, U.S.",
					"WF" => "Wallis And Futuna",
					"EH" => "Western Sahara",
					"YE" => "Yemen",
					"ZM" => "Zambia",
					"ZW" => "Zimbabwe"
				);
				$subs_country = isset($subscriber_meta[0]->subs_country) && $subscriber_meta[0]->subs_country !== "" && $subscriber_meta[0]->subs_country !== "0" ? $countries[$subscriber_meta[0]->subs_country] : "N/A";
				$birthday = isset($subscriber_meta[0]->birthday) && $subscriber_meta[0]->birthday !== "" && $subscriber_meta[0]->birthday !== "0" ? $subscriber_meta[0]->birthday : "N/A";
				$gender = isset($subscriber_meta[0]->gender) && $subscriber_meta[0]->gender !== "" && $subscriber_meta[0]->gender !== "0" ? $subscriber_meta[0]->gender : "N/A";
				$age_group = isset($subscriber_meta[0]->age_group) && $subscriber_meta[0]->age_group !== "" && $subscriber_meta[0]->age_group !== "0" ? $subscriber_meta[0]->age_group : "N/A";
				$device_type = isset($subscriber_meta[0]->device_type) && $subscriber_meta[0]->device_type !== "" && $subscriber_meta[0]->device_type !== "0" ? $subscriber_meta[0]->device_type : "N/A";


				echo '<div class="modal-header">
						<h5 class="modal-title" style="text-transform:capitalize">' . $name . '</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					<div class="modal-body">
					<div class="table-responsive">
							<table class="table table-xs">
								<thead>
								   <tr>
									  <th>Birthday</th>
									  <th>Gender</th>
									  <th>Age Group</th>
									  <th>Device Type</th>
									  <th>Nationality</th>
								   </tr>
								</thead>
								<tbody class="">
								<td>' . $birthday . '</td>
								<td>' . $gender . '</td>
								<td>' . $age_group . '</td>
								<td>' . $device_type . '</td>
								<td>' . $subs_country . '</td>
															
								</tbody>
							 </table>
							  <div class="datatable-footer">
								<div class="dataTables_paginate paging_simple_numbers"> ' . $links . '	</div>
							 </div>
						 </div>


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
								   ' . $data . '
								</tbody>
							 </table>
							  <div class="datatable-footer">
								<div class="dataTables_paginate paging_simple_numbers"> ' . $links . '	</div>
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