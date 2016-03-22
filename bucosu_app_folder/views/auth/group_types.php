<div class="theme-info tab-pane center-block mw500" id="group_types" role="tabpanel">
<h1>Group Types</h1>
<p>For reference</p>

<div id="infoMessage"><?php echo $message;?></div>

<!-- begin: .tray-center -->
<div class="tray tray-center">

	<div class="row">
		<div class="col-md-12">
		  <div class="panel panel-visible" id="spy1">
		    <div class="panel-heading">
		      <div class="panel-title hidden-xs">
		        <span class="glyphicon glyphicon-tasks"></span>Group Types
		      </div>
		    </div>
		    <div class="panel-body pn">
		    <div class="table-responsive">
		      <table class="table table-striped table-hover" id="users-table" cellspacing="0" width="100%">
		          <thead>
					<tr>
						<th>Name</th>
					</tr>
				  </thead>
				  <tbody>
 					<?php foreach ($group_types as $group_type):?>
						<tr>
				            <td><?php echo htmlspecialchars($group_type->name,ENT_QUOTES,'UTF-8');?></td>
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
</div>