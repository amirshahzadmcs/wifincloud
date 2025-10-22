<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-location3 position-left"></i> <span class="text-semibold">User</span> - Profile
            </h4>
        </div>
    </div>
    <!-- <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Profile</li>
        </ul>
    </div> -->

    <div class="navbar navbar-default navbar-component navbar-xs profile-menu">
        <ul class="nav navbar-nav visible-xs-block">
            <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i
                        class="icon-menu7"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-filter">
            <ul class="nav navbar-nav">
                <li <?php echo $activeTab=='profile'?'class="active"':'' ?>><a href="#viewProfile" data-toggle="tab"
                        aria-expanded="true" ><i
                            class="icon-profile position-left"></i> Profile</a></li>

                <li <?php echo $activeTab=='edit'?'class="active"':'' ?>><a href="#editProfile" data-toggle="tab"
                        aria-expanded="false" ><i
                            class="icon-pencil7 position-left"></i> Edit</a></li>

                <li <?php echo $activeTab=='change_pic'?'class="active"':'' ?>><a href="#editProfilePic"
                        data-toggle="tab" aria-expanded="false"
                        ><i
                            class="icon-user position-left"></i> Change Profile Pic</a></li>

                <li <?php echo $activeTab=='change_password'?'class="active"':'' ?>><a href="#changePassword"
                        data-toggle="tab" aria-expanded="false"
                        ><i
                            class="icon-unlocked2 position-left"></i> Change Password</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Main content -->
