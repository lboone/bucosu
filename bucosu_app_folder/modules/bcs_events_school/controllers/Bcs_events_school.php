<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_events_school extends Authorized_Controller {

	protected $_the_model = null;

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_events_school');
		$this->_the_model = $this->mdl_bcs_events_school;
	}

	public function all_by_school_district_event($event_id)
	{
		$param = array('event_school_district_id'=>$event_id, 'active'=>'1');
		$result = $this->mdl_bcs_events_school->get_by($param);
		return $result;
	}

	public function all_by_school_district_event_sort($event_id,$sort='school_name'){
		$this->_order_by = $sort;
		$param = array('event_school_district_id'=>$event_id, 'active'=>'1');
		$result = $this->mdl_bcs_events_school->get_by($param);
		return $result;
	}

	public function all_by_school_district_event_json($event_id)
	{
		echo json_encode($this->all_by_school_district_event($event_id));
	}


	public function all_by_school_district_event_input_options($event_id)
	{
		$results = $this->all_by_school_district_event($event_id);
		if (isset($results)) {
			foreach ($results as $result) {
				echo '<option name="bcs_events_school" value="' . $result->id. '">' . $result->school_name . '</option>';
			}
		} else {
			echo '<option name="bcs_events_school" value="">This District has no school events...</option>';
		}
	}

	public function all_by_school_district_event_array($event_id)
	{
		$param = array('event_school_district_id'=>$event_id, 'active'=>'1');
		$this->_the_model->set_order_by('school_name');
		$results = $this->_the_model->get_by($param);
		$s_events = null;
		if ($results)
		{
			$s_events = array();
			foreach ($results as $result) {
				$s_events[] = array('title'=>$result->school_name,'key'=>$result->id);
			}

			return $s_events;
		}
	}

}
