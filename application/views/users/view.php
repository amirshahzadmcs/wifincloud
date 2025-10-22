<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    User
    <small>manage user</small>
  </h1>
</section>

<!-- Main content -->
<section class="">


<div class="page-header">

    <div class="navbar navbar-default navbar-component navbar-xs profile-menu">
        <ul class="nav navbar-nav visible-xs-block">
            <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i
                        class="icon-menu7"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-filter">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#tab_1" data-toggle="tab"
                        aria-expanded="true" ><i
                            class="icon-profile position-left"></i> Overview</a></li>

                <li ><a  href="#tab_2" data-toggle="tab"
                        aria-expanded="false" ><i
                            class="icon-pencil7 position-left"></i> Activity</a></li>
				
				<?php if (hasPermissions('users_edit')): ?>
                <li ><a href="<?php echo url('users/edit/'.$User->id) ?>"
                        ><i
                            class="icon-user position-left"></i> Edit Profile</a></li>
				<?php endif ?>
				
            </ul>
        </div>
    </div>
</div>


<!-- Custom Tabs -->
  <div class="nav-tabs-custom">
	
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title">Edit 's details</h5>
			<div class="heading-elements">
				<ul class="icons-list">
					<li>
						<a data-action="collapse"></a>
					</li>
					<li>
						<a data-action="reload"></a>
					</li>
				</ul>
			</div> <a class="heading-elements-toggle"><i class="icon-more"></i></a>
		</div>
		<div class="panel-body">
	
		<div class="tab-content">
		  <div class="tab-pane active" id="tab_1">
			<div class="row">
				<div class="col-sm-2" style="padding-left: 50px;">
					<br>
					<img src="<?php echo userProfile($User->id) ?>" width="150" class="img-circle" alt="">
					<br>
				</div>
				<div class="col-sm-10" style="padding-left: 50px;">
					<table class="table table-xs custom-table">
						<tbody>
							<tr>
								<th width="160"><strong>Name</strong>:</th>
								<td><?php echo $User->name ?></td>
							</tr>
							<tr>
								<th><strong>Email</strong>:</th>
								<td><?php echo $User->email ?></td>
							</tr>
							<tr>
								<th><strong>Phone</strong>:</th>
								<td><?php echo $User->phone ?></td>
							</tr>
							<tr>
								<th><strong>Last Login</strong>:</th>
								<td><?php echo ($User->last_login!='0000-00-00 00:00:00')?date( setting('datetime_format'), strtotime($User->last_login)):'No Record' ?></td>
							</tr>
							<tr>
								<th><strong>username</strong>:</th>
								<td><?php echo $User->username ?></td>
							</tr>
							<tr>
								<th><strong>Role</strong>:</th>
								<td><?php echo $User->role->title ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		  </div>
		  <!-- /.tab-pane -->
		  <div class="tab-pane" id="tab_2">

			<table id="dataTable1" class="table table-xs">
				<thead>
				  <tr>
					<th>Id</th>
					<th>IP Address</th>
					<th>Message</th>
					<th>Date Time</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody>

				  <?php foreach ($User->activity as $row): ?>
					<tr>
					  <td width="60"><?php echo $row->id ?></td>
					  <td><?php echo !empty($row->ip_address)?'<a href="'.url('activity_logs/index?ip='.urlencode($row->ip_address)).'">'.$row->ip_address.'</a>':'N.A' ?></td>
					  <td>
						<a href="<?php echo url('activity_logs/view/'.$row->id) ?>"><?php echo $row->title ?></a>
					  </td>
					  <td><?php echo date('d M, Y', strtotime($row->created_at)) ?></td>
					  <td>
					  <ul class="icons-list">
							<li class="text-primary-600">
							<a href="<?php echo url('activity_logs/view/'.$row->id) ?>"  title="View Activity"   data-toggle="tooltip"><i class="icon-file-eye2"></i></a>
							</li>
						</ul>		          </td>
					</tr>
				  <?php endforeach ?>

				</tbody>
			  </table>

		  </div>
		  <!-- /.tab-pane -->
		  <div class="tab-pane" id="tab_3">
			Lorem Ipsum is simply dummy text of the printing and typesetting industry.
			Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
			when an unknown printer took a galley of type and scrambled it to make a type specimen book.
			It has survived not only five centuries, but also the leap into electronic typesetting,
			remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
			sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
			like Aldus PageMaker including versions of Lorem Ipsum.
		  </div>
		  <!-- /.tab-pane -->
		</div>
    </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->

</section>

<?php include viewPath('includes/footer'); ?>

