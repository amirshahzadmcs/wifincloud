<?php

defined('BASEPATH') or exit('No direct script access allowed');
$domain_setting = getDomainSetting($_SESSION['dname'], 'intervelSetting');
$brand = '';
if (isset($domain_setting->brand)) {
    $brand = $domain_setting->brand;
}
$subscriber_login_session = $this->session->userdata('subscriber_login_session');
//print_r($_SESSION);

//checking if there is an active campaign
if (isset($_SESSION['active_campaign_id']) && $_SESSION['active_campaign_id'] != 0) {
    if ($campaign_questions) {
        echo form_open('/f/subscriber/campaignSubmit', ['id' => 'subscriber_form', 'class' => 'needs-validation', 'novalidate' => '']);
?>
        <div class="">
            <div class="rating_campaign_container">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="error-message alert-success text-center pt-1 pb-1" role="alert">
                                <?php $logged_info =  get_session('logged_info');
                                ?>
                                Hi <b><?php echo $logged_info['name']; ?></b> Please rate to continue
                                <br />
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach ($campaign_questions as $campaign_question) :
                        $qNumber = $campaign_question->id;
                    ?>
                        <div class="row questions_row">
                            <div class="col-md-12">
                                <strong><?php echo $campaign_question->question_text; ?></strong>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="rate">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>
                                        <input type="radio" id="star<?php echo $i . $qNumber; ?>" name="rate<?php echo $qNumber; ?>" value="<?php echo $i; ?>" />
                                        <label for="star<?php echo $i . $qNumber; ?>" title="<?php echo $i; ?> stars"><?php echo $i; ?> stars</label>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="rating_error text-danger text-center pt-1 pb-1" style="display: none;" role="alert">
                                Please rate all questions
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="login_btn_wrap">
                                <div class="login_btn_wrap_inner">
                                    <div class="login_bgbtn"></div>
                                    <input type="submit" value="Rate & Connect " class="form-control login_btn" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            .rating_campaign_container {
                background-color: white;
                padding: 15px 5px;
                margin-top: 30px;
                margin-bottom: 25px;
                border-radius: 5px;
            }

            .questions_row {
                border-bottom: 1px dashed #0003;
                margin-top: 5px;
                margin-bottom: 5px;
                padding-bottom: 5px;
                padding-top: 10px;
            }

            .questions_row:first-child {
                padding-top: 0px;
                margin-top: 0px;
            }

            .questions_row:last-child {
                border-bottom: 0px;
                margin-bottom: 0px;
            }

            .questions_row .text-right {
                text-align: right;
            }

            .questions_row strong {
                font-weight: 400;
            }

            .rate {
                float: right;
                height: 46px;
                padding: 0 10px;
            }

            .rate:not(:checked)>input {
                position: absolute;
                top: -9999px;
            }

            .rate:not(:checked)>label {
                float: right;
                width: 1em;
                overflow: hidden;
                white-space: nowrap;
                cursor: pointer;
                font-size: 30px;
                color: #ccc;
            }

            .rate:not(:checked)>label:before {
                content: '★ ';
            }

            .rate>input:checked~label {
                color: #ffc700;
            }

            .rate:not(:checked)>label:hover,
            .rate:not(:checked)>label:hover~label {
                color: #deb217;
            }

            .rate>input:checked+label:hover,
            .rate>input:checked+label:hover~label,
            .rate>input:checked~label:hover,
            .rate>input:checked~label:hover~label,
            .rate>label:hover~input:checked~label {
                color: #c59b08;
            }

            .login_btn_wrap {
                margin-top: 14px;
                margin-bottom: 5px;
            }
        </style>
        <script>
            document.getElementById("subscriber_form").addEventListener("submit", function(event) {
                var radioButtons = document.querySelectorAll('input[name="rate<?php echo $qNumber; ?>"]');
                var radioChecked = false;

                for (var i = 0; i < radioButtons.length; i++) {
                    if (radioButtons[i].checked) {
                        radioChecked = true;
                        break;
                    }
                }

                if (!radioChecked) {
                    // Get the element with the class "rating_error"
                    var ratingError = document.querySelector('.rating_error');

                    // Change the "display" property to "block" to make it visible
                    ratingError.style.display = 'block';
                    event.preventDefault(); // Prevent form submission
                }
            });
        </script>
<?php

        echo form_close();
    }
} else {
    //safe handle for no campaigns
}
?>