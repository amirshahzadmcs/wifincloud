<?php
   defined('BASEPATH') OR exit('No direct script access allowed');

   $globelDomain = $this->session->userdata('globelDomain');
   is_set_domainSetting();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>WiFinCloud - Admin panel</title>
      <link rel="icon" href="<?php echo $url->assets ?>images/wifincloud_icon.svg" />
      <link rel="icon" href="<?php echo $url->assets ?>images/wifincloud_icon.svg" type="image/x-icon">
      <!-- Global stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
         type="text/css">
      <link href="<?php echo $url->assets ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $url->assets ?>css/bootstrap.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $url->assets ?>css/core.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $url->assets ?>css/custom.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $url->assets ?>css/components.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $url->assets ?>css/colors.css" rel="stylesheet" type="text/css">
      <!-- /global stylesheets -->
      <!-- Core JS files -->
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/loaders/pace.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/core/libraries/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/core/libraries/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/loaders/blockui.min.js"></script>
      <!-- /core JS files -->
      <!-- Theme JS files -->
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/visualization/d3/d3.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/visualization/d3/d3_tooltip.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/uniform.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/selects/bootstrap_multiselect.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/selects/select2.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/ui/moment/moment.min.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/pickers/daterangepicker.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/core/app.js"></script>
      <script type="text/javascript" src="<?php echo $url->assets ?>js/pages/form_select2.js"></script>
      <!-- /theme JS files -->
   </head>
   <body>
      <!-- Main navbar -->
      <div class="navbar navbar-default header-highlight">
         <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo url('/') ?>"><img
               src="<?php echo $url->assets ?>images/wifincloud_logo.svg" alt=""></a>
            <ul class="nav navbar-nav visible-xs-block">
               <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
               <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
         </div>
         <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
               <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
               </li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <i class="icon-git-compare"></i>
                  <span class="visible-xs-inline-block position-right">Git updates</span>
                  <span class="badge bg-warning-400">1</span>
                  </a>
                  <div class="dropdown-menu dropdown-content">
                     <div class="dropdown-content-heading">
                        Notification updates
                        <ul class="icons-list">
                           <li><a href="#"><i class="icon-sync"></i></a></li>
                        </ul>
                     </div>
                     <ul class="media-list dropdown-content-body width-350">
                        <li class="media">
                           <div class="media-left">
                              <a href="#"
                                 class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i
                                 class="icon-git-pull-request"></i></a>
                           </div>
                           <div class="media-body">
                              Notifications coming soon
                              <div class="media-annotation">4 minutes ago</div>
                           </div>
                        </li>
                     </ul>
                     <div class="dropdown-content-footer">
                        <a href="#" data-popup="tooltip" title="" data-original-title="All notifications"><i
                           class="icon-menu display-block"></i></a>
                     </div>
                  </div>
               </li>
            </ul>
            <p class="navbar-text">
               <script>
                  window.addEventListener('online', () => document.querySelectorAll('.online_status')[0].innerHTML =
                      '<span class="label bg-success">Online</span>');
                  window.addEventListener('offline', () => document.querySelectorAll('.online_status')[0].innerHTML =
                      '<span class="label bg-warning">Offline</span>');
               </script> <span class="online_status"><span class="label bg-success">Online</span></span>
            </p>
            <ul class="nav navbar-nav navbar-right">
               <li  class="dropdown dropdown-domain-selection">
                  <div class="">
                     <?php 
                        $domains = $this->domains_model->get();
                        $count_domain = count($domains);
                        ?>
                     <?php echo form_open_multipart('domains/setDomainName', [ 'class' => 'form-validate', 'id' => 'settingForm', 'autocomplete' => 'off' ]); ?>
                     <input type="hidden" value="<?php echo current_url();?>" name="url">
                     <select class="select-search" name="domainSelector" id="headerDomainDropdown" <?php echo (isset($disableDomains))? $disableDomains : "";?>>
                        
                        <?php  $sel = ''; foreach ($domains as $row): $counter = 1; ?>
                        <?php if(isset($globelDomain->domainId)){ $sel = ( $globelDomain->domainId == $row->id )?'selected':''; } ?>
                        <?php if($row->users_id == logged("id") && logged("role") != 1): ?>
                        <option  value="<?php echo $row->id ?>" <?php echo $sel ?>>
                           <?php echo ucfirst($row->domain_name) ?>
                        </option>
                        <?php endif; ?>
                        <?php if(logged("role") == 1): ?>
                        <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                           <?php echo ucfirst($row->domain_name) ?>
                        </option>
                        <?php endif; ?>
                        <?php $counter ++ ; endforeach ?>
                     </select>
                     <?php echo form_close(); ?>   
                  </div>
               </li>
               <li class="dropdown dropdown-user">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo userProfile(logged('id')) ?>" alt="">
                  <span><?php echo logged('name') ?></span>
                  <i class="caret"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <li><a href="<?php echo url('profile') ?>"><i class="icon-user-plus"></i> My profile</a></li>
                     <li><a href="<?php echo url('profile') ?>"><i class="icon-cog5"></i> Account settings</a></li>
                     <li><a href="<?php echo url('/logout') ?>"><i class="icon-switch2"></i> Logout</a></li>
                  </ul>
               </li>
            </ul>
         </div>
      </div>
      <!-- /main navbar -->
      <div class="page-container">
      <!-- Page content -->
      <div class="page-content">
      <!-- =============================================== -->
      <!-- Left side column. contains the sidebar -->
      <?php include 'nav.php' ?>
      <!-- =============================================== -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <!-- Content area -->
      <div class="content">
      <?php include 'notifications.php'; ?>