<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$subscriber_login_session = $this->session->userdata('subscriber_login_session');
?>

<?php if( isset( $subscriber_login_session['userurl'] ) ){?>
<form method="post" id="action_form" action="<?php echo $subscriber_login_session['userurl']; ?>" enctype="application/x-www-form-urlencoded" style="display:none">
	<input type="text" name="success_url" value="<?php echo $subscriber_login_session['loginurl']; ?>">
	<input type="text" name="username" value="">
	<input type="text" name="password" value="">
	<button type="submit">Connect</button>
</form>
<?php } ?>

<script>
	document.getElementById("action_form").submit();
</script>

