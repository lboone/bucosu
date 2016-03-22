<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->
<label for="<?php echo $q->slug; ?>" class="field prepend-icon">
	<input type="text" id="<?php echo $q->slug; ?>"  name="<?php echo $q->slug; ?>" class="gui-input" value="<?php if(isset($q->answer)){echo $q->answer; }?>" <?php if (isset($disabled)) { echo $disabled; } ?>>
	<label for="<?php echo $q->slug; ?>" class="field-icon">
		<i class="<?php if (isset($icon)) { echo $icon; } ?>"></i>
	</label>
</label>
<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>
