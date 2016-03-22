<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->

			<?php
					$answer = NULL;
					if (isset($q->answer)) {
						$answer = $q->answer;
					} else {

						$params = array(
							'type'		=>'hidden',
							'id'		=>'radio_'.  $q->slug . '_hidden',
							'name'		=> $q->slug,
							'value'		=> 0,
							'checked'	=> TRUE,
						);

						echo form_input($params);
					}

					$dis = NULL;
					if (isset($disabled)) {
						$dis = $disabled;
					}
			?>

			<div class="radio-custom mb5 <?php if (isset($disabled)) { echo 'radio-' . $disabled; } ?>">
			<?php 
					$checked = FALSE;
					if ($answer == "yes") {
						$checked = TRUE;
					} 
					$params = array(
						'id'		=>'radio_'.  $q->slug . '_yes',
						'name'		=> $q->slug,
						'value'		=> 'yes',
						'checked'	=> $checked,
						'disabled'	=> $dis,
						);
					echo form_radio($params);
				?>
				  <label for="radio_<?php echo $q->slug . '_yes'; ?>">Yes</label>
			</div>
			
			<div class="radio-custom mb5 <?php if (isset($disabled)) { echo 'radio-' . $disabled; } ?>">
				<?php 
					$checked = FALSE;
					if ($answer == "no") {
						$checked = TRUE;
					} 
					$params = array(
						'id'		=>'radio_'.  $q->slug . '_no',
						'name'		=> $q->slug,
						'value'		=> 'no',
						'checked'	=> $checked,
						'disabled'	=> $dis,
						);
					echo form_radio($params);
				?>
				  <label for="radio_<?php echo $q->slug . '_no'; ?>">No</label>
			</div>	

<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>