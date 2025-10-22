<?php 

/*
* function to handle user register/login request
*/

function subscriber_login($name, $email, $phone){
    $CI =& get_instance();

    $last_login_time_session = get_session("last_login_time");
    $subscriber_session = get_session('subscriber_login_session');
    switch_db(get_session('dname'));
    $history_check = $CI->subscribers_model->getByWhere(array(
        'email' => $email,
        'phone' => $phone,
    ));

    if(empty($history_check)){
        $new_user = $CI->subscribers_model->create(array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ));
        $new_mac = $CI->subscribers_mac_model->create(array(
                'subscriber_id' => $new_user,
                'device_mac' => $subscriber_session['mac'],
                'status' => '1',
            ));
        $new_mac = $CI->subscribers_meta_model->create(array(
                'subscriber_id' => $new_user,
                'logged_via' => '1',
            ));
        
        //setting the session for easier retrival of name
        set_session('logged_info', array(
            'name' => $name,
        ));
        //passing subscriber id to add or update the subscriber login history details
        subscriber_history($new_user);
    }else{
        //setting the session for easier retrival of name
        set_session('logged_info', array(
            'name' => $history_check[0]->name,
        ));

        //checking if the mac already existed
        $mac_check = $CI->subscribers_mac_model->getByWhere(array('device_mac' => $subscriber_session['mac']));
        if(empty($mac_check)){
            //storing the new mac, since the user wasnt automatically logged in.
            $new_mac = $CI->subscribers_mac_model->create(array(
                'subscriber_id' => $history_check[0]->id,
                'device_mac' => $subscriber_session['mac'],
                'status' => '1',
            ));
        }
        
        //checking if user is blocked to access the internet 
        if($history_check[0]->status  == 0){
            set_session('subscriber_error', 'You are not allowed to use internet. Please contact administrator');
            redirect('f/subscriber/accessNotAllowed','refresh');
        }

        //passing subscriber id to add or update the subscriber login history details
        
        subscriber_history($history_check[0]->id);
    }

    
}

function subscriber_history($subscriber_id){
    $CI =& get_instance();
    //getting last time a person logged in. 
    $last_login_time_session = get_session("last_login_time");
    $login_history_check = $CI->login_history_model->getByWhere(array(
        'subscriber_id' => $subscriber_id,
    ));
    //if history is empty
    if(empty($login_history_check)){
        $new_login = $CI->login_history_model->create(array(
            'subscriber_id' => $subscriber_id,
            'login_count' => '1',
            
        ));
        login_history_detail($subscriber_id, '1');
    }else{
        //checking 6 hours difference between login history 
        $seconds_diff = time() - strtotime($login_history_check[0]->last_login_time);
        //difference in hours
        $hours_diff = $seconds_diff / 60 / 60;
        //print_r( $seconds_diff / 60 / 60);
        if($hours_diff >= 6){
            $update_login_history = $CI->login_history_model->update($login_history_check[0]->id ,array(
            
                'login_count' => $login_history_check[0]->login_count +1,
                
            ));
            login_history_detail($subscriber_id, '1');
        }else{
            redirect('f/subscriber/loginSuccess','refresh');
        }
    }
}


/*
* function to store detailed login histroy
 */
function login_history_detail($subscriber_id, $channel_id){
    $CI =& get_instance();
    //getting the location of current subscriber 
    $location_id = get_session('location_id');
    $new_login = $CI->login_history_detail_model->create(array(
        'subscriber_id' => $subscriber_id,
        'channel_id' => $channel_id,
        'location_id' => $location_id,
    ));
    redirect('f/subscriber/loginSuccess','refresh');
}

function checkUserMac($mac){
    $CI =& get_instance();

    $mac_history_check = $CI->subscribers_mac_model->getByWhere(array(
        'device_mac' => $mac,
    ));
    
    if(!empty($mac_history_check)){
        set_session("returning_user", '1');

        //getting subscriber data 
        $subscriber_data = $CI->subscribers_model->getByWhere(array(
            'id' => $mac_history_check[0]->subscriber_id,
        ));
        $subscriber_data = $subscriber_data[0];
        
        //checking if user is blocked to access the internet 
        if($subscriber_data->status  == 0){
            set_session('subscriber_error', 'You are not allowed to use internet. Please contact administrator');
            redirect('f/subscriber/accessNotAllowed','refresh');
        }else{
            //passing data to login function for further processing 
            subscriber_login($subscriber_data->name, $subscriber_data->email, $subscriber_data->phone);
        }
        
    }

    return;
}