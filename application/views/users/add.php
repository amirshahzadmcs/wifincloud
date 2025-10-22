<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <?php include viewPath('includes/header'); ?>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-people position-left"></i> <span class="text-semibold">Manage Users</span> - Add</h4> </div>
            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li class="active">Add new user</li>
                </ul>
                <ul class="breadcrumb-elements">
                    <li><a class="bg-teal-400" href="<?php echo url('users') ?>"><i class=" icon-arrow-left52"></i> Go back to users</a></li>
                </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a></div>
        </div>
        <!-- Main content -->
        <section class="">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Add a new user</h5>
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
                    <p class="content-group-lg">Add a user and choose his/her role here.</p>
                    <?php echo form_open_multipart('users/save', [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>
                        <!--                    <form class="form-horizontal" action="#">-->
                        <fieldset class="content-group">
                            <legend class="text-bold">Basic details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Name">Name</label>
                                        <input type="text" class="form-control" name="name" id="formClient-Name" required placeholder="Enter Name" onkeyup="$('#formClient-Username').val(createUsername(this.value))" autofocus /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Contact">Contact Number</label>
                                        <input type="text" class="form-control" name="phone" id="formClient-Contact" placeholder="Enter Contact Number" /> </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="content-group">
                            <legend class="text-bold">Login details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Email">Email</label>
                                        <input type="email" class="form-control" name="email" data-rule-remote="<?php echo url('users/check') ?>" data-msg-remote="Email Already Exists" id="formClient-Email" required placeholder="Enter email"> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Username">Username</label>
                                        <input type="text" class="form-control" data-rule-remote="<?php echo url('users/check') ?>" data-msg-remote="Username Already taken" name="username" id="formClient-Username" required placeholder="Enter Username" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Password">Password</label>
                                        <input type="password" class="form-control" name="password" minlength="6" id="formClient-Password" required placeholder="Password"> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-ConfirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" equalTo="#formClient-Password" id="formClient-ConfirmPassword" required placeholder="Confirm Password"> </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="content-group">
                            <legend class="text-bold">Other details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Role">Role</label>
                                        <select name="role" id="formClient-Role" class="form-control select2" required>
                                            <option value="">Select Role</option>
                                            <?php foreach ($this->roles_model->get() as $row): ?>
                                                <?php $sel = !empty(get('role')) && get('role')==$row->id ? 'selected' : '' ?>
                                                    <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                                                        <?php echo $row->title ?>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Address">Address</label>
                                        <textarea type="text" class="form-control" name="address" id="formClient-Address" placeholder="Enter Address" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formClient-Image">Image</label>
                                        <input type="file" class="form-control" name="image" id="formClient-Image" placeholder="Upload Image" accept="image/*" onchange="previewImage(this, '#imagePreview')"> </div>
                                    <div class="form-group" id="imagePreview"> <img src="<?php echo userProfile('default') ?>" class="img-circle" alt="Uploaded Image Preview" width="100" height="100"> </div>
                                </div>
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

            function createUsername(name) {
                return name.toLowerCase().replace(/ /g, '_').replace(/[^\w-]+/g, '');;
            }
        </script>
        <?php include viewPath('includes/footer'); ?>