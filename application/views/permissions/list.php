<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<!-- Main content -->
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="showMessage">
         <?php echo $this->session->flashdata('successMes');?>
      </div>
      <div class="page-title">
         <h1> Permissions
            <small>manage user permissions</small> 
         </h1>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Permissions </li>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<section class="">
   <!-- Default box -->
   <div class="box">
   <div class="box-header with-border">
      <h3 class="box-title"></h3>
      <div class="box-tools pull-right permission-btn">
         <?php if (hasPermissions('permissions_add')): ?>
         <a href="<?php echo url('permissions/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Permission</a>
         <?php endif ?>
         <!--  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
            title="Collapse">
            <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button> -->
      </div>
   </div>
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">List of Permissions</h5>
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
      <div class="panel-body">
      </div>
      <div class="table-responsive">
         <table  class="table table-xs">
            <thead>
               <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($permissions as $row): ?>
               <tr>
                  <td width="60"><?php echo $row->id ?></td>
                  <td>
                     <?php echo $row->title ?>
                  </td>
                  <td>
                     <?php echo $row->code ?>
                  </td>
                  <td>
                     <ul class="icons-list">
                        <?php if (hasPermissions('permissions_edit')): ?>
                        <li class="text-primary-600">
                           <a href="<?php echo url('permissions/edit/'.$row->id) ?>" title="Edit Permission"><i class="icon-pencil7"></i></a>
                        </li>
                        <?php endif ?>    
                        <?php if (hasPermissions('permissions_delete')): ?>
                        <li class="text-danger-600">
                           <a href="<?php echo url('permissions/delete/'.$row->id) ?>" onclick="return confirm('Do you really want to delete this permissions ? \nIt may cause errors where it is currently being used !!')" title="Delete Permission" data-toggle="tooltip"><i class="icon-trash"></i></a>
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
   <!-- /.box-footer-->
   <!-- /.box -->
</section>
<!-- /.content -->
<?php include viewPath('includes/footer'); ?>
<script>
   // $('#dataTable1').DataTable()
</script>