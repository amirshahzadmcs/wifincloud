<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-feed position-left"></i> <span class="text-semibold">Manage Campaigns</span> - Add</h4>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Add new campaign</li>
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
            <h5 class="panel-title">Add a new campaign</h5>
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
        <div class="panel-body">
            <p class="content-group-lg">Add a new campaign. Supports star rating & videos (coming soon).</p>

            <?php

            ?>
            <?php echo form_open_multipart('panel/campaigns/save', ['class' => 'form-validate', 'autocomplete' => 'off']); ?>
            <fieldset class="content-group">
                <legend class="text-bold">Basic details</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formClient-Name">Campaign name</label>
                            <input type="text" class="form-control" name="name" required id="formClient-Name" required placeholder="Enter Campaign Name" autofocus />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formClient-campaign">Pick Campaign Launch Time</label>
                            <div class="input-group">
                                <input type="text" value="" name="campaign_time" id="campaign_time" class="form-control daterange-left" placeholder="Campaign launch time">
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
                                <option value="1" selected>Active</option>
                                <option value="0">InActive</option>
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
            <?php

            ?>
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    $(document).ready(function() {
        $('input[name="campaign_time"]').daterangepicker({
            autoUpdateInput: true,
            timePicker: true,
            timePickerIncrement: 10,
            minDate: moment(),
            startDate: moment(),
            locale: {
                format: 'MM/DD/YYYY h:mm a'
            },
        });

        //console.log(currentDate); 
    });
</script>
<?php include viewPath('includes/footer'); ?>