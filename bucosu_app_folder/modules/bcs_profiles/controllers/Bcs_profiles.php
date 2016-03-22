<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_profiles extends Authorized_Controller {
	protected $_the_model;

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_profiles');
		$this->_the_model = $this->mdl_bcs_profiles;
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
				var_dump($this->all());
			}
			else
			{
				return $this->all();
			}
			
		}

	}

	public function heading($heading_id,$type='json')
	{
		if ($type == 'json') {
			$this->by_heading_json($heading_id);
		}
		else
		{
			var_dump($this->by_heading($heading_id));
		}
	}


	public function all()
	{
		return($this->mdl_bcs_profiles->get());
	}

	public function all_json()
	{
		$results = $this->all();
		echo json_encode($results);
	}

	public function all_by_heading_id($h_id){
		$param = array('heading_id'=>$h_id, 'active'=>'1');
		$this->_the_model->set_order_by('name');
		$results = $this->_the_model->get_by($param);
		$pros = null;
		if ($results)
		{
			$pros = array();
			foreach ($results as $result) {
				$pros[] = array('title'=>$result->name,'key'=>$result->id);
			}
			return $pros;
		}
	}

	public function all_by_heading_id_project($h_id){
		$param = array('heading_id'=>$h_id, 'active'=>'1');
		$this->_the_model->set_order_by('name');
		$results = $this->_the_model->get_by($param);
		$pros = null;
		if ($results)
		{
			$pros = array();
			foreach ($results as $result) {
				$pros[] = array('title'=>$result->name,'key'=>$result->id,'bcs_qnum'=>$result->bcs_question_number);
			}
			return $pros;
		}
	}

	public function by_heading($heading_id)
	{
		$groupLevel = $this->session->userdata('user_group_level');
		if ($groupLevel) {
			if ($groupLevel < 10) {
				$params = array('heading_id'=>$heading_id);
			} else {
				$params = array('heading_id'=>$heading_id,'group_level ='=>$groupLevel);	
			}
		} else {
			$params = array('heading_id'=>$heading_id);	
		}
		
		return $this->mdl_bcs_profiles->get_by($params);
	}

	public function by_heading_array($heading_id)
	{
		$results = $this->by_heading($heading_id);
		if ($results)
		{
			$profiles = array();
			foreach ($results as $result) {
				$profiles[] = array('title'=>$result->bcs_question_number . ') ' . $result->name,'key'=>$result->id);
			}

			return $profiles;
		}
	}
	
	public function by_heading_json($heading_id)
	{
		$results = $this->by_heading($heading_id);
		echo json_encode($results);
	}
}
