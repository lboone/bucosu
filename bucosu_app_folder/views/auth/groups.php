<h1>Groups</h1>
<p>Edit and/or create new groups</p>

<div id="infoMessage"><?php echo $message;?></div>

<!-- begin: .tray-center -->
<div class="tray tray-center">

	<div class="row">
		<div class="col-md-12">
		  <div class="panel panel-visible" id="spy1">
		    <div class="panel-heading">
		      <div class="panel-title hidden-xs">
		        <span class="glyphicon glyphicon-tasks"></span>Groups
		      </div>
		    </div>
		    <div class="panel-body pn">
			    <div class="table-responsive">
			      <table class="table table-striped table-hover" id="users-table" cellspacing="0" width="100%">
			          <thead>
						<tr>
							<th>Type</th>
							<th>Name</th>
							<th>Level</th>
							<th>Description</th>
							<th><?php echo lang('index_status_th');?></th>
							<th><?php echo lang('index_action_th');?></th>
						</tr>
					  </thead>
					  <tbody>
						<?php foreach ($groups as $group):?>
							<tr>
					            <td><?php echo htmlspecialchars($group->type_name,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($group->level,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?></td>
								<?php if($cur_user_level == 0): ?>
									<td><?php echo ($group->active) ? anchor("auth/deactivate_group/".$group->id, lang('index_active_link')) : anchor("auth/activate_group/". $group->id, lang('index_inactive_link'));?></td>
									<td><?php echo anchor("auth/edit_group/".$group->id, 'Edit') ;?></td>
								<?php else: ?>
									<td><?php echo ($group->active) ? lang('index_active_link') : lang('index_inactive_link');?></td>
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
