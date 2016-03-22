<div id="view_projects_tab_container" class="admin-form <?php echo $tab_content_hidden['view_projects'];?>" >
	<div id="new_project_message_alert">
		<?php if ($this->session->flashdata('new_project_message')): ?>
			<div class="alert alert-micro alert-border-left alert-success alert-dismissable" >
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			  <i class="fa fa-check pr10"></i>
			  <strong>Project Saved! </strong> <?php echo $this->session->flashdata('new_project_message');?>
			</div>
		<?php endif ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-visible" id="spy6">
				<div class="panel-heading">
					<div class="panel-title hidden-xs">
						<span class="glyphicon glyphicon-tasks"></span><span id="view_projects_table_header"><?php if( isset( $project_school_district_name ) ) { echo $project_school_district_name; } ?></span></div>
				</div>
				<div class="panel-body pn">
					<table class="table display table-hover dataTable" id="view_projects_table" role="grid" cellspacing="0" width="100%">
						<thead>
						  <tr>
						    <th>School</th>
						    <th>Description</th>
						    <th class="hidden-xs">Purpose</th>
						    <th class="hidden-xs">Type</th>
						    <th class="hidden-xs hidden-sm">Yr</th>
						    <th class="hidden-xs hidden-sm">Priority</th>
						    <th class="hidden-xs hidden-sm">BCS#</th>
						    <th>Cost</th>
						    <th class="hidden-xs">Status</th>
						    <th class="hidden-print"></th>
						  </tr>
						</thead>
						<tfoot>
						  <tr>
						  	<th>School</th>       
						    <th>Description</th>
						    <th class="hidden-xs">Purpose</th>
						    <th class="hidden-xs">Type</th>
						    <th class="hidden-xs hidden-sm">Yr</th>
						    <th class="hidden-xs hidden-sm">Priority</th>
						    <th class="hidden-xs hidden-sm">BCS#</th>
						    <th>Cost</th>
						    <th class="hidden-xs">Status</th>
						    <th class="hidden-print"></th>
						  </tr>
						</tfoot>
						<tbody id="view_project_body">
							<?php if (isset($view_projects_body)){echo $view_projects_body;} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>	
</div>