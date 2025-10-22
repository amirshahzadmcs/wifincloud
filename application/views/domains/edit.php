<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script> -->
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-earth position-left"></i> <span class="text-semibold">Manage Domains</span> - Edit</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Edit domain</li>
      </ul>
      <ul class="breadcrumb-elements">
         <li><a class="bg-teal-400" href="<?php echo url('domains') ?>"><i class=" icon-arrow-left52 position-left"></i>
               Go back to
               domains</a>
         </li>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">Edit
            <?php echo $domain->domain_name ?>'s details
         </h5>
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
            <code>You can not change the machine name</code>
         </p>
         <?php echo form_open_multipart('domains/update/' . $domain->id, ['class' => 'form-validate', 'autocomplete' => 'off']); ?>
         <fieldset class="content-group">
            <legend class="text-bold">Basic details</legend>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Name">Domain name</label>
                     <input type="text" class="form-control" name="name" id="formClient-Name" required
                        placeholder="Enter Name" value="<?php echo $domain->domain_name ?>" autofocus />
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Machinename">Machine name</label>
                     <input type="text" class="form-control" name="machin" id="formClient-Machinename" placeholder=""
                        disabled value="<?php echo $domain->domain_db_name ?>" />
                  </div>
               </div>
            </div>
         </fieldset>
         <fieldset class="content-group">
            <legend class="text-bold">Other details</legend>
            <div class="row">
               <?php
               //checking if admin 
               if (logged("role") == 1):
                  ?>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="formClient-Owner">Domain owner</label>
                        <select name="owner_role" id="formClient-Owner" class="form-control select2" required>
                           <option value="">Select Domain Owner</option>
                           <?php foreach ($this->users_model->get() as $row): ?>
                              <?php $sel = !empty($domain->users_id) && $domain->users_id == $row->id ? 'selected' : '' ?>
                              <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                                 <?php echo $row->name ?>
                              </option>
                           <?php endforeach ?>
                        </select>
                     </div>
                  </div>
               <?php endif; ?>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-Status">Status</label>
                     <select name="status" id="formClient-Status" class="form-control">
                        <?php $sel = $domain->status == 1 ? 'selected' : '' ?>
                        <option value="1" <?php echo $sel ?>>Active</option>
                        <?php $sel = $domain->status == 0 ? 'selected' : '' ?>
                        <option value="0" <?php echo $sel ?>>InActive</option>
                     </select>
                  </div>
               </div>
               <?php
               //allowed only for super admins
               if (logged("role") == 1):
                  ?>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="formClient-locations">Total Locations</label>
                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" name="locations"
                           id="formClient-locations" required placeholder="Enter number of allowed locations"
                           value="<?php echo $domain->no_of_locations ?>" />
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="formClient-ap">Total Access Points</label>
                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" name="access_points"
                           id="formClient-ap" required placeholder="Enter number of allowed Access points"
                           value="<?php echo $domain->no_of_ap ?>" />
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="form-group">
                           <label for="formClient-Approval">Approval</label>
                           <select name="approval_domain" id="formClient-Approval" class="form-control">
                              <?php $sel = $domain->approved == 1 ? 'selected' : '' ?>
                              <option value="1" <?php echo $sel ?>>Approved</option>
                              <?php $sel = $domain->approved == 0 ? 'selected' : '' ?>
                              <option value="0" <?php echo $sel ?>>Not Approved</option>
                           </select>
                        </div>
                     </div>
                  </div>
                 
                  <?php $domain_meta = get_domain_meta("domain_as_demo"); ?>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="formClient-Approval">Is demo</label>
                        <div class="checkbox">
                           <div class="switchery-xs sms-status">

                              <input type="checkbox" value="domain_as_demo" <?php echo (!empty($domain_meta)) ? "checked='checked'" : "" ?> id="domain_as_demo" class="switchery landding-page-check-box"
                                 name="domain_as_demo">
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php
               endif;
               ?>
            </div>
         </fieldset>
         <fieldset class="content-group">
            <legend class="text-bold">License</legend>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-ap">License Activation Date</label>
                     <input type="text" class="form-control daterange-left" name="license_activation_date"
                        id="formClient-ap" placeholder="Pick a date for license activation"
                        value="<?php echo !is_null($domain->license_activation_date) && $domain->license_activation_date !== '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($domain->license_activation_date)) : ''; ?>" />

                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="formClient-ap">License Expiry Date</label>
                     <input type="text" class="form-control daterange-left" name="license_expiry_date"
                        id="formClient-ap" placeholder="Pick a date for license expiry"
                        value="<?php echo !is_null($domain->license_expiry_date)  && $domain->license_expiry_date !== '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($domain->license_expiry_date)) : ''; ?>" />
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="emails_to_send">Emails to send </label>
                     <input type="text" class="form-control" name="emails_to_send" id="emails_to_send" value="<?php echo isset($domain->emails_to_send)? $domain->emails_to_send : '' ?>" required placeholder="example1@email.com, example2@email.com" />
                  </div>
                 
               </div>
               <div class="col-md-6">
                  <div class="form-group domain_expiry_email">
                     <?php $email_expiry =  setting('domain_expiry_email') ?>
                     <label for="formSetting-domain_expiry_email">Emails for expiry domain</label>
                     <select class="form-control" name="domain_expiry_email">
                        <option value="weekly" <?php echo (isset($domain->email_expiry) && $domain->email_expiry == 'weekly') ? 'selected="selected"' : ''; ?>>weekly</option>
                           <option value="monthly"  <?php echo (isset($domain->email_expiry) && $domain->email_expiry == 'monthly') ? 'selected="selected"' : ''; ?> >Monthly</option>
                     </select>
                  </div>
               </div>
            </div>
         </fieldset>
         <fieldset class="content-group">
            <div class="row">
               <div class="col-md-12" style="margin-top:20px;">
                  <button type="submit" class="btn bg-teal-400">Submit <i
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
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
<script>

   $(document).ready(function () {
   });

   var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
   elems.forEach(function (html) {
      var switchery = new Switchery(html);
   });
   $(document).ready(function () {
      $('.form-validate').validate();
      //Initialize Select2 Elements
      // $('.select2').select2()

      //activation date 
      $('input[name="license_activation_date"]').daterangepicker({
         singleDatePicker: true,
         startDate: function () {
            var inputValue = $('input[name="license_activation_date"]').val();
            if (inputValue !== '') {
               return moment(inputValue, 'DD/MM/YYYY');
            } else {
               return null;
            }
         },
         autoUpdateInput: false,
         locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
         }
         //maxYear: parseInt(moment().format('YYYY'), 10)
      });

      $('input[name="license_activation_date"]').on('apply.daterangepicker', function (ev, picker) {
         $(this).val(picker.startDate.format('DD/MM/YYYY'));
      });

      $('input[name="license_activation_date"]').on('cancel.daterangepicker', function (ev, picker) {
         $(this).val('');
      });


      //expiry date date 
      $('input[name="license_expiry_date"]').daterangepicker({
         singleDatePicker: true,
         
         startDate: function () {
            var inputValue = $('input[name="license_expiry_date"]').val();
            if (inputValue !== '') {
               return moment(inputValue, 'DD/MM/YYYY');
            } else {
               return null;
            }
         },
         locale: {
            format: 'DD/MM/YYYY',
         },
         showDropdowns: true,
         autoUpdateInput: false,
         //minDate: moment(),
         
      });

      $('input[name="license_expiry_date"]').on('apply.daterangepicker', function (ev, picker) {
         $(this).val(picker.startDate.format('DD/MM/YYYY'));
      });

      $('input[name="license_expiry_date"]').on('cancel.daterangepicker', function (ev, picker) {
         $(this).val('');
      });

   });

   function previewImage(input, previewDom) {
      if (input.files && input.files[0]) {
         $(previewDom).show();
         var reader = new FileReader();
         reader.onload = function (e) {
            $(previewDom).find('img').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
      } else {
         $(previewDom).hide();
      }
   }
</script>
<?php include viewPath('includes/footer'); ?>