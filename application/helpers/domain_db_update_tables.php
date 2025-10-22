<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_and_update_tables')) {
    
        function check_and_update_tables($db_name, $db_default){
        // Load the CodeIgniter instance
                $CI =& get_instance();
                $CI->load->dbforge(); // Load the database forge class

                $new_db_name = 'cloud_db_' .$db_name;
                $db_attributes = array('COLLATE' => "utf8mb4_unicode_ci");

                if ($CI->dbforge->create_database($new_db_name, true, $db_attributes)) {
                        // Define the structure of the tables
                        $tables = [
                                'activity_logs' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'title' => ['type' => 'VARCHAR', 'constraint' => 400],
                                        'user' => ['type' => 'VARCHAR', 'constraint' => 400],
                                        'ip_address' => ['type' => 'VARCHAR', 'constraint' => 400],
                                        'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                                        'updated_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['title', 'user', 'ip_address']
                                ],
                                'ap_devices' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'device_mac' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'location_id' => ['type' => 'INT', 'constraint' => 5],
                                        'status' => ['type' => 'INT', 'constraint' => 5, 'default' => 1],
                                        'registered_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                                        'updated_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['device_mac', 'location_id', 'status']
                                ],
                                'campaigns' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'campaign_name' => ['type' => 'TEXT'],
                                        'campaign_status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                                        'start_datetime' => ['type' => 'DATETIME', 'null' => TRUE],
                                        'end_datetime' => ['type' => 'DATETIME', 'null' => TRUE],
                                        'campaign_type' => ['type' => 'VARCHAR', 'constraint' => 30],
                                        'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                                        'updated_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['campaign_status', 'start_datetime', 'end_datetime', 'campaign_type']
                                ],
                                'domains_meta' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'domain_id' => ['type' => 'INT', 'constraint' => 5],
                                        'meta_name' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'meta_value' => ['type' => 'TEXT'],
                                        'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                                        'updated_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['domain_id', 'meta_name']
                                ],
                                'email_verification' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'email' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'verification_id' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'verification_date' => ['type' => 'DATETIME', 'null' => TRUE],
                                        'created_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['email', 'verification_id']
                                ],
                                'locations' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'location_name' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'location_address' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'location_coordinates' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'status' => ['type' => 'INT', 'constraint' => 5, 'default' => 1],
                                        'registered_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                                        'updated_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['location_name', 'location_address', 'status']
                                ],
                                'login_auth' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'subscriber_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'channel_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'default' => 1],
                                        'auth_via' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'auth_number' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'auth_expiry_time' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'default' => 300],
                                        'auth_gen_time' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['subscriber_id', 'channel_id', 'auth_via', 'auth_number']
                                ],
                                'login_channels' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'channel_name' => ['type' => 'VARCHAR', 'constraint' => 100]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['channel_name']
                                ],
                                'login_history' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'subscriber_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'login_count' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'default' => 0],
                                        'last_login_time' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['subscriber_id', 'last_login_time']
                                ],
                                'login_history_detail' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'subscriber_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'channel_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'default' => 1],
                                        'location_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'default' => 1],
                                        'login_time' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['subscriber_id', 'channel_id', 'location_id']
                                ],
                                'ratings' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'campaign_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'question_text' => ['type' => 'TEXT'],
                                        'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                                        'updated_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on_update' => TRUE]
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['campaign_id']
                                ],
                                'rating_responses' => [
                                'fields' => [
                                        'response_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'rating_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'rating_value' => ['type' => 'INT', 'constraint' => 1],
                                        'feedback_text' => ['type' => 'TEXT'],
                                        'response_time' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
                                ],
                                'primary_key' => 'response_id',
                                'indexes' => ['rating_id']
                                ],
                                'sms_api_count' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'twillio_sms_count' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'monty_sms_count' => ['type' => 'INT', 'constraint' => 1],
                                        'month_name' => ['type' => 'VARCHAR', 'constraint' => 100],
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['month_name']
                                ],
                                'subscribers' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'email' => ['type' => 'VARCHAR', 'constraint' => 255],
                                        'name' => ['type' => 'VARCHAR', 'constraint' => 255],
                                        'phone' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
                                        'sms_verified' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                                        'email_verify' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
                                        'registered_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['name', 'email', 'phone', 'status', 'registered_on']
                                ],
                                'subscribers_mac' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'subscriber_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'device_mac' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
                                        'registered_on' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['subscriber_id', 'device_mac', 'status', 'status']
                                ],
                                'subscribers' => [
                                'fields' => [
                                        'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                                        'subscriber_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'logged_via' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                                        'birthday' => ['type' => 'VARCHAR', 'constraint' => 100],
                                        'gender' => ['type' => 'VARCHAR', 'constraint' => 50],
                                        'age_group' => ['type' => 'VARCHAR', 'constraint' => 50],
                                        'device_type' => ['type' => 'VARCHAR', 'constraint' => 50],
                                        'subs_country' => ['type' => 'VARCHAR', 'constraint' => 50],
                                ],
                                'primary_key' => 'id',
                                'indexes' => ['subscriber_id', 'logged_via', 'gender', 'age_group', 'subs_country']
                                ]
                        ];
                        

                        // Iterate over each table to check and create/update structure
                        foreach ($tables as $table_name => $table_data) {
                                // Check if the table exists
                                if (!$CI->db->table_exists($table_name)) {
                                        // Create the table if it does not exist
                                        $CI->dbforge->add_field($table_data['fields']);
                                        $CI->dbforge->add_key($table_data['primary_key'], TRUE); // Add primary key
                                        $CI->dbforge->create_table($table_name, TRUE);
                                        echo "Table `$table_name` created successfully.<br/>";
                                } else {
                                        // Table exists, now check for missing fields and add them if necessary
                                        $existing_fields = $CI->db->list_fields($table_name);

                                        foreach ($table_data['fields'] as $field_name => $field_attributes) {
                                                if (!in_array($field_name, $existing_fields)) {
                                                        // Add missing field
                                                        $CI->dbforge->add_column($table_name, [$field_name => $field_attributes]);
                                                        echo "Field `$field_name` added to table `$table_name`.<br/>";
                                                }
                                        }
                                        // Check and add primary key if missing
                                        if (!primaryKeyExists($CI, $table_name)) {
                                                $CI->db->query("ALTER TABLE `$table_name` ADD PRIMARY KEY (`{$table_data['primary_key']}`)");
                                                echo "Primary key added to table `$table_name`.<br/>";
                                        }

                                        // Check and add indexes if missing
                                        foreach ($table_data['indexes'] as $index_field) {
                                                if (!indexExists($CI, $table_name, $index_field)) {
                                                        $CI->db->query("CREATE INDEX `idx_{$index_field}` ON `$table_name` (`$index_field`)");
                                                        echo "Index on `$index_field` added to table `$table_name`.<br/>";
                                                }
                                        }
                                        
                                }
                        }

                        // Helper function to check if a primary key exists
                        function primaryKeyExists($CI, $table_name) {
                                $query = $CI->db->query("SHOW KEYS FROM `$table_name` WHERE Key_name = 'PRIMARY'");
                                return $query->num_rows() > 0;
                        }

                        // Helper function to check if an index exists
                        function indexExists($CI, $table_name, $index_field) {
                                $query = $CI->db->query("SHOW INDEX FROM `$table_name` WHERE Column_name = '$index_field'");
                                return $query->num_rows() > 0;
                        }
                }

                
        }

}