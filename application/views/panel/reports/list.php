<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class=" icon-stats-growth"></i> <span class="text-semibold">Subscribers Reports</span> -
            List
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Subscribers list</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('edit_reporting') && get('domains')): ?>
         <!-- <li><a href="<?php  echo url('panel/reports/add') .'?domains='.get('domains') ?>"><i class="icon-add position-left"></i> Add new location</a></li> -->
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
               <?php echo form_open('panel/reports', ['method' => 'GET', 'autocomplete' => 'off']); ?>
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
                        <?php
         //selecting only whats required by current id.
         $domains = $this->domains_model->getByUserId(logged("id"));
         $count_domain = count($domains);
         
         ?>
                        <select name="domains" id="Filter-User" onchange="$(this).parents('form').submit();"
                           class="form-control select2">
                           <?php if($count_domain > 1):  ?>
                           <option value="">Select Domain</option>
                           <?php endif; ?>
                           <?php foreach ($domains as $row): ?>
                           <?php $sel = (get('domains')==$row->id)?'selected':'' ?>
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
                        href="<?php echo url('/panel/reports') ?>" class="btn btn-danger">Reset</a> </div>
                  </div>
               </div>
               <?php echo form_close(); ?>
            </div>
         </div>
      </div>
      </div> -->
   <?php if(isset($subscribers_list)): ?>
   <div class="panel panel-flat">
   <div class="panel-heading">
      <h5 class="panel-title">Subscribers</h5>
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
      <style>
      </style>
      <a class="heading-elements-toggle"><i class="icon-more"></i></a>
   </div>
   <div class="panel-body subscribers-body">
      <div class="">
         <div class="row">
            <div class="col-md-12 padding-20">
               List of all subscribers for your business  <code>You cann't delete this data</code>
            </div>
            <div class="col-md-12">
               <div class="navbar navbar-inverse bg-teal-400 navbar-component report-menu">
                  <ul class="nav navbar-nav add-filter-box">
                     <?php if(registered_on_check()){?>
                     <li class="registered_on_"> <span class="label label-success position-right custome-css"> Registered On <br><?php echo $_GET['registered_on_check'];?> <i class="icon-cross filter-disabled"></i> </span>
                     <li>
                        <?php }?>
                        <?php if(last_visited_check()){?>
                     <li class="last_visited_"> <span class="label label-success position-right custome-css"> Last Visited <br><?php echo $_GET['last_visited_check'];?> <i class="icon-cross filter-disabled"></i> </span>
                     <li>
                        <?php }?>
                        <?php if(location_check()){?>
                     <li class="location_"> <span class="label label-success position-right custome-css"> 
                        Location <br><?php print_r($_GET['location_check'][0]);?>
                        <i class="icon-cross filter-disabled"></i> 
                        </span>
                     <li>
                        <?php }?>
                        <?php if(status_check()){?>
                     <li class="status_"> <span class="label label-success position-right custome-css"> Status <br>
                        <?php if($_GET['status_check'] == '1'){
                           echo "Active";
                           }else{
                           echo "Blocked";
                           }?>
                        <i class="icon-cross filter-disabled"></i> </span>
                     <li>
                        <?php }?>
                  </ul>
                  <div class="">
                     <ul class="nav navbar-nav navbar-right subscribers-nava">
                        <li class="all_filters <?php if(status_check() || status_check() || last_visited_check() || location_check()){ ?> active <?php }?>"><a href="#alpaca-option-tree-connector-source" data-toggle="collapse"> <i class="icon-search4 ml"></i>Filter records</a></li>
                        <li class="">
                        <li class="all_filters">
                           <?php $domain_meta = get_domain_meta("domain_as_demo");?>
                           <?php 
                              $domain_meta = get_domain_meta("domain_as_demo");
                              if((empty($domain_meta)  || logged("role") == 1)){
                              echo form_open_multipart('panel/reports/exportCsv', [ "id" => "reportForm" , 'class' => 'form-validate', 'autocomplete' => 'off'  , 'method' => 'get' ]); ?>
                           <input type="text" style="display:none;" value="<?php echo (isset($_GET['registered_on_check']))? $_GET['registered_on_check'] : "";?>" name="registered_on1"  class="form-control daterange-left" placeholder="Registered On">
                           <input type="hidden" name="registered_on_check1" value="<?php if(isset($_GET['registered_on_check'])) { echo $_GET['registered_on_check']; }?>" >
                           <input type="hidden" name="last_visited_check1" value="<?php if(isset($_GET['last_visited_check'])) { echo $_GET['last_visited_check']; }?>"  >
                           <input type="hidden" name="location_check1[]" value="<?php if(isset($_GET['location_check'])) { print_r($_GET['location_check'][0]); }?>"  >
                           <input type="hidden" name="status_check1" value="<?php if(isset($_GET['status_check'])) { echo $_GET['status_check']; }?>"  >
                           <input type="text"  style="display:none;" value="<?php echo (isset($_GET['last_visited_check']))? $_GET['last_visited_check'] : "";?>"  class="form-control daterange-left" placeholder="Last Visited">
                           <select name="status1"  style="display:none;"  class="form-control ">
                              <option <?php if(isset($_GET['status'])){ if($_GET['status'] == '1') echo "selected"; }  ?> value="1">Active</option>
                              <option <?php if(isset($_GET['status'])){ if($_GET['status'] == 'on') echo "selected"; } ?> value="0">Blocked</option>
                           </select>
                           <select name="location1[]"  style="display:none;">
                              <?php 
                                 foreach($locations as $location){
                                 ?>
                              <option <?php if(isset($_GET['location'])){ if($_GET['location'] == $location->location_name) echo "selected"; }  ?> value="<?php echo $location->location_name;?>"><?php echo $location->location_name;?></option>
                              <?php }?>
                           </select>
                           <?php } ?>
                           <button class="" type="submit" <?php if((!empty($domain_meta)  && logged("role") != 1)){ ?> data-toggle="modal" data-target="#alert_mode" <?php } ?> > <i class="icon-file-download ml"  ></i> Export records</button>
                           <?php if((empty($domain_meta)  || logged("role") == 1)){ echo form_close(); } ?>
                        </li>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="collapse mt-10" id="alpaca-option-tree-connector-source" >
                  <div class="filter-section padding-20">
                     <div class="row">
                        <?php echo form_open_multipart('panel/reports', [ "id" => "filterFrom" , 'class' => 'form-validate', 'autocomplete' => 'off'  , 'method' => 'get' ]); ?>
                        <div class="col-md-10">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <div class="visiter-filter">
                                    <span class="filter-labels">Registered On</span>
                                    <div class="input-group">    
                                       <input type="text" value="<?php echo (isset($_GET['registered_on_check']))? $_GET['registered_on_check'] : "";?>" name="registered_on" id="registered_on" class="form-control daterange-left" placeholder="Registered On">
                                       <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <input type="hidden" name="registered_on_check" value="<?php if(isset($_GET['registered_on_check'])) { echo $_GET['registered_on_check']; }?>" id="registered_on_check" >
                           <input type="hidden" name="last_visited_check" value="<?php if(isset($_GET['last_visited_check'])) { echo $_GET['last_visited_check']; }?>" id="last_visited_check" >
                           <input type="hidden" name="location_check[]" value="<?php if(isset($_GET['location_check'])) { print_r($_GET['location_check'][0]); }?>" id="location_check" >
                           <input type="hidden" name="status_check" value="<?php if(isset($_GET['status_check'])) { echo $_GET['status_check']; }?>" id="status_check" >
                           <div class="col-md-4">
                              <div class="visiter-filter">
                                 <div class="form-group">
                                    <span class="filter-labels">Last Visited</span>
                                    <div class="input-group">
                                       <input type="text" value="<?php echo (isset($_GET['last_visited_check']))? $_GET['last_visited_check'] : "";?>" name="last_visited"  id="last_visited" class="form-control daterange-left" placeholder="Last Visited">
                                       <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <option value="">Status</option>
                              <div class="form-group">
                                 <select name="status"  id="status" class="form-control ">
                                    <option value="">Filter By Status</option>
                                    <option <?php if(isset($_GET['status'])){ if($_GET['status'] == '1') echo "selected"; }  ?> value="1">Active</option>
                                    <option <?php if(isset($_GET['status'])){ if($_GET['status'] == 'on') echo "selected"; } ?> value="0">Blocked</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <option value="">Location</option>
                                 <div class="input-group">
                                    <select name="location[]" id="location" data-placeholder="Filter By location" multiple="" class="select select2-hidden-accessible daterange-left" tabindex="-1" aria-hidden="true">
                                       <option></option>
                                       <optgroup label="Locations">
                                          <?php 
                                             foreach($locations as $location){
                                             ?>
                                          <option <?php if(isset($_GET['location'])){ if($_GET['location'] == $location->location_name) echo "selected"; }  ?> value="<?php echo $location->location_name;?>"><?php echo $location->location_name;?></option>
                                          <?php }?>
                                       </optgroup>
                                    </select>
                                    <span class="input-group-addon"><i class="icon-location3"></i></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-2">
                           <div class="col-md-12 custome-margin">
                              <button class="btn bg-teal submit-button"  type="submit">Filter &nbsp;&nbsp;<i class="icon-search4"></i></button>
                           </div>
                        </div>
                        <?php echo form_close(); ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="table-responsive">
                  <?php if(!empty($subscribers_list)){ ?>
                  <table class="table table-xs" style="white-space: nowrap;">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Phone</th>
                           <th>Email</th>
                           <th>Nationality</th>
                           <th>Status</th>
                           <th>SMS verified</th>
                           <th>Registered on</th>
                           <th>Last Visited</th>
                           <th>Login count</th>
                        </tr>
                     </thead>
                     <tbody class="">
                        <?php
                           $domain_meta = get_domain_meta("domain_as_demo");
                                               foreach ($subscribers_list as $row):
                                                $date = $row->registered_on;
                           $date = explode(" " , $date);
                           $date  = $date[0];
                                               ?>
                        <tr class="table-row">
                           <td>
                              <?php  echo (empty($domain_meta)  || logged("role") == 1 || date("Y-m-d") == $date )? $row->id : "****"; ?>
                           </td>
                           <td class="popup-td">
                              <?php echo $row->name ?>
                              <?php if(empty($domain_meta) || logged("role") == 1 || date("Y-m-d") == $date ){?>
                              <div class="hover-show" data-toggle="modal" subName="<?php echo $row->name;?>" data-target="#modal_default" url="<?php echo base_url()?>/panel/reports/get_subscriber_login_detail/<?php echo $row->id?>"> <i class="icon-new-tab"></i> </div>
                              <?php }?>
                           </td>
                           <td>
                              <?php echo (empty($domain_meta)  || logged("role") == 1 || date("Y-m-d") == $date )? $row->phone : "***********"; ?>
                           </td>
                           <td>
                              <?php echo (empty($domain_meta) || logged("role") == 1 || date("Y-m-d") == $date )? $row->email : "****************"; ?>
                           </td>
                           <td>
                              <?php echo get_country_name($row->subs_country) ; ?>
                           </td>
                           <?php if(empty($domain_meta) || logged("role") == 1 || date("Y-m-d") == $date ){?>
                           <td>
                              <?php if (hasPermissions('edit_reporting')): ?>
                              <div class="switchery-xs">
                                 <span id="domainId" style="display:none;"><?php echo $domain_id ?></span>
                                 <input type="checkbox" user_id="<?php echo $row->id ?>" class="switchery changecheckbox" <?php echo ($row->status) ? 'checked' : '' ?>   />
                              </div>
                              <!--  -->
                              <?php endif ?>
                           </td>
                           <?php }else{ ?>
                           <td>
                              Not allowed
                           </td>
                           <?php }?>
                           <td style="text-align:center;">
                              <?php if($row->sms_verified == 1){?> <i class="icon-checkmark4 green"></i> <?php  ?>
                              <?php }else{ ?> <i class="icon-cross2 red"></i> <?php } ?>
                           </td>
                           <td>
                              <?php echo $row->registered_on ?>
                           </td>
                           <td>
                              <?php 
                                 echo getTimeAgo($row->last_login_time);            
                                 ?>
                           </td>
                           <td style="text-align:center">
                              <?php echo (empty($domain_meta) || logged("role") == 1 || date("Y-m-d") == $date ) ? $row->login_count : "***" ?>
                           </td>
                        </tr>
                        <?php endforeach ?>
                     </tbody>
                  </table>
                  <div class="datatable-footer">
                     <div class="dataTables_paginate paging_simple_numbers"><?php echo $links; ?>
                     </div>
                  </div>
                  <?php }else{?>
                  <div class="page-title no-record">
                     <h4> No Records Found</h4>
                  </div>
                  <?php }?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php endif; ?>
   <div id="modal_default" class="modal fade accesspoints">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-body" style="padding:0px">
               <div id="model_content">
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="alert_mode" class="modal fade accesspoints">
      <div class="modal-dialog">
         <div class="modal-content alert-container">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h2 class="modal-title">Alert</h2>
               <h5>
               You can't export demo data
               <h5>
            </div>
         </div>
      </div>
   </div>
   <!-- Default box -->
