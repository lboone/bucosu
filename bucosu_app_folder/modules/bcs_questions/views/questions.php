<div id="bcs_event_question_content_container" class="panel heading-border panel-primary">
	<div id="read_only_message" class="mb10">
		<div class="well">
			<h3 class="text-info mn text-center">You must save a new Profile before you can answer the questions.</h3>
		</div>
	</div>
	<div class="container-xl container-fluid">
		<div class="section-divider mb40" id="spy1">
			<span>3. Complete Questions</span>
		</div>
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
			?>
			<div class="section-divider mb40" id="spy1">
				<span>4. Save Questions</span>
			</div>
			<div id="bottom_of_form_controlls" class="section row mb5">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-left mb20 pl20">
					<button href="#" id="go_to_top" type="button" class="btn btn-default btn-rounded" >
    					<i class="fa fa-chevron-up text-success"></i>
  					</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-right mb20 pr20">                              
					<button type="submit" id="new_questions_school_save_button"  class="button btn-system pull-right ladda-button" data-style="zoon-out" <?php if($disabled){echo 'disabled';} ?>><span class="ladda-label">Save Questions</span></button>
				</div>  	
			</div>
			<?php
				echo form_close();
			?>
		</div> <!-- end #bcs_questions_form_container -->
	</div> <!-- end .container-xl container-fluid -->
</div> <!-- end #bcs_event_question_content_container -->