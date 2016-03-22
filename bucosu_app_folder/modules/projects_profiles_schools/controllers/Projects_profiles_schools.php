<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Projects_profiles_schools extends Authorized_Controller {
	protected $_the_model;

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_projects_profiles_schools');
		$this->_the_model = $this->mdl_projects_profiles_schools;
	}

	public function index() 
	{
		$this->_call_401();
		return;
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function get_all_projects_by_profile_school_id($id){
		$param = array('profiles_school_id'=>$id);
		$rslts = $this->_the_model->get_by($param);
		if ($rslts) {
			return $rslts;
		} else {
			return null;
		}
		
	}
}