<section class="">

    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-flat">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="tabbable">
                        <div class="tab-content">
                            <div class="<?php echo $activeTab=='profile'?'active in':'' ?> tab-pane fade "
                                id="viewProfile">
                                <table class="table table-xs table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="160"><strong>Name</strong>:</td>
                                            <td><?php echo $user->name ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>username</strong>:</td>
                                            <td><?php echo $user->username ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong>:</td>
                                            <td><?php echo $user->email ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role</strong>:</td>
                                            <td><?php echo $user->role->title ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone</strong>:</td>
                                            <td><?php echo $user->phone ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address</strong>:</td>
                                            <td><?php echo nl2br($user->address) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Login</strong>:</td>
                                            <td><?php echo ($user->last_login!='0000-00-00 00:00:00')?date( setting('datetime_format'), strtotime($user->last_login)):'No Record' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Member Since</strong>:</td>
                                            <td><?php echo ($user->created_at!='0000-00-00 00:00:00')?date( setting('datetime_format'), strtotime($user->created_at)):'No Record' ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="<?php echo $activeTab=='edit'?'active in':'' ?> tab-pane fade "
                                id="editProfile">
                                <?php echo form_open('/profile/updateProfile', ['method' => 'POST', 'autocomplete' => 'off', 'class' => 'form-horizontal form-validate']); ?>


                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="name" name="name" required class="form-control" id="inputName"
                                            value="<?php echo $user->name ?>" autofocus placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputUserName" class="col-sm-2 control-label">Username</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" minlength="5"
                                            data-rule-remote="<?php echo url('users/check?notId='.$user->id) ?>"
                                            data-msg-remote="Username Already taken" name="username" id="inputUsername"
                                            required placeholder="Enter Username"
                                            value="<?php echo $user->username ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" name="email" required
                                            data-rule-remote="<?php echo url('users/check?notId='.$user->id) ?>"
                                            data-msg-remote="Email Already Exists" class="form-control" id="inputEmail"
                                            placeholder="Email" value="<?php echo $user->email ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputContact" class="col-sm-2 control-label">Contact Number</label>

                                    <div class="col-sm-10">
                                        <input type="name" name="contact" class="form-control" id="inputContact"
                                            value="<?php echo $user->phone ?>" placeholder="Contact Number..">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputContact" class="col-sm-2 control-label">Address</label>

                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" name="address" id="inputAddress"
                                            placeholder="Enter Address" rows="3"><?php echo $user->address ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group hidden">
                                    <label for="inputContact" class="col-sm-2 control-label">Role</label>

                                    <div class="col-sm-10">
                                        <select name="role" id="inputRole" class="form-control select2">
                                            <option value="">Select Role</option>
                                            <?php foreach ($this->roles_model->get() as $row): ?>
                                            <?php $sel = !empty($user->role) && $user->role->id==$row->id ? 'selected' : '' ?>
                                            <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                                                <?php echo $row->title ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn bg-teal-400 ">Submit</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="<?php echo $activeTab=='change_password'?'active in':'' ?> tab-pane fade "
                                id="changePassword">
                                <?php echo form_open('/profile/updatePassword', ['method' => 'POST', 'autocomplete' => 'off', 'class' => 'form-horizontal form-validate']); ?>

                                <div class="alert alert-warning">
                                    <p>You will need to login again after password is changed !</p>
                                </div>

                                <div class="alert alert-info">
                                    <p>Password must be atleast 6 characters long !</p>
                                </div>

                                <div class="form-group">
                                    <label for="inputContact" class="col-sm-2 control-label">Old Password</label>

                                    <div class="col-sm-10">
                                        <div class="has-feedback">
                                            <input type="password" class="form-control"
                                                placeholder="Enter New Old Password..." minlength="6"
                                                name="old_password" required autofocus id="old_password" />
                                            <span class="fa fa-lock form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputContact" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">
                                        <div class="has-feedback">
                                            <input type="password" class="form-control"
                                                placeholder="Enter New Password..." minlength="6" name="password"
                                                required autofocus id="password" />
                                            <span class="fa fa-lock form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputContact" class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-10">
                                        <div class="has-feedback">
                                            <input type="password" class="form-control" equalTo="#password"
                                                placeholder="Enter New Password Again..." required
                                                name="password_confirm" />
                                            <span class="fa fa-lock form-control-feedback"></span>
                                        </div>
                                    </div>

                                </div>





                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn bg-teal-400 btn-flat">Submit</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="<?php echo $activeTab=='change_pic'?'active in':'' ?> tab-pane fade "
                                id="editProfilePic">
                                <?php echo form_open('/profile/updateProfilePic', ['method' => 'POST', 'autocomplete' => 'off', 'class' => 'form-horizontal form-validate', 'enctype' => 'multipart/form-data']); ?>

                                <div class="form-group">
                                    <label for="formAdmin-Image" class="col-sm-2 control-label">Image</label>

                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="image" id="formAdmin-Image"
                                            placeholder="Upload Image" required accept="image/*"
                                            onchange="previewImage(this, '#imagePreview')">
                                    </div>
                                </div>
                                <div class="form-group" id="imagePreview">
                                    <label for="formAdmin-Preview" class="col-sm-2 control-label">Preview</label>
                                    <div class="col-sm-10">
                                        <img src="<?php echo userProfile($user->id) ?>" class="img-circle" width="150"
                                            alt="Uploaded Preview">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn bg-teal-400 btn-flat">Update</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!-- /.tab-pane -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="thumbnail">
                <div class="thumb thumb-rounded thumb-slide">
                    <img src="<?php echo userProfile($user->id) ?>" alt="">
                </div>

                <div class="caption text-center">
                    <h6 class="text-semibold no-margin"><?php echo $user->name ?> <small
                            class="display-block"><?php echo $user->role->title ?></small>
                    </h6>

                </div>
            </div>
            <div class="panel panel-flat">

                <div class="">
                    <ul class="list-group list-group-unbordered" style="border:0px">
                        <li class="list-group-item">
                            <b>Username</b> <a class="pull-right"><?php echo $user->username ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Last Login</b> <a
                                class="pull-right"><?php echo date( setting('date_format'), strtotime($user->last_login)) ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since</b> <a
                                class="pull-right"><?php echo date( setting('date_format'), strtotime($user->created_at)) ?></a>
                        </li>
                    </ul>

                    <a href="<?php echo url('profile/index/edit') ?>" class="btn btn-block bg-teal-400"><b> <i
                                class="fa fa-pencil"></i> Edit Profile</b></a>
                </div>

            </div>
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

<script>
//Initialize Select2 Elements
$('.select2').select2()
</script>