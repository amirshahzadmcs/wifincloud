<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4>Email Templates</h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component " style="margin: 0px 12px 22px 8px;">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Settings</a></li>
         <li class="active">Email Templates</li>
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

      <?php include VIEWPATH.'/settings/sidebar.php'; ?>

    </div>
    <div class="col-sm-9">

      <!-- Default box -->
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Email Templates</h3>
        </div>

        <div class="box-body">

          <table id="dataTable1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Code</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($this->templates_model->get() as $row): ?>
            <tr>
              <td width="60"><?php echo $row->id ?></td>
              <td ><?php echo $row->code ?></td>
              <td ><?php echo $row->name ?></td>
              <td>
              <ul class="icons-list">
                  <li class="text-primary-600"><a href="<?php echo url('settings/edit_email_templates/'.$row->id) ?>" title="Edit"><i class="icon-pencil7"></i></a></li>
              </ul>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>


        </div>
        <!-- /.box-body -->

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

