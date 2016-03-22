<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_events_school_district extends Authorized_Controller {

	protected $_the_model = null;

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_events_school_district');
		$this->_the_model = $this->mdl_bcs_events_school_district;
		$this->load->module('bcs_events_school');
		$this->_the_module = $this->bcs_events_school;
	}

	public function index() 
	{
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);

	}


	public function event_by_school_district($sd_id)
	{
		$param = array('sd_id'=>$sd_id, 'event_started'=>'1','active'=>'1');
		$result = $this->_the_model->get_by($param,TRUE);
		return $result;
	}

	public function event_by_school_district_json($sd_id)
	{
		echo json_encode($this->event_by_school_district($sd_id));
	}


	public function event_by_school_district_input_options($sd_id)
	{
		$results = $this->event_by_school_district($sd_id);
		if ($results) {
			foreach ($results as $result) {
				echo '<option name="bcs_events_school_district" value="' . $results->id. '">' . $results->school_district . '</option>';
			}
		} else {
			echo '<option>Oops that district has no events!</option>';
		}
	}

	public function get_users_school_districts_school(){
		$sd_events = array();

		if ($this->session->userdata('user_group_type') == 3) {
			$this->_the_model->set_order_by('event_name');
			$rslt =  $this->event_by_school_district($this->session->userdata('company')->id);
			if ($rslt) {
				$sd_id = $rslt->id;
				$sd_events[$sd_id]['sd_event'] = $rslt;
				$sd_events[$sd_id]['s_events'] = $this->_the_module->all_by_school_district_event_sort($sd_id);
			}
		} elseif ($this->session->userdata('agreements')) {
			$agreements = $this->session->userdata('agreements');
			foreach ($agreements as $agreement) {
				$this->_the_model->set_order_by('event_name');
				$rslt = $this->event_by_school_district($agreement['agreement_with']->id);
				if ($rslt) {
					$sd_id = $rslt->id;
					$children = $this->_the_module->all_by_school_district_event($sd_id);
					if ($children) {
						$sd_events[$sd_id]['sd_event'] = $rslt;
						$sd_events[$sd_id]['s_events'] = $children;
					}
				}
			}
		}

		return $sd_events;
	}


	public function get_all_data_json()
	{
		$sd_events = $this->get_users_school_districts_school();

		$this->load->module('user_settings');
		$id = $this->session->userdata('user_id');
		$u_s = $this->user_settings->get_user_setting('project_school_district',$id);
		
		$sd = "";
		if($u_s)
		{	
			$sd = $u_s->setting_value;
		} else {
			foreach ($sd_events as $key => $value) {
				$sd = $value['sd_event']->id;
				$sd_n = $value['sd_event']->event_name;
				$params = array('project_school_district'=>$sd,'project_school_district_name'=>$sd_n);
				$this->user_settings->update_settings($params);
				break;
			}
		}
		

		$u_s = $this->user_settings->get_user_setting('project_school',$id);
		$s = "";
		if($u_s)
		{	
			$s = $u_s->setting_value;
		} else {
			foreach ($sd_events as $key => $value){
				if (intval($sd) === intval($key)) {
					$s = $value['s_events'][0]->id;
					$s_n = $value['s_events'][0]->school_name;
					$params = array('project_school'=>$s,'project_school_name'=>$s_n);
					$this->user_settings->update_settings($params);
					break;
				}
			}
		}

		if (count($sd_events)>0) {
			echo json_encode(array('success'=>true,'msg'=>$sd_events,'defaults'=>array('sd'=>$sd,'s'=>$s)));	
		} else {
			$err = $this->db->error();
			if ($err){
				echo json_encode(array('success'=>false,'msg'=>$err['message'],'defaults'=>NULL));	
			} else {
				echo json_encode(array('success'=>false,'msg'=>'There was an error getting the information.','defaults'=>NULL));	
			}
			
		}
		
	}

	public function get_all_nodes_json()
	{
		$sd_events = array();
		$this->_the_model->set_order_by('event_name');

		//If user is from a school, use the school id.
		if ($this->session->userdata('user_group_type') == 3) {
			$rslt =  $this->event_by_school_district($this->session->userdata('company')->id);
			if ($rslt) {
				$sd_events[] = array('title'=>$rslt->event_name, 'key'=>$rslt->id, 'folder'=>true, 'children'=>$this->_the_module->all_by_school_district_event_array($key));
			}
		} elseif ($this->session->userdata('agreements')) {
			$agreements = $this->session->userdata('agreements');
			foreach ($agreements as $agreement) {
				$rslt = $this->event_by_school_district($agreement['agreement_with']->id);
				if ($rslt) {
					$children = $this->_the_module->all_by_school_district_event_array($rslt->id);
					if ($children) {
						$sd_events[] = array('title'=>$rslt->event_name, 'key'=>$rslt->id, 'folder'=>true, 'children'=>$children);			
					}
				}
			}
		}


		echo json_encode($sd_events);


		/*
		$this->load->module('bcs_event_school_district');

		$results = $this->get_all();
		$raw_data = array();
		if ($results) {
			foreach ($results as $result) {
				$raw_data[] = array('title'=>$result->order . ') ' . $result->name,'key'=>$result->id, 'folder'=>true, 'children'=>$this->bcs_profiles->by_heading_array($result->id));
			}
		}

		echo json_encode($raw_data);
		*/
	}

}
