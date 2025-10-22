<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php echo $url->assets ?>chart/apexcharts.js"></script>
<?php
$hour = date('G');

if ($hour >= 5 && $hour <= 11) {
   $msg = "Good Morning";
} else if ($hour >= 12 && $hour <= 18) {
   $msg =  "Good Afternoon";
} else if ($hour >= 19 || $hour <= 4) {
   $msg =  "Good Evening";
}
?>
<!-- <div class="alert alert-success alert-bordered">
   <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
   <span class="text-semibold"><?php echo $msg; ?>!</span> We're glad to <a href="#" class="alert-link">see you
       again</a> and wish
   you a nice day.
   </div> -->
<!-- Main charts -->
<!-- <div class="alert alert-danger alert-bordered">
   <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
   <span class="text-semibold">Alert!</span> Graphs below may display dummy data for demo purposes.
   </div> -->
<!-- Dashboard content -->
<?php if (isset($last_refresh)) { ?>
<?php
   $refresh_date = new DateTime($last_refresh);

   // Get the current datetime
   $current_datetime = new DateTime();

   // Convert the last refresh datetime to a DateTime object
   $last_refresh_datetime = new DateTime($last_refresh);

   // Calculate the difference in hours
   $interval = $current_datetime->diff($last_refresh_datetime);
   $hours_since_last_refresh = $interval->days * 24 + $interval->h;
}
?>

