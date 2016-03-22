<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_questions extends Authorized_Controller {

	private $_row = array();
	private $_icon = array(
							'currency'		=> 'fa fa-usd',
							'date'			=> 'fa fa-calendar',
							'email'			=> 'fa fa-envelope-o',
							'number'		=> 'fa fa-bar-chart-o',
							'phone_number'	=> 'fa fa-phone',
							'text'			=> 'fa fa-font',
							'multi'			=> NULL,
							'single'		=> NULL,
							'yn'			=> NULL,
							'paragraph'		=> 'fa fa-comments',
						  );

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_questions');
		
	}


	// Returns all profiles in json format by default
	// params = change first param to anything to return an array
	// params = change second param to no to return the msql array and not print it to the screen.

	public function index($type='json',$print='Yes')
	{
		if ($type == 'json') 
		{
			$this->all_json();
		}
		else
		{
			if ($print == 'Yes') 
			{
				//var_dump($this->all());
				$this->load->library('bcs_qs',$this->all());
				$this->bcs_qs->html();
			}
			else
			{
				return $this->all();
			}
			
		}

	}



	public function profile($profile_id,$type='json')
	{
		if ($type == 'json') {
			$this->by_profile_json($profile_id);
		}
		else
		{
			$qs = $this->by_profile($profile_id);
			$this->_generate_question_rows($qs);
			if (isset($this->data['rules'])) {
				echo json_encode(array('status'=>'success','data'=>$this->load_view('questions',NULL,TRUE),'rules'=>$this->data['rules']));
			} else {
				echo json_encode(array('status'=>'success','data'=>$this->load_view('questions',NULL,TRUE)));
			}
			
		}
	}

	public function questions_with_data($qs,$f){
		if (is_array($qs)) {
			$this->_generate_question_rows($qs,'');
			$this->data['form_status'] = $f;
			if (isset($this->data['rules'])) {
				echo json_encode(array('status'=>'success','data'=>$this->load_view('questions',NULL,TRUE),'rules'=>$this->data['rules']));
			} else {
				echo json_encode(array('status'=>'success','data'=>$this->load_view('questions',NULL,TRUE)));
			}
		}
	}

	public function questions_with_data_for_project($qs,$f){
		if (is_array($qs)) {
			$this->_generate_question_rows($qs,'disabled');
			$this->data['form_status'] = $f;
			if (isset($this->data['rules'])) {
				echo json_encode(array('status'=>'success','data'=>$this->load_view('questions_for_project',NULL,TRUE),'rules'=>$this->data['rules']));
			} else {
				echo json_encode(array('status'=>'success','data'=>$this->load_view('questions_for_project',NULL,TRUE)));
			}
		}
	}

	public function return_questions_with_data($qs,$f){
		if (is_array($qs)) {
			$this->_generate_question_rows($qs,'');
			$this->data['form_status'] = $f;
			if (isset($this->data['rules'])) {
				return array('status'=>'success','data'=>$this->load_view('questions',NULL,TRUE),'rules'=>$this->data['rules']);
			} else {
				return array('status'=>'success','data'=>$this->load_view('questions',NULL,TRUE));
			}
		}
	}

	public function return_questions_with_data_for_project($qs,$f){
		if (is_array($qs)) {

			$this->_row = array();
			$this->_generate_question_rows($qs,'disabled');
			$this->data['form_status'] = $f;
			return $this->load_view('questions_for_project',NULL,TRUE);
		}
	}

	public function question_answers($type='json'){
		$rslts = $this->mdl_bcs_questions->question_answers();
		if (count($rslts)<1) {
			$rslts = array('status'=>'error','message'=>'No data returned');	
		} else {
			$rslts = array('status'=>'success','data'=>$rslts);
		}

		if ($type=='json') {
			echo json_encode($rslts);
		} else {
			print_r($rslts);
		}
		
	}

	private function _generate_question_rows($qs,$disabled='disabled'){
		$cnt = 0;

		if (array_key_exists('profile_school_id', $qs[0])) {
				$this->data['profile_school_id'] = $qs[0]->profile_school_id;
		}
		$rulz = array();
		foreach ($qs as $q) {

			$this->data['q'] = $q;
			$q_type = strtolower($q->type);
			$this->data['icon'] = $this->_icon[$q_type];

				$this->data['file_type'] = $q_type;
				$this->data['disabled'] = $disabled;
				$this->data['col_3'] = 'col-sm-7 col-md-7 col-lg-6';
				$this->data['head'] = $this->load_view('inc/head',NULL,TRUE);
				$nam = $q->slug;

				if (isset($q->validation) && !(trim($q->validation) == '')) {
					$rulz[] = $nam .': ' .$q->validation;	
				}

				$this->data['foot'] = $this->load_view('inc/foot',NULL,TRUE);
				

				$this->_add_to_row($this->load_view($q_type,NULL,TRUE));
		}

		$this->data['form_data'] = $this->_row;
		$this->data['rules'] = $rulz;
	}


	public function all()
	{
		return($this->mdl_bcs_questions->get());
	}

	public function all_json()
	{
		$results = $this->all();
		echo json_encode($results,JSON_UNESCAPED_SLASHES );
	}




	public function by_profile($profile_id)
	{
		$params = array('profile_id'=>$profile_id);
		return $this->mdl_bcs_questions->get_by($params);
	}

	public function by_profile_json($profile_id)
	{
		$results = $this->by_profile($profile_id);
		echo json_encode($results,JSON_UNESCAPED_SLASHES);
	}

	private function _add_to_row($val){
		$this->_row[] = $val;
	}
}
