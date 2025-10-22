<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->

<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4>  Activity Logs
      <small>manage activity logs</small></h4>
      </div>
   </div>
 <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Activity Logs</li>
      </ul>
	   <ul class="breadcrumb-elements">
         <li><a class="bg-teal-400" href="<?php echo url('activity_logs') ?>"><i class=" icon-arrow-left52 position-left"></i> Go back to activity log </a></li>
      </ul>
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