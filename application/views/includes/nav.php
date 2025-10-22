<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="sidebar sidebar-main">
    <div class="sidebar-content">
        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"><img src="<?php echo userProfile(logged('id')) ?>"
                            class="img-circle img-sm" alt=""></a>
                    <div class="media-body"> <span
                            class="media-heading text-semibold"><?php echo logged('name') ?></span>

                        <div class="text-size-mini text-muted"> <i class="icon-pin text-size-small"></i>
                            &nbsp;<?php echo logged('address') ?> </div>
                    </div>
                    <div class="media-right media-middle">
                        <ul class="icons-list">
                            <li> <a href="<?php echo url('profile') ?>"><i class="icon-cog3"></i></a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <!-- Main -->
                    <!-- <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li> -->
                    <li <?php echo ($page->menu=='dashboard')?'class="active"':'' ?>><a
                            href="<?php echo url('/dashboard') ?>"><i class="icon-home4"></i> <span>Dashboard</span></a>
                    </li>
                    <?php if (hasPermissions('users_list')): ?>
                    <li <?php echo ($page->menu=='users')?'class="active"':'' ?>> <a
                            href="<?php echo url('users') ?>"><i class="icon-people"></i> <span>Users</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('reporting') || hasPermissions('reporting')): ?>
                    <li <?php echo ($page->menu=='reports')?'class="active"':'' ?>> <a
                            href="<?php echo url('panel/reports') ?>"><i class=" icon-stats-growth"></i>
                            <span>Subscribers</span></a> </li>
                    <?php endif ?>
					
					
                    <?php if (hasPermissions('domains_list') || hasPermissions('manage_own_domain')): ?>
                    <li <?php echo ($page->menu == 'domains')?'class="active"':'' ?>> <a
                            href="#"><i class="icon-earth"></i> <span>Domains</span></a>
							<ul class="hidden-ul" <?php echo ($page->menu == 'domains')?'style="display: block;"':'style="display: none;"' ?>>
								<li <?php echo ($page->submenu=='domainslist')?'class="active"':'' ?>><a
										href="<?php echo url('domains') ?>"><i class="icon-list2"></i>List Domains</a>
								</li>
								<li <?php echo ($page->submenu=='domainSetting')?'class="active"':'' ?>><a
										href="<?php echo url('domains/domainSetting') ?>"><i class="icon-cog4  small-icon"></i>Domain Settings</a>
								</li>
                                                                <?php if (hasPermissions('manage_own_domain')): ?>
                                                                <li <?php echo ($page->submenu=='adminDomainsLogs')?'class="active"':'' ?>> <a
                                                                        href="<?php echo url('domains/activity_logs') ?>"><i class="icon-statistics"></i>
                                                                        <span>Domain Logs</span></a> </li>
                                                                <?php endif ?> 
							</ul>
                    </li>
                    <?php endif ?>

                    <?php if (hasPermissions('locations_list')): ?>
                    <li <?php echo ($page->menu=='locations')?'class="active"':'' ?>> <a
                            href="<?php echo url('panel/locations') ?>"><i class="icon-location3"></i>
                            <span>Locations</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('access_point_list')): ?> 
                    <li <?php echo ($page->menu=='accesspoints')?'class="active"':'' ?>> <a
                            href="<?php echo url('panel/accesspoints') ?>"><i class="icon-connection"></i> <span>Access
                                Points</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('campaigns_list')): ?> 
                    <li <?php echo ($page->menu=='campaigns')?'class="active"':'' ?>> <a
                            href="<?php echo url('panel/campaigns') ?>"><i class="icon-feed"></i> <span>Campaigns</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('activity_log_list')): ?>
                    <li <?php echo ($page->menu=='activity_logs')?'class="active"':'' ?>> <a
                            href="<?php echo url('activity_logs') ?>"><i class="icon-statistics"></i> <span>Activity
                                Logs</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('roles_list')): ?>
                    <li <?php echo ($page->menu=='roles')?'class="active"':'' ?>> <a
                            href="<?php echo url('roles') ?>"><i class="icon-lock"></i> <span>Manage Roles</span></a>
                    </li>
                    <?php endif ?>
                    <?php if (hasPermissions('permissions_list')): ?>
                    <li <?php echo ($page->menu=='permissions')?'class="active"':'' ?>> <a
                            href="<?php echo url('permissions') ?>"><i class="icon-key"></i> <span>Manage
                                Permissions</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('backup_db')): ?>
                    <li <?php echo ($page->menu=='backup')?'class="active"':'' ?>> <a
                            href="<?php echo url('backup') ?>"><i class=" icon-cloud-download"></i>
                            <span>Backup</span></a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('reporting') || hasPermissions('reporting')): ?>
                    <!-- <li <?php echo ($page->menu=='export')?'class="active"':'' ?>> <a
                            href="<?php echo url('panel/export') ?>"><i class="  icon-database-export"></i>
                            <span>Exports</span></a> </li> -->
                    <?php endif ?>
                    <?php if ( hasPermissions('company_settings') ): ?>
                    <li class="<?php echo ($page->menu=='setting')?'active':'' ?>"> <a href="#" class="has-ul "><i
                                class=" icon-cog2"></i> <span>Settings</span></a>
                        <ul class="hidden-ul" <?php echo ($page->menu=='setting')?'style="display: block;"':'style="display: none;"' ?> >
                            <li <?php echo ($page->submenu=='general')?'class="active"':'' ?>><a
                                    href="<?php echo url('settings/general') ?>">General Settings</a></li>
                            <li <?php echo ($page->submenu=='company')?'class="active"':'' ?>><a
                                    href="<?php echo url('settings/company') ?>">Company Settings</a></li>
                            <li <?php echo ($page->submenu=='login_theme')?'class="active"':'' ?>><a
                                    href="<?php echo url('settings/login_theme') ?>">Login Settings</a></li>
                            <li <?php echo ($page->submenu=='email_templates')?'class="active"':'' ?>><a
                                    href="<?php echo url('settings/email_templates') ?>">Manage Email Template</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <li>
                        
                                <?php 
                                        $domains = $this->domains_model->get();

                                        if( get_role_name()  == 'Business Owner' ){
                                                foreach ($domains as $row){
                                                        if($row->users_id == logged("id") && logged("role") != 1){

                                                                $expiryDate = $row->license_expiry_date;
                                                                $data =  licenceDateColor($expiryDate);
                                                                if( $data['isExpired'] ){

                                                                $this->session->set_flashdata('message', 'Your domain has expired. Please contact the administrator.');
                                                                redirect('/logout', 'refresh');

                                                                }else{
                                                                $color = (isset($data['color']))? $data['color'] : 'Data Not Available';
                                                                ?>
                                                                <div class="expire-notification">
                                                                        <?php echo (isset($data['date']))? 'Domain '.$data['date'] : "Data Not Available" ?>
                                                                </div>
                                                                <?php
                                                                }
                                                        }
                                                }
                                         }
                                ?>

                        
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navigation -->
    </div>
</div>
<!-- /main sidebar -->
<style>
.sidebar-category.sidebar-category-visible li {
    margin-top: 10px;
}
</style>