<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/pages/form_inputs.js"></script>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-connection position-left"></i> <span class="text-semibold">Manage Access Points</span> -
            List
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component access-points-menu">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Access Points list</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('add_access_point') && $globelDomain->domainId): ?>
			
				<li>
					<a class="bg-teal-400" href="#alpaca-option-tree-connector-source"  data-toggle="modal" data-target="#modal_default" id="bulk_import"> 
						<i class="icon-download4  position-left"></i> Bulk import
					</a>
				</li>
			
			<li>
				<a class="bg-teal-400" href="<?php  echo url('panel/accesspoints/add') .'?domains='.$globelDomain->domainId ?>"><i
				class="icon-add position-left"></i> Add new access point</a>
			</li>
			
         <?php endif ?>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <!-- <div class="panel panel-flat">
      <div class="panel-body">
         <div class="row">
            <div class="col-sm-12">
               <?php echo form_open('panel/accesspoints', ['method' => 'GET', 'autocomplete' => 'off']); ?>
               <div class="row">
                  <div class="col-sm-2 col-md-offset-2">
                     <div class="form-group">
                        <p style="margin-top: 20px"><strong>Filter :</strong> </p>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label for="Filter-User">Domain</label> <span class="pull-right"><a href="#"
                           onclick="event.preventDefault(); $('#Filter-User').val('').trigger('onchange')">clear</a></span>
                        <select name="domains" id="Filter-User" onchange="removeSelect(); $(this).parents('form').submit(); "
                           class="form-control select2">
                           <option value="">Select Domain</option>
                           <?php foreach ($this->domains_model->get() as $row): $counter = 1; ?>
                           <?php $sel = ($globelDomain->domainId==$row->id)?'selected':'' ?>
                           <?php if($row->users_id == logged("id") && logged("role") != 1): ?>
                           <option <?php echo ($counter == 1)? "selected id='selectItem'" : ""; ?> value="<?php echo $row->id ?>" <?php echo $sel ?>>
                              <?php echo $row->domain_name ?>
                           </option>
         <option value="3">
                              Amir shahzad
                           </option>
                           <?php endif; ?>
                           <?php if(logged("role") == 1): ?>
                           <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                              <?php echo $row->domain_name ?>
                           </option>
                           <?php endif; ?>
                           <?php $counter ++; endforeach ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="form-group" style="margin-top: 25px;"> <a
                        href="<?php echo url('/panel/accesspoints') ?>" class="btn btn-danger">Reset</a>
                     </div>
                  </div>
               </div>
               <?php echo form_close(); ?>
            </div>
         </div>
      </div>
      </div>-->
   <?php if(isset($accesspoints_list)): ?>
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Access Points ( <?php echo $used_accesspoints . " / " . $allow_accesspoints->no_of_ap;?> )</h5>
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
      <div class="panel-body"> List of all access points for your business/domain </div>
      <div class="table-responsive">
		
         <table class="table table-xs">
            <thead>
               <tr>
                  <th>Device MAC</th>
                  <th>Device Location</th>
                  <th>Status</th>
                  <th>Registered on</th>
                  <th>Last updated</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  foreach ($accesspoints_list as $row):
                     
                  ?>
               <tr>
                  <td>
                     <?php echo $row->device_mac ?>
                  </td>
                  <td>
                     <?php
                        switch_db_by_domain_id($globelDomain->domainId);
                        $location_row = $this->locations_model->getById($row->location_id);
                        echo $location_row->location_name;
                        //switching the db back
                        switch_db(default_db_name());
                        ?>
                  </td>
                  <td>
                     <?php if (hasPermissions('edit_location')): ?>
					 <div class="switchery-xs">
                     <input type="checkbox" class="switchery js-switch"
                        onchange="updateAccesspointStatus('<?php echo $row->id ?>', $(this).is(':checked'), <?php echo $globelDomain->domainId ?> )"
                        <?php echo ($row->status) ? 'checked' : '' ?> />
					 </div>
					 
                     <?php endif ?>
                  </td>
                  <td>
                     <?php echo $row->registered_on ?>
                  </td>
                  <td>
                     <?php echo $row->updated_on ?>
                  </td>
                  <td>
                     <ul class="icons-list">
                        <?php if (hasPermissions('edit_access_points')): ?>
                        <li class="text-primary-600"><a
                           href="<?php echo url('panel/accesspoints/edit/'.$row->id) . '/' . $globelDomain->domainId ?>"
                           title="Edit access point"><i class="icon-pencil7"></i></a></li>
                        <?php endif ?>
                        <?php if (hasPermissions('delete_access_points')): ?>
                        <li class="text-danger-600">
                           <a href="<?php echo url('panel/accesspoints/delete/'.$row->id) ?>/<?php echo $globelDomain->domainId ?>"
                              onclick="return confirm('Do you really want to delete this accesspoint?')"
                              title="Delete Access point" data-toggle="tooltip"><i class="icon-trash"></i></a>
                        </li>
                        <?php endif ?>
                     </ul>
                  </td>
               </tr>
               <?php endforeach ?>
            </tbody>
         </table>
      </div>
   </div>
   <?php endif; ?>
   <!-- Default box -->
</section>

