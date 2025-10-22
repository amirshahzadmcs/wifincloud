<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require APPPATH.'third_party/PHPMailer/src/Exception.php';
require APPPATH.'third_party/PHPMailer/src/PHPMailer.php';
require APPPATH.'third_party/PHPMailer/src/SMTP.php';

class Mailer_configration{
	
	
	function  sendMail( $to  , $name , $subject , $body){
		
		$mail = new PHPMailer(true);
		$CI = & get_instance();
		$globelDomain = get_session('dname');
		
		$this->page_data = getDomainSetting($globelDomain, 'intervelSetting');
		if( isset( $this->page_data->email_checkbox ) ){
			
			if( $this->page_data->email_checkbox == true|| $this->page_data->email_checkbox == 1 ){
				
				$host 		= $this->page_data->emailConfiguration->host_name;
				$username 	= $this->page_data->emailConfiguration->username;
				$password 	= $this->page_data->emailConfiguration->password;
				$port 		= $this->page_data->emailConfiguration->port_number;
				$from 		= $this->page_data->emailConfiguration->from_email;
				
				try {
					//Server settings
					$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
					$mail->isSMTP();                                            //Send using SMTP
					$mail->Host       = $host;                     //Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
					$mail->Username   = $username;                     //SMTP username
					$mail->Password   = $password;                               //SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
					$mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				
					//Recipients
					$mail->setFrom($from, 'WiFinCloud');
					$mail->addAddress($to, $name);     //Add a recipient
					// $mail->addAddress('ellen@example.com');               //Name is optional
					// $mail->addReplyTo('info@example.com', 'Information');
					// $mail->addCC('cc@example.com');
					// $mail->addBCC('bcc@example.com');
				
					//Attachments
					// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
					// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
				
					//Content
					$mail->isHTML(true);                                  //Set email format to HTML
					$mail->Subject = 'Here is the subject';
					$mail->Body    = $body;
					// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
					$mail->send();
					echo 'Message has been sent';
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
				
				try {
					$mail = new PHPMailer();
					$SMTP = new SMTP();
					//Server settings
					//$mail->SMTPDebug = $SMTP::DEBUG_SERVER;                      //Enable verbose debug output
					$mail->isSMTP();                                            //Send using SMTP
				

					$mail->Host       = $host;                     //Set the SMTP server to send through
					// $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
					$mail->Username   = $username;                     //SMTP username
					$mail->Password   = $password;                               //SMTP password
					$mail->SMTPAuth = true; // enable SMTP authentication
					$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
					// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
					$mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

					//Recipients
					$mail->setFrom($from, 'Mailer');
					$mail->addAddress($to , $name);     //Add a recipient

					//Content
					$mail->isHTML(true);                                  //Set email format to HTML
					$mail->Subject = $subject;
					$mail->Body    = $body;

					if($mail->send()) return true;
					else return false;
				} catch (Exception $e) {
					return false;
				}
		
			}
		}
	}
}


?>