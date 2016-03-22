<h1><?php echo lang('index_heading');?></h1>
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<!-- begin: .tray-center -->
<div class="tray tray-center">

	<div class="row">
		<div class="col-md-12">
		  <div class="panel panel-visible" id="spy1">
		    <div class="panel-heading">
		      <div class="panel-title hidden-xs">
		        <span class="glyphicon glyphicon-tasks"></span>Users
		      </div>
		    </div>
		    <div class="panel-body pn">
			    <div class="table-responsive">
			      <table class="table table-striped table-hover" id="users-table" cellspacing="0" width="100%">
			          <thead>
						<tr>
							<th><?php echo lang('index_fname_th');?></th>
							<th><?php echo lang('index_lname_th');?></th>
							<th><?php echo lang('index_email_th');?></th>
							<th>Company</th>
							<th>Type</th>
							<th><?php echo lang('index_groups_th');?></th>
							<th><?php echo lang('index_status_th');?></th>
							<th><?php echo lang('index_action_th');?></th>
						</tr>
					  </thead>
					  <tbody>
						<?php foreach ($users as $user):?>
							<tr>
					            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
					            <td><?php echo htmlspecialchars($user_companies[$user->id]['co_name'],ENT_QUOTES,'UTF-8');?></td>
								<td><?php echo htmlspecialchars($user->groups[0]->type_name,ENT_QUOTES,'UTF-8');?></td>
								<?php if($cur_user_level == 0): ?>
									<td><?php echo anchor("auth/edit_group/".$user->groups[0]->id, htmlspecialchars($user->groups[0]->name,ENT_QUOTES,'UTF-8')) ;?></td>
									<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
									<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>								
								<?php elseif ((in_array(intval($user->groups[0]->id), $user_can_add_groups)) || (intval($user->id) == intval($this->session->user_id))): ?>
									<td><?php echo htmlspecialchars($user->groups[0]->name,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
									<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
								<?php else: ?>
									<td><?php echo htmlspecialchars($user->groups[0]->name,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo ($user->active) ? lang('index_active_link') : lang('index_inactive_link');?></td>
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