<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
<!-- Content Header (Page header) -->
<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo base_url()?>assets/ckeditor/ckeditor.js"></script>
	
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/pages/form_inputs.js"></script>
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-location3 position-left"></i> <span class="text-semibold">Manage Locations</span> - Edit</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Edit location</li>
      </ul>
      <ul class="breadcrumb-elements">
         <li><a class="bg-teal-400" href="<?php echo url('panel/locations') . '?domains=' . $domain_id ?> "><i class=" icon-arrow-left52 position-left"></i> Go back to locations</a></li>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Edit <?php echo $location->location_name ?>'s details</h5>
         <div class="heading-elements">
            <ul class="icons-list">
               <li>
                  <a data-action="collapse"></a>
               </li>
               <li>
                  <a data-action="reload"></a>
               </li>
            </ul>
         </div>
         <a class="heading-elements-toggle"><i class="icon-more"></i></a>
      </div>
      <div class="panel-body">
         <p class="content-group-lg">Change below entries and press submit. <code>Disabling a location will disable the access to internet for your users on that location</code></p>
         <?php echo form_open_multipart('panel/locations/update/'.$location->id, [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>
         <fieldset class="content-group">
            <legend class="text-bold">Basic details</legend>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Name">Location name</label>
                     <input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Location Name" value="<?php echo $location->location_name ?>" autofocus /> 
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-address">Address</label>
                     <input type="text" class="form-control" name="address" id="formClient-address" required placeholder="Enter Address"  value="<?php echo $location->location_address ?>" /> 
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Status">Status</label>
                     <select name="status" id="formClient-Status" class="form-control" >
                        <?php $sel = $location->status==1 ? 'selected' : '' ?>
                        <option value="1" <?php echo $sel ?>>Active</option>
                        <?php $sel = $location->status==0 ? 'selected' : '' ?>
                        <option value="0" <?php echo $sel ?>>InActive</option>
                     </select>
                  </div>
               </div>
               <div class="hide">
                  <input type="hidden" class="form-control" name="domain_id" value="<?php echo $domain_id; ?>" />
                  <input type="hidden" class="form-control" id="location_id" value="<?php echo $location->id; ?>" />
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-address">Coordinates </label>
                     <input type="text" class="form-control" name="location_coordinates" id="coordinates" required placeholder="Coordinates "  value="<?php echo $location->location_coordinates ?>" />
                  </div>
               </div>
               <div class="col-md-12">
                  <!--<div class="flex-child flex-child--grow bg-darken10 viewport-twothirds viewport-full-mm"id="map" ></div>-->
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <div class="margin-swich">
                        <div class="switchery-xs  switch-check-box">
                           <input type="checkbox" name="landing_page_status" <?php echo ($location_image_status == "enable")? "checked='checked'" : "";  ?>id="landing-page" class="switchery" name="">
							<input type="hidden" id="check_box_check" value="<?php echo ($location_image_status == "enable")? "checked" : "";  ?>"/>
						</div>
                        <label class="landing-page-swich">
                        Landing page settings
                        </label>
                     </div>
                  </div>
               </div>
			   
            </div>
         </fieldset>
         
		 <div class="row">
            <div class="col-md-8">
               <fieldset class="content-group landing-page-images  input-file-style-location" <?php echo ($location_image_status == "enable")? "" : "style='display:none'";  ?>>
                  <legend class="text-bold">Override landing page branding</legend>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <div class="visiter-filter">
                              <label for="formClient-Image">Logo <small class="info-text"> (Only .png files are allowed) </small></label>
                              <input type="file" class="form-control file-styled-primary" name="domain_logo" id="formClient-Image"
                                 placeholder="Upload Image" accept="image/png"
                                 onchange="previewImage(this, '#imagePreview')">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group" id="imagePreview"> <img
                           src="<?php echo get_location_logo( $location->id,  $globelDomain->domain_db_name) ?>" class="logo_preview"
                           alt="Uploaded Image Preview" width="100" height="100"> </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <div class="visiter-filter">
                              <label for="formClient-Image">Gallery image 1  <small class="info-text"> (Only .jpg  or .jpeg files are allowed)  </small></label>
                              <input type="file" class="form-control file-styled-primary" name="domain_image1" id="formClient-Image"
                                 placeholder="Upload Image" accept="image/jpg , image/jpeg"
                                 onchange="previewImage(this, '#imagePreview1')">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group" id="imagePreview1"> <img
                           src="<?php echo get_domain_location_img($location->id, $globelDomain->domain_db_name, '1') ?>" class="logo_preview"
                           alt="Uploaded Image Preview" width="100" height="100"> </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <div class="visiter-filter">
                              <label for="formClient-Image">Gallery image 2  <small class="info-text"> (Only .jpg  or .jpeg files are allowed)  </small></label>
                              <input type="file" class="form-control file-styled-primary" name="domain_image2" id="formClient-Image"
                                 placeholder="Upload Image" accept="image/jpg , image/jpeg"
                                 onchange="previewImage(this, '#imagePreview2')">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group" id="imagePreview2"> <img
                           src="<?php echo get_domain_location_img( $location->id,   $globelDomain->domain_db_name,'2') ?>" class="logo_preview"
                           alt="Uploaded Image Preview" width="100" height="100"> </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <div class="visiter-filter">
                              <label for="formClient-Image">Gallery image 3  <small class="info-text"> (Only .jpg  or .jpeg files are allowed)  </small></label>
                              <input type="file" class="form-control file-styled-primary" name="domain_image3" id="formClient-Image"
                                 placeholder="Upload Image" accept="image/jpg , image/jpeg"
                                 onchange="previewImage(this, '#imagePreview3')">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group" id="imagePreview3"> <img
                           src="<?php echo get_domain_location_img( $location->id,   $globelDomain->domain_db_name,'3') ?>" class="logo_preview"
                           alt="Uploaded Image Preview" width="100" height="100"> </div>
                     </div>
                  </div>
               </fieldset>
               
            </div>
            <div class="col-md-3">
               <div class="preview-container">
                  <div class="device mobile" id="device">
                     <div class="top-bar">
                        <div class="icon current" id="mobile"><i class="icon-mobile"></i></div>
                        <div class="icon" id="tablet"><i class="icon-tablet"></i></div>
                        <div class="icon" id="desktop"><i class="icon-laptop"></i></div>
                     </div>
                     <div class="screen">
                        <iframe src="<?php echo base_url()?>domains/admin_preview?wificloud=<?php echo encryption("location");?>&location_id=<?php echo $location->id;?>" title="Iframe Example"></iframe>
                        <div class="fa fa-codepen">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
			
		  <div class="row">
			<div class="col-md-6">

				 <div class="form-group">
					<div class="margin-swich">
					   <div class="checkbox">
						  <div class="switchery-xs  switch-check-box">
							<?php $location_terms = get_domain_meta( 'location_terms' ,  $location->id); ?>
							 <input type="checkbox" value="checked"  <?php echo (empty($location_terms))? "" : "checked='checked'";  ?>  id="terms_and_conditions_check" class="switchery " name="overwrite_domain_term">
							 <input type="hidden" value="<?php echo (empty($location_terms))? "" : "checked='checked'";  ?>"   id="checkpoint" >
						  </div>
						  <label class="landing-page-swich">Overwrite term and condition </label>
					   </div>
				   </div>
				</div>
               </div>
			<div class="col-md-12">
				
				
				<textarea class="ckeditor" id="editor1" name="location_terms" cols="100" rows="10" >
					<?php 
						if(empty($location_terms)){
							
							?>
								
								<p>This agreement sets out the terms and conditions on which wireless internet access (&ldquo;the Service&rdquo;) is provided free of charge to you, a guest, vendor, board member or employee of the Service Provider.</p>
									<p>Your access to the Service is completely at the discretion of the Service Provider. Access to the Service may be blocked, suspended, or terminated at any time for any reason including, but not limited to, violation of this Agreement, actions that may lead to liability for the DOMAIN NAME disruption of access to other users or networks, and violation of applicable laws or regulations. The Service Provider reserves the right to monitor and collect information while you are connected to the Service and that the collected information can be used at discretion of the Service Provider, including sharing the information with any law enforcement agencies, the Service Provider partners and/or the Service Provider vendors.</p>
									<p>The Service Provider may revise this Agreement at any time. You must accept this Agreement each time you use the Service and it is your responsibility to review it for any changes each time.</p>
									<p>We reserve the right at all times to withdraw the Service, change the specifications or manner of use of the Service, to change access codes, usernames, passwords or other security information necessary to access the service.</p>
									<h5>IF YOU DO NOT AGREE WITH THESE TERMS, INCLUDING CHANGES THERETO, DO NOT ACCESS OR USE THE SERVICE.</h5>
									<ul>
									   <li>
										  <h6>1. Disclaimer</h6>
										  <p>You acknowledge</p>
										  <ol>
											 <li>that the Service may not be uninterrupted or error-free;</li>
											 <li>that your device may be exposed to viruses or other harmful applications through the Service;</li>
											 <li>that the Service Provider does not guarantee the security of the Service and that unauthorized third parties may access your computer or files or otherwise monitor your connection;</li>
											 <li>that the Service Provider&rsquo;s ability to provide the Service without charge is based on the limited warranty, disclaimer and limitation of liability specified in this Section and it would require a substantial charge if any of these provisions were unenforceable;</li>
											 <li>that the Service Provider can at any point block access to Internet Services that they deem violate the acceptable terms of use outlined in 2.1.</li>
										  </ol>
										  <p>The service and any products or services provided on or in connection with the service are provided on an &quot;as is&quot;, &quot;as available&quot; basis without warranties of any kind. All warranties, conditions, representations, indemnities and guarantees with respect to the content or service and the operation, capacity, speed, functionality, qualifications, or capabilities of the services, goods or personnel resources provided hereunder, whether express or implied, arising by law, custom, prior oral or written statements by the Service Provider, or otherwise (including, but not limited to any warranty of satisfactory quality, merchantability, fitness for particular purpose, title and non-infringement) are hereby overridden, excluded and disclaimed.</p>
									   </li>
									   <li>
										  <h6>2. Acceptable Use of the Service</h6>
										  <ul>
											 <li>
												2.1 You must not use the Service to access Internet Services, or send or receive e-mails, which:
												<ul>
												   <li>2.1.1 are defamatory, threatening, intimidating or which could be classed as harassment;</li>
												   <li>2.1.2 contain obscene, profane or abusive language or material;</li>
												   <li>2.1.3 contain pornographic material (that is text, pictures, films, video clips of a sexually explicit or arousing nature);</li>
												   <li>2.1.4 contain offensive or derogatory images regarding sex, race, religion, colour, origin, age, physical or mental disability, medical condition or sexual orientation;</li>
												   <li>2.1.5 contain material which infringe third party&rsquo;s rights (including intellectual property rights);</li>
												   <li>2.1.6 in our reasonable opinion may adversely affect the manner in which we carry out our work;</li>
												   <li>2.1.7 are bulk and/or commercial messages;</li>
												   <li>2.1.8 contain forged or misrepresented message headers, whether in whole or in part, to mask the originator of the message;</li>
												   <li>2.1.9 are activities that invade another&rsquo;s privacy; or</li>
												   <li>2.1.10 are otherwise unlawful or inappropriate;</li>
												</ul>
											 </li>
											 <li>2.2 Music, video, pictures, text and other content on the internet are copyright works and you should not download, alter, e-mail or otherwise use such content unless certain that the owner of such works has authorised its use by you.</li>
											 <li>2.3 You must not use the service to access illegally or without authorization computers, accounts, equipment or networks belonging to another party, or attempting to penetrate security measures of another system. This includes any activity that may be used as a precursor to an attempted system penetration, including, but not limited to, port scans, stealth scans, or other information gathering activity.</li>
											 <li>2.4 You must not use the service to distribute Internet Viruses, Trojan Horses, or other destructive software.</li>
											 <li>2.5 The Service is intended for the Service Provider guest use only. Access to this Service must not be used for commercial activity.</li>
											 <li>2.6 We may terminate or temporarily suspend the Service if we reasonably believe that you are in breach of any provisions of this agreement including but not limited to clauses 2.1 to 2.5 above.</li>
											 <li>2.7 We recommend that you do not use the service to transmit or receive any confidential information or data and should you choose to do so you do so at your own risk.</li>
										  </ul>
									   </li>
									   <li>
										  <h6>3. Criminal Activity</h6>
										  <ul>
											 <li>3.1 You must not use the Service to engage in any activity which constitutes or is capable of constituting a criminal offence, either in the United Arab Emirates or in any country throughout the world.</li>
											 <li>3.2 You agree and acknowledge that we may be required to provide assistance and information to law enforcement, governmental agencies and other authorities.</li>
											 <li>3.3 You agree and acknowledge that we will monitor your activity while you use this service and keep a log of the Internet Protocol (&ldquo;IP&rdquo;) addresses of any devices which access the Service, the times when they have accessed the Service and the activity associated with that IP address</li>
											 <li>3.4 You further agree we are entitled to co-operate with law enforcement authorities and rights-holders in the investigation of any suspected or alleged illegal activity by you which may include, but is not limited to, disclosure of such information as we have (whether pursuant to clause 3.3 or otherwise), and are entitled to provide by law, to law enforcement authorities or rights-holders.</li>
										  </ul>
									   </li>
									   <li>
										  <h6>4. Other Terms</h6>
										  <ul>
											 <li>4.1 Under no circumstances will the Service Provider, their suppliers or licensors, or their respective officers, directors, employees, agents, and affiliates be liable for consequential, indirect, special, punitive or incidental damages, whether foreseeable or unforeseeable, based on claims of the Guest or its appointees (including, but not limited to, unauthorized access, damage, or theft of your system or data, claims for loss of goodwill, claims for loss of data, use of or reliance on the service, stoppage of other work or impairment of other assets, or damage caused to equipment or programs from any virus or other harmful application), arising out of breach or failure of express or implied warranty, breach of contract, misrepresentation, negligence, strict liability in tort or otherwise.</li>
											 <li>4.2 You agree to indemnify and hold harmless the Service Provider and its suppliers, licensors, officers, directors, employees, agents and affiliates from any claim, liability, loss, damage, cost, or expense (including without limitation reasonable attorney&#39;s fees) arising out of or related to your use of the Service, any materials downloaded or uploaded through the Service, any actions taken by you in connection with your use of the Service, any violation of any third party&#39;s rights or an violation of law or regulation, or any breach of this agreement. This Section will not be construed to limit or exclude any other claims or remedies that the Service Provider may assert under this Agreement or by law.</li>
											 <li>4.3 This Agreement shall not be construed as creating a partnership, joint venture, agency relationship or granting a franchise between the parties. Except as otherwise provided above, any waiver, amendment or other modification of this Agreement will not be effective unless in writing and signed by the party against whom enforcement is sought. If any provision of this Agreement is held to be unenforceable, in whole or in part, such holding will not affect the validity of the other provisions of this Agreement.</li>
											 <li>4.4 The Service Provider&rsquo; performance of this Agreement is subject to existing laws and legal process, and nothing contained in this Agreement shall waive or impede the Service Provider&rsquo; right to comply with law enforcement requests or requirements relating to your use of this Service or information provided to or gathered by the Service Provider with respect to such use. This Agreement constitutes the complete and entire statement of all terms, conditions and representations of the agreement between you and the Service Provider with respect to its subject matter and supersedes all prior writings or understanding.</li>
										  </ul>
									   </li>
									</ul>
									<p>By agreeing to the terms of service, I confirm that I accept these terms and conditions as the basis of my use of the wireless internet access provided.</p>
								
							<?php
							
						}else{
							echo $location_terms;
						}
					?>
					
					
				</textarea>
			</div>
		</div> 
        <div class="row">
		  <div class="col-md-12" style="margin-top:20px;">
			 <button type="submit" class="btn bg-teal-400">Submit <i
				class="icon-arrow-right14 position-right"></i></button>
		  </div>
	   </div>
		 <?php echo form_close(); ?>
         <!--                    </form>-->
      </div>
   </div>
   <style>
		#cke_editor1 {
		margin-bottom: 40px;
	}
      small.info-text {
      font-size: 11px;
      color: red;
      }
      .switchery-xs.switch-check-box {
      width: 40px;
      float: left;
      }
      label.landing-page-swich {
      padding-left: 0px;
      margin-top: 2px;
      }
      #map {
      height: 200px !important;
      position: relative;
      cursor: pointer;
      }
      .mapboxgl-control-container {
      position: absolute;
      top: 0;
      }
      .mapboxgl-popup.mapboxgl-popup-anchor-bottom {
      position: relative;
      top: 30px;
      background: white;
      padding: 10px;
      border-radius: 5px;
      }
      .margin-swich {
      margin-top: 40px;
      }
      .mapboxgl-popup-content {
      position: absolute;
      top: -209px;
      padding: 10px;
      background: #26a69a;
      color: white;
      border-radius: 5px;
      }
      .mapboxgl-marker{
      top: 4px;
      position: absolute !important;
      }
   </style>
</section>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
<script>
   $(document).ready(function() {
    
	CKEDITOR.replace( 'editor1', {
		toolbar: [
			{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
			{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
		]
	});
	var timer  = setInterval(function() {
		if ($("#checkpoint").val() == "") {
			$("#cke_editor1").css("display" , "none");
		}else{
			$("#cke_editor1").css("display" , "block");
		}
		clearInterval(timer);
	}, 500);
	
	
	
	$("#terms_and_conditions_check").change(function() {
		if (this.checked) {
			$("#cke_editor1").css("display" , "block");
		}else{
			$("#cke_editor1").css("display" , "none");
		}
	});
    
        $("#landing-page").change(function() {
           if(this.checked) {
				$(".landing-page-images").slideToggle(400);
				$(".preview-container").css("display" , "block");
			}else{
				$(".landing-page-images").slideToggle(400);
				$(".preview-container").css("display" , "none");
			}
        });
     })
	
    if($("#check_box_check").val() == ""){
     $(".preview-container").css("display" , "none");
    }else{
      $(".preview-container").css("display" , "block");
    }
     // Switchery toggle
     var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
     elems.forEach(function(html) {
         var switchery = new Switchery(html);
     });
</script>
<!-- /.content -->
<script>
   function previewImage(input, previewDom) {
       if (input.files && input.files[0]) {
           $(previewDom).show();
           var reader = new FileReader();
           reader.onload = function (e) {
               $(previewDom).find('img').attr('src', e.target.result);
           }
           reader.readAsDataURL(input.files[0]);
       }
       else {
           $(previewDom).hide();
       }
   }
   
      $("#desktop").click(function(){
   $(".top-bar").css("position" , "fixed");
   });
   
   $("#mobile").click(function(){
   $(".top-bar").css("position" , "absolute");
   });
   $("#tablet").click(function(){
   $(".top-bar").css("position" , "absolute");
   });
   function previewImage(input, previewDom) {
       if (input.files && input.files[0]) {
           $(previewDom).show();
           var reader = new FileReader();
           reader.onload = function(e) {
               $(previewDom).find('img').attr('src', e.target.result);
           }
           reader.readAsDataURL(input.files[0]);
       } else {
           $(previewDom).hide();
       }
   }
   (function() {
   $(document).ready(function() {
   return $('.icon').click(function() {
    $(this).addClass('current').siblings('.icon').removeClass('current');
    return $('#device').removeClass('desktop').removeClass('tablet').removeClass('mobile').addClass($(this).attr('id'));
   });
   });
   
   }).call(this);
</script>
<?php 
   $coordinates = '';
   if(!empty($location->location_coordinates)){
   	$coordinates = $location->location_coordinates;
   }else{
   	$coordinates = '55.2958244683588 , 25.27297675388658';
   }?>
<script>
   /*mapboxgl.accessToken = 'pk.eyJ1IjoibXVzaWNodWJjb2xsZWN0aW9uIiwiYSI6ImNrdDRoMDh5cjEzdGcycHBoYTg2N21iZWsifQ.7Wd0_9YhP9czuN4DFVFs-g';
   const map = new mapboxgl.Map({
     container: 'map',
     style: 'mapbox://styles/mapbox/streets-v11',
     center: [<?php echo $coordinates;?>],
     zoom: 10
   });
   
   const geocoder = new MapboxGeocoder({
     accessToken: mapboxgl.accessToken,
     mapboxgl: mapboxgl
   });
   
   map.addControl(geocoder, 'top-left');
   
   map.on('style.load', function() {
   map.on('click', function(e) {
   var coordinates = e.lngLat;
   $("#coordinates").val(coordinates.lng + " , "+coordinates.lat);
   new mapboxgl.Popup()
   .setLngLat(coordinates)
   .setHTML(coordinates)
   .addTo(map);
   });
   });*/
</script>		
<?php include viewPath('includes/footer'); ?>