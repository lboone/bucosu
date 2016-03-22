<?php
	if (!isset($list_item_table)) {
		$list_item_table = "Nothing found....";
	}

	$mi_title = null;
	$mi_single = null;
	$mi_plural = null;
	if (!isset($module_items)){
		$module_items = NULL;
	} else {
		if(isset($module_items['title'])){
			$mi_title = $module_items['title'];
		}
		if (isset($module_items['single'])) {
			$mi_single = $module_items['single'];
		}
		if(isset($module_items['plural'])){
			$mi_plural = $module_items['plural'];
		}
	}
?>

<div id="list_item_table_container"> <?php echo $list_item_table; ?> </div>


<div id="dialog-form-<?php echo $mi_single; ?>" title="Create New <?php echo $mi_title; ?>">
  <p class="validateTips">All form fields are required.</p>
  <form>
    <fieldset>
      <label for="<?php echo $mi_single; ?>"><?php echo $mi_title; ?></label>
      <input type="text" name="<?php echo $mi_single; ?>" id="<?php echo $mi_single; ?>_field" value="" class="text ui-widget-content ui-corner-all">

      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>