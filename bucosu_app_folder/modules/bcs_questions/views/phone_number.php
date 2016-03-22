<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->
<label for="<?php echo $q->slug; ?>" class="field prepend-icon">
	<input type="text" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" maxlength="14" minlength="14" placeholder="(518) 123-4567" name="<?php echo $q->slug; ?>" id="<?php echo $q->slug; ?>" class="gui-input" value="<?php if(isset($q->answer)){echo $q->answer; }?>" <?php if (isset($disabled)) { echo $disabled; } ?>>
	<label for="<?php echo $q->slug; ?>" class="field-icon">
		<i class="<?php if (isset($icon)) { echo $icon; } ?>"></i>
	</label>
</label>
<!-- End: unique part - quesiton -->
<?php if (isset($foot)) { echo $foot; } ?>
