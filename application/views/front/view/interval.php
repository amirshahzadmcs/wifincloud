<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="row form_box mt-3">
    <div class="col">
        <div class="mb-12">
            <h5 class="" style="font-weight:normal;margin:15px 0px;text-align:center;">Welcome back </h5>
            <h5 class="" style="font-weight:normal;margin:15px 0px;text-align:center;">
                <b><?php if(isset($name)) echo $name;?></b></h5>
            <h6 style="text-align:center;">You have used your allocated time. Please wait for <br><b><span
                        id="rest_link"><span id="timer"></span></psan></b> to connect again.</h6>
        </div>
    </div>

    <script>
    var seconds = Number('<?php echo $locktime; ?>');
    var hours = Math.floor(seconds % (3600 * 24) / 3600);
    var minutes = Math.floor(seconds % 3600 / 60);
    var second = Math.floor(seconds % 60);
    timer = setInterval(function() {

        if (hours < 1 && minutes < 1 && second == 1) {
            var url = '<?php echo base_url()."f/subscriber/loginSuccess"?>';
            window.location.href = url;
        } else {

            if (hours > 0) {
                if (minutes < 1) {
                    hours = hours - 1;
                    minutes = 60;
                }
            }
            if (second < 2) {
                minutes = minutes - 1;
                second = 60;
            }
        }
        second--;
        document.getElementById('timer').innerHTML = hours + " : " + minutes + " : " + second;
    }, 1000);
    </script>