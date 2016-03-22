<div class="row">

	<div class="col-md-12">
		<div class="panel-group accordion" id="accordion">
			<div class="panel">	<!-- Input Fields -->
				<div class="panel-heading">
					<a class="accordion-toggle accordion-icon link-unstyled" data-toggle="collapse" data-parent="#accordion" href="#accord1" aria-expanded="true">
					Default Event Selection
					</a>
				</div>
				<div id="accord1" class="panel-collapse collapse in" style="" aria-expanded="true">
					<div class="panel-body">
						<?php echo form_open('',array('class'=>'form-horizontal','role'=>'form','id'=>'default_event_selection_1')) ;?>
							<?php if (isset($bcs_esds)): ?>
								<div id="default_event_selection_form-group_1" class="form-group">
									<label for="inputSelect" class="col-lg-3 control-label">School District</label>
									<div class="col-lg-8">
										<div class="bs-component">
											<select class="form-control" id="bcs_events_school_district_1">
												<option name="bcs_events_school_district" value="empty">Please select a school district event...</option>
												<?php foreach ($bcs_esds as $esd): ?>
													<?php if (intval($esd->id) == intval($current_bcs_esd)){$select='selected="select"';}else{$select="";} ?>
													<option name="bcs_events_school_district" <?php echo $select; ?> value="<?php echo $esd->id;?>"><?php echo $esd->event_name; ?></option>				
												<?php endforeach ?>
											</select>
											
										</div>
									</div>
								</div>
							<?php endif ?>

							<?php if (isset($bcs_ess)): ?>
								<div class="form-group">
									<label for="inputSelect" class="col-lg-3 control-label">Current School</label>
										<div class="col-lg-8">
											<div class="bs-component">
												<select class="form-control" id="bcs_events_school_1">
													<?php if (is_array($bcs_ess)): ?>
														<?php foreach ($bcs_ess as $es): ?>
															<?php if (intval($es->id) == intval($current_bcs_es)){$select='selected="select"';}else{$select="";} ?>
															<option name="bcs_events_school" <?php echo $select; ?> value="<?php echo $es->id;?>"><?php echo $es->school_name; ?></option>				
														<?php endforeach ?>
													<?php else: ?>
														<option name="bcs_events_school"><?php echo $bcs_ess; ?></option>
													<?php endif ?>	
												</select>
											</div>
										</div>
									</div>	
							<?php endif ?>
							<input type="button" class="button" value="Update Default" id="update_button_1">
						<?php echo form_close() ?>
					</div><!-- End panel-body -->
				</div><!-- end panel-collapse -->
			</div>	<!-- End Input Field -->		
		</div> <!-- end panel-group -->
	</div>	<!-- End col-md-12 -->

</div>	<!-- End row -->