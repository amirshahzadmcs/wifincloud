<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
<!-- Content Header (Page header) -->
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
                           <input type="checkbox" <?php echo ($location_image_status == "enable")? "checked='checked'" : "";  ?>id="landing-page" class="switchery" name="">
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
			 <div class="row">
				<div class="col-md-12" style="margin-top:20px;">
				   <button type="submit" class="btn bg-teal-400">Submit <i
					  class="icon-arrow-right14 position-right"></i></button>
				</div>
			 </div>
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
         <?php echo form_close(); ?>
         <!--                    </form>-->
      </div>
   </div>
   <style>
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
        $("#landing-page").change(function() {
           if(this.checked) {
   		$(".landing-page-images").slideToggle(400);
   	}else{
   		$(".landing-page-images").slideToggle(400);
   	}
           var checkbox = $(this);
           var status = "disbale";
           if( this.checked){
              status = "enable";
           }
   	 var location_id = $("#location_id").val();
           $.ajax({
                 url: '<?php echo base_url()?>panel/locations/save_location_setting',
                 type: 'GET',
   		   dataType: 'json',
                 data: {status : status , location_id : location_id},
                 success: function(response) { 
   
   			   new PNotify({
   				   title: 'Success',
   				   text: 'Landing page settings status ' + response.status + ' successfully!',
   				   icon: 'icon-checkmark3',
   				   type: 'success'
   			   });
   		  
   		 
   		   }
           }); 
        });
     })
   
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
</script>
<link
   href="<?php echo base_url()?>/assets/mapbox/assembly.min.css"
   rel="stylesheet"
   />
<script src="<?php echo base_url()?>/assets/mapbox/mapbox-gl.js"></script>
<link
   href="<?php echo base_url()?>/assets/mapbox/api.tiles.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css"
   rel="stylesheet"
   />
<script src="<?php echo base_url()?>/assets/mapbox/mapbox-gl-geocoder.min.js"></script>
<link
   rel="stylesheet"
   href="<?php echo base_url()?>/assets/mapbox/mapbox-gl-geocoder.css"
   type="text/css"
   />
<script src="<?php echo base_url()?>/assets/mapbox/9c5feb5b248b49f79a585804c259febc.min.js" crossorigin="anonymous"></script>
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