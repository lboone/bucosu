<h1>Companies</h1>
<p>Edit and/or create new companies</p>

<div id="infoMessage"><?php echo $message;?></div>

<!-- begin: .tray-center -->
<div class="tray tray-center">

	<div class="row">
		<div class="col-md-12">
		  <div class="panel panel-visible" id="spy1">
		    <div class="panel-heading">
		      <div class="panel-title hidden-xs">
		        <span class="glyphicon glyphicon-tasks"></span>Companies
		      </div>
		    </div>
		    <div class="panel-body pn">
			    <div class="table-responsive">
			      <table class="table table-striped table-hover" id="users-table" cellspacing="0" width="100%">
			          <thead>
						<tr>
							<th>Name</th>
							<th>Type</th>
							<th>phone</th>
							<th>Website</th>
							<th><?php echo lang('index_action_th');?></th>
						</tr>
					  </thead>
					  <tbody>
	 					<?php foreach ($companies as $company):?>
							<tr>
					            <td><?php echo htmlspecialchars($company->name,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($company->type_name,ENT_QUOTES,'UTF-8');?></td>
								<?php $phoneData = htmlspecialchars($company->phone,ENT_QUOTES,'UTF-8'); ?>
					            <td><?php echo "(".substr($phoneData, 0, 3).") ".substr($phoneData, 3, 3)."-".substr($phoneData,6); ?></td>
					            <td><a href="<?php echo htmlspecialchars($company->website,ENT_QUOTES,'UTF-8');?>" target="_blank"><?php echo htmlspecialchars($company->website,ENT_QUOTES,'UTF-8');?></a></td>
								<?php if($cur_user_level < 2 && $cur_user_group_type < 3): ?>
									<td><?php echo anchor("auth/edit_company/".$company->id, 'Edit') ;?></td>
								<?php else: ?>
									<td>Edit</td>
								<?php endif ?>
							</tr>
						<?php endforeach;?>
					  </tbody>
					</table>
				</div>
			</div>
		  </div>
		</div>
	</div>
</div>