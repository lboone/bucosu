<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->
				<?php
						$rows = array();
						$values = explode(';',$q->values);
						foreach ($values as $v) {
							$r = explode('|',$v);
							$rows[] = array('label'=>$r[0], 'val'=>$r[1]);
						}
						$answer = array();
						if (isset($q->answer)) {
							$answer = unserialize($q->answer);
						}
				?>
				
				<?php foreach ($rows as $row): ?>
					<div class="checkbox-custom mb5 <?php if (isset($disabled)) { echo 'checkbox-' . $disabled; } ?>">

						<?php 
							$checked = FALSE;
							$dis = NULL;

							if (count($answer)> 0 ){
								$theVal = $row['val'];
								if (in_array($theVal, $answer)) {
									$checked = TRUE;
								} 
							} 
							if (isset($disabled)) {
								$dis = $disabled;
							}
							$params = array(
								'id'		=>'checkbox_'.  $q->slug . '_' . $row['val'],
								'name'		=> $q->slug . '[]',
								'value'		=> $row['val'],
								'checked'	=> $checked,
								'disabled'	=> $dis,
								);
							echo form_checkbox($params);
						?>
					  <label for="checkbox_<?php echo $q->slug . '_' . $row['val']; ?>"><?php echo trim($row['label']); ?></label>
					</div>
				<?php endforeach; ?>		
				<input type="hidden" name="<?php echo $q->slug; ?>[]" value="0" />
<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>