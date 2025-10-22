<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include viewPath('includes/header'); ?>
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-location3 position-left"></i> <span class="text-semibold">Manage Subscribers</span> -
                List</h4>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Subscribers list</li>
        </ul>
        <ul class="breadcrumb-elements">
            <?php if (hasPermissions('edit_reporting') && get('domains')): ?>
            <!-- <li><a href="<?php  echo url('panel/reports/add') .'?domains='.get('domains') ?>"><i class="icon-add position-left"></i> Add new location</a></li> -->
            <?php endif ?>
        </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
    </div>
</div>
<!-- Main content -->
<section class="">
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php echo form_open('panel/reports', ['method' => 'GET', 'autocomplete' => 'off']); ?>
                    <div class="row">
                        <div class="col-sm-2 col-md-offset-2">
                            <div class="form-group">
                                <p style="margin-top: 20px"><strong>Filter :</strong> </p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="Filter-User">Domain</label> <span class="pull-right"><a href="#"
                                        onclick="event.preventDefault(); $('#Filter-User').val('').trigger('onchange')">clear</a></span>
                                <?php
                                //selecting only whats required by current id.
                                $domains = $this->domains_model->getByUserId(logged("id"));
                                $count_domain = count($domains);
                                
                                ?>
                                <select name="domains" id="Filter-User" onchange="$(this).parents('form').submit();"
                                    class="form-control select2">

                                    <?php if($count_domain > 1):  ?>
                                    <option value="">Select Domain</option>
                                    <?php endif; ?>

                                    <?php foreach ($domains as $row): ?>
                                    <?php $sel = (get('domains')==$row->id)?'selected':'' ?>
                                    <?php if($row->users_id == logged("id") && logged("role") != 1): ?>
                                    <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                                        <?php echo $row->domain_name ?>
                                    </option>
                                    <?php endif; ?>
                                    <?php if(logged("role") == 1): ?>
                                    <option value="<?php echo $row->id ?>" <?php echo $sel ?>>
                                        <?php echo $row->domain_name ?>
                                    </option>
                                    <?php endif; ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group" style="margin-top: 25px;"> <a
                                    href="<?php echo url('/panel/reports') ?>" class="btn btn-danger">Reset</a> </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($subscribers_list)): ?>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Subscribers</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li>
                        <a data-action="collapse"></a>
                    </li>
                    <li>
                        <a data-action="reload"></a>
                    </li>
                    <!--
                            <li>
                                <a data-action="close"></a>
                            </li>
-->
                </ul>
            </div> <a class="heading-elements-toggle"><i class="icon-more"></i></a>
        </div>
        <div class="panel-body"> 
			List of all subscribers for your business <code>You cann't delete this data</code>
			
        </div>
        <div class="table-responsive ">
            <table class="table table-xs">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Registered on</th>
                        <th>Login count</th>
                        <th>Last Visited</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                    
                                        foreach ($subscribers_list as $row):
                                            
                                        ?>
                    <tr>
                        <td>
                            <?php echo $row->id ?>
                        </td>
                        <td>
                            <?php echo $row->name ?>
                        </td>
                        <td>
                            <?php echo $row->phone ?>
                        </td>
                        <td>
                            <?php echo $row->email ?>
                        </td>

                        <td>
                            
                            <?php if (hasPermissions('edit_reporting')): ?>
                            <div class="switchery-xs">
                                <input type="checkbox" class="switchery" onchange="updateSubscriberStatus('<?php echo $row->id ?>', $(this).is(':checked'), <?php echo $domain_id ?> )" <?php echo ($row->status) ? 'checked' : '' ?> />
                            </div>
                            <!--  -->
                            <?php endif ?>
                        </td>
                        <td>
                            <?php echo $row->registered_on ?>
                        </td>
                        <td>
                            <?php echo $row->login_count ?>
                        </td>
                        <td>
                            <?php 
                                  echo $row->last_login_time;            
                                                ?>
                        </td>

                    </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
            <div class="datatable-footer">
                <div class="dataTables_paginate paging_simple_numbers"><?php echo $links; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Default box -->
</section>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/forms/styling/switchery.min.js"></script>
<script>
// Switchery toggle
var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
elems.forEach(function(html) {
    var switchery = new Switchery(html);
});
</script>
<!-- /.content -->
<script>
//                $('#dataTable1').DataTable();
//                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
//                elems.forEach(function (html) {
//                    var switchery = new Switchery(html, {
//                        size: 'small'
//                    });
//                });
window.updateSubscriberStatus = (id, status, domain_id) => {
    var status_var = status;
    if (status == true) {
        status_var = "enabled";
    } else {
        status_var = "disabled";
    }
    $.get('<?php echo url('panel/reports/change_status') ?>/' + id + '/' + domain_id, {
        status: status
    }, (data, status) => {
        if (data == 'done') {
            // code
            // alert('Status changed successfully!');

            // Success notification
            new PNotify({
                title: 'Success',
                text: 'Subscriber ' + status_var + ' successfully!',
                icon: 'icon-checkmark3',
                type: 'success'
            });


        } else {
            //alert('Unable to change Status ! Try Again');
            // error notification
            new PNotify({
                title: 'Error',
                text: 'Unable to change Status! Try Again',
                icon: 'icon-warning22',
                addclass: 'alert alert-warning alert-styled-right',
                type: 'error'
            });
        }
    })
}
</script>
<?php include viewPath('includes/footer'); ?>