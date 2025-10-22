<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>

<?php

echo form_open('/f/subscriber/login_verification', ['id' => 'subscriber_form', 'class' => 'needs-validation', 'novalidate' => '']);

?>

<link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/select2.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/intlTelInput.min.css">
<script src="<?php echo $url->assets ?>front/js/intlTelInput.min.js"></script>
<div class="row form_box mt-3">
	<div class="row social-media-container">

		<?php if (check_is_social_media_login_active($intervelSetting)) { ?>
			<h6 class="mb-0 mr-4 mt-2 text-center">Sign in with</h6>
		<?php } ?>
		<?php if (isset($intervelSetting->social_media->facebook)) { ?>
			<?php if ($intervelSetting->social_media->facebook == "enabled") { ?>
				<div class="col">
					<a href="<?php echo base_url() ?>social_login/facebook" class="fb btn">
						<img src="<?php echo base_url() ?>assets/images/social-media-logo/facebook.svg" class="social-icon" />
					</a>
				</div>
				<?php
			}
		}
		if (isset($intervelSetting->social_media->insta)) {
			if ($intervelSetting->social_media->insta == "enabled") {
				?>
				<div class="col">
					<a href="<?php echo base_url() ?>social_login/instagram" class="insta btn">
						<img src="<?php echo base_url() ?>assets/images/social-media-logo/instagram.svg" class="social-icon" />
					</a>
				</div>
				<?php
			}
		}
		if (isset($intervelSetting->social_media->twitter)) {
			if ($intervelSetting->social_media->twitter == "enabled") {
				?>
				<div class="col">
					<a href="<?php echo base_url() ?>social_login/twitter" class="twitter btn">
						<img src="<?php echo base_url() ?>assets/images/social-media-logo/twitter.svg" class="social-icon" />
					</a>
				</div>
				<?php
			}
		}
		if (isset($intervelSetting->social_media->linkedin)) {
			if ($intervelSetting->social_media->linkedin == "enabled") {
				?>
				<div class="col">
					<a href="<?php echo base_url() ?>social_login/linkedin" class="linkedin btn">
						<img src="<?php echo base_url() ?>assets/images/social-media-logo/linkedin.svg" class="social-icon" />
					</a>
				</div>
				<?php
			}
		}
		if (isset($intervelSetting->social_media->google)) {
			if ($intervelSetting->social_media->google == "enabled") {
				?>
				<div class="col">
					<a href="<?php echo base_url() ?>social_login/google" class="google btn">
						<img src="<?php echo base_url() ?>assets/images/social-media-logo/google.svg" class="social-icon" />
					</a>
				</div>
				<?php
			}
		}
		if (isset($intervelSetting->social_media->yahoo)) {
			if ($intervelSetting->social_media->yahoo == "enabled") {
				?>
				<div class="col">
					<a href="<?php echo base_url() ?>social_login/yahoo" class="yahoo btn">
						<img src="<?php echo base_url() ?>assets/images/social-media-logo/yahoo.svg" class="social-icon" />
					</a>
				</div>
				<?php
			}
		}
		$login_form = true;
		if (isset($intervelSetting->login_form)) {
			if ($intervelSetting->login_form == "disabled") {
				$login_form = false;
			}
		}
		?>
		<?php if (check_is_social_media_login_active($intervelSetting) && $login_form == true) { ?>
			<div class="row px-3 mb-4">
				<small class="or text-center">Or</small>
				<div class="line"></div>
			</div>
			<?php
		}
		?>
	</div>

	<?php

	if ($login_form) {
		?>
		<div class="col">
			<div class="mb-12">
				<?php echo $this->session->flashdata('successMes'); ?>
			</div>
			<div class="mb-3">
				<input type="text" class="form-control" pattern="^[a-zA-Z ]{4,30}$" name="name" required id="name"
					maxlength="20" minlength="4" placeholder="Full Name">
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
			if (isset($intervelSetting->additional_fields->age_gender)) {
				if ($intervelSetting->additional_fields->age_gender == "enable") {
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
			if (isset($intervelSetting->additional_fields->age_dob)) {
				if ($intervelSetting->additional_fields->age_dob == "enable") {
					?>
					<div class="mb-3">
						<input type="text" onfocus="(this.type = 'date')" class="form-control" name="birthdate" required
							onfocus="(this.type='date')" name="birthdate" minlength="10" id="date" placeholder="Birth date">
						<div class="invalid-feedback">
							Please choose your birth date.
						</div>
					</div>
					<?php
				}
			}
			?>
			<?php
			if (isset($intervelSetting->additional_fields->age_group)) {
				if ($intervelSetting->additional_fields->age_group == "enable") {
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
			<?php
			if (isset($intervelSetting->additional_fields->subs_country)) {
				if ($intervelSetting->additional_fields->subs_country == "enable") {
					?>
					<div class="mb-3">
						<select class="form-select subs_country_select" name="subs_country" required
							aria-label="Default select example">
							<option selected value="" disabled>Select your nationality</option>
							<option value="AF">Afghanistan</option>
							<option value="AX">Aland Islands</option>
							<option value="AL">Albania</option>
							<option value="DZ">Algeria</option>
							<option value="AS">American Samoa</option>
							<option value="AD">Andorra</option>
							<option value="AO">Angola</option>
							<option value="AI">Anguilla</option>
							<option value="AQ">Antarctica</option>
							<option value="AG">Antigua And Barbuda</option>
							<option value="AR">Argentina</option>
							<option value="AM">Armenia</option>
							<option value="AW">Aruba</option>
							<option value="AU">Australia</option>
							<option value="AT">Austria</option>
							<option value="AZ">Azerbaijan</option>
							<option value="BS">Bahamas</option>
							<option value="BH">Bahrain</option>
							<option value="BD">Bangladesh</option>
							<option value="BB">Barbados</option>
							<option value="BY">Belarus</option>
							<option value="BE">Belgium</option>
							<option value="BZ">Belize</option>
							<option value="BJ">Benin</option>
							<option value="BM">Bermuda</option>
							<option value="BT">Bhutan</option>
							<option value="BO">Bolivia</option>
							<option value="BA">Bosnia And Herzegovina</option>
							<option value="BW">Botswana</option>
							<option value="BV">Bouvet Island</option>
							<option value="BR">Brazil</option>
							<option value="IO">British Indian Ocean Territory</option>
							<option value="BN">Brunei Darussalam</option>
							<option value="BG">Bulgaria</option>
							<option value="BF">Burkina Faso</option>
							<option value="BI">Burundi</option>
							<option value="KH">Cambodia</option>
							<option value="CM">Cameroon</option>
							<option value="CA">Canada</option>
							<option value="CV">Cape Verde</option>
							<option value="KY">Cayman Islands</option>
							<option value="CF">Central African Republic</option>
							<option value="TD">Chad</option>
							<option value="CL">Chile</option>
							<option value="CN">China</option>
							<option value="CX">Christmas Island</option>
							<option value="CC">Cocos (Keeling) Islands</option>
							<option value="CO">Colombia</option>
							<option value="KM">Comoros</option>
							<option value="CG">Congo</option>
							<option value="CD">Congo, Democratic Republic</option>
							<option value="CK">Cook Islands</option>
							<option value="CR">Costa Rica</option>
							<option value="CI">Cote D'Ivoire</option>
							<option value="HR">Croatia</option>
							<option value="CU">Cuba</option>
							<option value="CY">Cyprus</option>
							<option value="CZ">Czech Republic</option>
							<option value="DK">Denmark</option>
							<option value="DJ">Djibouti</option>
							<option value="DM">Dominica</option>
							<option value="DO">Dominican Republic</option>
							<option value="EC">Ecuador</option>
							<option value="EG">Egypt</option>
							<option value="SV">El Salvador</option>
							<option value="GQ">Equatorial Guinea</option>
							<option value="ER">Eritrea</option>
							<option value="EE">Estonia</option>
							<option value="ET">Ethiopia</option>
							<option value="FK">Falkland Islands (Malvinas)</option>
							<option value="FO">Faroe Islands</option>
							<option value="FJ">Fiji</option>
							<option value="FI">Finland</option>
							<option value="FR">France</option>
							<option value="GF">French Guiana</option>
							<option value="PF">French Polynesia</option>
							<option value="TF">French Southern Territories</option>
							<option value="GA">Gabon</option>
							<option value="GM">Gambia</option>
							<option value="GE">Georgia</option>
							<option value="DE">Germany</option>
							<option value="GH">Ghana</option>
							<option value="GI">Gibraltar</option>
							<option value="GR">Greece</option>
							<option value="GL">Greenland</option>
							<option value="GD">Grenada</option>
							<option value="GP">Guadeloupe</option>
							<option value="GU">Guam</option>
							<option value="GT">Guatemala</option>
							<option value="GG">Guernsey</option>
							<option value="GN">Guinea</option>
							<option value="GW">Guinea-Bissau</option>
							<option value="GY">Guyana</option>
							<option value="HT">Haiti</option>
							<option value="HM">Heard Island &amp; Mcdonald Islands</option>
							<option value="VA">Holy See (Vatican City State)</option>
							<option value="HN">Honduras</option>
							<option value="HK">Hong Kong</option>
							<option value="HU">Hungary</option>
							<option value="IS">Iceland</option>
							<option value="IN">India</option>
							<option value="ID">Indonesia</option>
							<option value="IR">Iran, Islamic Republic Of</option>
							<option value="IQ">Iraq</option>
							<option value="IE">Ireland</option>
							<option value="IM">Isle Of Man</option>
							<option value="IL">Israel</option>
							<option value="IT">Italy</option>
							<option value="JM">Jamaica</option>
							<option value="JP">Japan</option>
							<option value="JE">Jersey</option>
							<option value="JO">Jordan</option>
							<option value="KZ">Kazakhstan</option>
							<option value="KE">Kenya</option>
							<option value="KI">Kiribati</option>
							<option value="KR">Korea</option>
							<option value="KW">Kuwait</option>
							<option value="KG">Kyrgyzstan</option>
							<option value="LA">Lao People's Democratic Republic</option>
							<option value="LV">Latvia</option>
							<option value="LB">Lebanon</option>
							<option value="LS">Lesotho</option>
							<option value="LR">Liberia</option>
							<option value="LY">Libyan Arab Jamahiriya</option>
							<option value="LI">Liechtenstein</option>
							<option value="LT">Lithuania</option>
							<option value="LU">Luxembourg</option>
							<option value="MO">Macao</option>
							<option value="MK">Macedonia</option>
							<option value="MG">Madagascar</option>
							<option value="MW">Malawi</option>
							<option value="MY">Malaysia</option>
							<option value="MV">Maldives</option>
							<option value="ML">Mali</option>
							<option value="MT">Malta</option>
							<option value="MH">Marshall Islands</option>
							<option value="MQ">Martinique</option>
							<option value="MR">Mauritania</option>
							<option value="MU">Mauritius</option>
							<option value="YT">Mayotte</option>
							<option value="MX">Mexico</option>
							<option value="FM">Micronesia, Federated States Of</option>
							<option value="MD">Moldova</option>
							<option value="MC">Monaco</option>
							<option value="MN">Mongolia</option>
							<option value="ME">Montenegro</option>
							<option value="MS">Montserrat</option>
							<option value="MA">Morocco</option>
							<option value="MZ">Mozambique</option>
							<option value="MM">Myanmar</option>
							<option value="NA">Namibia</option>
							<option value="NR">Nauru</option>
							<option value="NP">Nepal</option>
							<option value="NL">Netherlands</option>
							<option value="AN">Netherlands Antilles</option>
							<option value="NC">New Caledonia</option>
							<option value="NZ">New Zealand</option>
							<option value="NI">Nicaragua</option>
							<option value="NE">Niger</option>
							<option value="NG">Nigeria</option>
							<option value="NU">Niue</option>
							<option value="NF">Norfolk Island</option>
							<option value="MP">Northern Mariana Islands</option>
							<option value="NO">Norway</option>
							<option value="OM">Oman</option>
							<option value="PK">Pakistan</option>
							<option value="PW">Palau</option>
							<option value="PS">Palestinian Territory, Occupied</option>
							<option value="PA">Panama</option>
							<option value="PG">Papua New Guinea</option>
							<option value="PY">Paraguay</option>
							<option value="PE">Peru</option>
							<option value="PH">Philippines</option>
							<option value="PN">Pitcairn</option>
							<option value="PL">Poland</option>
							<option value="PT">Portugal</option>
							<option value="PR">Puerto Rico</option>
							<option value="QA">Qatar</option>
							<option value="RE">Reunion</option>
							<option value="RO">Romania</option>
							<option value="RU">Russian Federation</option>
							<option value="RW">Rwanda</option>
							<option value="BL">Saint Barthelemy</option>
							<option value="SH">Saint Helena</option>
							<option value="KN">Saint Kitts And Nevis</option>
							<option value="LC">Saint Lucia</option>
							<option value="MF">Saint Martin</option>
							<option value="PM">Saint Pierre And Miquelon</option>
							<option value="VC">Saint Vincent And Grenadines</option>
							<option value="WS">Samoa</option>
							<option value="SM">San Marino</option>
							<option value="ST">Sao Tome And Principe</option>
							<option value="SA">Saudi Arabia</option>
							<option value="SN">Senegal</option>
							<option value="RS">Serbia</option>
							<option value="SC">Seychelles</option>
							<option value="SL">Sierra Leone</option>
							<option value="SG">Singapore</option>
							<option value="SK">Slovakia</option>
							<option value="SI">Slovenia</option>
							<option value="SB">Solomon Islands</option>
							<option value="SO">Somalia</option>
							<option value="ZA">South Africa</option>
							<option value="GS">South Georgia And Sandwich Isl.</option>
							<option value="ES">Spain</option>
							<option value="LK">Sri Lanka</option>
							<option value="SD">Sudan</option>
							<option value="SR">Suriname</option>
							<option value="SJ">Svalbard And Jan Mayen</option>
							<option value="SZ">Swaziland</option>
							<option value="SE">Sweden</option>
							<option value="CH">Switzerland</option>
							<option value="SY">Syrian Arab Republic</option>
							<option value="TW">Taiwan</option>
							<option value="TJ">Tajikistan</option>
							<option value="TZ">Tanzania</option>
							<option value="TH">Thailand</option>
							<option value="TL">Timor-Leste</option>
							<option value="TG">Togo</option>
							<option value="TK">Tokelau</option>
							<option value="TO">Tonga</option>
							<option value="TT">Trinidad And Tobago</option>
							<option value="TN">Tunisia</option>
							<option value="TR">Turkey</option>
							<option value="TM">Turkmenistan</option>
							<option value="TC">Turks And Caicos Islands</option>
							<option value="TV">Tuvalu</option>
							<option value="UG">Uganda</option>
							<option value="UA">Ukraine</option>
							<option value="AE">United Arab Emirates</option>
							<option value="GB">United Kingdom</option>
							<option value="US">United States</option>
							<option value="UM">United States Outlying Islands</option>
							<option value="UY">Uruguay</option>
							<option value="UZ">Uzbekistan</option>
							<option value="VU">Vanuatu</option>
							<option value="VE">Venezuela</option>
							<option value="VN">Viet Nam</option>
							<option value="VG">Virgin Islands, British</option>
							<option value="VI">Virgin Islands, U.S.</option>
							<option value="WF">Wallis And Futuna</option>
							<option value="EH">Western Sahara</option>
							<option value="YE">Yemen</option>
							<option value="ZM">Zambia</option>
							<option value="ZW">Zimbabwe</option>
						</select>
						<div class="invalid-feedback">
							Please select your country.
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

<script src="<?php echo base_url() ?>/assets/js/core/jquery.min.js"></script>

<script src="<?php echo $url->assets ?>front/js/select2.min.js"></script>
<!--
	select 2 related styles and js
 -->
<script type="text/javascript">
	$(document).ready(function () {
		if ($('.subs_country_select').length) {
			$('.subs_country_select').select2();
		}
	});
</script>
<style>
	.select2-container--default .select2-selection--single .select2-selection__arrow{
		height: 40px;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered{
		line-height: 40px;
	}
	.select2-container--default .select2-selection--single{
		height: 40px;
		border-color: #ced4da;
	}
</style>
<?php
//setting up default country
if (isset($intervelSetting->default_country) && !empty($intervelSetting->default_country)) {
	$telCountry = $intervelSetting->default_country;
} else {
	$telCountry = 'ae';
}
?>

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
	window.addEventListener('keydown', function (e) {
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
		preferredCountries: ['<?php echo $telCountry; ?>'],
		hiddenInput: "full_number",
		separateDialCode: true,
		utilsScript: "<?php echo $url->assets; ?>front/js/utils.js", // any initialisation options go here
	});
	var reset = function () {
		phone_input.classList.remove("error");
		errorMsg.innerHTML = "";
		errorMsg.classList.add("hide");
		validMsg.classList.add("hide");
	};
	// on blur: validate
	phone_input.addEventListener('blur', function () {
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
	(function () {
		'use strict'

		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.querySelectorAll('.needs-validation')

		// Loop over them and prevent submission
		Array.prototype.slice.call(forms)
			.forEach(function (form) {
				form.addEventListener('submit', function (event) {
					var bm_phone_input = document.querySelector('#phone');
					var iti = window.intlTelInputGlobals.getInstance(bm_phone_input);
					//iti.isValidNumber(); // etc
					if (iti.isValidNumber() == false) {

						event.preventDefault();
						event.stopPropagation();
					}
					if (!form.checkValidity()) {
						event.preventDefault();
						event.stopPropagation();
					}



					form.classList.add('was-validated')
				}, false)
			})
	})();
</script>
<? echo form_close(); ?>