<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <?php include viewPath('includes/header'); ?>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!--        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>-->
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-earth position-left"></i> <span class="text-semibold">Manage Domains</span> - Add</h4> </div>
            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li class="active">Add new domain</li>
                </ul>
                <ul class="breadcrumb-elements">
                    <li><a class="bg-teal-400" href="<?php echo url('domains') ?>"><i class=" icon-arrow-left52 position-left"></i> Go back to domains</a></li>
                </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a></div>
        </div>
        <!-- Main content -->
        <section class="">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Add a new domain</h5>
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
                    <p class="content-group-lg">Register a new domain. A domain is a separate business or client.</p>
                    <?php echo form_open_multipart('domains/save', [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>
                        <!--                    <form class="form-horizontal" action="#">-->
                        <fieldset class="content-group">
                            <legend class="text-bold">Basic details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Name">Domain name</label>
                                        <input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Name" onkeyup="$('#formClient-Machinename').val(createdomainname(this.value))" autofocus /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Machinename">Machine name</label>
                                        <input type="text" class="form-control" data-rule-remote="<?php echo url('domains/check') ?>" data-msg-remote="Domain Already taken" name="machine_name" id="formClient-Machinename" required placeholder="" /> </div>
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="content-group">
                            <legend class="text-bold">Other details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Owner">Domain owner</label>
                                        <select name="owner_role" id="formClient-Owner" class="form-control select2" required>
                                            <option value="">Select Domain Owner</option>
                                            <?php foreach ($this->users_model->get() as $row): ?>
                                                <?php $sel = !empty(get('owner_role')) && get('owner_role')==$row->id ? 'selected' : '' ?>
                                                    <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                                                        <?php echo $row->name ?>
                                                    </option>
                                                    <?php endforeach ?>
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
                                <?php 
                                //allowed only for super admins
                                    if(logged("role") == 1):
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-locations">Total Locations</label>
                                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" name="locations" id="formClient-locations" required placeholder="Enter number of allowed locations" value="1" /></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-ap">Total Access Points</label>
                                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" name="access_points" id="formClient-ap" required placeholder="Enter number of allowed Access points"  value="1" /></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="formClient-Approval">Approval</label>
                                            <select name="status" id="formClient-Approval" class="form-control" >
                                              
                                              <option value="1">Approved</option>
                                              <option value="0">Not approved</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                endif;
                                ?>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn bg-teal-400">Submit <i class="icon-arrow-right14 position-right"></i></button>
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
                //$('.select2').select2()
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

            function createdomainname(name) {
                return name.toLowerCase().replace(/ /g, '_').replace(/[^\w-]+/g, '');;
            }
        </script>
        <?php include viewPath('includes/footer'); ?>