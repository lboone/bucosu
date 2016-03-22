<div class="topbar-right">
	<?php echo form_open('',array('class'=>'form-horizontal','role'=>'form','id'=>'default_event_selection_1')) ;?>
							<?php if (isset($bcs_esds)): ?>
								<div id="default_event_selection_form-group_1" class="form-group">
									<label for="inputSelect" class="col-lg-3 control-label">District</label>
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
		<!--<input type="button" class="button" value="Update Default" id="update_button_1">-->
	<?php echo form_close() ?>
</div>



