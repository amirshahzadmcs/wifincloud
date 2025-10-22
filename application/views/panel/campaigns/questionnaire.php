<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class=" icon-feed position-left"></i> <span class="text-semibold">Manage campaigns</span> - questionnaire
         </h4>
      </div>
   </div>
   <div class="page-header-content">
      <div class="showMessage">
         <?php echo $this->session->flashdata('successMes'); ?>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Campaigns questionnaire</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('add_campaign') && $globelDomain->domainId) : ?>
            <li><a class="bg-teal-400" href="<?php echo url('panel/campaigns');  ?>"><i class=" icon-arrow-left52 position-left"></i> Go back to campaigns</a></li>
         <?php endif ?>
      </ul>
      <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <div class="panel panel-flat">
      <div class="panel-heading">
         <h5 class="panel-title">List your questions for <b><?php echo $campaign_data->campaign_name; ?></b></h5><br />
         <div class="heading-elements">
            <ul class="icons-list">

            </ul>
         </div>
         <a class="heading-elements-toggle"><i class="icon-more"></i></a>
         <a class="heading-elements-toggle"><i class="icon-more"></i></a>
      </div>
      <?php //print_r($campaign_data); 
      ?>
      <div class="panel-body">
         <div class="container-fluid">
            <?php echo form_open_multipart('panel/campaigns/questionnaire/' . $campaign_data->id, ['class' => 'form-validate', 'autocomplete' => 'off']); ?>
            <div class="row">
               <div class="col-md-6 questions-box">
                  <?php
                  //checking if the questions are available
                  if (!empty($ratings)) {
                     $counter = 1;
                     foreach ($ratings as $rating) {
                  ?>
                        <div class="form-group Cquestion-group">
                           <div class="row">
                              <div class="col-md-8">
                                 <span class="btn btn-default btn-minutes btn-questions"><i class=" icon-question3"></i> </span>
                                 <input type="text" class="form-control" name="question<?php echo $rating->id; ?>" id="question<?php echo $rating->id; ?>" placeholder="Ask a question" required value="<?php echo $rating->question_text; ?>" autofocus />
                              </div>
                              <div class="col-md-4">
                                 <!-- <a href="#" class="btn border-success text-success-600 btn-flat btn-icon btn-xs"><i class="icon-checkmark3 text-success"></i></a> -->
                                 <a href="#" class="<?php echo ($counter > 1) ? '' : 'hidden'; ?> delQuestion btn border-warning  text-warning-600 btn-flat btn-icon btn-xs"><i class="icon-cross2 text-danger-400"></i></a>

                              </div>
                           </div>

                        </div>
                     <?php
                        $counter++;
                     }
                  } else {
                     ?>

                     <div class="form-group Cquestion-group">
                        <div class="row">
                           <div class="col-md-8">
                              <span class="btn btn-default btn-minutes btn-questions"><i class=" icon-question3"></i> </span>
                              <input type="text" class="form-control" name="question1" id="question1" placeholder="Ask a question" value="" autofocus />
                           </div>
                           <div class="col-md-4">
                              <a href="#" class="delQuestion btn border-warning hidden text-warning-600 btn-flat btn-icon btn-xs"><i class="icon-cross2 text-danger-400"></i></a>
                           </div>
                        </div>

                     </div>
                  <?php
                  } //ending the else statement here
                  ?>


                  <div class="add_question">
                     <a id="duplicateQuestion" class="align-right" href="#"><i class="icon-plus2 position-right"></i> Add question</a>
                  </div>


               </div>
               <div class="hidden">
               <input type="hidden" name="campaign_id" value="<?php echo $campaign_data->id; ?>" />
               </div>
               <div class="col-md-12">
                  <button type="submit" class="btn bg-teal-400">Submit <i class="icon-arrow-right14 position-right"></i></button>
               </div>
            </div>
            <?php echo form_close(); ?>
         </div>
      </div>
      <?php
      ?>
   </div>
   <!-- Default box -->
</section>
<script type="text/javascript">
   $(document).ready(function() {
      $("#duplicateQuestion").on("click", function(event) {
         event.preventDefault();
         // Selecting the last .questions-group element
         var lastQuestion = $(".Cquestion-group:last").clone(true);
         $(lastQuestion).insertAfter(".Cquestion-group:last");
         $(".Cquestion-group:last input").val("");

         var qName = $(".Cquestion-group:last input").attr("name");
         var qId = $(".Cquestion-group:last input").attr("id");


         qName = qName.match(/\d+/);
         qName = parseInt(qName[0]) + 1;

         qId = qId.match(/\d+/);
         qId = parseInt(qId[0]) + 1;

         //console.log(qId);
         // Update attributes of the cloned elemnet
         $(".Cquestion-group:last input").attr("name", "question" + qName);
         $(".Cquestion-group:last input").attr("id", "question" + qId);
         $(".Cquestion-group:last input").attr("newField", "1");
         $(".Cquestion-group:last .delQuestion").removeClass("hidden");

      });

      //delete a question model handler
      $(".delQuestion").on("click", function(event) {
         event.preventDefault();

         var inputField = $(this).closest('.Cquestion-group').find("input").attr('name');
         var newFieldFlag = $(this).closest('.Cquestion-group').find("input").attr('newfield');

         if (newFieldFlag == 1) {
            var inputField = $(this).closest('.Cquestion-group').hide("slow", function() {
                     $(this).remove();
                  });
         } else {


            $(".modal-body").html("");
            $(".modal-body").hide();
            $("#delSubmit").prop("disabled", false);

            $('#modal_delete_warning').modal('show');


            inputField = inputField.match(/\d+/);
            inputField = parseInt(inputField[0]);
            jQuery("#hiddenQId").val(inputField);
         }
      });

      //deleting the question ajax handler
      $("#delSubmit").on("click", function(event) {
         var Cid = <?php echo $campaign_data->id; ?>;
         var QId = $("#hiddenQId").val();

         $(this).prop("disabled", true);
         $.ajax({
            url: '<?php echo base_url() ?>panel/campaigns/delQuestion',
            type: 'GET',
            data: {
               cid: Cid,
               qid: QId,
            },
            success: function(response) {

               var responseObject = JSON.parse(response);
               if (responseObject.success == '1') {
                  var inputField = $("#question" + QId).closest('.Cquestion-group').hide("slow", function() {
                     $(this).remove();
                  });
                  $('#modal_delete_warning').modal('hide');
               } else {
                  $(".modal-body").html("There was a problem with your request. Please try again later or contact administrator");
                  $(".modal-body").show("slow");
               }
            }
         });
      });
   });
</script>
<!-- /.content -->

<!-- Warning modal -->
<div id="modal_delete_warning" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h6 class="modal-title text-center">Are you sure you want to delete this?</h6>
            <input class="" type="hidden" id="hiddenQId" name="hidden_id" value="" />
         </div>
         <div class="modal-body" style="display: none;"></div>
         <div class="modal-footer text-center" style="margin-top: 25px;">
            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            <button type="button" id="delSubmit" class="btn btn-warning">Delete</button>
         </div>
      </div>
   </div>
</div>
<!-- /warning modal -->
<?php include viewPath('includes/footer'); ?>