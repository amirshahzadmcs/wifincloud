<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-connection position-left"></i> <span class="text-semibold">Manage Access Points</span> -
                Add</h4>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Add new Access Point</li>
        </ul>
        <ul class="breadcrumb-elements">
            <?php if (hasPermissions('locations_list')): ?>
            <li><a class="bg-teal-400" href="<?php echo url('panel/accesspoints')  .'?domains='.get('domains'); ?>"><i
                        class=" icon-arrow-left52 position-left"></i> Go back to access points</a></li>
            <?php endif; ?>
        </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
    </div>
</div>
<!-- Main content -->
<section class="">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Add a new access point</h5>
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
            <p class="content-group-lg">Add a new access point. An access point is a device installed to distribute wifi
                on your business location.</p>

            <?php
                    //Checking the locations if quota reached
                    //0 means still allowed to add, 1 means already reached its limit
                    $accesspoints_allowed = accesspoint_number_check(get('domains'));
                    if($accesspoints_allowed == 0):
                    ?>
            <?php echo form_open_multipart('panel/accesspoints/save', [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>
            <!--                    <form class="form-horizontal" action="#">-->
            <fieldset class="content-group">
                <legend class="text-bold">Basic details</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formClient-mac">MAC address</label>
                            <input type="text" class="form-control" name="mac_address" id="formClient-mac" required
                                placeholder="Enter MAC address" maxlength="17" autofocus />
                            <script type="text/javascript">
                            document.getElementById("formClient-mac").addEventListener('keyup', function() {
                                // remove non digits, break it into chunks of 2 and join with a colon
                                this.value =
                                    (this.value.toUpperCase()
                                        .replace(/[^\d|A-Z]/g, '')
                                        .match(/.{1,2}/g) || [])
                                    .join(":")
                            });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formClient-Location">Location</label>
                            <select name="location" id="formClient-Location" class="form-control">
                                <?php
                                            switch_db_by_domain_id(get('domains'));
                                            foreach ($this->locations_model->get() as $row): 
                                            ?>
                                <?php $sel = !empty(get('role')) && get('role')==$row->id ? 'selected' : '' ?>
                                <option value="<?php echo $row->id ?>" <?php //echo $sel ?>>
                                    <?php echo $row->location_name ?></option>
                                <?php endforeach;
                                             //switching the db back
                                            switch_db(default_db_name());
                                            ?>

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
                        <input type="hidden" class="form-control" name="domain_id"
                            value="<?php echo get('domains'); ?>" />
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn bg-teal-400">Submit <i
                                class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </fieldset>
            <?php echo form_close(); ?>
            <?php else: 
                    echo "<code>You have already reached the maximum allowed limit of your access points, please contact support to increase your quota.</code>";
                    endif;
                    ?>
        </div>
    </div>
</section>
<!-- /.content -->
<script>
$(document).ready(function() {
    $('.form-validate').validate();
    //Initialize Select2 Elements
    //$('.select2').select2()
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

function createdomainname(name) {
    return name.toLowerCase().replace(/ /g, '_').replace(/[^\w-]+/g, '');;
}
</script>
<?php include viewPath('includes/footer'); ?>