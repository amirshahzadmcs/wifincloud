<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Hybridauth\Hybridauth;

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->load
            ->helper('url');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
        
        // declaring empty view data
        $view_data = array();
        //var_dump($this->input->post());
        //checking for the registration variables.
        $mobile = $this
            ->input
            ->post('full_number');
        $email = $this
            ->input
            ->post('email');
        $name = $this
            ->input
            ->post('name');
        $action_url = $this
            ->input
            ->post('action_url');
        $user_mac = $this
            ->input
            ->post('user_mac');
        $view_data['action_url'] = $action_url;
        $this->session->set_userdata('action_url', $action_url);
        
        
        
        //checking the action url
        if(isset($_GET['actionurl'])){
            $action_url_b = $_GET['actionurl'];
            $parts = parse_url($action_url_b);
            parse_str($parts['query'], $query);
            $view_data['user_mac'] = $query['mac'];
            
            if ( isset( $query['mac'] ) && $query['mac'] != '' ){
                $this->session->set_userdata('user_mac', $query['mac']);
                $mac_response = mac_check($query['mac']);
                
                //if 0, no existing mac found, else $mac_response is the user id 
                if($mac_response != '0'){
                    $where_get = array(
                        'uid' => $mac_response
                    );
                    $register_model = model_load_model('registers_model');
                    $user_data = $register_model->get($where_get, true);
                    //print_r($user_data);
                    //user already available
                    //seeting the content for autologin
                    $view_data['existing_user'] = 'Welcome back <b>'. $user_data['name'] . '</b>';
                    $view_data['success'] = 'You are successfully logged in.';
                    $view_data['action_url'] = $_GET['actionurl'];
                    view_with_headerFooter('welcome_message', $view_data);
                    return;
                }
                //$this->check_mac($query['mac']);
            }
        }
        
        
        //echo $name;
        if (isset($mobile) && $mobile == '')
        {
            $view_data['error_msg'] = 'Mobile number is required';
        }
        if (isset($email) && $email == '')
        {
            $view_data['error_msg'] = 'Email is required';
        }
        if (isset($name) && $name == '')
        {
            $view_data['error_msg'] = 'Name is required';
        }
        if (isset($view_data['error_msg']) && $view_data['error_msg'] != '')
        {
            view_with_headerFooter('welcome_message_mob', $view_data);
        }
        
        if (isset($mobile) && isset($user_mac))
        {
            $login_value = logmein($name, $email, $mobile, 'direct', $user_mac);
           
            //loading the views data
            if($login_value != 0){
                $view_data['success'] = 'You are successfully logged in.';
                $view_data['action_url'] = $action_url;
            }
            
        }

        //$view_data['error_msg'] = 'worked is required';
        view_with_headerFooter('welcome_message', $view_data);

        //		$this->load->view('welcome_message');
        
    }

}
