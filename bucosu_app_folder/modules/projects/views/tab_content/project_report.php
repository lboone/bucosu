<div id="project_report_tab_container" class="admin-form <?php echo $tab_content_hidden['project_report'];?>" >

	<?php if (isset($report_data)): ?>
<!-- 		<pre>
		<?php //var_dump($report_data); ?>
		</pre> -->
		<?php $reportName = strtoupper(str_replace(array("_"), array(" "), $report_data["report_name"])); ?>
		<h1><?php echo($reportName) ?></h1>
		<hr>
		<?php $rptObjs = $report_data["report_object"]; ?>
		<?php
			switch ($report_data["report_name"]) {
				case 'district_summary':
					# code...
					break;
				case 'building_estimate':
					// echo '<pre>';
					// var_dump($rptObjs);
					// echo '</pre>';
					$rptYears = array();

					foreach ($rptObjs as $rptObj) {
						$yr = intval($rptObj->year_to_complete);
						$rptYears[$yr][] = $rptObj;
					}
					ksort($rptYears);
					$rptYears2 = array();
					foreach ($rptYears as $key => $value) {
						$rptYr2 = array();
						foreach ($value as $val){
							$rptYr2[intval($val->priority)][] = $val;
						}
						ksort($rptYr2);
						$rptYears[$key] = $rptYr2;
					}

		
					echo('<div class="panel mb20">');
					echo('<div class="panel-heading">');
					echo('<div class="row" style="font-size:18px; color: rgb(102, 102, 102) !important;">');
					echo('<div class="col-md-4">District or Board Name:</div><div class="col-md-8">' . $report_data["project_school_district_name"] . '</div>');
					echo('<div class="col-md-4">Facility Name: </div><div class="col-md-8">' . $report_data["project_school_name"] . '</div>');
					echo('<div class="col-md-4">SED Number:</div><div class="col-md-8">53060001</div>');
					echo('</div>');
					echo('</div>');
					echo('<div class="panel-body pn"><table style="font-size:13;" class="table table-responsive table-condensed table-hover mbn">');
					echo('<thead>');
					echo('<tr class="dark" style=><th></th/><th></th><th></th><th></th><th>New<br/>Construction</th><th>Addition</th><th>Alteration</th><th>Major<br/>System</th><th>Major<br/>Repair</th><th>Energy</th><th>Bond</th><th>Capital</th><th></th></tr>');
					echo('</thead>');
					echo('<tbody>');
					$facilityTot = 0;
					foreach ($rptYears as $key => $value) {
						echo('<tr class="primary">');
						echo('<td>Year ' . $key . '</td/><td>Priority</td><td>BCS#</td><td colspan="9">Item Description</td><td align="right">Cost</td>');
						echo('</tr>');
						$priorityTot = 0;
						foreach($value as $key2 => $value2) {
							foreach ($value2 as $key3 => $value3) {
								$tmpPriorityTot= intval($value3->cost);
								$purpose = intval($value3->purpose_id);
								$nc = "";
								$ad = "";
								$al = "";
								$ms = "";
								$mr = "";
								$en = "";
								if ($purpose == 1) {
									$ad = "X";
								} else if ($purpose == 2) {
									$al = "X";
								} else if ($purpose == 3) {
									$ms = "X";
								} else if ($purpose == 4) {
									$mr = "X";
								} else if ($purpose == 5) {
									$en = "X";
								} else if ($purpose == 6) {
									$nc = "X";
								}
								
								$type = intval($value3->type_id);
								$bo = "";
								$ca = "";
								if ($type == 1) {
									$bo = "X";
								} else if ($type == 2){
									$ca = "X";
								}
								echo('<tr class="" ><td></td>');
								echo('<td>' .$key2. '</td><td>'.$value3->bcs_question_number.'</td><td>' . $value3->item_description . '</td><td>'. $nc .'</td><td>'. $ad .'</td><td>'. $al .'</td><td>'. $ms .'</td><td>'. $mr .'</td><td>'. $en .'</td><td>'. $bo .'</td><td>'. $ca .'</td><td align="right">$'. number_format(floatval($value3->cost),2,'.',',') . '</td>');
								echo('</tr>');
								$priorityTot = $priorityTot + $tmpPriorityTot;
							}
						}
						echo('<tr class="system"><td colspan="4" align="right">Priority Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align="right">$'. number_format(floatval($priorityTot),2,'.',',') .'</td></tr>');
						echo('<tr class="default"><td colspan="13"></td></tr>');
						$facilityTot = $facilityTot + $priorityTot;
					}

					echo('<tr class="dark"><td colspan="4"  align="right">Facility Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align="right">$'. number_format(floatval($facilityTot),2,'.',',') .'</td></tr>');
					echo('</tbody>');
					echo('</table></div></div>');
					break;
				default:
					# code...
					break;
			}
		?>

	<?php else: ?>

		<h2>Oops!  There was an error getting your report, please try again.</h2>

	<?php endif ?>	
	
</div>