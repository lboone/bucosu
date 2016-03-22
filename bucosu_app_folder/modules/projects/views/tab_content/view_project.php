<div id="view_project_tab_container" class=" <?php echo $tab_content_hidden['view_project'];?>" >

<?php if (isset($project_data)): ?>
	<?php $po = $project_data['project_object']; ?>

	<?php 
		$pids = array();
		$pidz = $project_data['project_purposes'];
		foreach ($pidz as $key => $value) {
			$pids[$value->id] = $value->project_purpose;
		}

		$tids = array();
		$tidz = $project_data['project_types'];
		foreach($tidz as $key => $value) {
				$tids[$value->id] = $value->project_type;
		}
		$stids = array();
		$stidz = $project_data['project_statuses'];
		foreach($stidz as $key => $value) {
				$stids[$value->id] = $value->project_status;
		}
	?>
	<div class="admin-form theme-primary tab-pane active" id="" role="tabpanel">
		<div class="panel panel-primary heading-border">
			<div class="panel-heading">
		    	<span class="panel-title">
		    		<i class="fa fa-tachometer"></i>Project Information</span>
		  	</div>
			<!-- end .form-header section -->

			<?php $hidden1 = array('name'=>'id','type'=>'hidden','id'=>'id', 'value'=>$po->id);?>
	        <?php $hidden2 = array('name'=>'is_bcs_project','type'=>'hidden','id'=>'is_bcs_project','value'=>$po->is_bcs_project);?>
	        <?php $hidden3 = array('name'=>'event_school_id','type'=>'hidden','id'=>'event_school_id','value'=>$po->event_school_id);?>			
			
			<?php echo form_open("save_project",array('id'=>'project_form_' . $po->id)); ?>
	        
	          <?php echo form_input($hidden1);?>
	          <?php echo form_input($hidden2);?>
	          <?php echo form_input($hidden3);?>

	            <div class="panel-body p25">
					<!-- BEGIN: Item Details - Detailed Description -->
					<div class="section row">
					  <div class="col-md-12">
					    <div class="section">
					      <?php echo form_label('Item Description','item_description',array('class'=>'field-label')); ?>
					      <label for="item_description" class="field prepend_icon">
					        <?php echo form_input(array('name'=>'item_description','type'=>'text','id'=>'item_description', 'class'=>"gui-input"),$po->item_description); ?>
					      </label>
					    </div>
					  </div>
					  <div class="col-md-12">
					    <div class="section">
					      <?php echo form_label('Detailed Description','detailed_description',array('class'=>'field-label')); ?>
					      <label for="detailed_description" class="field prepend_icon">
					        <?php echo form_textarea(array('name'=>'detailed_description','type'=>'text','id'=>'detailed_description', 'class'=>"gui-textarea"),$po->detailed_description); ?>
					        <span class="input-footer">
					          <strong>Hint:</strong>Provide a more detailed description of the project, for later reference.  Not used in the 5 Year Plan.</span>
					      </label>
					    </div>
					  </div>
					</div>
					<!-- END: Item Details - Detailed Description -->

					<!-- BEGIN: Year To Complete - Cost -->
					<div class="section row">
					  <div class="col-md-3">
					    <div class="section">
					      <?php echo form_label('Year To Complete','year_to_complete',array('class'=>'field-label')); ?>
					      <label for="year_to_complete" class="field prepend_icon">
					        <?php echo form_input(array('name'=>'year_to_complete','type'=>'text','id'=>'year_to_complete', 'class'=>"gui-input"),$po->year_to_complete); ?>
					      </label>
					    </div>
					  </div>
					  <div class="col-md-3">
					    <div class="section">
					      <?php echo form_label('Priority','priority',array('class'=>'field-label')); ?>
					      <label for="priority" class="field prepend_icon">
					        <?php echo form_input(array('name'=>'priority','type'=>'text','id'=>'priority', 'class'=>"gui-input"),$po->priority); ?>
					      </label>
					    </div>
					  </div>
					  <div class="col-md-3">
					    <div class="section">
					      <?php echo form_label('BCS Question Number','bcs_question_number',array('class'=>'field-label')); ?>
					      <label for="bcs_question_number" class="field prepend_icon">
					        <?php echo form_input(array('name'=>'bcs_question_number','type'=>'text','id'=>'bcs_question_number', 'class'=>"gui-input"),$po->bcs_question_number); ?>
					      </label>
					    </div>
					  </div>
					  <div class="col-md-3">
					    <div class="section">
					      <?php echo form_label('Cost','cost',array('class'=>'field-label')); ?>
					      <label for="cost" class="field prepend_icon">
					        <?php echo form_input(array('name'=>'cost','type'=>'text','id'=>'cost', 'class'=>"gui-input"),$po->cost); ?>
					      </label>
					    </div>
					  </div>
					</div>            
					<!-- END: Year To Complete - Cost -->

					<!-- BEGIN: Project Purpose - Project Type -->
					<div class="section row mb5">
					  <div class="col-md-4">
					    <div class="section">
					      <?php echo form_label('Project Purpose','purpose_id',array('class'=>'field-label')); ?>
					      <label for="purpose_id" class="field select">
					        <?php echo form_dropdown('purpose_id',$pids,$po->purpose_id,array('id'=>'purpose_id')); ?>
					        <i class="arrow double"></i>
					      </label>
					    </div>
					  </div>
					  <div class="col-md-4">
					    <div class="section">
					      <?php echo form_label('Project Type','type_id',array('class'=>'field-label')); ?>
					      <label for="type_id" class="field select">
					        <?php echo form_dropdown('type_id',$tids,$po->type_id,array('id'=>'type_id')); ?>
					        <i class="arrow double"></i>
					      </label>
					    </div>
					  </div>
					  <div class="col-md-4">
					    <div class="section">
					      <?php echo form_label('Project Status','status_id',array('class'=>'field-label')); ?>
					      <label for="status_id" class="field select">
					        <?php echo form_dropdown('status_id',$stids,$po->status_id,array('id'=>'status_id')); ?>
					        <i class="arrow double"></i>
					      </label>
					    </div>
					  </div>
					</div>            
					<!-- END: Project Purpose - Project Type -->
				</div>                        <!-- END .panel-body -->
				<div class="panel-footer">
					<button type="submit" id="view_project_save_btn" disabled class="button btn-primary">Save Project</button>
				</div>
	            <!-- end .form-footer section -->
			<?php echo form_close(); ?>
		</div>
	<!-- end .admin-form section -->
	</div>
<?php else: ?>

	<h2>You must provide a project to view/edit!</h2>

<?php endif ?>

	


</div>
