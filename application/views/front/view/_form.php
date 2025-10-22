<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php 

echo form_open('/f/subscriber/login_verification', ['id' => 'subscriber_form', 'class' => 'needs-validation', 'novalidate'=>'']);

?>

<link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/intlTelInput.min.css">
<script src="<?php echo $url->assets ?>front/js/intlTelInput.min.js"></script>
<div class="row form_box mt-3">
<div class="row social-media-container">
			
			<?php if(check_is_social_media_login_active($intervelSetting)){ ?>
			<h6 class="mb-0 mr-4 mt-2 text-center">Sign in with</h6>
			<?php }?>
			<?php if( isset($intervelSetting->social_media->facebook) ){ ?>
				<?php if( $intervelSetting->social_media->facebook == "enabled" ){ ?>
				<div class="col"> 
					<a href="<?php echo base_url()?>social_login/facebook" class="fb btn">
					  <img src="<?php echo base_url()?>assets/images/social-media-logo/facebook.svg" class="social-icon"/> 
					</a>
				</div>
			<?php 
				}
			}
			if( isset($intervelSetting->social_media->insta) ){
				if( $intervelSetting->social_media->insta == "enabled" ){
			?>
			<div class="col"> 
				<a href="<?php echo base_url()?>social_login/instagram" class="insta btn">
				  <img src="<?php echo base_url()?>assets/images/social-media-logo/instagram.svg" class="social-icon"/>
				</a>
			</div>
			<?php 
				}
			}
			if( isset($intervelSetting->social_media->twitter) ){
				if( $intervelSetting->social_media->twitter == "enabled" ){
			?>
			<div class="col"> 
				<a href="<?php echo base_url()?>social_login/twitter" class="twitter btn">
				  <img src="<?php echo base_url()?>assets/images/social-media-logo/twitter.svg" class="social-icon"/>
				</a>
			</div>
			<?php 
				}
			}
			if( isset($intervelSetting->social_media->linkedin) ){
				if( $intervelSetting->social_media->linkedin == "enabled" ){
			?>
			<div class="col"> 
				<a href="<?php echo base_url()?>social_login/linkedin" class="linkedin btn">
				<img src="<?php echo base_url()?>assets/images/social-media-logo/linkedin.svg" class="social-icon"/>
				</a>
			</div>
			<?php 
				}
			}
			if( isset($intervelSetting->social_media->google) ){
				if( $intervelSetting->social_media->google == "enabled" ){
			?>
			<div class="col"> 
				<a href="<?php echo base_url()?>social_login/google" class="google btn">
				  <img src="<?php echo base_url()?>assets/images/social-media-logo/google.svg" class="social-icon"/>
				</a>
			</div>
			<?php 
				}
			}
			if( isset($intervelSetting->social_media->yahoo) ){
				if( $intervelSetting->social_media->yahoo == "enabled" ){
			?>
			<div class="col"> 
				<a href="<?php echo base_url()?>social_login/yahoo" class="yahoo btn">
				  <img src="<?php echo base_url()?>assets/images/social-media-logo/yahoo.svg" class="social-icon"/>
				</a>
			</div>
			<?php 
				}
			}
			$login_form = true;
			if( isset($intervelSetting->login_form)){ 
				if($intervelSetting->login_form == "disabled"){
					$login_form = false;
				}
			}
			?>
			<?php if(check_is_social_media_login_active($intervelSetting) && $login_form == true){ ?>
			<div class="row px-3 mb-4">
				<small class="or text-center">Or</small>
				<div class="line"></div>
			</div>
			<?php 
			}
			?>
		</div>
		
	<?php 
		
		if($login_form){
	?>	
		<div class="col">
			 <div class="mb-12">
					<?php echo  $this->session->flashdata('successMes');?>
			</div>
			<div class="mb-3">
				<input type="text" class="form-control"  pattern="^[a-zA-Z ]{4,30}$" name="name" required id="name" maxlength="20" minlength="4" placeholder="Full Name">
				<div class="invalid-feedback">
					Please enter valid name. (min 4 letters)
				</div>
			</div> 
			<div class="mb-3">
				<input type="email" class="form-control" required name="email" minlength="10" id="name" placeholder="Email">
				<div class="invalid-feedback">
					Please enter valid email address.
				</div>
			</div>
			<?php 
				if( isset($intervelSetting->additional_fields->age_gender) ){
					if($intervelSetting->additional_fields->age_gender == "enable"){
			?>
					<div class="mb-3">
						<select class="form-select" name="gender" required aria-label="Default select example">
						  <option selected value="" disabled hidden>Gender</option>
						  <option value="male">Male</option>
						  <option value="female">Female</option>
						  <option value="other">Other</option>
						</select>
						<div class="invalid-feedback">
							Please select gender.
						</div>
					</div> 
			
			<?php 
					}
				} 
			?>
			<?php 
				if( isset($intervelSetting->additional_fields->age_dob) ){
					if($intervelSetting->additional_fields->age_dob == "enable"){
			?>
					<div class="mb-3">
						<input type="text" onfocus="(this.type = 'date')"  class="form-control" name="birthdate" required onfocus="(this.type='date')" name="birthdate" minlength="10" id="date" placeholder="Birth date">
						<div class="invalid-feedback">
							Please choose your birth date.
						</div>
					</div> 
			<?php 
					}
				} 
			?>
			<?php 
				if( isset($intervelSetting->additional_fields->age_group) ){
					if($intervelSetting->additional_fields->age_group == "enable"){
			?>
					<div class="mb-3">
						<select class="form-select" name="age_group" required aria-label="Default select example">
						  <option selected value="" disabled>Age group</option>
						  <option value="male">10 - 20 year</option>
						  <option value="female">20 - 30 year</option>
						  <option value="other">30 - 40 year</option>
						</select>
						<div class="invalid-feedback">
							Please select your age group.
						</div>
					</div> 
			<?php 
					}
				} 
			?>
			<div class="mb-3 phone-box">
				<input type="tel" class="form-control" name="phone" required id="phone" placeholder="Phone">
				<input type="hidden" class="form-control" name="device" required id="device" placeholder="device">
				<span id="valid-msg" class="hide">✓ Valid</span>
				<span id="error-msg" class="hide"></span>
			</div>
			<div class="mb-3">
				<div class="form-check form-switch terms_box">
					<input class="form-check-input" type="checkbox" id="terms_conditions" name="tnc" required>
					<label class="form-check-label" for="terms_conditions">I agree to <a href="#" data-bs-toggle="modal"
							data-bs-target="#termsConditionsModal">terms and conditions</a></label>
					<div class="invalid-feedback">
						Please agree to terms and conditions.
					</div>
				</div>
			</div>
			<div class="mb-3 text-center">
				<div class="login_btn_wrap">
					<div class="login_btn_wrap_inner">
						<div class="login_bgbtn"></div>
						<input type="submit" value="Connect to internet" class="form-control login_btn" />
					</div>
				</div>
			</div>
			</div>

		<?php } ?>
	
    </div>
</div>
<script src="<?php echo base_url()?>/assets/js/core/jquery.min.js"></script>

<script type="text/javascript">
/*
 * avoiding form submission upon enter button press
 */

const getUA = () => {
    let device = "Unknown"; 
    const ua = {
        "Generic Linux": /Linux/i,
        "Android": /Android/i,
        "BlackBerry": /BlackBerry/i,
        "Bluebird": /EF500/i,
        "Chrome OS": /CrOS/i,
        "Datalogic": /DL-AXIS/i,
        "Honeywell": /CT50/i,
        "iPad": /iPad/i,
        "iPhone": /iPhone/i,
        "iPod": /iPod/i,
        "macOS": /Macintosh/i,
        "Windows": /IEMobile|Windows/i,
        "Zebra": /TC70|TC55/i,
    }
    Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));
    return device;
}
document.getElementById("device").value = getUA();
window.addEventListener('keydown', function(e) {
    if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
}, true);
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
    preferredCountries: ['ae','ke'],
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
<? echo form_close(); ?>