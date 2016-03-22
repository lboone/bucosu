<div id="bcs_event_question_content_container" class="panel heading-border panel-primary">
	<div class="container-xl container-fluid">
		<div id="bcs_questions_form_container">
			<?php 
				if (!isset($profile_school_id)) {
					$profile_school_id = '';
				}
				if (!isset($form_status)){
					$form_status = 'new';
				}
				$params = array(
									'id'	=> 'bcs_questions_form_1',
								);

				$hidden = array('profile_school_id'=>$profile_school_id, 'form_status_2'=>$form_status);
				echo form_open("bcs_questions_school/save",$params,$hidden);

				foreach ($form_data as $value) {
					echo $value;
				}
				echo form_close();
			?>
		</div> <!-- end #bcs_questions_form_container -->
	</div> <!-- end .container-xl container-fluid -->
</div> <!-- end #bcs_event_question_content_container -->