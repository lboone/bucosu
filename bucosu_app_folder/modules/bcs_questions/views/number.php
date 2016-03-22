<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->
	<label for="<?php echo $q->slug; ?>" class="field prepend-icon">
		 <input class="gui-input" type="text" id="<?php echo $q->slug; ?>" name="<?php echo $q->slug; ?>" <?php if (isset($disabled)) { echo $disabled; } ?> value="<?php if(isset($q->answer)){echo $q->answer; }?>">
		<label for="<?php echo $q->slug; ?>" class="field-icon">
			<i class="<?php if (isset($icon)) { echo $icon; } ?>"></i>
		</label>
	</label>
<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>
