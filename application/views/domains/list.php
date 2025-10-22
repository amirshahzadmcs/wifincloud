<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-earth position-left"></i> <span class="text-semibold">Manage Domains</span> - List</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Domains list</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('add_domains')): ?>
            <li><a class="bg-teal-400" href="<?php echo url('domains/add') ?>"><i class="icon-add position-left"></i> Add
                  new domain</a></li>
         <?php endif ?>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Domains</h5>
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
      <div class="panel-body"> List of all domains registered on admin panel that you can manage</div>
      <div class="table-responsive">
         <table class="table table-xs">
            <thead>
               <tr>
                  <th>Domain name</th>
                  <?php if (logged("role") == 1): ?>
                     <!-- <th>Domain db name</th> -->
                  <?php endif; ?>
                  <th>Status</th>
                  <th>Approval</th>
                  <th>Allowed AP</th>
                  <th>Allowed Locations</th>
                  <!-- <th>Registration Date</th> -->
                  <!-- <th>Updated on</th> -->
                  <th>License Expiry</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               foreach ($domains as $row): ?>
                  <?php
                  //checking if admin or has the permission to current domain
                  if (hasPermissions('manage_own_domain') || logged("role") == 1):

                     //checking if owner of the current domain
                     if (logged("role") != 1 && $row->users_id != logged("id")):
                        continue;
                     endif;
                     ?>
                     <tr>
                        <td>
                           <?php echo $row->domain_name ?>
                        </td>
                        <?php if (logged("role") == 1): ?>
                           <!-- <td>
                     <?php //echo $row->domain_db_name   ?>
                  </td> -->
                        <?php endif; ?>
                        <td>
                           <?php if (hasPermissions('manage_own_domain')): ?>

                              <div class="switchery-xs">
                                 <input type="checkbox" class="switchery js-switch"
                                    onchange="updateDomainStatus('<?php echo $row->id ?>', $(this).is(':checked') )" <?php echo ($row->status) ? 'checked' : '' ?> />
                              </div>



                           <?php endif ?>
                        </td>
                        <td>
                           <?php if ($row->approved == 0): ?> <span class="label label-danger">Pending</span>
                           <?php else: ?> <span class="label label-flat border-success text-success-600">Approved</span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php echo $row->no_of_ap ?>
                        </td>
                        <td>
                           <?php echo $row->no_of_locations ?>
                        </td>
                        <!-- <td>
                     <?php //echo $row->created_at   ?>
                  </td> -->
                        <td>
                           <?php 
                              $expiryDate = $row->license_expiry_date;
                              $data =  licenceDateColor($expiryDate);
                              $color = (isset($data['color']))? $data['color'] : 'Data Not Available';
                           ?>
                           <span class="label label-flat border-<?php echo $color; ?> text-<?php echo $color; ?>-600">
                              <?php echo (isset($data['date']))? ucfirst($data['date']) : "Data Not Available" ?>
                           </span>
                        </td>
                        <td>
                           <ul class="icons-list">
                              <?php if (hasPermissions('manage_own_domain')): ?>
                                 <!-- <li class="text-primary-600" disabled ><a href="<?php if ($globelDomain->domainId == $row->id) {
                                    echo url('domains/edit/' . $row->id);
                                 } else {
                                    echo "#";
                                 } ?>" <?php if ($globelDomain->domainId != $row->id) { ?> data-popup="tooltip" title="" data-placement="top" id="right" data-original-title="Choose domain first"  <?php } ?>><i class="icon-pencil7"></i></a></li> -->
                                 <li class="text-primary-600"><a href="<?php echo url('domains/edit/' . $row->id) ?>"
                                       title="Edit Domain"><i class="icon-pencil7"></i></a></li>
                              <?php endif ?>
                              <?php if (hasPermissions('domains_list')): ?>
                                 <!-- <li class="text-teal-600"><a href="<?php echo url('domains/view/' . $row->id) ?>" title="View Domain"><i class="icon-cog7"></i></a></li> -->
                              <?php endif ?>
                           </ul>
                        </td>
                     </tr>
                  <?php endif; ?>
               <?php endforeach ?>
            </tbody>
         </table>
      </div>
   </div>
   <!-- Default box -->
</section>
<!-- /.content -->
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
<script>

   // Switchery toggle
   var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
   elems.forEach(function (html) {
      var switchery = new Switchery(html);
   });
</script>
<script>
   //                $('#dataTable1').DataTable();
   //                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
   //                elems.forEach(function (html) {
   //                    var switchery = new Switchery(html, {
   //                        size: 'small'
   //                    });
   //                });
   window.updateDomainStatus = (id, status) => {
      $.get('<?php echo url('domains/change_status') ?>/' + id, {
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