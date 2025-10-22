<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-lock position-left"></i> <span class="text-semibold">Manage User Roles</span> - Add</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Add new role</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('roles_list')): ?>
         <li><a class="bg-teal-400" href="<?php echo url('roles') ?>"><i class=" icon-arrow-left52 position-left"></i> Go back to roles</a></li>
         <?php endif ?>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <!-- Default box -->
   <div class="box">
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
        
         <div class="box-body add-role-container">
			<?php echo form_open('roles/save', [ 'class' => 'form-validate' ]); ?>
            <div class="form-group">
               <label for="formClient-Name">Name</label>
               <input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Name" autofocus />
            </div>
            <div class="form-group">
               <label for="formClient-Table">Permission</label>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="table-responsive">
                        <table class="table table-xs">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th width="50" class="text-center"><input type="checkbox" class="check-select-all-p"></th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if (!empty($permissions = $this->permissions_model->get())): ?>
                              <?php foreach ($permissions as $row): ?>
                              <tr>
                                 <td><?php echo ucfirst($row->title) ?></td>
                                 <td width="50" class="text-center"><input type="checkbox" class="check-select-p" name="permission[]" value="<?php echo $row->code ?>"></td>
                              </tr>
                              <?php endforeach ?>
                              <?php else: ?>
                              <td colspan="2" class="text-center">No Permissions Found</td>
                              </tr>
                              <?php endif ?>
                           </tbody>
                        </table>
                     </div>
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
      </div>
   </div>
   <!-- /.box -->
</section>
<!-- /.content -->
<script></script>
<?php include viewPath('includes/footer'); ?>
<script>
   //Initialize Select2 Elements
   $('.select2').select2()
</script>