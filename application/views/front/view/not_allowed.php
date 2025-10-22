<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="error_page">

<?php $error_messages = get_session('subscriber_error'); ?>
<?php 
	
	switch ($error_number) {
        case 0:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Direct access is not allowed. Please connect via WiFi.
				</div>
			<?php 
        break;
		case 2:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Current domain has been disabled. Please contact your administrator or service provider.
				</div>
			<?php 
        break;
		case 3:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Invalid brand configuration. Please contact your administrator.
				</div>
			<?php 
        break;
		case 4:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Undefined access point. Please contact your service provider.
				</div>
			<?php 
        break;
		case 5:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Current location has been disabled. Please contact your administrator or service provider.
				</div>
			<?php 
        break;
		case 6:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Your account has been disbale. Please contact your service provider.
				</div>
			<?php 
        break;
		case 7:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Please verify your email first.
				</div>
			<?php 
        break;
		case 8:
            ?>
				<div class="error-message alert-success text-center mt-4 mb-4" role="alert">
					Your mail has been verified.
				</div>
			<?php 
        break;
		case 9:
            ?>
				<div class="error-message alert-danger text-center mt-4 mb-4" role="alert">
					Verification link is not valid.
				</div>
			<?php 
        break;
    }
	

?>

</div> 