<div id="modal_default" class="modal fade accesspoints">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Import accesspoints</h5>
			</div>

			<div class="modal-body  first-body">
			
			
			<div id="error-message"></div>
			<div id="success-message"></div>
			  <div class="row model-custome-body">
				<?php if(check_access_points()){ ?>
					<?php echo form_open_multipart('panel/accesspoints/import_csv/', [ 'class' => 'form-validate', 'id' => 'csv_form', 'autocomplete' => 'off' ]); ?>
					   <div class="col-md-12">
						  <div class="form-group">
							 <div class="visiter-filter">
								<span class="filter-labels">Choose CSV file</span>
									<div class="uploader">
										<input type="hidden" name="domain_id" value="<?php echo (isset($_SESSION['globelDomain']->domainId))? $_SESSION['globelDomain']->domainId : "";?>">
										<input type="file" id="csv_access_points" accept=".csv" name="csv_access_points" class="file-styled-primary" required="required">
									</div>								
								
							 </div>
						  </div>
					   </div>
					   <div class="col-md-12">
						  <option value="">Choose location</option>
						  <div class="form-group">
							 <select name="location" id="status" class="form-control ">
								<option disabled >Location</option>
								<?php foreach($location_list as $location){  ?>
									<option value="<?php echo $location->id?>"><?php echo $location->location_name?></option>
								<?php } ?>
							 </select>
						  </div>
					   </div>
						
							<div class="col-md-12">
							   <div class="custome-margin">
								  <button class="btn bg-teal submit" id="sweet_loader" type="submit"><i class="icon-file-upload position-left"></i> Import accesspoints </button>
							   </div>
							</div>
							
				<?php 
						echo form_close(); 
					}else{
				?>
				
					<div class="alert alert-warning alert-bordered">
						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						<span class="text-">
							You have already exceeded your access points limit if you want to add new access points Please contact your administrator for more access points or remove some unwanted access points.
						</span>
					</div>
					<?php }?>
			  </div>
			  
			  
			  
			</div>
			
			<div class="modal-body second-body"> 
				<div class="row model-custome-body">
					<h5 class="modal-title title-sure">Are you sure you want to import these access points</h5>
					<div id="access_confirmation">
					
					</div>
					<div class="modal-footer">	
						<button type="button" id="back_move" class="btn btn-danger"><i class="icon-arrow-left8 position-left"></i> Back</button>
						<button type="button" class="btn bg-teal submit" id="store_data"><i class="icon-file-upload position-left"></i> Yes, Sure</button>	
					</div>
			  </div>
			</div>
			
		</div>
	</div>
</div>

<!-- /.content -->
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
<script>
	
   // Switchery toggle
   var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
   elems.forEach(function(html) {
       var switchery = new Switchery(html);
   });
</script>
<script>
   //                            $('#dataTable1').DataTable();
   //                            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
   //                            elems.forEach(function (html) {
   //                                var switchery = new Switchery(html, {
   //                                    size: 'small'
   //                                });
   //                            });
   
   function removeSelect(){
    $("#selectItem").find('option:selected').remove();
   };
   
   
   window.updateAccesspointStatus = (id, status, domain_id) => {
       $.get('<?php echo url('panel/accesspoints/change_status') ?>/' + id + '/' + domain_id, {
           status: status
       }, (data, status) => {
           if (data == 'done') {
				   // code
				   // alert('Status changed successfully!');
	   
				   // Success notification
				   new PNotify({
					   title: 'Success',
					   text: 'Status changed successfully!',
					   icon: 'icon-checkmark3',
					   type: 'success'
				   });
	   
	   
			   } else {
				   //alert('Unable to change Status ! Try Again');
				   // error notification
				   new PNotify({
					   title: 'Error',
					   text: 'Unable to change Status! Try Again',
					   icon: 'icon-warning22',
					   addclass: 'alert alert-warning alert-styled-right',
					   type: 'error'
				   });
			   }
       })
   }
   
     $('#csv_form').on('submit', function (e) {
			e.preventDefault();
			$(".title-sure").css("display" , "block");
			 var fd = new FormData(this);
			var files = $('#csv_access_points')[0].files;
        
			// Check file selected or not
			if(files.length > 0 ){
			   fd.append('file',files[0]);
			}
			var url = '<?php echo base_url()?>/panel/accesspoints/import_csv_check/'
          $.ajax({
            type: 'post',
            url: url,
			contentType: false,
            processData: false,
			dataType: 'json',
            data: fd,
			beforeSend: function(){
				$('.custom-loader').css("display" , "block");
			},
            success: function (data) {
				$('.custom-loader').css("display" , "none");
				if(data.error){
					$("#error-message").html(data.error);
					$("#error-container").css("display" , "block");
					$("#success-container").css("display" , "none");
					$("input[name=csrf_test_name]").val(data.csrfHash);
				}
				if(data.confirm){
					
					$("#access_confirmation").html(data.content);
					$("#error-container").css("display" , "none");
					$("#success-container").css("display" , "none");
					$("input[name=csrf_test_name]").val(data.csrfHash);
					$('.second-body').css("display" , "block");
					$('.first-body').css("display" , "none");
				}
            }
			
          });

		return false;
     });
	 
	  $('#store_data').click(function(){
		
			var url = '<?php echo base_url()?>/panel/accesspoints/import_access_points/'
          $.ajax({
            type: 'get',
            url: url,
			dataType: 'json',
			beforeSend: function(){
				$('.custom-loader').css("display" , "block");
			},
            success: function (data) {
				$('.custom-loader').css("display" , "none");
				if(data.success){
					$("#access_confirmation").html(data.success);
					$(".title-sure").css("display" , "none");
					$("#error-container").css("display" , "none");
					$("#success-container").css("display" , "block");
					if(!data.repeated){
						setInterval(function() {
							 location.reload();
						}, 3000); 
					}
				}
            }
			
          });

		return false;
     });
	
	$("#back_move").click(function(){
		$('.first-body').css("display" , "block");
		$('.second-body').css("display" , "none");
	});
	
	
</script>
<?php include viewPath('includes/footer'); ?>