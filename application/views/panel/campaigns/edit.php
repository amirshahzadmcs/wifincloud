<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-feed position-left"></i> <span class="text-semibold">Manage Campaigns</span> - Edit</h4>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Edit campaign</li>
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
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Edit campaign</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li>
                        <a data-action="collapse"></a>
                    </li>
                    <li>
                        <a data-action="reload"></a>
                    </li>
                </ul>
            </div> <a class="heading-elements-toggle"><i class="icon-more"></i></a>
        </div>
        <?php
            if (isset($campaign->id)) {


            ?>
        <div class="panel-body">
            <p class="content-group-lg">Change below entries and press submit.</p>

                <?php echo form_open_multipart('panel/campaigns/update/' . $campaign->id, ['class' => 'form-validate', 'autocomplete' => 'off']); ?>
                <?php
                //setting up date: 
                $startDatetime = new DateTime($campaign->start_datetime);
                $endDatetime = new DateTime($campaign->end_datetime);
                $startFormatted = $startDatetime->format('m/d/Y h:i a');
                $endFormatted = $endDatetime->format('m/d/Y h:i a');
                ?>
                <fieldset class="content-group">
                    <legend class="text-bold">Basic details</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="formClient-Name">Campaign name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $campaign->campaign_name ?>" required id="formClient-Name" required placeholder="Enter Campaign Name" autofocus />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="formClient-campaign">Campaign Launch picker</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $startFormatted . ' - ' . $endFormatted  ?>" name="campaign_time" id="campaign_time" class="form-control daterange-left" placeholder="Campaign launch time">
                                    <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="formClient-Status">Type</label>
                                <select name="campaign_type" id="formClient-Status" class="form-control">
                                    <option value="Star Ratings" selected>Star Rating</option>
                                    <option value="Videos" disabled>Videos (coming soon)</option>
                                    <option value="Survey" disabled>Survey (coming soon)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="formClient-Status">Status</label>
                                <select name="status" id="formClient-Status" class="form-control">
                                    <option value="1" <?php if($campaign->campaign_status == 1) echo ' selected '; ?> >Active</option>
                                    <option value="0" <?php if($campaign->campaign_status == 0) echo ' selected '; ?>>InActive</option>
                                </select>
                            </div>
                        </div>
                        <div class="hide">

                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn bg-teal-400">Submit <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            
        </div>
        <?php
            } else {
                echo '<div class="panel-body">This campaign dosn\'t exist</div>';
            }
            ?>
    </div>
</section>
<!-- /.content -->
<script>
    $(document).ready(function() {
        //$('.form-validate').validate();

        $('input[name="campaign_time"]').daterangepicker({
            autoUpdateInput: true,
            timePicker: true,
            timePickerIncrement: 10,
            locale: {
                format: 'MM/DD/YYYY h:mm a'
            }
        });
    });
</script>
<?php include viewPath('includes/footer'); ?>