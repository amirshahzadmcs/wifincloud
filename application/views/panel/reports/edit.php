<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <?php include viewPath('includes/header'); ?>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-location3 position-left"></i> <span class="text-semibold">Manage Locations</span> - Edit</h4> </div>
            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li class="active">Edit location</li>
                </ul>
                <ul class="breadcrumb-elements">
                    <li><a href="<?php echo url('panel/locations') . '?domains=' . $domain_id ?> "><i class=" icon-arrow-left52 position-left"></i> Go back to locations</a></li>
                </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a></div>
        </div>
        <!-- Main content -->
        <section class="">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Edit <?php echo $location->location_name ?>'s details</h5>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li>
                                <a data-action="collapse"></a>
                            </li>
                            <li>
                                <a data-action="reload"></a>
                            </li>
                        </ul>
                    </div> <a class="heading-elements-toggle"><i class="icon-more"></i></a></div>
                <div class="panel-body">
                    <p class="content-group-lg">Change below entries and press submit. <code>Disabling a location will disable the access to internet for your users on that location</code></p>
                    <?php echo form_open_multipart('panel/locations/update/'.$location->id, [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>
                        
                    <fieldset class="content-group">
                            <legend class="text-bold">Basic details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Name">Location name</label>
                                        <input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Location Name" value="<?php echo $location->location_name ?>" autofocus /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-address">Address</label>
                                        <input type="text" class="form-control" name="address" id="formClient-address" required placeholder="Enter Address"  value="<?php echo $location->location_address ?>" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Status">Status</label>
                                        <select name="status" id="formClient-Status" class="form-control" >
                                          <?php $sel = $location->status==1 ? 'selected' : '' ?>
                                          <option value="1" <?php echo $sel ?>>Active</option>
                                          <?php $sel = $location->status==0 ? 'selected' : '' ?>
                                          <option value="0" <?php echo $sel ?>>InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hide">
                                <input type="hidden" class="form-control" name="domain_id" value="<?php echo $domain_id; ?>" />
                                <input type="hidden" class="form-control" name="coordinates" value="<?php echo $location->location_coordinates; ?>" />
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
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
            $(document).ready(function () {
                $('.form-validate').validate();
                //Initialize Select2 Elements
                $('.select2').select2()
            })

            function previewImage(input, previewDom) {
                if (input.files && input.files[0]) {
                    $(previewDom).show();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(previewDom).find('img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    $(previewDom).hide();
                }
            }
        </script>
        <?php include viewPath('includes/footer'); ?>