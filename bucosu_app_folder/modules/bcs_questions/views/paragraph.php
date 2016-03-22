<?php if (isset($head)) { echo $head; } ?>

<!-- Begin unique part question -->

 	<label class="field prepend-icon"><!-- BEGIN: label.field -->
                
	     <?php 

	        $params = array(
	                          'name'        =>$q->slug,
	                          'id'          =>$q->slug,
	                          'class'       =>'event-notes gui-textarea',);

	        if (isset($disabled)) {
	        	$params['disabled']='disabled';
	        }
	        $notes_value = null;
	        if (isset($q->answer)) {
	        	$notes_value = $q->answer;
	        }
	        echo form_textarea($params,$notes_value); 
	     ?>
	     
	      <label for="<?php echo $q->slug; ?>" class="field-icon">
	        <i class="fa fa-comments"></i>
	      </label>
               
    </label><!-- END: label.field -->
			
<!-- End: unique part - quesiton -->

<?php if (isset($foot)) { echo $foot; } ?>
