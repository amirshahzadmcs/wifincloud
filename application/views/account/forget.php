<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <?php include 'includes/header.php' ?>
        <!-- Password recovery -->
        <?php if(isset($message)): ?>
            <div class="alert alert-<?php echo $message_type ?>">
                <p>
                    <?php echo $message ?>
                </p>
            </div>
            <?php endif; ?>
                <?php echo form_open('/login/reset_password', ['method' => 'POST', 'autocomplete' => 'off']); ?>
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
                            <h5 class="content-group">Password recovery <small class="display-block">We'll send you instructions in email</small></h5> </div>
                        <?php if(!empty($this->session->flashdata('alert'))): ?>
                            <div class="alert alert-<?php echo $this->session->flashdata('alert-type') ?>">
                                <p>
                                    <?php echo $this->session->flashdata('alert') ?>
                                </p>
                            </div>
                            <?php endif; ?>
                                <div class="form-group has-feedback">
                                    <input type="text" name="username" autofocus class="form-control" placeholder="Your email" value="<?php echo !empty(post('username'))? post('username') : get('username')  ?>">
                                    <div class="form-control-feedback"> <i class="icon-mail5 text-muted"></i> </div>
                                </div>
                                <button type="submit" class="btn bg-blue btn-block">Reset password <i class="icon-arrow-right14 position-right"></i></button>
                                <div class="text-center mt-10">
                                    <a href="<?php echo url('login') ?>"> <i class="fa fa-chevron-left"></i> Go To Login</a>
                                </div>
                    </div>
                    <?php echo form_close(); ?>
                        <!-- /password recovery -->
                        <!-- /.login-box -->
                        <?php include 'includes/footer.php' ?>