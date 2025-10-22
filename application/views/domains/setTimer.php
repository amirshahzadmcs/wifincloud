<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script> -->
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-earth position-left"></i> <span class="text-semibold">Manage Timer</span> - Add</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Add Timer</li>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Add Timer </h5>
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
         <p class="content-group-lg">Change below entries and press submit.
         </p>
         <?php echo form_open_multipart('domains/timer', [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>
         <fieldset class="content-group">
            <legend class="text-bold">Timer</legend>
            <div class="row">
               <div class="col-md-12">
					<?php if(isset($successMes) && !empty( $successMes )){ ?>
						<div class="alert alert-success" role="alert">
							<?php echo $successMes; ?>
						</div>
					<?php } ?>
			   </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Name">Start Time</label>
                     <input type="time" class="form-control" name="start" id="formClient-Name" required
                        placeholder="Enter Name" value="<?php echo (isset($timer->start))? $timer->start : ''; ?>"  autofocus />
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Machinename">End Time</label>
                     <input type="time" class="form-control" name="end" id="formClient-Machinename"
                        placeholder="" value="<?php echo (isset($timer->end))? $timer->end : ''; ?>"  />
                  </div>
               </div>
            </div>
			 <div class="row">
               <div class="col-md-12" style="margin-top:20px;">
                  <button type="submit" class="btn btn-primary">Submit <i
                     class="icon-arrow-right14 position-right"></i></button>
               </div>
            </div>
         </fieldset>
         <?php echo form_close(); ?>
         <!--                    </form>-->
      </div>
   </div>
</section>
<!-- /.content -->
<script>
   $(document).ready(function() {
       $('.form-validate').validate();
       //Initialize Select2 Elements
       // $('.select2').select2()
   })
   
   function previewImage(input, previewDom) {
       if (input.files && input.files[0]) {
           $(previewDom).show();
           var reader = new FileReader();
           reader.onload = function(e) {
               $(previewDom).find('img').attr('src', e.target.result);
           }
           reader.readAsDataURL(input.files[0]);
       } else {
           $(previewDom).hide();
       }
   }
</script>
<?php include viewPath('includes/footer'); ?>