<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="dashboard-container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Domains</h5>
				</div>
				<div class="panel-body"> List of all domains registered on admin panel that you can manage <a
						href="<?php echo base_url() ?>/domains"> click here </a>
				</div>
				<div class="table-responsive">
					<table class="table table-xs">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Approved</th>
								<th>Locations</th>
								<th>Access Points</th>
								<th>License Expiry</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php

							if (isset($domainss)) {
								foreach ($domainss as $row):

									?>
									<tr>
										<td>
											<?php echo $row->id ?>
										</td>
										<td>
											<?php echo ucfirst(strtolower($row->domain_name)); ?>
										</td>
										<td>
											<?php if ($row->approved == '1') { ?> <i class="icon-checkmark4  green"></i>
											<?php } else { ?>
												<i class="icon-cross2 red"></i>
											<?php } ?>
										</td>
										<td>
											<?php echo $row->no_of_locations ?>
										</td>
										<td>
											<?php echo $row->no_of_ap ?>
										</td>
										<td>
											<?php 
												$expiryDate = $row->license_expiry_date;
												$data =  licenceDateColor($expiryDate);
												$color = (isset($data['color']))? $data['color'] : 'Data Not Available';
											?>
											<span class="label label-flat border-<?php echo $color; ?> text-<?php echo $color; ?>-600">
												<?php echo (isset($data['date']))? ucfirst($data['date']) : "Data Not Available" ?>
											</span>
										</td>
										<td>
											<?php if ($row->status == '1') { ?><i class="icon-checkmark4  green"></i>
											<?php } else { ?>
												<i class="icon-cross2 red"></i>
											<?php } ?>
										</td>
									</tr>
								<?php
								endforeach;
							} else {
								?>
								<tr class="text-center">
									<td colspan="7">No records found</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="datatable-footer">
						<div class="dataTables_paginate paging_simple_numbers">
							<?php echo $links; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.red {
		color: red;
	}

	.green {
		color: green;
	}
</style>