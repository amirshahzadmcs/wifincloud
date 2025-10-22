<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-earth position-left"></i>  Permissions
      <small>manage permissions</small></h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Domains list</li>
      </ul>
	  <ul class="breadcrumb-elements">
            <li><a class="bg-teal-400" href="<?php echo base_url()?>permissions "><i class=" icon-arrow-left52 position-left"></i> Go back to permissions</a></li>
        </ul>
   </div>
</div>
<!-- Main content -->
<section class="" >
   <div class="panel panel-flat" style="padding:18px 38px 21px 21px;">
      <div class="panel-heading">

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
		
      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Edit Permission</h3>

              
         <?php echo form_open('permissions/update/'.$permission->id, [ 'class' => 'form-validate' ]); ?>
         <div class="box-body" >
            <div class="form-group">
               <label for="formClient-Name">Name</label>
               <input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Name" value="<?php echo $permission->title ?>" autofocus />
            </div>
            <div class="form-group">
               <label for="formClient-Code">Code</label>
               <input type="text" class="form-control" data-rule-remote="<?php echo url('permissions/checkIfUnique?notId='.$permission->id) ?>" name="code" id="formClient-Code" required placeholder="Enter Code" value="<?php echo $permission->code ?>" />
               <p style="color: red;">* code must be unique</p>
            </div>
         </div>
         <!-- /.box-body -->
         <div class="box-footer">
            <button type="submit" class="btn bg-teal-400">Submit <i class="icon-arrow-right14 position-right"></i></button>
         </div>
         <!-- /.box-footer-->
         <?php echo form_close(); ?>
      </div>
   </div>
   <!-- /.box -->
</section>
<!-- /.content -->
<script>
   
   
</script>
<?php include viewPath('includes/footer'); ?>
<script>
   //Initialize Select2 Elements
   $('.select2').select2()
</script>