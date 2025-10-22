<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>

<?php
//setting up basic variables
$currentDatetime = new DateTime();

$startDatetime = new DateTime($campaign_data->start_datetime);
$humanReadableStartDate = $startDatetime->format('F j, Y h:i a');

$endDatetime = new DateTime($campaign_data->end_datetime);
$humanReadableEndDate = $endDatetime->format('F j, Y h:i a');
?>
<!-- Content Header (Page header) -->
<div class="page-header">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class=" icon-feed position-left"></i> <span class="text-semibold"><?php echo $campaign_data->campaign_name; ?></span> - Report <?php
                                                                                                                                                if (($currentDatetime > $startDatetime) && ($currentDatetime < $endDatetime)) {
                                                                                                                                                   echo '<span class="label bg-blue pulse_anim"><span class="live_anim"></span> Live</span>';
                                                                                                                                                } else if (($currentDatetime < $startDatetime)) {
                                                                                                                                                   echo '<span class="label bg-pink">Scheduled</span>';
                                                                                                                                                } else if (($endDatetime < $currentDatetime)) {
                                                                                                                                                   echo '<span class="label bg-success">Ended</span>';
                                                                                                                                                }
                                                                                                                                                ?>
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line breadcrumb-line-component">
      <ul class="breadcrumb">
         <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Campaign report</li>
      </ul>
      <ul class="breadcrumb-elements">
         <?php if (hasPermissions('campaigns_list')) : ?>
            <li><a class="bg-teal-400" href="<?php echo url('panel/campaigns');  ?>"><i class=" icon-arrow-left52 position-left"></i> Go back to campaigns</a></li>
         <?php endif; ?>
      </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
   </div>
</div>
<!-- Main content -->
<section class="">
   <?php if (isset($rating_values)) { ?>
      <div class="panel panel-flat">
         <div class="panel-heading">
            <h5 class="panel-title">Ratings by subscribers</h5>
         </div>
         <div class="panel-body"> Below is the rating you have received for this campaign.</code>
         </div>
         <div class="table-responsive">
            <table class="table table-xs">
               <thead>
                  <tr>
                     <th>Sub. ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone</th>
                     <th>Rating</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ($rating_values as $rating_value) :
                     //setting up the answers decode
                     $answers = json_decode($rating_value->response, true);
                     $sub_id = $rating_value->subscriber_id;
                  ?>
                     <tr>
                        <td>
                           <?php echo $rating_value->subscriber_id; ?>
                        </td>
                        <td>
                           <?php echo ucfirst($subscribers_list[$rating_value->subscriber_id]->name); ?>
                        </td>
                        <td>
                           <?php echo ucfirst($subscribers_list[$rating_value->subscriber_id]->email); ?>
                        </td>
                        <td>
                           <?php echo ucfirst($subscribers_list[$rating_value->subscriber_id]->phone); ?>
                        </td>
                        <td>
                           <div class="rating_responses">
                              
                              <?php
                              
                              $num_questions = count($ratings_questions); // number of questions 
                              $total_rating = 0;
                              $avg_rating = 0;


                              //calculating the avarage rating from answers
                              foreach ($answers as $answer){
                                 $total_rating += $answer['value'];
                              }
                              
                              //calculating the avrage 
                              if ($num_questions > 0) {
                                 $avg_rating = round($total_rating / $num_questions);
                             } else {
                                 $avg_rating = 0; // Default to 0 if no ratings provided
                             }

                              
                              
                              ?>
                              <div class=" avg_rating"><?php if (isset($avg_rating)) { ?>
                                 <span class="avg_text">Average: </span>
                                 <div class="rate">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>
                                       <input disabled type="radio" id="avg<?php echo $i . $sub_id; ?>" name="rate<?php echo $sub_id; ?>" value="<?php echo $i; ?>" <?php echo ($avg_rating == $i) ? 'checked' : ''; ?> />
                                       <label for="avg<?php echo $i . $sub_id; ?>" title="<?php echo $avg_rating; ?> Stars"><?php echo $avg_rating; ?> Stars</label>
                                    <?php } ?>
                                    
                                 </div>
                                 <span class="view_response">View Details</span>
                              <?php } ?>
                           </div>
                              <div class="rating_details">
                              <?php
                                 foreach ($ratings_questions as $ratings_question) {
                                    $question_id = $ratings_question->id;
                                    // Use array_filter to filter the array based on rate_q_id
                                    $value = 0;
                                    foreach ($answers as $item) {
                                       if ($item['rate_q_id'] == $question_id) {
                                          $value = $item['value']; // Get the value when rate_q_id matches $id
                                          break; // Exit the loop once a match is found
                                       }
                                    }
                                 ?>
                                    
                                    <div class="rate_question">
                                       <div class="question_text"><?php echo $ratings_question->question_text; ?></div>
                                       <?php
                                       $qNumber = $ratings_question->id;

                                       ?>
                                       <div class="answer_rate"><?php if (isset($value)) { ?>
                                             <div class="rate">
                                                <?php for ($i = 5; $i >= 1; $i--) { ?>
                                                   <input disabled type="radio" id="star<?php echo $i . $sub_id . $qNumber; ?>" name="rate<?php echo $qNumber . $sub_id; ?>" value="<?php echo $i; ?>" <?php echo ($value == $i) ? 'checked' : ''; ?> />
                                                   <label for="star<?php echo $i . $sub_id . $qNumber; ?>" title="<?php echo $i; ?> stars"><?php echo $i; ?> stars</label>
                                                <?php } ?>
                                             </div>
                                          <?php } ?>
                                       </div>

                                    </div>
                                 <?php } ?>
                              </div>
                           </div>

                        </td>


                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>

      </div>
   <?php } else {
      echo "No data found";
   } ?>
   <!-- Default box -->
