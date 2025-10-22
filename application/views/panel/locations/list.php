<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
   
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-location3 position-left"></i> <span class="text-semibold">Manage Locations</span> - List
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Locations list</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('add_location') && $globelDomain->domainId): ?>
         <li><a class="bg-teal-400" href="<?php  echo url('panel/locations/add') .'?domains='.$globelDomain->domainId ?>"><i
            class="icon-add position-left"></i> Add new location</a></li>
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
               <?php echo form_open('panel/locations', ['method' => 'GET', 'autocomplete' => 'off']); ?>
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
                        <select name="domains" id="Filter-User" onchange="$(this).parents('form').submit();"
                           class="form-control select2">
                           <option value="">Select Domain</option>
                           <?php foreach ($this->domains_model->get() as $row): ?>
                           <?php $sel = ($globelDomain->domainId==$row->id)?'selected':'' ?>
                           <?php if($row->users_id == logged("id") && logged("role") != 1): ?>
                           <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                              <?php echo $row->domain_name ?>
                           </option>
                           <?php endif; ?>
                           <?php if(logged("role") == 1): ?>
                           <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                              <?php echo $row->domain_name ?>
                           </option>
                           <?php endif; ?>
                           <?php endforeach ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="form-group" style="margin-top: 25px;"> <a
                        href="<?php echo url('/panel/locations') ?>" class="btn btn-danger">Reset</a> </div>
                  </div>
               </div>
               <?php echo form_close(); ?>
            </div>
         </div>
      </div>
   </div> -->
   <?php if(isset($locations_list)): ?>
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Locations</h5>
         <div class="heading-elements">
            <ul class="icons-list">
               <li>
                  <a data-action="collapse"></a>
               </li>
               <li>
                  <a data-action="reload"></a>
               </li>
               <!--
                  <li>
                      <a data-action="close"></a>
                  </li>
                  -->
            </ul>
         </div>
         <a class="heading-elements-toggle"><i class="icon-more"></i></a>
      </div>
      <div class="panel-body"> List of all locations for your business <code>You cann't delete locations</code>
      </div>
      <div class="table-responsive">
         <table class="table table-xs">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Location name</th>
                  <th>Address</th>
                  <th>Coordinates</th>
                  <th>Status</th>
                  <th>Registered on</th>
                  <th>Last updated</th>
                  <th>Access points</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  foreach ($locations_list as $row): ?>
               <tr>
                  <td>
                     <?php echo $row->id ?>
                  </td>
                  <td>
                     <?php echo $row->location_name ?>
                  </td>
                  <td>
                     <?php echo $row->location_address ?>
                  </td>
                  <td>
                     <?php echo $row->location_coordinates ?>
                  </td>
                  <td>
                     <?php if (hasPermissions('edit_location')): ?>
					 <div class="switchery-xs">
                     <input type="checkbox" class=" switchery js-switch"
                        onchange="updateLocationStatus('<?php echo $row->id ?>', $(this).is(':checked'), <?php echo $globelDomain->domainId ?> )"
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
                     <?php 
                        $total_aps = all_access_points_by_domain_id_location($globelDomain->domainId, $row->id);
                                   echo count($total_aps);
                        ?>
                  </td>
                  <td>
                     <?php $link = '' ;
                        echo $link;
                        ?>
                     <?php
                        $digits = 2;
                        
                        $created_timestamp = strtotime($row->registered_on);
                        
                        
                        $domain_name = $globelDomain->domain_db_name;
                        $encryption_time = md5($created_timestamp);
                        
                        ?>
                     <!--<a class="label label-flat border-success text-success-600 position-left" href="<?php echo url('panel/accesspoints?domains=') . $globelDomain->domainId ?>"><i class="icon-connection"></i> Manage access points</a>-->
                     <?php if (hasPermissions('edit_location')): ?><a
                        class="label label-flat border-success text-success-600 position-center"
                        href="<?php echo url('panel/locations/edit/'.$row->id) . '/' . $globelDomain->domainId; ?>"><i
                        class="icon-database-edit2"></i> Edit Location</a><?php endif ?>
                     <a class="label label-flat border-primary text-primary-600 position-right view_link"
                        href="#"
                        data-link="<?php echo url('f/subscriber/view/'). encryption($domain_name);?>"><i
                        class="icon-copy3"></i> View link</a>
                  </td>
               </tr>
               <?php endforeach ?>
            </tbody>
         </table>
      </div>
      <div class="panel-body">
         <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/ui/prism.min.js"></script>
         <div class="loc_link_copy">
            <p>Copy the below location url into External splash page setup: </p>
            <pre class="language-markup content-group"><code></code></pre>
         </div>
      </div>
   </div>
   <?php endif; ?>
   <!-- Default box -->
</section>
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
   jQuery(".view_link").click(function(event) {
       event.preventDefault();
       var link_value = $(this).data("link");
       jQuery(".loc_link_copy code").html(link_value);
       jQuery(".loc_link_copy").fadeIn("slow");
   });
   //                $('#dataTable1').DataTable();
   //                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
   //                elems.forEach(function (html) {
   //                    var switchery = new Switchery(html, {
   //                        size: 'small'
   //                    });
   //                });
   window.updateLocationStatus = (id, status, domain_id) => {
       $.get('<?php echo url('panel/locations/change_status') ?>/' + id + '/' + domain_id, {
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
</script>
<?php include viewPath('includes/footer'); ?>