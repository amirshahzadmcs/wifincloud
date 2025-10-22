<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4>Email Templates</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component " style="    margin: 0px 20px 22px 19px;">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Settings</a></li>
         <li class="active">Email Templates</li>
      </ul>
	  <ul class="breadcrumb-elements">
         <li><a class="bg-teal-400" href="<?php echo url('settings/email_templates') ?>"><i class=" icon-arrow-left52 position-left"></i>  Go back to email templates</a></li>
      </ul>
   </div>
</div>
<!-- Main content -->
<section class="content">
   <div class="panel panel-flat" style="padding: 5px 30px 32px 21px;">
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
  <div class="row">

    <div class="col-sm-3">

      <?php include VIEWPATH.'/settings/sidebar.php'; ?>

    </div>
    <div class="col-sm-9">

      <!-- Default box -->
      <div class="box">
        <div class="box-tools pull-right email-temlate" style="    margin: 0px 20px 22px 19px;">
          </div>
        <?php echo form_open_multipart('settings/update_email_templates/'.$template->id, [ 'class' => 'form-validate', 'autocomplete' => 'off', 'method' => 'post' ]); ?>

        <div class="box-header with-border">
          <h3 class="box-title">Email Templates</h3>
         
         

        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="Code"> Code</label>
            <input type="text" class="form-control" readonly name="code" id="Code" value="<?php echo $template->code ?>" required placeholder="Enter Code" />
          </div>

          <div class="form-group">
            <label for="Name"> Name</label>
            <input type="text" class="form-control" name="name" id="Name" value="<?php echo $template->name ?>" required placeholder="Enter Name" autofocus />
          </div>

          <div class="form-group">
            <label for="Data"> Template</label>
            <textarea name="data" rows="40" id="Data"><?php echo $template->data ?></textarea>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
        <button type="submit" class="btn bg-teal-400">Submit <i class="icon-arrow-right14 position-right"></i></button>
          <a href="<?php echo url('settings/email_templates') ?>" class="btn btn-default btn-danger pull-right">Cancel</a>
        </div>
        <!-- /.box-footer-->

        <?php echo form_close(); ?>

      </div>
      <!-- /.box -->

    </div>
  </div>
  </div>

</section>
<!-- /.content -->


<?php include viewPath('includes/footer'); ?>

<!-- CK Editor -->
