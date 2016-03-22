<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_questions_school extends Authorized_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('array');
	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_questions_school');
	}

	public function index() 
	{
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function get_answers_by_profile_school_id_clean($id = NULL,$qs=NULL){
		if (!$id) {
			return false;
		}

		$this->mdl_bcs_questions_school->set_table('v_bcs_questions_school_answers');
		$this->mdl_bcs_questions_school->set_order_by('q_order, alpha');
		$params = array('profile_school_id'=>$id);
		$rslts = $this->mdl_bcs_questions_school->get_by($params);

		$this->mdl_bcs_questions_school->set_table('bcs_questions_school');
		$this->mdl_bcs_questions_school->set_order_by('question_id');

		if (!$rslts) {
			return false;
		}
		foreach ($rslts as $value) {
			if ($value->type == 'Multi') {
				if (isset($qs[$value->id]) && is_array($qs[$value->id])) {
					array_push($qs[$value->id],unserialize($value->answer));	
				} else {
					$qs[$value->id] = unserialize($value->answer);
				}
			} else {
				if (isset($qs[$value->id]) && is_array($qs[$value->id])) {
					array_push($qs[$value->id],$value->answer);
				} else {
					$qs[$value->id] = $value->answer;
				}
				
			}
		}

		return $qs;
	}

	public function get_question_school_results_for_project($id){
		if (!$id) {
			return null;
		}

		$this->mdl_bcs_questions_school->set_table('v_bcs_questions_school_answers');
		$this->mdl_bcs_questions_school->set_order_by('q_order, alpha');
		$params = array('profile_school_id'=>$id);
		$rslts = $this->mdl_bcs_questions_school->get_by($params);

		$this->mdl_bcs_questions_school->set_table('bcs_questions_school');
		$this->mdl_bcs_questions_school->set_order_by('question_id');
		return $rslts;
	}

	public function save()
	{
		$d2 = $this->_process_the_form();
		if(!$d2){
			return false;	
		}
		
		$d3 = $this->mdl_bcs_questions_school->save_batch($d2);
		if ($d3) {
			echo json_encode(array('status'=>'success','message'=>'Successfully saved your questions.'));
		} else {
			echo json_encode(array('status'=>'error','message'=>'There was a problem saving your quesitons, please please try again.'));
		}
		

		/*
				if ($d3) {
					$this->mdl_bcs_questions_school->set_table('v_bcs_questions_school_answers');
					$this->mdl_bcs_questions_school->set_order_by('q_order, alpha');
					$params = array('profile_school_id'=>$p);
					$rslts = $this->mdl_bcs_questions_school->get_by($params);
					$this->mdl_bcs_questions_school->set_table('bcs_questions_school');
					$this->mdl_bcs_questions_school->set_order_by('question_id');

					$this->load->module('bcs_questions');
					$this->bcs_questions->questions_with_data($rslts,'saved');

					//echo json_encode($rslts,JSON_UNESCAPED_SLASHES);
		*/
		// } else {
		// 	echo json_encode(array('status'=>'error','message'=>'There was an error saving your questions, please check them and try again.'));
		// }
		// return false;
	}

	public function edit(){
		$d2 = $this->_process_the_form();
		if(!$d2){
			return false;	
		}
		foreach ($d2 as $key => $value) {
			$q = $this->mdl_bcs_questions_school->save_where($value,array('question_id'=>$value['question_id'],'profile_school_id'=>$value['profile_school_id']));
		}
		echo json_encode(array('status'=>'success','message'=>'Your questions were updated!','data'=>$d2));
		return true;
	}


	public function edit_form($id=NULL,$return=FALSE){
		if (!$id) {
			echo json_encode(array('status'=>'error','message'=>'Could not load the saved profile!'));
			return false;
		}

		$this->mdl_bcs_questions_school->set_table('v_bcs_questions_school_answers');
		$this->mdl_bcs_questions_school->set_order_by('q_order, alpha');
		$params = array('profile_school_id'=>$id);
		$rslts = $this->mdl_bcs_questions_school->get_by($params);

		$this->mdl_bcs_questions_school->set_table('bcs_questions_school');
		$this->mdl_bcs_questions_school->set_order_by('question_id');

		$this->load->module('bcs_questions');

		if (empty($rslts)) {
			$this->load->module('bcs_profiles_school');
			$p = $this->bcs_profiles_school->get($id);

			if ($p) {
				$pid = $p->profile_id;
				$this->bcs_questions->profile($pid,'html');
			} else {
				echo json_encode(array('status'=>error,'Can not find profile'));
				return false;
			}
			
		} else {
			if ($return) {
				return $this->bcs_questions->return_questions_with_data($rslts,'saved');
			} else {
				$this->bcs_questions->questions_with_data($rslts,'saved');
			}
			
		}
		
	}

	public function edit_form_for_project($id=NULL){
		if (!$id) {
			return NULL;
		}

		$this->mdl_bcs_questions_school->set_table('v_bcs_questions_school_answers');
		$this->mdl_bcs_questions_school->set_order_by('q_order, alpha');
		$params = array('profile_school_id'=>$id);
		$rslts = $this->mdl_bcs_questions_school->get_by($params);

		$this->mdl_bcs_questions_school->set_table('bcs_questions_school');
		$this->mdl_bcs_questions_school->set_order_by('question_id');

		$this->load->module('bcs_questions');

		if (empty($rslts)) {
			return NULL;
		} else {			
			return $this->bcs_questions->return_questions_with_data_for_project($rslts,'saved');
		}

	}

	private function _process_the_form(){
				// Get the entire post value from post then get
		$r = $this->input->post();
		if (!$r) {
			$r = $this->input->get();
		}

		// Get profile_school_id field value
		// If it is missing, this is a critical error---
		if(element('profile_school_id',$r)){
			$p = element('profile_school_id',$r);
		} else {
			echo json_encode(array('status'=>'error','message'=>'There was an error saving your quesitons, please try again!'));
			return false;
		}
		
		// Get form_status_2 field value
		$f = element('form_status_2',$r,'new');

		$d = array();
		foreach ($r as $key => $value) {
			if ( ! ($key == 'profile_school_id' || $key == 'form_status_2' || strtolower(substr($key,0,4)) == 'qid_' || strtolower(substr($key,0,5)) == 'desc_' )) {
				$d[] = elements(array('profile_school_id',$key,'qid_'.$key,'desc_'.$key),$r);

			}
		}

		$d2 = array();
		$x = 0;
		foreach ($d as $k => $v) {
			foreach ($v as $key => $value) {
				if ($key == 'profile_school_id') {
					$d2[$x]['profile_school_id'] = $value;
				} elseif (strtolower(substr($key,0,4)) == 'qid_') {
					$d2[$x]['question_id'] = $value;
				} elseif ( (strtolower(substr($key,0,5)) == 'desc_') ) {		
					$d2[$x]['description'] = $value;	
				} else {
					if (is_array($value)) {
						$d2[$x]['answer'] = serialize($value);
					} else {
						$d2[$x]['answer'] = $value;
					}
				}
			}
			$x = $x + 1;
		}
		return $d2;
	}
}