</section>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
<script>
   // Switchery toggle
   var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
   elems.forEach(function(html) {
       var switchery = new Switchery(html);
   });
   var elems = Array.prototype.slice.call(document.querySelectorAll('.statusSwich'));
   elems.forEach(function(html) {
       var switchery = new Switchery(html);
   });
</script>
<script>
   $(document).ready(function() {
   	$(".all_filters").click(function(){
   		$(this).toggleClass("active");
   	});
   	$(document).on("click", ".filter-disabled" , function() {
   		var class_name = $(this).parent().parent().attr("class");
   		$("#"+class_name+"check").val("");
              $("."+class_name+"2").removeClass(class_name+"2");
              $(this).parent().parent().remove();
   		document.getElementById("filterFrom").submit();
          });
   	
   	
   
   $('.hover-show').click(function(e) {
   	var url = $(this).attr("url");
   	var name = $(this).attr("subName");
   	$.ajax({
   		url: url,
   		type: 'GET',
   		data: {name : name},
   		beforeSend: function(){
   			$('.custom-loader').css("display" , "block");
   		},
   		success: function(response) {
   			$('.custom-loader').css("display" , "none");
   			$("#model_content").html(response);
   		}
   	});     
     });
     
     $(document).on("click", ".loginDetail" , function() {
   		var url = $(this).attr("href");
   		$.ajax({
   			url: url,
   			type: 'GET',
   			beforeSend: function(){
   				$('.custom-loader').css("display" , "block");
   			},
   			success: function(response) {
   				$('.custom-loader').css("display" , "none");
   				$("#model_content").html(response);
   			}
   		});
   	return false;
     });
   
   		
   	$("#registered_on").change(function(){
   		$("#registered_on_check").val($(this).val());
   		remove_class( this , 'registered_on_' , "registered_on_2" );
   	});
   	
   	$("#last_visited").change(function(){
   		$("#last_visited_check").val($(this).val());
   		remove_class( this , 'last_visited_' , "last_visited_2" );
   	});
   	
   	$("#location").change(function(){
   		$("#location_check").val($(this).val());
   		remove_class( this , 'location_' , "location_2" );
   	});
   	
   	$("#status").change(function(){
   		$("#status_check").val($(this).val());
   		remove_class( this , 'status_' , "status_2" );
   		
   	});
   });
   
   function filter_alert_condition(current_item , class_name , class_item , filter_name){
   	if($("body").find('.'+class_name).html() == undefined && $("body").find(class_item).html() == undefined){
   		add_filter_alert( class_name , filter_name );
   		$(this).addClass('status_2');
   	}
   }
   
   function remove_class(current_item , alert_class , item_class){
   	if($(current_item).val() == ""){
   		$("."+alert_class).remove();
   		$(current_item).prop("selected", false);
   		$(current_item).removeClass(item_class);
   	}
   }
   
   function add_filter_alert( class_name , filter_name ){
   	$('.add-filter-box').append('<li class="'+class_name+'"> <span class="label label-success position-right custome-css"> '+filter_name+' <i class="icon-cross filter-disabled"></i> </span><li>');
   }
   
   $('input[name="registered_on"]').daterangepicker({
    autoUpdateInput: false,
   });
   
   $('input[name="registered_on"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    $("#registered_on_check").val(picker.startDate.format('YYYY-MM-DD') + ' _ ' + picker.endDate.format('YYYY-MM-DD'));
   remove_class( this , 'registered_on_' , "registered_on_2" );
    
   });
   
   $('input[name="registered_on"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
   });
   
   
   $('#last_visited').daterangepicker({
    autoUpdateInput: false,
   });
   
   $('input[name="last_visited"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    $("#last_visited_check").val(picker.startDate.format('YYYY-MM-DD') + ' _ ' + picker.endDate.format('YYYY-MM-DD'));
   remove_class( this , 'last_visited_' , "last_visited_2" );
   });
   
   $('input[name="last_visited"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
   });
     
     
     $("input").on("change", function() {
         this.setAttribute(
             "data-date",
             moment(this.value, "YYYY-MM-DD")
             .format( this.getAttribute("data-date-format") )
         )
     }).trigger("change")
     
     //                $('#dataTable1').DataTable();
     //                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
     //                elems.forEach(function (html) {
     //                    var switchery = new Switchery(html, {
     //                        size: 'small'
     //                    });
     //                });
     
     $(document).ready(function() {
        $(".changecheckbox").change(function() {
   	 var status_var = "";
   	 var status = "";
   		 if(this.checked) {
      status = this.checked;
   			status_var = "enabled";
   		 }else{
   	status = this.checked;
   			status_var = "disabled";
   		 }
      var id = $(this).attr('user_id'); 
      var domain_id = $("#domainId").html(); 
      $.get('<?php echo url('panel/reports/change_status') ?>/' + id + '/' + domain_id, {
   		   status: status
      }, (data, status) => {
   		   if (data == 'done') {
   			   // code
   			   // alert('Status changed successfully!');
      
   			   // Success notification
   			   new PNotify({
   				   title: 'Success',
   				   text: 'Subscriber ' + status_var + ' successfully!',
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
      })
     });
     
</script>
<?php include viewPath('includes/footer'); ?>