<div class="dashboard-container">
   <?php
   //display only if the data is 6 hours or older
   if ($hours_since_last_refresh >= 6) {
   ?>
      <script type="text/javascript">
         $(document).ready(function() {
            jQuery("#fresh_data1").trigger("click");
            //console.log('6 hours ago');
         });
      </script>
      <div class="row">
         <div class="col-lg-12">
            <div class="alert alert-warning" role="alert">
               The last data sync was on <?php echo date("j M - h:i A", strtotime($last_refresh)); ?>. <a href="#" data-popup="tooltip" title="" data-placement="right" id="fresh_data1" data-original-title="Sync again">Click to sync again</a>
            </div>
         </div>
      </div>
   <?php } ?>
   <div class="row">
      <div class="col-lg-12">
         <!-- Marketing campaigns -->
         <!-- /marketing campaigns -->
         <!-- Quick stats boxes -->
         <div class="row top_counts">
            <div class="col-lg-3">
               <!-- Members online -->
               <div class="panel bg-teal-400">
                  <div class="panel-body">
                     <div class="heading-elements">
                        <?php
                        $subscribers_today_count = (isset($subscribers_today_count)) ? $subscribers_today_count : 0;
                        $subscribers_count = (isset($subscribers_count)) ? $subscribers_count : 0;
                        $subscribers_returning_today_count = (isset($subscribers_returning_today_count)) ? $subscribers_returning_today_count : 0;
                        $subscribers_new_yesterday_count = (isset($subscribers_new_yesterday_count)) ? $subscribers_new_yesterday_count : 0;


                        if (empty($subscribers_today_count)) {
                           $subscribers_today_count = 0;
                        }
                        // percentage calculator
                        $old_subs = $subscribers_count - $subscribers_today_count;
                        if ($subscribers_count > 0 && $old_subs > 0) {
                           $subsc_percent_increase = ($subscribers_today_count / $old_subs) * 100;
                        } else {
                           $subsc_percent_increase = 0;
                        }
                        ?>
                        <span class="heading-text badge bg-teal-800">+<?php echo round($subsc_percent_increase, 2); ?>%</span>
                     </div>
                     <h3 class="no-margin">+<?php echo $subscribers_today_count; ?></h3>
                     New Subscribers Today <?php echo get_role_name(); ?>
                     <!-- <div class="text-muted text-size-small">489 avg</div> -->
                  </div>
                  <div class="container-fluid">
                     <div id="members-online"></div>
                  </div>
               </div>
               <!-- /members online -->
            </div>
            <div class="col-lg-3">
               <!-- Current server data -->
               <div class="panel bg-pink-400">
                  <div class="panel-body">
                     <div class="heading-elements">
                        <?php
                        if (empty($subscribers_returning_today_count)) {
                           $subscribers_returning_today_count = 0;
                        }
                        // percentage calculator
                        $old_subs_returning = $subscribers_count - $subscribers_today_count;
                        if ($subscribers_count > 0) {
                           $subsc_percent_returned = ($subscribers_returning_today_count / $subscribers_count) * 100;
                        } else {
                           $subsc_percent_returned = 0;
                        }
                        ?>
                        <span class="heading-text badge bg-pink-800"><?php echo round($subsc_percent_returned, 2); ?>%</span>
                     </div>
                     <h3 class="no-margin"><?php echo $subscribers_returning_today_count; ?></h3>
                     Returning subscribers today
                     <!-- <div class="text-muted text-size-small">34.6% avg</div> -->
                  </div>
                  <!-- <div id="server-load"></div> -->
               </div>
               <!-- /current server load -->
            </div>
            <div class="col-lg-3">
               <!-- Current server load -->
               <div class="panel bg-violet-400">
                  <div class="panel-body">
                     <div class="heading-elements">
                        <?php
                        if (empty($subscribers_returning_yesterday_count)) {
                           $subscribers_returning_yesterday_count = 0;
                        }
                        // percentage calculator

                        ?>
                        <span class="heading-text badge bg-violet-800">New + Returning</span>
                     </div>
                     <h3 class="no-margin"><?php echo $subscribers_new_yesterday_count; ?> +
                        <?php echo $subscribers_returning_yesterday_count; ?>
                     </h3>
                     Yesterday's subscribers
                     <!-- <div class="text-muted text-size-small">34.6% avg</div> -->
                  </div>
                  <!-- <div id="server-load"></div> -->
               </div>
               <!-- /current server load -->
            </div>
            <div class="col-lg-3">
               <!-- Today's revenue -->
               <div class="panel bg-blue-600">
                  <div class="panel-body">
                     <div class="heading-elements">
                        <ul class="icons-list">
                           <!-- <li><a data-action="reload"></a></li> -->
                        </ul>
                     </div>
                     <h3 class="no-margin"><?php echo $subscribers_count; ?></h3>
                     Total Subscribers
                     <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                  </div>
                  <!-- <div id="today-revenue"></div> -->
               </div>
               <!-- /today's revenue -->
            </div>
         </div>
         <!-- /quick stats boxes -->
      </div>
   </div>
   <div class="row">
      <div class="col-lg-7">
         <span id="returnig_by_month" class="hidden"><?php echo json_encode($returnig_by_month); ?></span>
         <span id="month_names" class="hidden"><?php echo json_encode($month_names); ?></span>
         <span id="all_new_by_months" class="hidden"><?php echo json_encode($all_new_by_months); ?></span>
         <div class="panel panel-flat">
            <div class="panel-body">
               <div class="top-returning-heading">Monthly statistics</div>
               <div id="baseOnMonth"> </div>
            </div>
         </div>
      </div>
      <div class="col-lg-5">
         <span id="get_returning_by_day" class="hidden"><?php echo json_encode($get_returning_by_day); ?></span>
         <span id="all_new_by_day" class="hidden"><?php echo json_encode($all_new_by_day); ?></span>
         <span id="days_name_by_date" class="hidden"><?php echo json_encode($days_name_by_date); ?></span>
         <div class="panel panel-flat">
            <div class="panel-body">
               <div class="top-returning-heading">Weekly statistics</div>
               <div id="subBaseOnDays"> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-6">
         <?php
         $names = array();
         $login_count = array();
         if (!empty($top_returning)) {
            $count = 1;
            foreach ($top_returning as $data) {

               $names_array =  explode(" ", $data->name);

               if (isset($names_array[0])) {
                  $name = $names_array[0];
               }
               if (isset($names_array[1])) {
                  $name = $name . " " . $names_array[1];
               }
               if (isset($names_array[2])) {
                  $name =  $name . " " . $names_array[2];
               }

               $names[] = ucfirst(strtolower($name));
               //$names[] = strtok($data->name, " ");
               $login_count[] = $data->login_count;
            }
         }
         ?>
         <span id="subscriber_names" class="hidden"><?php echo json_encode($names); ?></span>
         <span id="subscriber_login_count" class="hidden"><?php echo json_encode($login_count); ?></span>
         <div class="panel panel-flat">
            <div class="panel-body">
               <div class="top-returning-heading">Top returning subscribers</div>
               <div id="myChart"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <?php

         $devices = (!empty($devices)) ? $devices : array("name" => 0, "counts" => 0);

         ?>
         <span id="device_data" class="hidden"><?php echo json_encode($devices->counts); ?></span>
         <span id="device_names" class="hidden"><?php echo json_encode($devices->name); ?></span>
         <!-- new vs returning chart -->
         <div class="panel panel-flat">
            <div class="panel-body ">
               <div class="title-">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="top-returning-heading">Top devices</div>
                     </div>
                  </div>
               </div>
               <div id="devicess"></div>
            </div>
         </div>
      </div>
   </div>
   <div class="row flex-row">
      <div class="col-lg-6 ">
         <?php
         $all_new_subs = (!empty($all_new_subs)) ? $all_new_subs : 0;
         $all_returning_subs = (!empty($all_returning_subs)) ? $all_returning_subs : 0;

         ?>
         <span id="all_new_subs" class="hidden"><?php echo $all_new_subs; ?></span>
         <span id="all_returning_subs" class="hidden"><?php echo $all_returning_subs; ?></span>
         <!-- new vs returning chart -->
         <div class="panel panel-flat">
            <div class="panel-body ">
               <div class="title-">
                  <div class="top-returning-heading"> New vs returning (all time)</div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="newSub"><span class="marSing">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> New Subscribers </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="retSub"> <span class="retSt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Returning Subscribers </div>
                     </div>
                  </div>
               </div>
               <div id="newAndReturningSubscriber"></div>
            </div>
         </div>
         <!-- /new vs returning chart -->
      </div>
      <div class="col-lg-6">
         <div class="panel panel-flat">
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">

                     <div class="title-div">
                        License Statistics<br>
                        <span class="inner-title">of your domain
                     </div>
                     <div id="smallContainer">
                        <div class="small-chart">
                           <div id="accessPointsData" style="display:none"><?php echo json_encode($access_points); ?></div>
                           <div id="accessPoints"></div>
                        </div>
                        <div class="small-chart">
                           <div id="locationsData" style="display:none"><?php echo json_encode($locations_check) ?></div>
                           <div id="accessPsoints"></div>
                        </div>
                        <div class="small-chart">
                           <div id="subs_total" style="display:none">
                              <?php
                              $subscribers_count_per = ($subscribers_count / 20000) * 100;
                              echo json_encode(round($subscribers_count_per, 2));
                              ?>
                           </div>
                           <div id="accessPsasoints"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-flat">
            <div class="panel-heading">
               <h5 class="panel-title">Recent subscribers</h5>
            </div>
            <div class="panel-body"> List of last 5 subscribers for your business
               <code>This includes all of your locations in case of multiple</code>
            </div>
            <div class="table-responsive">
               <table class="table table-xs">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Registered on</th>
                        <th>Login count</th>
                        <th>Last Visited</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $domain_meta = get_domain_meta("domain_as_demo");
                     if (isset($subscribers_list)) {
                        foreach ($subscribers_list as $row) :
                           $date = $row->registered_on;
                           $date = explode(" ", $date);
                           $date  = $date[0];
                     ?>
                           <tr>
                              <td>
                                 <?php echo (empty($domain_meta)  || logged("role") == 1 || date("Y-m-d") == $date) ? $row->id : "****"; ?>
                              </td>
                              <td>
                                 <?php echo $row->name ?>
                              </td>
                              <td>
                                 <?php echo (empty($domain_meta)  || logged("role") == 1 || date("Y-m-d") == $date) ? $row->phone : "***********"; ?>
                              </td>
                              <td>
                                 <?php echo (empty($domain_meta)  || logged("role") == 1 || date("Y-m-d") == $date) ? $row->email : "****************"; ?>
                              </td>
                              <td>
                                 <?php echo $row->registered_on ?>
                              </td>
                              <td style="text-align:center">
                                 <?php echo (empty($domain_meta)  || logged("role") == 1 || date("Y-m-d") == $date) ? $row->login_count : "***" ?>
                              </td>
                              <td>
                                 <?php
                                 echo getTimeAgo($row->last_login_time);
                                 ?>
                              </td>
                           </tr>
                        <?php
                        endforeach;
                     } else {
                        ?>
                        <tr class="text-center">
                           <td colspan="7">No records found</td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
               <?php if (isset($subscribers_list)) { ?>
                  <div class="datatable-footer">
                     <div class="dataTables_paginate paging_simple_numbers"><a href="<?php echo url('panel/reports') ?>"><button type="button" class="btn bg-teal-400 btn-labeled"><b><i class="icon-stats-growth"></i></b>
                              View all</button></a>
                     </div>
                  </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var width = $('#myChart').width();
   var height = $('#myChart').height();
   $('#devicess').css("wight", width);
   $('#devicess').css("height", height);

   $(window).resize(function() {
      var width = $('#myChart').width();
      var height = $('#myChart').height();
      $('#devicess').css("wight", width);
      $('#devicess').css("height", height);

   });


   var height = $('#newAndReturningSubscriber').height();
   var h = window.innerHeight;
   if (h > 601) {
      $('#accessPoints').css("height", height);
      $('#accessPsoints').css("height", height);
      $('#accessPsasoints').css("height", height);
   }
   $(window).resize(function() {
      var height = $('#newAndReturningSubscriber').height();

      var h = window.innerHeight;
      if (h > 601) {
         $('#accessPoints').css("height", height);
         $('#accessPsoints').css("height", height);
         $('#accessPsasoints').css("height", height);
      } else {
         $('#accessPoints').css("height", 'auto');
         $('#accessPsoints').css("height", 'auto');
         $('#accessPsasoints').css("height", 'auto');
      }
   });
</script>
<script type="text/javascript" src="<?php echo $url->assets ?>chart/chart-config.js"></script>
<?php include viewPath('includes/footer'); ?>