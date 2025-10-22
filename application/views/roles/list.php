<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-lock position-left"></i> <span class="text-semibold">Manage User Roles</span> - List</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">List of roles</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('roles_add')): ?>
         <li><a class="bg-teal-400" href="<?php echo url('roles/add') ?>"><i class="icon-add position-left"></i> New user role</a></li>
         <?php endif ?>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">User Roles</h5>
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
      <div class="panel-body"> List of all user roles </div>
      <div class="table-responsive">
         <table class="table table-xs">
            <thead>
               <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($roles as $row): ?>
               <tr>
                  <td width="60"><?php echo $row->id ?></td>
                  <td>
                     <?php echo $row->title ?>
                  </td>
                  <td>
                     <?php if (hasPermissions('roles_edit')): ?>
                     <ul class="icons-list">
                        <li class="text-primary-600"><a href="<?php echo url('roles/edit/'.$row->id) ?>" class="" title="Edit User Role" data-toggle="tooltip"><i class="icon-pencil7"></i></a></li>
                     </ul>
                     <?php endif; ?>
                  </td>
               </tr>
               <?php endforeach ?>
            </tbody>
         </table>
      </div>
   </div>
</section>
<!-- /.content -->
<?php include viewPath('includes/footer'); ?>
<script>
</script>