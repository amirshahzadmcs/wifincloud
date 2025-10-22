<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



function set_session($key, $data){
    $CI = & get_instance();
    $CI->load->library('session');

    $CI->session->set_userdata($key, $data);
    return;
}

function get_session($key) {
    $CI = & get_instance();
    $CI->load->library('session');
    // checking sessions if any data is stored
    $session_data = ($CI->session->userdata($key));
    
    return $session_data;
}


//special function to check the subscriber_login_session
function check_session($key){
    $CI = & get_instance();
    $CI->load->library('session');
    // checking sessions if any data is stored
    $session_data = ($CI->session->userdata($key));

    if(!isset($session_data)){
        redirect('f/subscriber/accessNotAllowed','refresh'); 
    }
    return $session_data;
}


function session_set_linksys($key, $data){
    $CI = & get_instance();
    $CI->load->library('session');
    $CI->session->set_userdata($key, $data);
    return;
}

function get_linksys_session( $linksys_session_key ){
    $CI = & get_instance();
    $CI->session->set_userdata($key, $data);
    $session_data = ($CI->session->userdata('linksys_session'));
    if(!isset( $session_data-> $linksys_session_key )){
        return $session_data-> $linksys_session_key;
    }else{
        return '';
    }
}


function checkMac($mac_address){
    $CI =& get_instance();
    $mac_address = str_replace("-",":", $mac_address);
    $access_point_check = $CI->accesspoint_model->getByWhere(array('device_mac' => $mac_address , "status" => 1)); 
    return $access_point_check;
}

function checkMacAddress($mac_address){ 
    $CI =& get_instance();
    $mac_address = str_replace(":","-", $mac_address);
    $access_point_check = $CI->accesspoint_model->getByWhere(array('device_mac' => $mac_address)); 
    
    return $access_point_check;
}