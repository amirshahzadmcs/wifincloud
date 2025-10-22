<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4>Login Settings</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component " style="margin: 0px 12px 22px 8px;">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Settings</a></li>
         <li class="active">Login Settings</li>
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
          <h3 class="box-title">Login Settings</h3>
        </div>

        <?php echo form_open_multipart('settings/loginthemeUpdate', [ 'class' => 'form-validate', 'autocomplete' => 'off', 'method' => 'post' ]); ?>
        <div class="box-body">

          <div class="form-group">
            <label for="login_theme">Login Theme</label>
            <div class="row text-center">
              <div class="col-sm-6">
                <label for="formSetting-Login-Theme-1">
                  <img src="<?php echo $url->assets ?>/img/Theme_1.png" style="border: 1px solid #eee;" width="100%" />
                  <input type="radio" name="login_theme" id="formSetting-Login-Theme-1" <?php echo setting('login_theme')=='1' ? 'checked' : '' ?> value="1" required />
                </label>
              </div>
              <div class="col-sm-6">
                <label for="formSetting-Login-Theme-2">
                  <img src="<?php echo $url->assets ?>/img/Theme_2.png" style="border: 1px solid #eee;" width="100%" />
                  <input type="radio" name="login_theme" id="formSetting-Login-Theme-2" <?php echo setting('login_theme')=='2' ? 'checked' : '' ?> value="2" required />
                </label>
              </div>
            </div>

            <div class="form-group">
              <label for="formClient-Image">Background Image</label>
              <input type="file" class="form-control" name="image" id="formClient-Image" placeholder="Upload Image" accept="image/*" onchange="previewImage(this, '#imagePreview')">
            </div>
            <div class="form-group" id="imagePreview">
              <img src="<?php echo urlUpload('/login-bg.'.setting('bg_img_type'), true); ?>" alt="Uploaded Image Preview" width="100" height="100">
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
      <!-- /.box -->

    </div>
  </div>
  </div>
  </div>

</section>
<!-- /.content -->

<script>
  $(document).ready(function() {
      //Initialize Select2 Elements
    $('.select2').select2()

  })

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

