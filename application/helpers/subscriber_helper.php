<?php

/*
* function to handle user register/login request
*/
function change_status($subscriber_email)
{
    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->set('status', '1');
    $CI->db->set('sms_verified', '1');
    $CI->db->where('email', $subscriber_email);
    $CI->db->update('subscribers');
}

function get_subscriber_login_detail($subsciber_id)
{
    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->where('subscriber_id', $subsciber_id);
    $subsciber = $CI->db->get('login_history')->result();
    if (!empty($subsciber)) {
        return  $subsciber;
    }
    return false;
}

function subscriber_by_mac($mac)
{

    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->select('device_mac , subscriber_id');
    $CI->db->from('subscribers_mac');
    $CI->db->where('device_mac', $mac);
    $mac = $result = $CI->db->get()->result();

    if (isset($mac[0]->device_mac)) {

        $CI->db->where('id', $mac[0]->subscriber_id);
        $CI->db->where('status', '1');
        $subsciber = $CI->db->get('subscribers')->result();

        if (!empty($subsciber)) {
            return  $subsciber;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function find_disbale_subscriber_by_mac($mac)
{
    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->select('device_mac , subscriber_id');
    $CI->db->from('subscribers_mac');
    $CI->db->where('device_mac', $mac);
    $mac = $result = $CI->db->get()->result();

    if (isset($mac[0]->device_mac)) {

        $CI->db->where('id', $mac[0]->subscriber_id);
        $CI->db->where('status', '0');
        $subsciber = $CI->db->get('subscribers')->result();

        if (!empty($subsciber))
            return  true;
    }
    return false;
}


function get_subscriber_by_email($email)
{
    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->where('email', $email);
    $CI->db->where('status', '1');
    $subsciber = $CI->db->get('subscribers')->result();
    if (!empty($subsciber)) {
        return  $subsciber;
    }
    return false;
}

function is_sms_verified_subscriber($email)
{
    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->where('email', $email);
    $CI->db->where('sms_verified', '1');
    $subsciber = $CI->db->get('subscribers')->result();
    if (!empty($subsciber)) {
        return  $subsciber;
    }
    return false;
}

function check_subscriber($email, $phone_number)
{
    $CI = &get_instance();
    switch_db(get_session('dname'));
    $CI->db->where(array('email' => $email));
    $CI->db->where(array('phone_number' => $phone_number));
    if ($CI->db->get('subscribers')->result()) {
        return true;
    } else {
        redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
    }
}

function sms_count($api)
{

    $CI = &get_instance();
    switch_db(get_session('dname'));
    $month_name = date('F  Y');
    $CI->db->where(array('month_name' => $month_name));
    $data = $CI->db->get('sms_api_count')->result();

    if (isset($data[0]->id)) {

        if ($api == "twillio") {

            $twillio_count = 1 + (int)$data[0]->twillio_sms_count;
            $CI->db->set('twillio_sms_count', $twillio_count);
            $CI->db->where('month_name',  $month_name);
            $CI->db->update('sms_api_count');
        } elseif ($api == "monty") {

            $monty_count = 1 + (int)$data[0]->monty_sms_count;
            $CI->db->set('monty_sms_count', $monty_count);
            $CI->db->where('month_name',  $month_name);
            $CI->db->update('sms_api_count');
        }
    } else {

        if ($api == "twillio") {

            $array = array(
                'twillio_sms_count'     => 1,
                'monty_sms_count'       => 0,
                'month_name'            => $month_name
            );

            $CI->db->set($array);
            $CI->db->insert('sms_api_count');
        } elseif ($api == "monty") {


            $array = array(
                'twillio_sms_count'     => 1,
                'monty_sms_count'       => 0,
                'month_name'            => $month_name
            );

            $CI->db->set($array);
            $CI->db->insert('sms_api_count');
        }
    }
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function check_if_success_send()
{
    if (isset($_SESSION['success_send']) && isset($_SESSION['sms_verification_detail'])) {
        redirect(base_url() . 'f/subscriber/formSubmit', 'refresh');
    }
}

function is_blocked($ip_address)
{
    $CI = &get_instance();
    $sms_block = $CI->session->userdata('sms_block');
    if (isset($sms_block->ip) == $ip_address) {
        unset_all_sms_verification_session();
        $CI->session->set_flashdata('successMes', '<div class="alert alert-danger" role="alert">You have been blocked for one hour due to incorrect OTP attempts.</div> ');
        redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
    }
}

//--------------------------------------------------------------------------------------
function subscriber_login($name, $email, $phone = 0, $gender = '', $birthday = '', $age_group = '', $device = '', $subs_country = '',  $logged_via = 1)
{
    $CI = &get_instance();


    
    $last_login_time_session = get_session("last_login_time");
    $subscriber_session = get_session('subscriber_login_session');
    switch_db(get_session('dname'));
    $history_check = $CI->subscribers_model->getByWhere(array(
        'email' => $email,
    ));
    $mac  = str_replace(":", "-", $subscriber_session['mac']);
    if (empty($history_check)) {
        
        $sms_verified = 0;
        if (isset($_SESSION['sms_verified'])) {
            unset($_SESSION['sms_verified']);
            $sms_verified = 1;
        }

        $new_user = $CI->subscribers_model->create(array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'sms_verified' => $sms_verified,
        ));
        $new_mac = $CI->subscribers_mac_model->create(array(
            'subscriber_id' => $new_user,
            'device_mac' => $mac,
            'status' => '1',
        ));
        $new_mac = $CI->subscribers_meta_model->create(array(
            'subscriber_id' => $new_user,
            'logged_via'     => $logged_via,
            'birthday'         => $birthday,
            'gender'         => $gender,
            'age_group'     => $age_group,
            'device_type'     => $device,
            'subs_country'     => $subs_country,
        ));

        //setting the session for easier retrival of name
        set_session('logged_info', array(
            'name' => $name,

        ));
        //passing subscriber id to add or update the subscriber login history details

        subscriber_history($new_user);
    } else {
        
        //setting the session for easier retrival of name
        set_session('logged_info', array(
            'name' => $history_check[0]->name,
            'id' => $history_check,
        ));

        //checking if the mac already existed
        $mac_check = $CI->subscribers_mac_model->getByWhere(array('device_mac' =>  $mac));
        if (empty($mac_check)) {
            //storing the new mac, since the user wasnt automatically logged in.
            $new_mac = $CI->subscribers_mac_model->create(array(
                'subscriber_id' => $history_check[0]->id,
                'device_mac' => $mac_address = str_replace(":", "-",  $mac),
                'status' => '1',
            ));
        }

        //checking if user is blocked to access the internet 
        if ($history_check[0]->status  == 0) {
            set_session('subscriber_error', 'You are not allowed to use internet. Please contact administrator');
            redirect('f/subscriber/accessNotAllowed', 'refresh');
        }
        
        //passing subscriber id to add or update the subscriber login history details
        
        subscriber_history($history_check[0]->id);
    }
}



function subscriber_history($subscriber_id)
{
    $CI = &get_instance();
    //getting last time a person logged in. 
    $last_login_time_session = get_session("last_login_time");
    $login_history_check = $CI->login_history_model->getByWhere(array(
        'subscriber_id' => $subscriber_id,
    ));
    
    //if history is empty
    if (empty($login_history_check)) {
        
        $new_login = $CI->login_history_model->create(array(
            'subscriber_id' => $subscriber_id,
            'login_count' => '1',

        ));
        login_history_detail($subscriber_id, '1');
    } else {

                
        $domainName = get_session('dname');
        $intervelSetting = getDomainSetting($domainName, 'intervelSetting');

        // lock point in mint
        $setLockPoint = 0;
        if (isset($intervelSetting->returning_interval_time)) {
            $setLockPoin = (int)$intervelSetting->returning_interval_time;
        } else {
            $setLockPoin = 300;
        }

        //User login time 
        $userloginTime = date("Y-m-d H:i:s", strtotime($login_history_check[0]->last_login_time));
        $setLockTime = date("Y-m-d H:i:s", strtotime($login_history_check[0]->last_login_time . " +" . $setLockPoin . " minutes"));
        $currentTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")));


        if ($setLockTime <= $currentTime) {
            $update_login_history = $CI->login_history_model->update($login_history_check[0]->id, array(
                'login_count' => $login_history_check[0]->login_count + 1,
                'last_login_time' => date("Y-m-d H:i:s"),
            ));

            login_history_detail($subscriber_id, '1');
            
        } else {
            
            $session_interval_time = (int)$intervelSetting->session_interval_time;
            $block_time_interval = (int)$intervelSetting->block_time_interval;
            $last_login_time = $login_history_check[0]->last_login_time;
            //print_r($_SESSION['userBlocked']);
            //print_r($block_time_interval);
            $userloginTime = date("Y-m-d H:i:s", strtotime($last_login_time));
            $totalAccessTime = date("Y-m-d H:i:s", strtotime($last_login_time . " +" . $session_interval_time . " minutes"));
            $setLockTime = date("Y-m-d H:i:s", strtotime($totalAccessTime . " +" . $block_time_interval . " minutes"));
            //print_r($setLockTime);
            if (isset($_SESSION['userBlocked']) || $currentTime > $setLockTime) {
                
                unset($_SESSION['userBlocked']);
                $update_login_history = $CI->login_history_model->update($login_history_check[0]->id, array(
                    'last_login_time' => date("Y-m-d H:i:s"),
                ));
            } else {
                
                login_success_submit();
            }
            
        }
    }
}

/*
* function to store detailed login histroy
 */
function login_history_detail($subscriber_id, $channel_id)
{
    $CI = &get_instance();
    //getting the location of current subscriber 
    $location_id = get_session('location_id');
    $new_login = $CI->login_history_detail_model->create(array(
        'subscriber_id' => $subscriber_id,
        'channel_id' => $channel_id,
        'location_id' => $location_id,
    ));
    login_success_submit();
}


function login_success_submit()
{
    $CI = &get_instance();
    if (isset($_SESSION['dname'])) {
        unset_all_sms_verification_session();
        
        //if returning user & have already submitted the campaign
        if (isset($_SESSION['returning_user']) && ($_SESSION['returning_user'] == 1)) {
            
            //checking for active campaigns
            campaigns_active_check();
            
            if (isset($_SESSION['active_campaign']) && !empty($_SESSION['active_campaign_id'])) {
                //checking if the response is already stored
                $response_id = $CI->rating_responses_model->getByWhere(array(
                    'campaign_id' => $_SESSION['active_campaign_id'],
                    'subscriber_id' => $_SESSION['subscriber_id'],
                ));
                if(empty($response_id)){
                    redirect('f/subscriber/campaign', 'refresh');
                }else{
                    redirect('f/subscriber/loginSuccess', 'refresh');
                }
            }
            //redirecting all the users other than campaign to success 
            redirect('f/subscriber/loginSuccess', 'refresh');
        } else {
            // redirecting to success
            redirect('f/subscriber/loginSuccess', 'refresh');
        }
    } else {
        redirect('f/subscriber/accessNotAllowed', 'refresh');
    }
}

function checkUserMac($mac)
{
    $CI = &get_instance();
    
    $mac_history_check = $CI->subscribers_mac_model->getByWhere(array(
        'device_mac' => $mac,
    ));

    if (!empty($mac_history_check)) {
        
        set_session("returning_user", '1');

        //getting subscriber data 
        $subscriber_data = $CI->subscribers_model->getByWhere(array(
            'id' => $mac_history_check[0]->subscriber_id,
        ));
        if (isset($subscriber_data[0])) {
            
            $subscriber_data = $subscriber_data[0];

            //checking if user is blocked to access the internet 
            if ($subscriber_data->status  == 0) {
                
                set_session('subscriber_error', 'You are not allowed to use internet. Please contact administrator');
                //redirect('f/subscriber/accessNotAllowed','refresh');
            } else {
                   
                //passing data to login function for further processing 
                subscriber_login($subscriber_data->name, $subscriber_data->email, $subscriber_data->phone, "");
                
            }
        } else {
            set_session('subscriber_error', 'You are not allowed to use internet. Please contact administrator');
            //redirect('f/subscriber/accessNotAllowed','refresh');
        }
    }

    return;
}

function add_subscriber_update($id)
{
    switch_db(get_session('dname'));
    $CI = &get_instance();
    $CI->login_history_model->update($id, array(
        'last_login_time' => date("Y-m-d H:i:s"),
    ));
    login_history_detail($id, '1');
}
function monty_api($username,  $password, $sende_name, $mobile_number, $message)
{

    // Public Variables that are used as parameters in API calls

    $base_url_SendSMS = 'http://manage.ad-ventura.ae/Developer/api/SendSMS/SingleSMS/?Username=' . $username . '&Password=' . $password;
    $data = array(
        'MobileNumbers' => $mobile_number,
        'SenderName' => $sende_name,
        'Message' => $message
    );
    $payload = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $base_url_SendSMS);
    //curl_setopt($ch, CURLOPT_POST, $fieldcnt);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
}

function submit_form()
{
    redirect('f/subscriber/formSubmit', 'refresh');
}

function invalid_brand_configration_redirect()
{
    $CI = &get_instance();
    $CI->session->set_userdata('subscriber_login_session', '1');
    set_session('subscriber_error', 'Invalid brand configuration. Please contact administrator');
    redirect('f/subscriber/accessNotAllowed', 'refresh');
}

function login_form_redirect()
{
    unset_all_sms_verification_session();
    redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
}


function unset_all_sms_verification_session()
{

    unset($_SESSION['is_change_phone']);
    unset($_SESSION['sms_block']);
    unset($_SESSION['sms_verification_detail']);
    unset($_SESSION['subscriber_error']);
    unset($_SESSION['end_time']);
    unset($_SESSION['current_time']);
    unset($_SESSION['current_second']);
    unset($_SESSION['successMes']);
    unset($_SESSION['success_send']);
    unset($_SESSION['social_login_session']);
}

function unset_unwanted_session()
{
    unset($_SESSION["sms_block"]);
    unset($_SESSION["success_send"]);
    unset($_SESSION['current_time']);
    unset($_SESSION['end_time']);
    unset($_SESSION['current_second']);
}

function registered_on_check()
{
    if (isset($_GET['registered_on_check'])) {
        if (!empty($_GET['registered_on_check']))
            return true;
    }
    return false;
}

function last_visited_check()
{
    if (isset($_GET['last_visited_check'])) {
        if (!empty($_GET['last_visited_check']))
            return true;
    }
    return false;
}


function status_check()
{
    if (isset($_GET['status_check'])) {
        if (!empty($_GET['status_check']) || $_GET['status_check'] == '0') {
            return true;
        }
    }
    return false;
}


function location_check()
{
    if (isset($_GET['location_check'][0])) {
        if (!empty($_GET['location_check'][0])) {
            return true;
        }
    }
    return false;
}

function get_first_and_end_date($month)
{
    $query_date = date("Y") . '-' . $month . '-04';
    if ($month == 6) {
        return  array("start" =>  '2021-06-01', "last" => '2021-06-31');
    } else {
        return array("start" => date('Y-m-01', strtotime($query_date)), "last" => date('Y-m-t', strtotime($query_date)));
    }
}

function get_first_and_end_date_new($month)
{
    $query_date = date("Y") . '-' . $month;
    if ($month == 6) {
        return  array("start" =>  '2021-06', "last" => '2021-06');
    } else {
        return array("start" => date('Y-m', strtotime($query_date)), "last" => date('Y-m', strtotime($query_date)));
    }
}

function getLastNDays($days, $format = 'd/m')
{
    $m = date("m");
    $de = date("d");
    $y = date("Y");
    $dateArray = array();
    for ($i = 0; $i <= $days - 1; $i++) {
        $dateArray[] = '"' . date($format, mktime(0, 0, 0, $m, ($de - $i), $y)) . '"';
    }
    return array_reverse($dateArray);
}

function days_name_by_date()
{
    $days = getLastNDays(7, 'Y-m-d');
    $dayname = array();
    foreach ($days as $value) {
        $dayname[] = date('l', strtotime(str_replace('"', "", $value)));
    }
    return $dayname;
}

function not_allow_message($error)
{
    redirect('f/subscriber/accessNotAllowed?error=' . $error, 'refresh');
}

function get_subscriber_meta($subscriber_id, $meta_key)
{
    $CI = &get_instance();
    $db_info = cunrrent_domain_db();
    switch_db($db_info['db_name']);
    $domain_meta =  $CI->db->get_where("subscribers_meta", ['subscriber_id' => $subscriber_id])->first_row();
    switch_db(default_db_name());
    if (isset($domain_meta->meta_key)) {
        return $domain_meta->meta_key;
    }
    return "";
}
function set_subscriber_meta($subscriber_id, $meta_key, $meta_value)
{
    $CI = &get_instance();
    $db_info = cunrrent_domain_db();
    switch_db($db_info['db_name']);
    if ($CI->db->get_where("subscribers_meta", ['subscriber_id' => $subscriber_id])->num_rows() == 0) {
        return $CI->db->insert("subscribers_meta", ['subscriber_id' => $subscriber_id, $meta_key => $meta_value]);
    } else {
        $CI->db->where(['subscriber_id' => $subscriber_id]);
        return $CI->db->update("subscribers_meta", [$meta_key => $meta_value]);
    }
    switch_db(default_db_name());
}
function unset_subscriber_meta($domain_id, $meta_key)
{
    $CI = &get_instance();
    $db_info = cunrrent_domain_db();
    switch_db($db_info['db_name']);
    $CI->db->where(['subscriber_id' => $subscriber_id]);
    return $CI->db->update("subscribers_meta", [$meta_key => ""]);
}

function cunrrent_domain_db()
{
    $CI = &get_instance();
    $globelDomain = $CI->session->userdata("globelDomain");
    $domain_id = $db_name = 0;
    if (!isset($globelDomain->domainId)) {
        $db_name = $_SESSION['domain_name'];
        $domain_id = get_domain_by_machine($_SESSION['domain_name']);
        $domain_id = $domain_id->id;
    } else {
        $db_name = $globelDomain->domain_db_name;
        $domain_id = $globelDomain->domainId;
    }
    return array("db_name" => $db_name, "domain_id" => $domain_id);
}
