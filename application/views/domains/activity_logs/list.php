<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>

<!-- Content Header (Page header) -->
	<div class="page-header">
	   <div class="page-header-content">
		   <div class="showMessage">
			  <?php echo $this->session->flashdata('successMes');?>
		   </div>
		  <div class="page-title">
			 <h1>Domain Logs </h1>
		  </div>
	   </div>
	   <div class="breadcrumb-line breadcrumb-line-component">
		  <ul class="breadcrumb">
			 <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
			 <li class="active">Domain Logs</li>
		  </ul>
		  <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
     
	   </div>
     
	</div>

<!-- Main content -->
<section class="">

  <!-- Default box -->
  <div class="box">
	
    <div class="box-body">
<div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title"> List of All Activites</h5>
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
	  <div class="panel-body"> List of all domains registered on admin panel that you can manage</div>
	  <div class="table-responsive">
	  <table id="dataTable1" class="table table-xs">
        <thead>
          <tr>
            <th>Id</th>
            <th>IP Address</th>
            <th>Message</th>
            <th>Date Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($activity_logs as $row): ?>
            <tr>
              <td width="60"><?php echo $row->id ?></td>
              <td><?php echo !empty($row->ip_address)?'<a href="'.url('activity_logs/index?ip='.urlencode($row->ip_address)).'">'.$row->ip_address.'</a>':'N.A' ?></td>
              <td>
                <a href="<?php echo url('domains/activityView/'.$row->id) ?>"><?php echo $row->title ?></a>
              </td>
              <td><?php echo date( setting('datetime_format') , strtotime($row->created_at)) ?></td>
              <td>

              <ul class="icons-list">
              <?php if (hasPermissions('manage_own_domain')): ?>
                  <li class="text-primary-600">
                      <a href="<?php echo url('domains/activityView/'.$row->id) ?>" title="View Activity"><i class="icon-file-eye2"></i></a>
                  </li>
                  <?php if (hasPermissions('activity_log_view')): ?>
                    <li class="">
                      <a href="<?php echo url('users/view/'.$row->user) ?>"  title="View User"  target="_blank" data-toggle="tooltip"><i class="icon-user"></i></a>
                    </li>
                <?php endif ?>
                <?php endif ?>
             </ul>
              
                

              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
      <div class="panel-body">
<!--      <div class="row">
        <div class="col-sm-12">
            <?php echo form_open('activity_logs', ['method' => 'GET', 'autocomplete' => 'off']); ?> 
            <div class="row">

                <div class="col-sm-2">
                  <div class="form-group">
                    <p style="margin-top: 20px"><strong>Filter :</strong> </p>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Filter-IpAddress">Ip Address </label>
                    <span class="pull-right"><a href="#" onclick="event.preventDefault(); $('#Filter-IpAddress').val('').trigger('onchange')">clear</a></span>
                    <input type="text" name="ip" id="Filter-IpAddress" onchange="$(this).parents('form').submit();" class="form-control" value="<?php echo get('ip') ?>" placeholder="Search by Ip Addres" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Filter-User">User</label>
                    <span class="pull-right"><a href="#" onclick="event.preventDefault(); $('#Filter-User').val('').trigger('onchange')">clear</a></span>
                    <select name="user" id="Filter-User" onchange="$(this).parents('form').submit();" class="form-control select2">
                      <option value="">Select User</option>
                      <?php foreach ($this->users_model->get() as $row): ?>
                        <?php $sel = (get('user')==$row->id)?'selected':'' ?>
                        <option value="<?php echo $row->id ?>" <?php echo $sel ?>><?php echo $row->name ?> #<?php echo $row->id ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group" style="margin-top: 25px;">
                    <a href="<?php echo url('/activity_logs') ?>" class="btn btn-danger">Reset</a>
                  </div>
                </div>

            </div>

          <?php echo form_close(); ?>
          
        </div>
      </div>
                      -->
      
	</div>
    </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->

<?php include viewPath('includes/footer'); ?>

<script>


</script>