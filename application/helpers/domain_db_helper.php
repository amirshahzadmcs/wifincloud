<?php
/*
* function to create a database
*/

function create_domain_db($db_name, $db_default){
    
    $CI =& get_instance();
    $CI->load->dbforge();
    $new_db_name = 'cloud_db_' .$db_name;
    $db_attributes = array('COLLATE' => "utf8mb4_unicode_ci");
    
    if ($CI->dbforge->create_database($new_db_name, true, $db_attributes)) {
            
        //defining table global attributes array 
        $table_attributes = array('COLLATE' => "utf8mb4_unicode_ci");
                
        switch_db($db_name);
        


        // Creating activity_logs
        $activity_logs = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '400',
                ),
                'user' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '400',
                ),
                'ip_address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '400',
                ),
            );
        $CI->dbforge->add_field($activity_logs);
        $CI->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $CI->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        $CI->dbforge->add_key('id', TRUE);

        $CI->dbforge->add_key('title');
        $CI->dbforge->add_key('user');
        $CI->dbforge->add_key('ip_address');

        $CI->dbforge->create_table('activity_logs', TRUE, $table_attributes);


        // Creating ap_devices
        $fields_ap_devices = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'device_mac' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'location_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                ),
                'status' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'default' => 1,
                ),
        );
        $CI->dbforge->add_field($fields_ap_devices);
        $CI->dbforge->add_key('id', TRUE);

        $CI->dbforge->add_field("registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $CI->dbforge->add_field("updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('device_mac');
        $CI->dbforge->add_key('location_id');
        $CI->dbforge->add_key('status');

        $CI->dbforge->create_table('ap_devices', TRUE, $table_attributes);

        // Creating campaigns
        $fields_ap_devices = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'campaign_name' => array(
                       'type' => 'TEXT',
                ),
                'campaign_status' => array(
                        'type' => 'TINYINT',
                        'constraint' => 1,
                        'default' => 0,
                ),
                'start_datetime' => array(
                        'type' => 'DATETIME',
                        'null' => TRUE,
                ),
                'end_datetime' => array(
                        'type' => 'DATETIME',
                        'null' => TRUE,
                ),
                'campaign_type' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '30',
                ),
        );
        $CI->dbforge->add_field($fields_ap_devices);
        $CI->dbforge->add_key('id', TRUE);

        $CI->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $CI->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('campaign_status');
        $CI->dbforge->add_key('start_datetime');
        $CI->dbforge->add_key('end_datetime');
        $CI->dbforge->add_key('campaign_type');

        $CI->dbforge->create_table('campaigns', TRUE, $table_attributes);

        // Creating domains_meta
        $fields_ap_devices = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'domain_id' => array(
                       'type' => 'INT',
                       'constraint' => 5,
                ),
                'meta_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'meta_value' => array(
                        'type' => 'TEXT',
                ),
        );
        $CI->dbforge->add_field($fields_ap_devices);
        $CI->dbforge->add_key('id', TRUE);

        $CI->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $CI->dbforge->add_field("updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('domain_id');
        $CI->dbforge->add_key('meta_name');

        $CI->dbforge->create_table('domains_meta', TRUE, $table_attributes);

        // Creating email_verification
        $fields_ap_devices = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'email' => array(
                       'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'verification_id' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'verification_date' => array(
                        'type' => 'DATETIME',
                        'null' => TRUE,
                ),
        );
        $CI->dbforge->add_field($fields_ap_devices);
        $CI->dbforge->add_key('id', TRUE);

        $CI->dbforge->add_field("created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('email');
        $CI->dbforge->add_key('verification_id');

        $CI->dbforge->create_table('email_verification', TRUE, $table_attributes);

        //creating locations table
        $fields_locations = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'location_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'location_address' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'location_coordinates' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'status' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'default' => 1,
                ),
        );
        $CI->dbforge->add_field($fields_locations);
        $CI->dbforge->add_field("registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $CI->dbforge->add_field("updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('location_name');
        $CI->dbforge->add_key('location_address');
        $CI->dbforge->add_key('status');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('locations', TRUE, $table_attributes);

        //creating login_auth
        $fields_login_auth = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'subscriber_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'channel_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'default' => 1,
                ),
                'auth_via' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
                'auth_number' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'auth_expiry_time' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'default'   => 300,
                ),
        );
        $CI->dbforge->add_field($fields_login_auth);
        $CI->dbforge->add_field("auth_gen_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('subscriber_id');
        $CI->dbforge->add_key('channel_id');
        $CI->dbforge->add_key('auth_via');
        $CI->dbforge->add_key('auth_number');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('login_auth', TRUE, $table_attributes);


        //creating login_channels
        $fields_login_channels = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                
                'channel_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                ),
        );
        $CI->dbforge->add_field($fields_login_channels);

        $CI->dbforge->add_key('channel_name');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('login_channels', TRUE, $table_attributes);


        //creating login_history
        $fields_login_history = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'subscriber_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'login_count' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'default' => 0,
                ),
        );
        $CI->dbforge->add_field($fields_login_history);
        $CI->dbforge->add_field("last_login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('subscriber_id');
        $CI->dbforge->add_key('last_login_time');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('login_history', TRUE, $table_attributes);


        //creating login_history_detail
        $fields_login_history_detail = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'subscriber_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'channel_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'default' => 1,
                ),
                'location_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'default' => 1,
                ),
        );
        $CI->dbforge->add_field($fields_login_history_detail);
        $CI->dbforge->add_field("login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('channel_id');
        $CI->dbforge->add_key('subscriber_id');
        $CI->dbforge->add_key('location_id');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('login_history_detail', TRUE, $table_attributes);


        //creating ratings
        $fields_login_history_detail = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'campaign_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'question_text' => array(
                        'type' => 'TEXT',
                ),
        );
        $CI->dbforge->add_field($fields_login_history_detail);

        $CI->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $CI->dbforge->add_field("updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('campaign_id');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('ratings', TRUE, $table_attributes);


        //creating rating_responses
        $rating_responses = array(
                'response_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'subscriber_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'campaign_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                ),
                'response' => array(
                        'type' => 'TEXT',
                ),
        );
        $CI->dbforge->add_field($rating_responses);
        $CI->dbforge->add_key('response_id', TRUE);

        $CI->dbforge->add_key('subscriber_id');
        $CI->dbforge->add_key('campaign_id');

        $CI->dbforge->create_table('rating_responses', TRUE, $table_attributes);


        //creating sms_api_count
        $sms_api_count = array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'twillio_sms_count' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                ),
                'monty_sms_count' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'default' => 1,
                ),
                'month_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                )
        );
        $CI->dbforge->add_field($sms_api_count);

        $CI->dbforge->add_key('month_name');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('sms_api_count', TRUE, $table_attributes);

        // Creating subscribers table
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 5,
                'default' => 1,
            ),
            'sms_verified' => array(
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0,
            ),
            'email_verify' => array(
                'type' => 'INT',
                'constraint' => 5,
            ),
        );
        $CI->dbforge->add_field($fields);
        $CI->dbforge->add_field("registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('name');
        $CI->dbforge->add_key('email');
        $CI->dbforge->add_key('phone');
        $CI->dbforge->add_key('status');
        $CI->dbforge->add_key('registered_on');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('subscribers', TRUE, $table_attributes);
        
        // Creating subscribers_mac
        $fields_subscribers_mac = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'subscriber_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'device_mac' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 5,
                'default' => 1,
            ),
        );
        $CI->dbforge->add_field($fields_subscribers_mac);
        $CI->dbforge->add_field("registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        $CI->dbforge->add_key('subscriber_id');
        $CI->dbforge->add_key('device_mac');
        $CI->dbforge->add_key('status');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('subscribers_mac', TRUE, $table_attributes);
        
        
        // Creating subscribers_meta
        $fields_subscribers_meta = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'subscriber_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'logged_via' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'birthday' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'gender' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'age_group' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => '0',
            ),
            'device_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'subs_country' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
        );
        $CI->dbforge->add_field($fields_subscribers_meta);

        $CI->dbforge->add_key('subscriber_id');
        $CI->dbforge->add_key('logged_via');
        $CI->dbforge->add_key('gender');
        $CI->dbforge->add_key('age_group');
        $CI->dbforge->add_key('subs_country');

        $CI->dbforge->add_key('id', TRUE);
        $CI->dbforge->create_table('subscribers_meta', TRUE, $table_attributes);
        
    }
}
?>
