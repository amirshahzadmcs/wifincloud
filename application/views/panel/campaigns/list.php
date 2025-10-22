<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class=" icon-feed position-left"></i> <span class="text-semibold">Manage Campaigns</span> - List
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Campaigns list</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('add_campaign') && $globelDomain->domainId) : ?>
            <li><a class="bg-teal-400" href="<?php echo url('panel/campaigns/add'); ?>"><i class="icon-add position-left"></i> Add new campaign</a></li>
         <?php endif ?>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <?php
   ?>
   <?php if (isset($campaigns_list)) : ?>

      <div class="panel panel-flat">
         <div class="panel-heading">
            <h5 class="panel-title">Campaigns</h5>
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
         <div class="panel-body"> List of all campagins for your business <code>You can run only one campaign at a time.</code>
         </div>
         <div class="table-responsive">
            <table class="table table-xs">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Campaign name</th>
                     <th>Start date</th>
                     <th>End date</th>
                     <th>Status</th>
                     <th>Campaign type</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ($campaigns_list as $row) :
                     //check if the start time of campaign is in past
                     $currentDatetime = new DateTime();

                     $startDatetime = new DateTime($row->start_datetime);
                     $humanReadableStartDate = $startDatetime->format('F j, Y h:i a');

                     $endDatetime = new DateTime($row->end_datetime);
                     $humanReadableEndDate = $endDatetime->format('F j, Y h:i a');

                  ?>

                     <tr>
                        <td>
                           <?php echo $row->id ?>
                        </td>
                        <td>
                           <?php echo $row->campaign_name; ?>
                        </td>
                        <td>
                           <?php echo $humanReadableStartDate; ?>
                        </td>
                        <td>
                           <?php echo $humanReadableEndDate; ?>
                        </td>
                        <?php

                        //flag or campaigns in progress
                        $campaign_in_progress = 0;
                        if ($currentDatetime > $startDatetime) {
                           $campaign_in_progress = 1;
                        }
                        //flag for campaign already launched or end time is in past
                        $past_campaign = 0;
                        if ($currentDatetime > $endDatetime) {
                           $past_campaign = 1;
                        }
                        ?>
                        <td>
                           <?php
                           if (($currentDatetime > $startDatetime) && ($currentDatetime < $endDatetime)) {
                              echo '<div class="label bg-blue pulse_anim"><span class="live_anim"></span> Live</div>';
                           } else if (($currentDatetime < $startDatetime)) {
                              echo '<div class="label bg-pink">Scheduled</div>';
                           } else if (($endDatetime < $currentDatetime)) {
                              echo '<div class="label bg-success">Ended</div>';
                           }
                           ?>
                        </td>
                        <td>
                           <?php echo $row->campaign_type ?>
                        </td>
                        <td>
                           <ul class="icons-list">
                              <?php if ($past_campaign == 0) { ?>
                                 <li class="text-primary-600"><a href="<?php echo url('panel/campaigns/questionnaire/' . $row->id); ?>" title="Edit questionnaire"><i class="icon-pencil7"></i></a></li>

                                 <li class="">
                                    <a href="<?php echo url('panel/campaigns/edit/' . $row->id) . '/' ?>" title="Campaign settings" data-toggle="tooltip"><i class="icon-gear"></i></a>
                                 </li>
                                 <?php if ($campaign_in_progress != 0) { ?>
                                    <li>
                                       <a class="label label-flat border-success text-success-600 position-center" href="<?php echo url('panel/campaigns/report/' . $row->id) . '/' ?>"><i class="icon-statistics"></i> Live Report</a>
                                    </li>
                                 <?php } ?>

                                 <?php if (hasPermissions('delete_campaign') && $campaign_in_progress == 0) { ?>
                                    <li class="text-danger-600">
                                       <a href="<?php echo url('panel/campaigns/delete/' . $row->id) . '/' ?>" onclick="return confirm('Do you really want to delete this campaign? It will delete all its settings & questionnaire')" title="Delete Campaign & its data" data-toggle="tooltip"><i class="icon-trash"></i></a>
                                    </li>
                                 <?php }
                              } else { ?>
                                 <a class="label label-flat border-success text-success-600 position-center" href="<?php echo url('panel/campaigns/report/' . $row->id) . '/' ?>"><i class="icon-statistics"></i> View report</a>
                              <?php } ?>
                           </ul>
                           <?php

                           ?>


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
<!-- /.content -->
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>

<script>
   window.updateCampaignStatus = (id, status, domain_id) => {
      $.get('<?php echo url('panel/campaigns/change_status') ?>/' + id + '/' + domain_id, {
         status: status
      }, (data, status) => {
         if (data == 'done') {
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