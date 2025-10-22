<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Subscriber extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page_data['page']->title = 'Subscriber login';
        $this->page_data['page']->menu = 'subscriber_login';
    }
    public function index()
    {
    }

    //not allowed access function
    public function accessNotAllowed()
    {
        $this->page_data['error_number'] = 0;
        if (isset($_GET['error'])) $this->page_data['error_number']  = $_GET['error'];

        $this->load->view('front/include/header', $this->page_data);
        $this->load->view('front/view/not_allowed', $this->page_data);
        $this->load->view('front/include/footer', $this->page_data);
    }
    //front display function
    public function view($passcode)
    {
        
        if (isset($_SESSION['subscriber_login_session'])) unset($_SESSION['subscriber_login_session']);
        if (isset($_SESSION['sms_verification_detail'])) unset($_SESSION['sms_verification_detail']);
        $domain_name = decryption($passcode);
        
        // check if domain is active or not
        if (empty($this->domains_model->is_active_domain($domain_name)))  not_allow_message(2);
        $this->session->set_userdata('domain_name', $domain_name);
        
        $domain_setting = getDomainSetting($domain_name, 'intervelSetting');
        $query = array();
        

        

        // Invalid brand configuration checking
        if (!isset($domain_setting->brand)) not_allow_message(3);
       

        if ($domain_setting->brand == "Linksys" && isset($_GET['login_url']) && isset($_GET['continue_url'])) {
            $query = array('networkId' => '', 'ssidProfileId' => '', 'userurl' => $_GET['login_url'], 'mac' => $_GET['client_mac'], 'loginurl' => $_GET['continue_url'], 'called' => $_GET['ap_mac'],);
            set_session('subscriber_login_session', $query); // this line was missing.

        } elseif ($domain_setting->brand == "EnGenius" && isset($_GET['actionurl'])) {
            $parts = parse_url($_GET['actionurl']);
            
            parse_str($parts['query'], $query);
            
            set_session('subscriber_action_url', $_GET['actionurl']);
            set_session('subscriber_login_session', $query); // this line was missing.
            

        } elseif($domain_setting->brand == "Cisco" && isset($_GET['base_grant_url']) && isset($_GET['node_mac']) && isset($_GET['client_mac'])){

            /* base_grant_url = The URL a client will use to authenticate
               user_continue_url = The URL the client intended on visiting
               node_mac = Access Point’s physical network address
               client_ip = Client’s logical network address
               client_mac = Client’s physical network address
            */
            $query = array(
                'networkId' => '',
                'ssidProfileId' => '',
                'userurl' => $_GET['user_continue_url'],
                'mac' => $_GET['client_mac'],
                'loginurl' => $_GET['base_grant_url'],
                'called' => $_GET['node_mac']);
            
            set_session('subscriber_login_session', $query);
        } else {
            not_allow_message(3);
        }
        switch_db($domain_name);
        
        //getting client mac address
        $mac = (isset($_SESSION['subscriber_login_session']['mac'])) ? $_SESSION['subscriber_login_session']['mac'] : '';
        //getting access point's mac address
        $mac_address = (isset($_SESSION['subscriber_login_session']['called'])) ? $_SESSION['subscriber_login_session']['called'] : '';
        //10 digits added randomly to hide the url on both ends
        
        $curr_db = $this->db->database;
        $mac = str_replace(":", "-", $mac);
        //setting db name in session
        set_session('dname', $domain_name);
        //checking if accesspoint is registered
        $access_point_check = checkMac($mac_address);
        
        if (empty($access_point_check)) not_allow_message(4);
        //setting location id for easier retrival
        set_session('location_id', $access_point_check['0']->location_id);
        // checking if location is disbale
        if (empty($this->locations_model->is_active_location($access_point_check['0']->location_id))) not_allow_message(5);
        
        // check is user disbale or not
        if (find_disbale_subscriber_by_mac($mac)) not_allow_message(6);

        //checking if existing user
        $subscriber = subscriber_by_mac($mac);

        if (empty($subscriber)) redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
        
        if (isset($subscriber[0]->id)) {
            
            //is_mail_verified($subscriber[0]->email);
            
            $_SESSION['subscriber_id'] = $subscriber[0]->id;
            
            $subsciber_login_detail = get_subscriber_login_detail($subscriber[0]->id);
            //getting domain settnigs for time variables
            $session_interval_time = (int)$domain_setting->session_interval_time;
            $block_time_interval = (int)$domain_setting->block_time_interval;
            $last_login_time = $subsciber_login_detail[0]->last_login_time;
            //handling time constrants for login time, returning login time, block time etc
            $last_login_time = date("Y-m-d H:i:s", strtotime($last_login_time));
            $totalAccessTime = date("Y-m-d H:i:s", strtotime($last_login_time . " +" . $session_interval_time . " minutes"));
            $setLockTime = date("Y-m-d H:i:s", strtotime($totalAccessTime . " +" . $block_time_interval . " minutes"));
            $currentTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")));
            $this->page_data['name'] = $subscriber[0]->name;
            
            //current time less thn access time means he still have a valid available time slot to use the internet.
            if ($currentTime < $totalAccessTime || $currentTime > $setLockTime) {
                //function to redirect to login for existing uesrs by passing mac address
                checkUserMac($mac);
                
            } else if ($setLockTime > $currentTime) //means he is stil in block time
            {
                
                $lockTime = strtotime($setLockTime) - strtotime($currentTime);
                if ($lockTime > 0) {
                    $this->page_data['locktime'] = $lockTime;
                } else {
                    $this->page_data['locktime'] = 0; //means dont lock this user

                }
                $_SESSION['userBlocked'] = "yes";
                $this->load->view('front/include/header', $this->page_data);
                $this->load->view('front/view/aftter-one-hour', $this->page_data);
                $this->load->view('front/include/footer', $this->page_data);
                unset($_SESSION["successMes"]);
            } else {
                //if lock time is bigger then current time, the time window will be as blocked time. and wont login. instead will show message
                submit_form();
                
            }
            
        } else {
            redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
        } // what if is ending here? add comments.
        
    }
    public function loginForm()
    {
        $sms_setting_session = $this->session->userdata('sms_verification_detail');
        if (isset($sms_setting_session->code)) {
            redirect(base_url() . 'f/subscriber/login_verification', 'refresh');
        } else {
            check_if_success_send();
            //checking if session is valid
            unset_unwanted_session();
            $subscriber_session = check_session('subscriber_login_session');
            //loading views
            $domain_setting = getDomainSetting($_SESSION['dname'], 'intervelSetting');
            $this->page_data['intervelSetting'] = $domain_setting;


            switch_db($_SESSION['dname']);

            $mac = $_SESSION['subscriber_login_session']['mac'];

            $subscriber = subscriber_by_mac($mac);

            if (!empty($subscriber)) {
                $subsciber_login_detail = get_subscriber_login_detail($subscriber[0]->id);
                $session_interval_time = (int)$domain_setting->session_interval_time;
                $block_time_interval = (int)$domain_setting->block_time_interval;
                $last_login_time = $subsciber_login_detail[0]->last_login_time;

                $userloginTime = date("Y-m-d H:i:s", strtotime($last_login_time));
                $totalAccessTime = date("Y-m-d H:i:s", strtotime($last_login_time . " +" . $session_interval_time . " minutes"));
                $setLockTime = date("Y-m-d H:i:s", strtotime($totalAccessTime . " +" . $block_time_interval . " minutes"));
                $currentTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")));

                // here checking is user has access wifi?
                $this->page_data['name'] = $subscriber[0]->name;
                if ($currentTime < $setLockTime) {
                    $lockTime = strtotime($setLockTime) - strtotime($currentTime);
                    $this->page_data['locktime'] = 0;
                    if ($lockTime > 0) {
                        $this->page_data['locktime'] = $lockTime;
                    }
                    $this->load->view('front/include/header', $this->page_data);
                    $this->load->view('front/view/interval', $this->page_data);
                    $this->load->view('front/include/footer', $this->page_data);
                    unset($_SESSION["successMes"]);
                } else {
                    $this->load->view('front/include/header', $this->page_data);
                    $this->load->view('front/view/form', $this->page_data);
                    $this->load->view('front/include/footer', $this->page_data);
                }
            } else {
                $this->load->view('front/include/header', $this->page_data);
                $this->load->view('front/view/form', $this->page_data);
                $this->load->view('front/include/footer', $this->page_data);
                unset($_SESSION["successMes"]);
            }
        }
    }

    // login verification function
    function login_verification()
    {
        // if sms successfully send and verified then redirect on wifi access

        check_if_success_send();
        $sms_verification_detail = $this->session->userdata('sms_verification_detail');


        if (!isset($_SESSION['dname']) && !isset($_SESSION['sms_verification_detail'])) {
            unset_all_sms_verification_session();
            redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
        }

        // this function check if pass 5 mint of sedding code then redirect to home login page
        if (isset($sms_verification_detail->code_expire_time))
            $this->return_to_home(date("H:i:s"), $sms_verification_detail->code_expire_time);

        // checking if 5 attempts are compelet then redirect to main form add show message 
        $ip = get_client_ip();
        is_blocked($ip);

        $domain_setting = getDomainSetting($_SESSION['dname'], 'intervelSetting');


        // checking if user submit login form
        if (isset($_POST['name']) && isset($_POST['email'])) {

            //is_mail_verified($_POST['email']);

            //email paused
            //send_email_varification_link($_POST['email']);

            $name = post('name');
            // checking user phone number or email is valid or not
            $this->form_validation->set_rules('phone', 'Mobile Number ', 'required|min_length[6]');
            $this->form_validation->set_rules('email', 'Email ', 'trim|required|valid_email');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                $error = "";
                if (isset($errors['phone'])) $error = 'Invalid mobile number';
                if (isset($errors['email'])) $error = $errors['email'];
                unset($_SESSION['sms_verification_detail']);
                $this->session->set_flashdata('successMes', '<div class="alert alert-danger error-font" role="alert">  <strong>Error!</strong> ' . $error . ' </div> ');
                redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
            }
            $phone_number = post('full_number');
            $device = post('device');
            $email = post('email');
            $gender = post('gender');
            $birthday = post('birthday');
            $age_group = post('age_group');
            $subs_country = post('subs_country');

            $send_sms_detail = (object)array(
                "name"             => $name,
                "email"         => $email,
                "phone_number"     => $phone_number,
                "device"         => $device,
                "gender"         => $gender,
                "birthday"         => $birthday,
                "age_group"     => $age_group,
                "subs_country"     => $subs_country,
            );

            // checking if user phone is verified then redirect to submit form function 
            if (is_sms_verified_subscriber($email)) {
                $this->session->set_userdata('success_send', "true");
                submit_form();
            }
            // if this domain has disbale SMS setting then pass success page without SMS verification
            if (!isset($domain_setting->api_active_status) || $domain_setting->api_active_status == false) {
                $this->session->set_userdata('sms_verification_detail', $send_sms_detail);
                submit_form();
            }
            // send sms when user send login form and active sms api

            $this->load->library('twilio_library');
            $this->twilio_library->send_twilio_sms($send_sms_detail, false);
        }

        // when user want to change phone for sms verification
        if (isset($_POST['full_number'])) {

            $this->form_validation->set_rules('full_number', 'full_number Number ', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                $error = "";
                if (isset($errors['full_number'])) $error = 'Invalid mobile number';
                $this->session->set_flashdata('successMes', '<div class="alert alert-danger error-font" role="alert">  <strong>Error!</strong> ' . $error . ' </div> ');
                redirect(base_url() . 'f/subscriber/login_verification', 'refresh');
            }

            $phone_number = post('full_number');
            $this->session->set_userdata('is_change_phone', "true");

            $this->load->library('twilio_library');
            $this->twilio_library->send_twilio_sms($phone_number, true);
        }

        // if user want to resend  OTP code 
        if (isset($_GET['resend_otp'])) {
            if (decryption($_GET['resend_otp']) == "send_new_code") {

                $sms_session = $this->session->userdata('sms_verification_detail');


                if ($sms_verification_detail->code_count > 5) {
                    $sms_block = (object)array(
                        "ip" => get_client_ip(),
                        "is_block" => true,
                    );
                    $this->session->set_userdata('sms_block', $sms_block);
                    unset($_SESSION['sms_verification_detail']);
                    $this->session->set_flashdata('successMes', '<div class="alert alert-danger" role="alert">You have been blocked for one hour due to incorrect OTP attempts.</div> ');
                    redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
                }
                $this->load->library('twilio_library');
                $this->twilio_library->send_twilio_sms($sms_session, false);
            }
        }


        $this->load->view('front/include/header', $this->page_data);
        $this->load->view('front/view/login_verification', $this->page_data);
        $this->load->view('front/include/footer', $this->page_data);
        unset($_SESSION["successMes"]);
    }

    // this function check if past 5 mint of sedding code then redirect to home login page
    function return_to_home($code_send_time, $code_expire_time)
    {
        if ($code_send_time > $code_expire_time && !empty($code_expire_time)) {
            unset_all_sms_verification_session();
            $this->session->set_flashdata('successMes', '<div class="alert alert-danger" role="alert">Oops! Your OTP has been expired. Please try again</div> ');
            redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
        }
    }


    function check_otp()
    {

        check_if_success_send();
        if (isset($_SESSION['dname']) && isset($_SESSION['sms_verification_detail']) && isset($_SESSION['subscriber_login_session'])) {

            $sms_verification_detail = $this->session->userdata('sms_verification_detail');
            $opt = post('code');
            unset($_SESSION["successMes"]);

            if (empty($opt)) redirect(base_url() . 'f/subscriber/login_verification', 'refresh');

            if ($sms_verification_detail->code == $opt) {

                $location_id = get_session("location_id");
                $machine_name = get_session("dname");
                $domain_detail = get_domain_by_machine($machine_name);
                $subscriber_session = check_session('subscriber_login_session');
                // helper to login the subscriber
                $sms_verification_detail = $this->session->userdata('sms_verification_detail');

                $name             = $sms_verification_detail->name;
                $phone_number     = $sms_verification_detail->phone_number;
                $email             = $sms_verification_detail->email;
                $device         = $sms_verification_detail->device;
                $gender         = (isset($sms_verification_detail->gender)) ? $sms_verification_detail->gender : "";
                $birthday         = (isset($sms_verification_detail->birthday)) ? $sms_verification_detail->birthday : "";
                $age_group         = (isset($sms_verification_detail->age_group)) ? $sms_verification_detail->age_group : "";
                $subs_country         = (isset($sms_verification_detail->subs_country)) ? $sms_verification_detail->subs_country : "";


                $this->session->set_userdata('sms_verified', "true");
                $this->session->set_userdata('success_send', "true");
                subscriber_login($name, $email, $phone_number, $gender, $birthday, $age_group, $device, $subs_country);
            } else {
                $this->session->set_flashdata('successMes', '<div class="alert alert-danger" role="alert">The OTP code is incorrect, please try again.</div> ');
                redirect(base_url() . 'f/subscriber/login_verification', 'refresh');
            }
        } else {
            unset_all_sms_verification_session();
            redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
        }
    }
    public function formSubmit()
    {

        //checking if session is valid
        $subscriber_session = check_session('subscriber_login_session');
        $sms_verification_detail = $this->session->userdata('sms_verification_detail');
        if (isset($sms_verification_detail->name)) { // helper to login the subscriber
            $this->session->set_userdata('success_send', "true");
            $name             = $sms_verification_detail->name;
            $phone_number     = $sms_verification_detail->phone_number;
            $email             = $sms_verification_detail->email;
            $device         = $sms_verification_detail->device;

            $gender         = (isset($sms_verification_detail->gender)) ? $sms_verification_detail->gender : "";
            $birthday         = (isset($sms_verification_detail->birthday)) ? $sms_verification_detail->birthday : "";
            $age_group         = (isset($sms_verification_detail->age_group)) ? $sms_verification_detail->age_group : "";
            $subs_country         = (isset($sms_verification_detail->subs_country)) ? $sms_verification_detail->subs_country : "";

            if (strlen($phone_number) > 5) {



                subscriber_login($name, $email, $phone_number, $gender, $birthday, $age_group, $device, $subs_country);
            } else {
                $this->session->set_flashdata('successMes', '<div class="alert alert-danger" role="alert">Your phone number is invalid</div> ');
                unset_all_sms_verification_session();
                redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
            }
            //no need for return, page redirects to loginSuccess via subscriber helper

        } else {
            unset_all_sms_verification_session();
            redirect(base_url() . 'f/subscriber/loginForm', 'refresh');
        }
    }
    //triggers when a user is successfully returning back to the wifi (returning subscriber)
    public function loginSuccess()
    {
        //checking if the user is blocked and unsetting its sessions & blocking its access to internet
        if (isset($_SESSION['userBlocked']) && isset($_SESSION['subscriber_id'])) {
            $id = $_SESSION['subscriber_id'];
            unset($_SESSION['userBlocked']);
            unset($_SESSION['subscriber_id']);
            add_subscriber_update($id);
        }

        //checking if subscriber found & triggering the raiting module
        if (isset($_SESSION['subscriber_id'])) {
            
        }
        $this->load->view('front/include/header', $this->page_data);
        $this->load->view('front/view/success', $this->page_data);
        $this->load->view('front/include/footer', $this->page_data);
    }
    public function logged()
    {
        redirect(get_session('subscriber_action_url'), 'refresh');
    }

    //subscriber rating page
    public function campaign()
    {

        switch_db(get_session('dname'));
        $CI = &get_instance();
        //setting up the campagin related data
        if (isset($_SESSION['active_campaign_id']) && $_SESSION['active_campaign_id'] != 0) {
            $campaign = $CI->campaigns_model->getById($_SESSION['active_campaign_id']);
            $campaign_questions = $CI->ratings_model->getByWhere(array(
                'campaign_id' => $_SESSION['active_campaign_id'],
            ));

            //setting up page data
            $this->page_data['campaign'] = $campaign;
            $this->page_data['campaign_questions'] = $campaign_questions;
        }

        $this->load->view('front/include/header', $this->page_data);
        $this->load->view('front/view/campaign', $this->page_data);
        $this->load->view('front/include/footer', $this->page_data);
    }

    //handling the submission of rating
    public function campaignSubmit()
    {
        switch_db(get_session('dname'));
        $CI = &get_instance();
        if (!empty($_POST)) {

            $ratings = $_POST;
            $rateData = array();
            foreach ($ratings as $key => $value) {
                // Check if the key starts with 'rate' and extract the numeric part
                if (strpos($key, 'rate') === 0) {
                    $rateId = substr($key, 4); // Remove the 'rate' prefix
                    $rateData[] = array(
                        'rate_q_id' => $rateId,
                        'value' => $value
                    );
                }
            }
            $ratingsJson = json_encode($rateData);
            //storing the values
            $response_id = $CI->rating_responses_model->create(array(
                'campaign_id' => $_SESSION['active_campaign_id'],
                'subscriber_id' => $_SESSION['subscriber_id'],
                'response' => $ratingsJson,
            ));
        }
        redirect('f/subscriber/loginSuccess', 'refresh');
    }
}
