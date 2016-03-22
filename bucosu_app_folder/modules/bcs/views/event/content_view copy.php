
<div class="row" style="margin-top:-20px; background-color:white;">
	<div id="event_centent_heading" class="panel-body col-md-12 text-primary dark">
		<span id="event_content_district" ></span>
		<span class="text-muted p5">/</span>
		<span id="event_content_school"></span>
	</div>
</div>

<h1><div id="event_content_profile_title"></div></h1>

<div id="event_school_profile">
	<h1>The BCS Form for completing the BCS on the States Website, for above referenced School District</h1>

	<?php if (isset($bcs_headings)): ?>
		<!--
			<pre> -->
				<?php print_r($bcs_percent_complete); ?>
				<br/>
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
							<?php foreach ($value['profiles'] as $key2 => $value2): ?>
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
																		<?php array_push($an, $a); ?>	
																	<?php endforeach ?>
																<?php else: ?>
																	<?php array_push($an, $ans); ?>	
																<?php endif ?>
																
															<?php endforeach ?>
															<td><?php echo implode(', ', array_unique($an)); ?></td>
														<?php else: ?>
															<td></td>
														<?php endif ?>
														
													</tr>
													<?php $nbr = $nbr + 1;?>
												<?php endforeach ?>
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
</div>

<div id="bcs_event_question_content" class="admin-form theme-primary"></div>