<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<div class="page-header">
   <div class="page-header-content" style="margin-left: 10px;">
      <div class="page-title">
         <h4>Company Settings</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component " style="margin: 0px 12px 22px 8px;">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Settings</a></li>
         <li class="active">Company Settings</li>
      </ul>
   </div>
</div>
<!-- Main content -->
<section class="content">

  <div class="row">
<div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title"> &nbsp;</h5>
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
      <div class="panel-body">
    <div class="col-sm-3">

      <?php include 'sidebar.php'; ?>

    </div>
    <div class="col-sm-9">

      <!-- Default box -->
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Company Settings</h3>
        </div>

        <?php echo form_open_multipart('settings/companyUpdate', [ 'class' => 'form-validate', 'autocomplete' => 'off', 'method' => 'post' ]); ?>
        <div class="box-body">

          <div class="form-group">
            <label for="formSetting-Company-Name">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="formSetting-Company-Name" value="<?php echo setting('company_name') ?>" required placeholder="Enter Company Name" autofocus />
          </div>

          <div class="form-group">
            <label for="formSetting-Company-Email">Company Email</label>
            <input type="text" class="form-control" name="company_email" id="formSetting-Company-Email" value="<?php echo setting('company_email') ?>" required placeholder="Enter Company Email" autofocus />
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
        <button type="submit" class="btn bg-teal-400">Submit <i class="icon-arrow-right14 position-right"></i></button>
        </div>
        <!-- /.box-footer-->

        <?php echo form_close(); ?>

      </div>
      <!-- /.box -->

    </div>
  </div>
  </div>
  </div>

</section>
<!-- /.content -->

<script>

  function previewImage(input, previewDom) {

    if (input.files && input.files[0]) {

      $(previewDom).show();

      var reader = new FileReader();

      reader.onload = function(e) {
        $(previewDom).find('img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }else{
      $(previewDom).hide();
    }

  }
</script>

<?php include viewPath('includes/footer'); ?>

