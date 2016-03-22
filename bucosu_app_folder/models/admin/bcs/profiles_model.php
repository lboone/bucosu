<?php
class Profiles_model extends Bcs_admin_model
{

	protected $_table_name = 'v_bcs_profiles';
	protected $_order_by = 'bcs_question_number';
	protected $_primary_key = 'id';

	protected $_config = array(
    	'table' => 'bcs_profiles',
    	'id' => 'id',
    	'field' => 'slug',
    	'title' => 'Slug',
    	'replacement' => 'underscore' // Either dash or underscore
	);

	public function __construct()
	{
		parent::__construct();
	}

	// Get all the active bcs_headings
	public function get_bcs_profiles($active=TRUE){
		return $this->get();
	}

	// Get a given bcs_heading.
	public function get_bcs_profile($search_key = NULL)
	{
		if (is_numeric($search_key)) {
			$filter = $this->_primary_filter;
			$headingID = $filter($search_key);
		} else {
			$headingID = $this->get_id($search_key);
		}
		return $this->get($headingID);

	}

	//Return profiles for a given bcs_heading
	public function get_bcs_profile_questions($search_key = NULL, $active=TRUE){
		$profile = $this->get_bcs_profile($search_key);
		$profile_id = $profile->id;
		$this->_table_name = 'bcs_questions';
		$this->_order_by = 'q_order,alpha';
		$arguments = array(
				'profile_id'=>$profile_id,
				'active'=>$active,
			);
		$qs = $this->get_by($arguments);
		$this->reset_model();
		return $qs;
	}

	public function update_profile($search_key = '', $data = array()) 
	{

		if ( empty($search_key)) { return FALSE; }

		$this->reset_model();
		
		$this->set_table_name('bcs_profiles');

		$profile_id = $this->get_id($search_key);

		if (isset($data['name'])) {
			$data['slug'] = $this->return_slug($data['name']);
		}

		$profile = $this->save($data,$profile_id);

		$this->reset_model();
		
		if (!$profile) {
			$this->ion_auth->set_error('Profile not updated');
			return FALSE;
		} else {
			$this->ion_auth->set_message('Profile update successfull');
			return $profile;
		}

	}

	public function insert_profile($data = array())
	{
		if (!isset($data)) { return FALSE; }

		if (!isset($data['name'])) { return FALSE; }

		
		$this->reset_model();

		$data['slug'] = $this->return_slug($data['name']);
		

		$this->reset_model('bcs_profiles');
		
		$header = $this->save($data);

		$this->reset_model();
		
		if (!$header) {
			$this->ion_auth->set_error('Profile not inserted');
			return FALSE;
		} else {
			$this->ion_auth->set_message('Profile update successfull');
			return $header;
		}

	}


	public function reset_model($table_name = 'v_bcs_Profiles', $order_by = 'bcs_question_number', $primary_key = 'id'){
		parent::reset_model($table_name,$order_by,$primary_key);
	}
}