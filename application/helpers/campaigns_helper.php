<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


function campaigns_active_check(){
    $CI = &get_instance();
    $campaign = $CI->campaigns_model->active_campaign();
    if($campaign == 0){
        set_session("active_campaign", '0');
        set_session("active_campaign_id", '0');
        return;
    }else{
        set_session("active_campaign", '1');
        set_session("active_campaign_id", $campaign['id']);
    }
}
	
?>