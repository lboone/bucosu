<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->
				<?php
						$rows = array();
						$values = explode(';',$q->values);
						foreach ($values as $v) {
							$r = explode('|',$v);
							$rows[] = array('label'=>$r[0], 'val'=>$r[1]);
						}
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
				?>
								
				
				<?php foreach ($rows as $row): ?>
				<div class="radio-custom mb5 <?php if (isset($disabled)) { echo 'radio-' . $disabled; } ?>">
					<?php 
							$checked = FALSE;
							$dis = NULL;
							
							$theVal = $row['val'];
							if ($answer == $theVal) {
								$checked = TRUE;
							} 
							
							if (isset($disabled)) {
								$dis = $disabled;
							}
							$params = array(
								'id'		=>'radio_'.  $q->slug . '_' . $row['val'],
								'name'		=> $q->slug,
								'value'		=> $row['val'],
								'checked'	=> $checked,
								'disabled'	=> $dis,
								);
							echo form_radio($params);
						?>
						  <label for="radio_<?php echo $q->slug . '_' . $row['val']; ?>"><?php echo trim($row['label']); ?></label>
					</div>	
				<?php endforeach; ?>				
<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>
