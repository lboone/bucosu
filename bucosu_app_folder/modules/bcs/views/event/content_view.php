<button id="bcs_event_back_button" class="btn btn-primary hidden hidden-print mr20"><i class="fa fa-angle-double-left"></i> Back To Dashboard</button>
<button id="bcs_event_print_button" class="btn btn-success hidden hidden-print"><i class="fa fa-print"></i> Event Print Page</button>

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
													<th class="w300">Answers</th>
												</tr>
											</thead>
											<tbody>
												<?php $nbr = 1;?>
												<?php foreach ($value2 as  $key3 =>$value3): ?>
													<?php $question = $value3; ?>
													<tr>
														<td><?php echo $nbr; ?></td>
														<td><?php echo $value3['text']; ?></td>
														<?php $answers = $question['answers']; ?>
														<?php if (is_array($answers)): ?>
															<td><?php echo process_answers(array('answers'=>$answers,'type'=>$question['q_type'],'rule'=>$question['q_rule_report'],'custom'=>$question['q_rule_custom'])); ?>
																<?php 
																	if(isset($question['descs'])){
																		
																		if(is_array($question['descs'])){

																			if($question['descs'][0] != null){
																				echo('<br /><small><em>' . $question['descs'][0] . '</em></small>');
																			}
																		} else {
																			if($question['descs'] != null && $question['descs'] != "none") {
																				echo('<br /><small><em>' . $question['descs'] . '</em></small>');
																			}
																		}
																	} 
																?>
															</td>															
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
																						<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
																							<a href="<?php echo $img['image_src'];?>" data-lightbox="image-<?php echo $img['image_psi'];?>" data-title="<?php echo $img['image_title'];?>" class="thumbnail">
																								<img src="http://bucosu.com/attachments/app/bcs/ui/loading.gif" data-original="<?php echo $img['image_src'];?>" class="img-responsive lazyload" width="<?php echo $img['width'];?>" height="<?php echo $img['height'];?>">
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

			<div class="section row mb5 mt20">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-right">
					<button id="go_to_top" type="button" class="btn btn-default btn-rounded pull-right">
    					<i class="fa fa-chevron-up text-success"></i>
  					</button>
				</div>

			</div>
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


	function process_answers($answers_to_process){
		$all_answers 	= $answers_to_process['answers'];
		$type 			= $answers_to_process['type'];
		$rule 			= $answers_to_process['rule'];
		$custom 		= $answers_to_process['custom'];

		$ans = array();
		foreach ($all_answers as $key => $answers) {
			if (is_array($answers)) {
				foreach ($answers as $answer) {
					if (is_numeric($answer)) {
						$found = false;

						if ( (($type == 'Multi' || $type == 'Single') && intval($answer) == 0) ) {
							$found = true;
						}
						if (!$found) {
							array_push($ans,$answer);
						}
					} else {
						array_push($ans,strtoupper(str_replace("_"," ",$answer)));
					}
				}	
			} else {
				if (is_numeric($answers)) {
					$found = false;
					if ( (($type == 'Multi' || $type == 'Single') && intval($answers) == 0) ) {
						$found = true;
					}
					if (!$found) {
						array_push($ans,$answers);
					}
				} else {
					array_push($ans,strtoupper(str_replace("_"," ",$answers)));
				}
			}
		}
		

		if (!is_array_numeric($ans)) { $ans = array_keys(array_flip($ans));}

			if ($rule && function_exists("bcs_" . $rule)) {
				$rule = "bcs_".$rule;
					$ans = $rule($ans);
					return $ans;
			} else {
				return Trim(implode(', ', $ans));
			}

	}

	function bcs_sum($answers){
		return array_sum($answers);
	}
	function bcs_max($answers){
		return max($answers);
	}
	function bcs_min($answers){
		return min($answers);
	}
	function bcs_condition_best($answers){

		$cond = array(
			'EXCELLENT'			=> 6,
			'GOOD'				=> 6,
			'SATISFACTORY'		=> 5,
			'FAIR'				=> 5,
			'UNSATISFACTORY'	=> 4,
			'NON FUNCTIONAL'	=> 3,
			'FAILING'			=> 2,
			'CRITICAL FAILURE'	=> 1,
			'POOR'				=> 1,
			);
		$fin_cond = 0;
		$fin_cond_index = '';

		foreach ($answers as $answer) {
			$cur_cond = $cond[$answer];
			if ($cur_cond > $fin_cond) {
				$fin_cond = $cur_cond;
				$fin_cond_index = $answer;
			}
		}
		return $fin_cond_index;
	}
	function bcs_condition_worst($answers){
		$cond = array(
			'EXCELLENT'			=> 1,
			'GOOD'				=> 1,
			'SATISFACTORY'		=> 2,
			'FAIR'				=> 2,
			'UNSATISFACTORY'	=> 3,
			'NON FUNCTIONAL'	=> 4,
			'FAILING'			=> 5,
			'CRITICAL FAILURE'	=> 6,
			'POOR'				=> 6,
			);
		$fin_cond = 0;
		$fin_cond_index = '';

		foreach ($answers as $answer) {
			$cur_cond = $cond[$answer];
			if ($cur_cond > $fin_cond) {
				$fin_cond = $cur_cond;
				$fin_cond_index = $answer;
			}
		}
		return $fin_cond_index;
	}

	function bcs_yn_any_y($answers) {
		$y_found = false;

		if (is_array($answers)) {
			foreach ($answers as $answer) {
				if (strtolower($answer) == 'yes') {
					$y_found = true;
				}
			}
		} else {
			if (strtolower($answers) == 'yes') {
				$y_found = true;
			}
		}

		if ($y_found) {
			return 'YES';
		} else {
			return 'NO';
		}
	}

	function bcs_yn_any_n($answers) {
		$n_found = false;
		if (is_array($answers)) {
			foreach ($answers as $answer) {
				if (strtolower($answer) == 'no') {
					$n_found = true;
				}
			}			
		} else {
			if (strtolower($answers) == 'no') {
				$n_found = true;
			}
		}

		if ($n_found) {
			return 'NO';
		} else {
			return 'YES';
		}
	}
?>