</section>
<!-- /.content -->
<style type="text/css">
   .rate_question {
      position: relative;
      background-color: #0000000a;
      padding: 5px 15px;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
   }

   .question_text {
      float: left;
      font-size: 11px;
   }
   .rating_responses{
      position: relative;
   }
   .answer_rate {
      float: right;
      min-width: 100px;
      transform: scale(.8);
      transform-origin: center right;
   }
   .rating_details{
      float: left;
      margin-top: 5px;
      width: 100%;
      display: none;
   }
   .avg_rating{
      float: left;
      width: 100%;
      position: relative;
      min-width: 125px;
   }
   .avg_rating .rate{
      float: left;
   }
   .avg_rating .avg_text{
      float: left;
      margin-right:5px;
      display: none;
   }

   .view_response{
      position: absolute;
      right: 0px;
      font-size:11px;
      visibility: hidden;
      top: 50%;
      transform: translateY(-50%);
   }
   .view_response:hover{
      cursor: pointer;
   }

   tr:hover .view_response{
      visibility: visible;
   }
   .rate {}

   .rate:not(:checked)>input {
      position: absolute;
      top: -9999px;
   }

   .rate:not(:checked)>label {
      float: right;
      width: 1em;
      overflow: hidden;
      white-space: nowrap;
      /* cursor: pointer; */
      font-size: 20px;
      color: #ccc;
      margin-bottom: 0px;
      line-height: 22px;
   }

   .rate:not(:checked)>label:before {
      content: '★ ';
   }

   .rate>input:checked~label {
      color: #ffc700;
   }
</style>
<script type="text/javascript">
jQuery(document).ready(function() {
        // When view_response is clicked
        jQuery(".view_response").click(function() {
            // Toggle the visibility of elements with class rating_details
            var ratingDetails = jQuery(this).closest(".avg_rating").next(".rating_details");
            var avgText = jQuery(this).closest(".avg_rating").children(".avg_text");
            
            // Toggle the visibility of the found .rating_details
            ratingDetails.toggle('normal');
            avgText.toggle('normal');
            jQuery(this).text(function(_, text) {
                return text === "View Details" ? "Hide Details" : "View Details";
            });
        });
    });
</script>

<?php include viewPath('includes/footer'); ?>