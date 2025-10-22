<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-location3 position-left"></i> <span class="text-semibold">Manage Access Points</span> -
                Edit</h4>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Edit Accesspoint</li>
        </ul>
        <ul class="breadcrumb-elements">
            <li><a class="bg-teal-400" href="<?php echo url('panel/accesspoints') . '?domains=' . $domain_id ?> "><i
                        class=" icon-arrow-left52 position-left"></i> Go back to access points</a></li>
        </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
    </div>
</div>
<!-- Main content -->
<section class="">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Edit details</h5>
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
            <p class="content-group-lg">Change below entries and press submit.
                <code>Please make sure to add the correct MAC address.</code></p>
            <?php echo form_open_multipart('panel/accesspoints/update/'.$accesspoint->id, [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>

            <fieldset class="content-group">
                <legend class="text-bold">Basic details</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formClient-mac">MAC address</label>
                            <input type="text" class="form-control" name="mac_address" id="formClient-mac" required
                                placeholder="Enter MAC address" maxlength="17"
                                value="<?php echo $accesspoint->device_mac ?>" />
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
                                            switch_db_by_domain_id($domain_id);
                                            foreach ($this->locations_model->get() as $row): 
                                            ?>
                                <?php $sel = !empty($accesspoint->id) && $accesspoint->location_id == $row->id ? 'selected' : '' ?>
                                <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
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
                                <?php $sel = $accesspoint->status==1 ? 'selected' : '' ?>
                                <option value="1" <?php echo $sel ?>>Active</option>
                                <?php $sel = $accesspoint->status==0 ? 'selected' : '' ?>
                                <option value="0" <?php echo $sel ?>>InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="hide">
                        <input type="hidden" class="form-control" name="domain_id" value="<?php echo $domain_id; ?>" />

                    </div>
                    <div class="col-md-12">
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
<script>

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