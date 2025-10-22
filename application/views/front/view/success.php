<?php
defined('BASEPATH') or exit('No direct script access allowed');
$domain_setting = getDomainSetting($_SESSION['dname'], 'intervelSetting');
$brand = '';
if (isset($domain_setting->brand)) {
    $brand = $domain_setting->brand;
}
$subscriber_login_session = $this->session->userdata('subscriber_login_session');
?>

<?php $error_messages = get_session('subscriber_error'); ?>
<div class="error_page">

    <div class="error-message alert-success text-center mt-4 mb-4" role="alert">
        <?php $logged_info =  get_session('logged_info');
        ?>
        Welcome <?php if (null !== (get_session('returning_user'))) {
                    echo "back ";
                } ?><br /><b><?php echo $logged_info['name']; ?></b>
        <br /> Redirecting...
    </div>

    <div class="row text-center">
        <div class="col"><progress value="0" max="5" id="progressBar"></progress></div>
    </div>



    <?php if (isset($subscriber_login_session['userurl'])) { ?>
        <form method="post" style="display:none;" id="action_form" action="<?php echo $subscriber_login_session['userurl']; ?>" enctype="application/x-www-form-urlencoded" style="display:none">
            <input type="text" name="success_url" value="<?php echo $subscriber_login_session['loginurl']; ?>">
            <input type="text" name="username" value="">
            <input type="text" name="password" value="">
            <button type="submit">Connect</button>
        </form>
    <?php } ?>

    <script>
        var brand = "<?php echo $brand; ?>";
        var timeleft = 5;
        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                if (brand == 'Linksys') {
                    document.getElementById("action_form").submit();
                } else {
                    window.location.href = '../subscriber/logged'; //one level up
                }
            }
            document.getElementById("progressBar").value = 5 - timeleft;
            timeleft -= 1;
        }, 1000);
    </script>
</div>