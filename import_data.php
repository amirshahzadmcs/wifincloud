<?php


function connect_db( $db_name ){
	
	$servername = 'localhost';
	$username = 'admin';
	$password = 'JAD09hks6SSmyM5';
	// Create connection
	$conn = new mysqli($servername, $username, $password , $db_name);
	// Check connection
	if ($conn->connect_error) {
	  return false;
	}
	return $conn;
}

// Old database name here
$old = connect_db( 'wifincloud_old_db' );
// new database name
$new = connect_db( 'cloud_db_beruit' );


$sql = 'SELECT * FROM registers';
$result = $old->query($sql);


$subscribers = 'SELECT * FROM subscribers';
$subscribers_resutl = $new->query($subscribers);
if($subscribers_resutl->num_rows > 0){
	echo "You have already import database";
}else{
	
	while($row = $result->fetch_assoc()) {	
		
		$id	 = $row['uid'];
		$name = $row['name'];
		$name = str_replace("'","\'", $name); 
		$email = $row['email'];
		$phone = $row['phone'];
		$registered_on = $row['registered_on'];
		
		
		$sql = "INSERT INTO subscribers (name, email, phone , status , sms_verified , registered_on)
		VALUES ('$name', '$email', '$phone' , '1' , '0' , '$registered_on')";
		
		if ($new->query($sql) === TRUE) {
		  
			$subscriber_id = 	$new->insert_id;
			
			  //Old db user detail of user mac address and his login history
			$users_meta_sql 	= 'SELECT * FROM users_meta WHERE user_id = '.$id;
			$users_meta_sql = $old->query($users_meta_sql);
			
			if($users_meta_sql->num_rows > 0){
				$users_meta_sql = $users_meta_sql->fetch_assoc();

				$device_mac = 	$users_meta_sql['device_mac'];
				$meta_sql = "INSERT INTO subscribers_mac (subscriber_id, device_mac, status , registered_on)
				VALUES ('$subscriber_id', '$device_mac', '1' ,'$registered_on')";
				$new->query($meta_sql);
				
			}else{
				
				echo " Subscriber id > <b>".$subscriber_id."</b> has not mac address in old databse <br>";
			}
			
			$user_login_history = 'SELECT * FROM user_login_history WHERE uid = '.$id;
			$user_login_history = $old->query($user_login_history);
			if($user_login_history->num_rows > 0){
				
				$user_login_history = $user_login_history->fetch_assoc();
				$login_count = $user_login_history['login_count'];
				$last_login_time = $user_login_history['login_on'];
				
				$meta_sql = "INSERT INTO login_history (subscriber_id, login_count, last_login_time)
				VALUES ('$subscriber_id', '$login_count', '$last_login_time')";
				$new->query($meta_sql);
				
				$meta_sql = "INSERT INTO login_history_detail (subscriber_id, channel_id, location_id , login_time)
				VALUES ('$subscriber_id','1','1','$last_login_time')";
				$new->query($meta_sql);
				
			}else{
				
				$login_count = '1';
				$last_login_time = $registered_on;
				$meta_sql = "INSERT INTO login_history (subscriber_id, login_count, last_login_time)
				VALUES ('$subscriber_id', '$login_count', '$last_login_time')";
				$new->query($meta_sql);
				
				$meta_sql = "INSERT INTO login_history_detail (subscriber_id, channel_id, location_id , login_time)
				VALUES ('$subscriber_id','1','1','$last_login_time')";
				$new->query($meta_sql);
			}
			
			
			 $meta_sql = "INSERT INTO subscribers_meta (subscriber_id, logged_via, birthday , gender , device_type)
			VALUES ('$subscriber_id', '1' , '' , '' , '' )"; 
			$new->query($meta_sql);
			
		} else {
		  echo '<br>Error: ' . $sql . '<br>' . $new->error;
		}
	}
}

?>