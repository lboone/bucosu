<div class="section row mb5 q_type_<?php echo $file_type; ?>" id="question_row_<?php echo $q->id; ?>">
	<div class="col-sm-1 col-md-1 col-lg-1 text-right pr5">	
		<?php if ($q->alpha): ?>
				<?php echo $q->alpha; ?>
		<?php endif ?>
	</div>	

	<?php 
		$sm = 'col-sm-4';
		$md = 'col-md-4';
		$lg = 'col-lg-5';
	?>
	<div class="<?php echo $sm . ' ' . $md . ' ' . $lg; ?> ">
		<div class="section">
			<?php echo  $q->text; ?>
			<?php if ($q->reminder): ?>
				<span class="help-block mt5">
		  		<i class="fa fa-info"></i> <?php echo $q->reminder; ?></span>		
			<?php endif ?>

			<?php 
				if (strtolower($q->show_description == 1)) {	
					$dis = NULL;				
					$val = NULL;
					if (isset($disabled)) {
						$dis = $disabled;
					}
					if(isset($q->description)){
						$val = $q->description;
					}
					$params = array(
							'class'			=> 'form-control',
							'id'			=> 'description',
							'name'			=> 'desc_'. $q->slug,
							'value' 		=> $val,
							'rows'			=> '2',
							'style'			=> 'margin-top: 0px; margin-bottom: 0px; height: 52px;',
							'placeholder'	=> $q->description_placeholder,
							'disabled'		=> $dis,
						);
					echo form_textarea($params);
				}
			?>
		</div>
	</div>
	<div class="<?php echo $col_3; ?>">
		<div class="section">