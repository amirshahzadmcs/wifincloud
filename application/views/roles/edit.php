<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-lock position-left"></i>  Roles
      <small>manage roles</small></h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Edit Role</li>
      </ul>
	  <ul class="breadcrumb-elements">
		<li><a class="bg-teal-400" href="<?php echo url('roles') ?> "><i class=" icon-arrow-left52 position-left"></i> Go back to roles</a></li>
	</ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class=" " >
   <!-- Default box -->
      
	   <div class="box">
	   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Edit Role</h5>
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
		  <div class="box-header with-border">

		  <?php echo form_open('roles/update/'.$role->id, [ 'class' => 'form-validate' ]); ?>
		  <div class="box-body" style="padding:56px 13px 14px 19px;">
			 <div class="form-group">

				<input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Name" autofocus value="<?php echo $role->title ?>" />
			 </div>
			 <div class="form-group">
				<label for="formClient-Table">Permission</label>
				<div class="row">
				   <div class="col-sm-6">
					  <table class="table table-xs">
						 <thead>
							<tr>
							   <th>Name</th>
							   <th width="50" class="text-center"><input type="checkbox" class="check-select-all-p"></th>
							</tr>
						 </thead>
						 <tbody>
							<tr>
							   <?php if (!empty($permissions = $this->permissions_model->get())): ?>
							   <?php foreach ($permissions as $row): ?>
							   <td><?php echo ucfirst($row->title) ?></td>
							   <?php 
								  $isChecked = in_array($row->code, $role_permissions) ? 'checked' : '';
								  ?>
							   <td width="50" class="text-center"><input type="checkbox" class="check-select-p" name="permission[]" value="<?php echo $row->code ?>" <?php echo $isChecked ?>></td>
							</tr>
							<?php endforeach ?>
							<?php else: ?>
							<tr>
							   <td colspan="2" class="text-center">No Permissions Found</td>
							</tr>
							<?php endif ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
		  <!-- /.box-body -->
		  <div class="box-footer" style="padding:6px 13px 14px 19px;">
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
   $(document).ready(function() {

   
     $('.check-select-all-p').on('change', function() {
   
       $('.check-select-p').attr('checked', $(this).is(':checked'));
       
     })
   
     var checked = true;
     $('.check-select-p').each(function() {
   
       if(!$(this).is(':checked'))
         checked = false;
   
         return checked;
   
     });
   
     if(checked){
       $('.check-select-all-p').attr('checked', true);
     }
   
   
   })
   
</script>
<?php include viewPath('includes/footer'); ?>
<script>
   //Initialize Select2 Elements
   $('.select2').select2()
</script>