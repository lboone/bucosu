<div id="event_school_profile">
	<?php if (isset($bcs_headings)): ?>
		<div class="row">
			<div class="col-md-12">
				<button id="bcs_event_back_button" class="btn btn-primary hidden hidden-print mr20"><i class="fa fa-angle-double-left"></i> Back To Dashboard</button>
				<button id="bcs_event_print_page_button" class="btn btn-success hidden hidden-print"><i class="fa fa-print"></i> Print Event Document</button>
			</div>

			<div class="col-md-12" id="invoice-item">
	            <div class="row mb10 mt10">
	              <div class="col-md-12">
	                <div class="pull-left">
	                  <h1 class="lh10 mt10"><?php if (isset($current_bcs_es_name)) { echo $current_bcs_es_name;} else {echo 'School'; } ?></h1>
	                  <h5 class="mn"><?php if (isset($current_bcs_esd_name)) { echo $current_bcs_esd_name;} else {echo 'School District'; } ?></h5>
	                </div>
	              </div>
	            </div>

	            <pre>
		            <?php print_r(json_encode($bcs_headings)); ?>
	            </pre>

				<?php foreach ($bcs_headings as $bcs_heading_title => $bcs_heading): ?>
					<div class="row" id="<?php echo(strtoupper($bcs_heading['slug'])); ?>">
						<div class="col-md-12">
							<div class="panel panel-alt avoid-page-break-inside">
								<div class="panel-heading text-center text-uppercase">
									<strong style="font-size:18px"><?php print_r($bcs_heading_title); ?></strong>
								</div>
								<div class="panel-body">
									<?php $profiles = $bcs_heading['profiles']; ?>
									<?php foreach ($profiles as $profile_title => $profile): ?>
										<table class="table table-striped table-responsive table-condensed table-hover table-bordered mb10 mtn avoid-page-break-inside">
											<thead>
												<tr>
													<th colspan="3"><?echo $profile_title; ?></th>
												</tr>
											</thead>
											<tbody>
												<?php $nbr = 1;?>
												<?php $questions = $profile['questions']; ?>
												<?php foreach ($questions as  $question_number => $question): ?>
													<tr>
														<td class="w20"><?php echo $nbr; ?></td>
														<td class="w300"><?php echo $question['text']; ?></td>
														<?php $answers = $question['answers']; ?>
														<?php if (is_array($answers)): ?>
															<td><?php echo process_answers(array('answers'=>$answers,'type'=>$question['q_type'],'rule'=>$question['q_rule_report'],'custom'=>$question['q_rule_custom'])); ?></td>
														<?php else: ?>
															<td></td>
														<?php endif ?>
													</tr>
													<?php $nbr = $nbr + 1;?>
												<?php endforeach ?>
												<!-- The Images if set to show them: -->
												<?php if (isset($show_images)): ?>
													<?php if ($profile['images']): ?>
														<tr class="no-touch">
															<td colspan="3">
																<div class="wrap">
																	<?php foreach ($profile['images'] as $imgs): ?>
																		<?php foreach ($imgs as $img): ?>
																			<div class="box">
																				<div class="boxInner">
																					<img src="<?php echo $img['image_src'];?>" />
																				</div>
																			</div>
																		<?php endforeach ?>
																	<?php endforeach ?>
																</div>
															</td>
														</tr>
													<?php endif ?>
												<?php endif ?>
												<!-- End: The Images -->
											</tbody>
										</table>
									<?php endforeach ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>

		<div class="section row mb5 mt20 hidden-print">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-right">
				<button id="go_to_top" type="button" class="btn btn-default btn-rounded pull-right">
					<i class="fa fa-chevron-up text-success"></i>
					</button>
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
				return implode(', ', $ans);
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
			'SATISFACTORY'		=> 5,
			'UNSATISFACTORY'	=> 4,
			'NON FUNCTIONING'	=> 3,
			'FAILING'			=> 2,
			'CRITICAL FAILURE'	=> 1,
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
			'SATISFACTORY'		=> 2,
			'UNSATISFACTORY'	=> 3,
			'NON FUNCTIONING'	=> 4,
			'FAILING'			=> 5,
			'CRITICAL FAILURE'	=> 6,
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
?>