<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	//unset($_SESSION['current_time']); 	unset($_SESSION['end_time']);
	$current_seccond = 0;
	if( !isset($_SESSION['current_time']) ){
		$_SESSION['current_time'] 	= date("Y-m-d h:i:s");
		$_SESSION['end_time'] 		= date("Y-m-d h:i:s" ,time() + 60);
	}else{
		$_SESSION['current_time'] 	= date("Y-m-d h:i:s");
	}
	if(isset($_SESSION['current_time']  )){
		$current_seccond = strtotime($_SESSION['end_time']) - strtotime($_SESSION['current_time']);
		//$_SESSION['current_second'] = strtotime($_SESSION['end_time']) - strtotime($_SESSION['current_time']);
	}
	
?>
<div id="otp-section" <?php if(isset( $_SESSION['notset'] )) echo 'style="display:none"'?>>
    <?php echo form_open('/f/subscriber/check_otp', ['id' => 'subscriber_form', 'onsubmit' => "disbale()"]); ?>
    <div class="row form_box mt-3">
        <div class="col">
            <div class="mb-12">
                    <?php //print_r( $_SESSION['successMes'] ); ?>
                    <?php echo  $this->session->flashdata('successMes');?>
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <input type="number" required min="0" class="form-control" name="code" id="code" placeholder="Enter the 5 digit OTP you received" aria-label="Enter the 5 digit OTP you received on your phone" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text" id="send-otp-code"> <div id="timer"></div> </span>
                    </div>
                </div>
            </div>  
            <div class="mb-3 text-center">
                <div class="login_btn_wrap">
                    <div class="login_btn_wrap_inner">
                        <div class="login_bgbtn"></div>
                        <input type="submit"   id="submitOtb" value="CONNECT TO INTERNET"  class="form-control login_btn" />
                    </div>
                </div>
                <div class="" style="font-size: 13px;     margin-top: 15px; margin-bottom: 5px;">Wrong number?</div> 
                <div class="reset-number-session"> <?php if(!isset( $_SESSION['is_change_phone'] )){ echo "<a id='phone_number_link' Onclick='Onclick()' href='#'>Change Number</a>";  }  ?> </div>
            </div>
    </div>
    
</form>
</div>
</div>
<?php if(!isset( $_SESSION['is_change_phone'] ) ){  ?>
    <div id="phone-number"  <?php if(isset( $_SESSION['notset'] )){ echo 'style="display:block"'; } else{ echo 'style="display:none"'; }?> >
        <?php echo form_open('/f/subscriber/chnage_phone_number', ['id' => 'subscriber_form', 'class' => 'needs-validation', 'novalidate'=>'']); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/intlTelInput.min.css">
        <script src="<?php echo $url->assets ?>front/js/intlTelInput.min.js"></script>
        <div class="row form_box mt-3">
            <div class="col">
                <div class="mb-12">
                        <?php echo  $this->session->flashdata('successMes');?>
                </div>  
                <div class="mb-3 phone-box">
                    <input type="tel" class="form-control" name="phone" required id="phone" placeholder="Phone">
                    <input type="hidden" class="form-control" name="device" required id="device" placeholder="device">
                    <span id="valid-msg" class="hide">✓ Valid</span>
                    <span id="error-msg" class="hide"></span>
                </div>
                <div class="mb-3 text-center">
                    <div class="login_btn_wrap">
                        <div class="login_btn_wrap_inner">
                            <div class="login_bgbtn"></div>
                            <input type="submit"  value="CHNAGE NUMBER" class="form-control login_btn" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
<?php } ?>
<style>
#phone_number_link{
    font-size: 12px;
    text-transform: uppercase;
    background: #b240f5;
    color: #fff;
    padding: 5px 18px;
    border-radius: 20px;
}
#send-otp-code a{
font-size: 14px;
    color: #000;
}
    </style>
<script type="text/javascript">
/*
 * avoiding form submission upon enter button press
 */
window.addEventListener('keydown', function(e) {
    if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
}, true);

function disbale(){
   var code = document.getElementById("code").value;
    if(code !== ""){
        document.getElementById("submitOtb").disabled = true;
    }
}
/*
 * phone validation
 */
//var input = document.querySelector("#phone");
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
var phone_input = document.querySelector("#phone"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");
var iti = window.intlTelInput(phone_input, {
    placeholderNumberType: "MOBILE",
    preferredCountries: ['ae'],
    hiddenInput: "full_number",
    separateDialCode: true,
    utilsScript: "<?php echo $url->assets; ?>front/js/utils.js", // any initialisation options go here
});
var reset = function() {
    phone_input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};
// on blur: validate
phone_input.addEventListener('blur', function() {
    reset();
    if (phone_input.value.trim()) {
        if (iti.isValidNumber()) {
            validMsg.classList.remove("hide");
        } else {
            phone_input.classList.add("error");
            var errorCode = iti.getValidationError();
            //console.log(errorCode);
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
        }
    }
});

// on keyup / change flag: reset
phone_input.addEventListener('change', reset);
phone_input.addEventListener('keyup', reset);


/*
 * form validation
 */
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                var bm_phone_input = document.querySelector('#phone');
                var iti = window.intlTelInputGlobals.getInstance(bm_phone_input);
                //iti.isValidNumber(); // etc
                if(iti.isValidNumber() == false){
                    
                    event.preventDefault();
                    event.stopPropagation();
                }
                if (!form.checkValidity() ) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated')
            }, false)
        })
})();

</script>


<script>
var count = parseInt('<?php echo $current_seccond; ?>'); 
timer = setInterval(function() {
	if( count > 1 ){
        count = count-1;
		document.getElementById('send-otp-code').innerHTML = count;
    }else{
        var url = '<?php echo base_url()."f/subscriber/resend_otp"?>';
        document.getElementById('send-otp-code').innerHTML = '<a href="'+url+'">Resend OTP</a>';
    }
}, 1000);



function Onclick(){
    document.getElementById('otp-section').style.display = "none";
    document.getElementById('phone-number').style.display = "block";
}
</script>