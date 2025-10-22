<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emails extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function domain_expired() {
        $domains = $this->domains_model->get();
    
        foreach ($domains as $domain) {
            $expiryDate = $domain->license_expiry_date;
            $data = licenceDateColor($expiryDate); // Helper to calculate days left and other details
            $user = $this->users_model->where($domain->users_id)->get()->row();
    
            $emails = explode(',', $domain->emails_to_send); // Convert comma-separated emails to an array
            $email_expiry = $domain->email_expiry; // Weekly or Monthly email preference
            $daysLeft = $data['figer']; // Days remaining before expiry
            
            // Determine whether to send email based on daysLeft
            if ($daysLeft == 30 || $daysLeft == 15 || $daysLeft == 7 || $daysLeft < 3){
                
                // Prepare email data
                $emailData = [
                    'name' => $user->name,
                    'daysLeft' => $daysLeft,
                    'registration_date' => date('d-m-Y', strtotime($domain->license_activation_date)),
                    'expire_date' => date('d-m-Y', strtotime($domain->license_expiry_date)),
                ];
    
                // Load the email content from the view
                $message = $this->load->view('templates/email/license-expired.php', $emailData, TRUE);
    
                // Load email library and set configuration
                $this->load->library('email');
                $this->email->clear();
                $this->email->from('company@email.com', 'WifinCloud');
                $this->email->to($emails); // Send to multiple recipients
                $this->email->subject('License Expiry Notification');
                $this->email->message($message); // Set the view as the email body content
    
                // Send email
                if ($this->email->send()) {
                    log_message('info', 'Expiry notification email sent to: ' . implode(', ', $emails));
                } else {
                    log_message('error', 'Failed to send expiry notification email.');
                }
            }
        }
    }
}
