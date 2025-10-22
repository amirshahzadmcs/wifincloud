<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->

<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h1>  Domain Logs</h1>
      </div>
   </div>
 <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Domain Logs</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('add_access_point') && $globelDomain->domainId): ?>
         <li><a class="bg-teal-400" href="<?php  echo url('domains/activity_logs');?>"><i class="icon-arrow-left5"></i> Back to domain</a></li>
         <?php endif ?>
      </ul>
   </div>
   
</div>
<!-- Main content -->

<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Log</h5>
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
      <div class="panel-body"><code>You cann't delete this data</code></div>
   <div class="box">

      <div class="box-body" >
         <table class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
               <tr>
                  <td width="150">Id: </td>
                  <td><?php echo $activity->id ?></td>
               </tr>
               <tr>
                  <td>Message: </td>
                  <td><?php echo $activity->title ?></td>
               </tr>
               <tr>
                  <td>User: </td>
                  <?php $User = $this->users_model->getById($activity->user) ?>
                  <td><?php echo $activity->user > 0 ? $User->name : '' ?> <a href="<?php echo url('users/view/'.$User->id) ?>" target="_blank"><i class="fa fa-eye"></i></a></td>
               </tr>
               <tr>
                  <td>Date Time: </td>
                  <td><?php echo date('h:m a - d M, Y', strtotime($activity->created_at)) ?></td>
               </tr>
            </tbody>
         </table>
      </div>
      </div>
      <!-- /.box-body -->
   </div>
</section>
<?php include viewPath('includes/footer'); ?>