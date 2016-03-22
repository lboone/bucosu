<button id="bcs_event_back_button" class="btn btn-primary hidden hidden-print"><i class="fa fa-angle-double-left"></i> Go Back</button>


<div class="row" style="margin-top:-20px; background-color:white;">
	<div id="event_centent_heading" class="panel-body col-md-12 text-primary dark">
		<span id="event_content_district" ><?php if (isset($current_bcs_esd_name)) { echo $current_bcs_esd_name; } ?></span>
		<span class="text-muted p5">/</span>
		<span id="event_content_school"><?php if (isset($current_bcs_es_name)) { echo $current_bcs_es_name; } ?></span>
	</div>
</div>

<h1><div id="event_content_profile_title"></div></h1>

<div id="event_school_profile">
	<h1><?php if (isset($current_bcs_esd_name) && isset($current_bcs_es_name)) { echo $current_bcs_esd_name . ' - ' . $current_bcs_es_name;} else {echo 'BCS Event Performed'; } ?></span></h1>

	<?php if (isset($bcs_headings)): ?>
		<!--
			<pre> -->
				<div class="panel mb20">
					<div class="panel-heading">
						<span class="panel-title">
							<span class="fa fa-bar-chart-o"></span>
							BCS Event Completed
						</span>
					</div>
					<div class="panel-body">
						<?php print_r($bcs_percent_complete); ?>
					</div>
				</div>


		<!--
			</pre>
			<pre>
				<?php //print_r($bcs_headings); ?>
			</pre>
		-->
		<menu id="nestable-menu">
	        <button type="button" data-action="expand-all">Expand All</button>
	        <button type="button" data-action="collapse-all">Collapse All</button>
	    </menu>
		<div class="dd mb35" id="nestable">
			<ol class="dd-list">
				<?php foreach ($bcs_headings as $key => $value): ?>
					<li class="dd-item" data-id="<?php echo $key; ?>">
						<div class="dd-handle dd-nodrag"><?php print_r($key); ?><div class="pull-right w100"><?php echo $value['bar_chart']; ?></div></div>
						<ol class="dd-list">
							<?php foreach ($value['profiles'] as $key2 => $value2a): ?>
								<?php $value2 = $value2a['questions']; ?>
								<li class="dd-item" data-id="<?php echo $key2; ?>"><div class="dd-handle dd-nodrag"><?echo $key2; ?></div>
									<div class="dd-content">
										<table class="table table-striped table-responsive table-condensed table-hover mbn">
											<thead>
												<tr class="info">
													<th class="w20">#</th>
													<th>Question</th>
													<th class="w200">Answers</th>
												</tr>
											</thead>
											<tbody>
												<?php $nbr = 1;?>
												<?php foreach ($value2 as  $key3 =>$value3): ?>
													<tr>
														<td><?php echo $nbr; ?></td>
														<td><?php echo $value3['text']; ?></td>
														<?php if (is_array($value3['answers'])): ?>
															<?php $an = array(); ?>
															<?php foreach ($value3['answers'] as $ans): ?>
																<?php if (is_array($ans)): ?>
																	<?php foreach ($ans as $a): ?>
																		<?php if (is_numeric($a)): ?>
																			<?php if ( intval($a) !== 0): ?>
																				<?php array_push($an, $a); ?>		
																			<?php endif ?>
																		<?php else: ?>
																			<?php array_push($an, $a); ?>	
																		<?php endif ?>
																	<?php endforeach ?>
																<?php else: ?>
																	<?php if (is_numeric($ans)): ?>
																		<?php if ( intval($ans) !== 0): ?>
																			<?php array_push($an, $ans); ?>		
																		<?php endif ?>
																	<?php else: ?>
																		<?php array_push($an, $ans); ?>	
																	<?php endif ?>
																<?php endif ?>
																
															<?php endforeach ?>
															<!-- <td><?php //echo implode('<br />', array_unique($an)); ?></td> -->
															<?php if (!is_array_numeric($an)) { $an = array_keys(array_flip($an)); }?>
															<td><?php echo implode('<br />', $an); ?></td>
														<?php else: ?>
															<td></td>
														<?php endif ?>
														
													</tr>
													<?php $nbr = $nbr + 1;?>
												<?php endforeach ?>
												<tr>
													<td colspan="3">
														<?php if ($value2a['images']): ?>
																<div class="admin-form theme-primary center-block">
																	<div class="panel heading-border panel-primary">
																		<div class="panel-body bg-light">
																			<div class="sectionrow">
																				<div class="section-divider mb30">
				                        											<span><?php echo $key2; ?> - Uploaded Images</span>
				                      											</div>
																				<?php foreach ($value2a['images'] as $imgs): ?>
																					<?php foreach ($imgs as $img): ?>
																						<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
																							<a href="<?php echo $img['image_src'];?>" data-lightbox="image-<?php echo $img['image_psi'];?>" data-title="<?php echo $img['image_title'];?>" class="thumbnail">
																								<!--<img src="<?php echo $img['image_src'];?>" class="img-responsive lazyload">-->
																								<img data-original="<?php echo $img['image_src'];?>" class="img-responsive lazyload" width="<?php echo $img['width'];?>" height="<?php echo $img['height'];?>">
																							</a>
																						</div>
																					<?php endforeach ?>
																				<?php endforeach ?>
																			</div>
																		</div>
																	</div>
																</div>
														<?php endif ?>
														
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</li>
							<?php endforeach ?>
						</ol>
					</li>
				<?php endforeach ?>
			</ol>
		</div>
	<?php else: ?>
		<h2>Please select default a school district & school</h2>
	<?php endif ?>

	        <!-- Panel popup -->
        <div id="modal-panel" class="popup-basic bg-none mfp-with-anim mfp-hide">

          <div class="panel panel-alert">
            <div class="panel-heading">
              <span class="panel-icon">
                <i class="fa fa-lightbulb-o"></i>
              </span>
              <span class="panel-title">This is a reminder!</span>
            </div>
            <div class="panel-body">
              <h2 id="event_content_school_2" class="mt5 text-system"></h2>
              <p>Are you performing the event for this school? <br />
              If <strong>not</strong>, please change to the correct school, see below.</p>
              <hr class="short alt">
              <p>
              	<h4>To Update Current School:</h4>
              	<ol class="pl25">
              		<li>Locate the <strong>'Default Settings'</strong> tab in the <strong>'BCS Event'</strong> panel.</li>
              		<li>Select the correct 'School District'.</li>
              		<li>Select the correct 'School'.</li>
              		<li>Press the 'Update Default' button.</li>
              	</ol>
              	Or click this link to start over <a href="/bcs">Start Over</a>
              </p>
            </div>
            <div class="panel-footer text-right">
              <button id="sd_s_reminder_panel_button" class="btn btn-alert" type="button">OK</button>
            </div>
          </div>
        </div>
</div>

<div id="bcs_event_question_content" class="admin-form theme-primary"></div>
<?php 
	function is_array_numeric($arr=null){
		if ($arr !== null && is_array($arr)) {
			foreach ($arr as $a => $b)
				{
					if (!is_numeric($b)) {
						return false;
					}
				}
			return true;
		}
		return false;
	}
?>