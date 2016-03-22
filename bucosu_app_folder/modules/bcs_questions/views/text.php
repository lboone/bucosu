<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->

	<label for="<?php echo $q->slug; ?>" class="field prepend-icon">
		<input type="text" name="<?php echo $q->slug; ?>" id="<?php echo $q->slug; ?>" class="gui-input" <?php if (isset($disabled)) { echo $disabled; } ?> value="<?php if(isset($q->answer)){echo $q->answer; }?>">
		<label for="<?php echo $q->slug; ?>" class="field-icon">
			<i class="<?php if (isset($icon)) { echo $icon; } ?>"></i>
		</label>
	</label>
			
<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>
