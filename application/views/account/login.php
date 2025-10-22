<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <?php include 'includes/header.php' ?>
        
                        <!-- Simple login form -->
                        <?php echo form_open('/login/check', ['method' => 'POST', 'autocomplete' => 'off']); ?>
                            <div class="panel panel-body login-form">
                                <div class="text-center">
                                    <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                                    <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5> </div>
                                <?php if(isset($message)): ?>
                                    <div class="alert alert-<?php echo $message_type ?>">
                                        <p>
                                            <?php echo $message ?>
                                        </p>
                                    </div>
                                    <?php endif; ?>
                                        <?php if(!empty($this->session->flashdata('message'))): ?>
                                            <div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?>">
                                                <p>
                                                    <?php echo $this->session->flashdata('message') ?>
                                                </p>
                                            </div>
                                            <?php endif; ?>
                                                <div class="form-group has-feedback has-feedback-left">
                                                    <input type="text" class="form-control" value="<?php echo post('username') ?>" name="username" autofocus placeholder="Enter Username or Email...">
                                                    <div class="form-control-feedback"> <i class="icon-user text-muted"></i> </div>
                                                    <?php echo form_error('username', '<div class="error" style="color: red;">', '</div>'); ?> </div>
                                                <div class="form-group has-feedback has-feedback-left">
                                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                                    <div class="form-control-feedback"> <i class="icon-lock2 text-muted"></i> </div>
                                                    <?php echo form_error('password', '<div class="error" style="color: red;">', '</div>'); ?> </div>
                                                <?php if (setting('google_recaptcha_enabled') == '1'): ?>
                                                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="<?php echo setting('google_recaptcha_sitekey') ?>"></div>
                                                        <?php echo form_error('g-recaptcha-response', '<div class="error" style="color: red;">', '</div>'); ?> </div>
                                                    <?php endif ?>
                                                        <div class="form-group login-options">
                                                            <div class="form-group login-options">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <label class="checkbox-inline">
                                                                            <input type="checkbox" <?php echo post( 'remember_me')? 'checked': '' ?> name="remember_me" class="styled" />
                                                                             Remember </label>
                                                                    </div>
                                                                    <div class="col-sm-6 text-right"> <a href="<?php echo url('login/forget?username='.post('username')) ?>">Forgot password?</a> </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                                                        </div>
                                                        
                            </div>
                            <?php echo form_close(); ?>
                                <!-- /simple login form -->
                        <!-- Footer -->
					
        <?php include 'includes/footer.php' ?>