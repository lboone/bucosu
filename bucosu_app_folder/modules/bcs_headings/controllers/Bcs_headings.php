<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_headings extends Authorized_Controller {
	protected $_the_model;
	protected $_the_module;

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_headings');
		$this->_the_model = $this->mdl_bcs_headings;
	}


	public function get_all()
	{
		return($this->mdl_bcs_headings->get());
	}

	public function get_all_json()
	{
		$results = $this->get_all();
		echo json_encode($results);
	}

	public function get_all_nodes_json()
	{
		$this->load->module('bcs_profiles');

		$results = $this->get_all();
		$raw_data = array();
		if ($results) {
			foreach ($results as $result) {
				$raw_data[] = array('title'=>$result->order . ') ' . $result->name,'key'=>$result->id, 'folder'=>true, 'children'=>$this->bcs_profiles->by_heading_array($result->id));
			}
		}

		echo json_encode($raw_data);
	}


	public function get_headings_profiles(){
		$this->load->module('bcs_profiles');
		$this->_the_module = $this->bcs_profiles;

		$headings = array();
		
		$param = array('bcs_project_option'=>'1');

		$rslts = $this->_the_model->get_by($param);
		foreach ($rslts as $key => $value) {
			if ($value) {
				$h_id = $value->id;
				$children = $this->_the_module->all_by_heading_id($h_id);
				if ($children) {
					$headings[$h_id]['heading'] = $value;
					$headings[$h_id]['profiles'] = $children;
				}
			}
		}
		return $headings;
	}

	public function get_headings_profiles_project(){
		$this->load->module('bcs_profiles');
		$this->_the_module = $this->bcs_profiles;

		$headings = array();
		
		$param = array('bcs_project_option'=>'1');

		$rslts = $this->_the_model->get_by($param);
		foreach ($rslts as $key => $value) {
			if ($value) {
				$h_id = $value->id;
				$children = $this->_the_module->all_by_heading_id_project($h_id);
				if ($children) {
					$headings[$h_id]['heading'] = $value;
					$headings[$h_id]['profiles'] = $children;
				}
			}
		}
		return $headings;
	}

	public function get_all_data_json()
	{
		$headings = $this->get_headings_profiles();

		$this->load->module('user_settings');
		$id = $this->session->userdata('user_id');
		$h_s = $this->user_settings->get_user_setting('project_bcs_heading',$id);
		$h = "";
		if($h_s)
		{	
			$h = $h_s->setting_value;
		} else {
			foreach ($headings as $key => $value) {
				$h = $value['heading']->id;
				$h_n = $value['heading']->name;
				$params = array('project_bcs_heading'=>$h,'project_bcs_heading_name'=>$h_n);
				$this->user_settings->update_settings($params);
				break;
			}
		}
		
		$p_s = $this->user_settings->get_user_setting('project_bcs_profile',$id);
		$p = "";
		if($p_s)
		{	
			$p = $p_s->setting_value;
		} else {
			foreach ($headings as $key => $value){
				if (intval($h) === intval($key)) {
					$s = $value['profiles'][0]['key'];
					$s_n = $value['profiles'][0]['title'];
					$params = array('project_bcs_profile'=>$s,'project_bcs_profile_name'=>$s_n);


					$this->user_settings->update_settings($params);
					break;
				}
			}
		}

		if (count($headings)>0) {
			echo json_encode(array('success'=>true,'msg'=>$headings,'defaults'=>array('h'=>$h,'p'=>$p)));	
		} else {
			$err = $this->db->error();
			if ($err){
				echo json_encode(array('success'=>false,'msg'=>$err['message'],'defaults'=>NULL));	
			} else {
				echo json_encode(array('success'=>false,'msg'=>'There was an error getting the information.','defaults'=>NULL));	
			}
			
		}
		
	}
}
