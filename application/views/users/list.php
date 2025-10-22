<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <?php include viewPath('includes/header'); ?>
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-people position-left"></i> <span class="text-semibold">Manage Users</span> - List</h4> </div>
                 </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('') ?>"><i class="icon-home2 position-left"></i> Home</a></li>

                    <li class="active">Users list</li>
                </ul>
                <ul class="breadcrumb-elements">
                    <?php if (hasPermissions('users_add')): ?>
                    <li><a class="bg-teal-400" href="<?php echo url('users/add') ?>"><i class="icon-add position-left"></i> Add new user</a></li>
                    <?php endif ?>
                </ul> <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a></div>
        </div>
        <!-- Main content -->
        <section class="">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Users</h5>
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
                    </div> <a class="heading-elements-toggle"><i class="icon-more"></i></a></div>
                <div class="panel-body"> List of all users registered on admin panel</div>
                <div class="table-responsive">
                    <table class="table table-xs">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Last login</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $row): ?>
                                <tr>
                                    <td width="60">
                                        <?php echo $row->id ?>
                                    </td>
                                    <td width="50" class="text-center"> <img src="<?php echo userProfile($row->id) ?>" width="40" height="40" alt="" class="img-avtar"> </td>
                                    <td>
                                        <?php echo $row->name ?>
                                    </td>
                                    <td>
                                        <?php echo $row->email ?>
                                    </td>
                                    <td>
                                        <?php echo ucfirst($this->roles_model->getById($row->role)->title) ?>
                                    </td>
                                    <td>
                                        <?php echo ($row->last_login!='0000-00-00 00:00:00')?date( setting('date_format'), strtotime($row->last_login)):'No Record' ?>
                                    </td>
                                    <td>
                                        <?php if (logged('id')!==$row->id): ?>
										<div class="switchery-xs">
                                            <input type="checkbox" class="js-switch switchery" onchange="updateUserStatus('<?php echo $row->id ?>', $(this).is(':checked') )" <?php echo ($row->status) ? 'checked' : '' ?> />
											</div>
                                            <?php endif ?>
											 
                                    </td>
                                    <td>
                                        <ul class="icons-list">
                                            <?php if (hasPermissions('users_edit')): ?>
                                                <li class="text-primary-600"><a href="<?php echo url('users/edit/'.$row->id) ?>" title="Edit User"><i class="icon-pencil7"></i></a></li>
                                                <?php endif ?>
                                                    <?php if (hasPermissions('users_view')): ?>
                                                        <li class="text-teal-600"><a href="<?php echo url('users/view/'.$row->id) ?>" title="View User"><i class="icon-cog7"></i></a></li>
                                                        <?php endif ?>
                                                            <?php if (hasPermissions('users_delete')): ?>
                                                                <li class="text-danger-600">
                                                                    <?php if ($row->id!=1 && logged('id')!=$row->id): ?> <a href="<?php echo url('users/delete/'.$row->id) ?>" onclick="return confirm('Do you really want to delete this user ?')" title="Delete User" data-toggle="tooltip"><i class="icon-trash"></i></a>
                                                                        <?php else: ?> <a href="#" title="You cannot Delete this User" data-toggle="tooltip" disabled><i class="icon-trash"></i></a>
                                                                            <?php endif ?>
                                                                </li>
                                                                <?php endif ?>
                                        </ul>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
<script>
//                $('#dataTable1').DataTable();
//                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
//                elems.forEach(function (html) {
//                    var switchery = new Switchery(html, {
//                        size: 'small'
//                    });
//                });
                window.updateUserStatus = (id, status) => {
					
                    $.get('<?php echo url('users/change_status') ?>/' + id, {
                            status: status
                        }, (data, status) => {
                           if (data == 'done') {
							   // code
							   // alert('Status changed successfully!');
				   
							   // Success notification
							   new PNotify({
								   title: 'Success',
								   text: 'Status has been successfully changed!',
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
            