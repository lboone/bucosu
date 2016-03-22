<?php
class Headings_model extends Bcs_admin_model 
{
	protected $_table_name = 'v_bcs_headings';
	protected $_order_by = 'order';
	protected $_primary_key = 'id';

	protected $_config = array(
    	'table' => 'bcs_headings',
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
	public function get_bcs_headings($active=TRUE){
		return $this->get();
	}

	// Get a given bcs_heading.
	public function get_bcs_heading($search_key = NULL)
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
	public function get_bcs_heading_profiles($search_key = NULL, $active=TRUE){
		$heading = $this->get_bcs_heading($search_key);
		$heading_id = $heading->id;
		$this->_table_name = 'v_bcs_profiles';
		$this->_order_by = 'bcs_question_number';
		$arguments = array(
				'heading_id'=>$heading_id,
				'active'=>1,
			);
		$profs = $this->get_by($arguments);
		$this->reset_model();
		return $profs;
	}

	public function update_heading($search_key = '', $data = array()) 
	{

		if ( empty($search_key)) { return FALSE; }

		$this->reset_model();
		
		$this->set_table_name('bcs_headings');

		$heading_id = $this->get_id($search_key);

		if (isset($data['name'])) {
			$data['slug'] = $this->return_slug($data['name']);
		}

		$header = $this->save($data,$heading_id);

		$this->reset_model();
		
		if (!$header) {
			$this->ion_auth->set_error('Header not updated');
			return FALSE;
		} else {
			$this->ion_auth->set_message('Heading update successfull');
			return $header;
		}

	}

	public function insert_heading($data = array())
	{
		if (!isset($data)) { return FALSE; }

		if (!isset($data['name'])) { return FALSE; }

		
		$this->reset_model();

		$data['slug'] = $this->return_slug($data['name']);
		
		$data['order'] = $this->get_next_order();

		$this->reset_model('bcs_headings');
		
		$header = $this->save($data);

		$this->reset_model();
		
		if (!$header) {
			$this->ion_auth->set_error('Header not inserted');
			return FALSE;
		} else {
			$this->ion_auth->set_message('Heading update successfull');
			return $header;
		}

	}


	public function reset_model($table_name = 'v_bcs_headings', $order_by = 'order', $primary_key = 'id'){
		parent::reset_model($table_name,$order_by,$primary_key);
	}


	public function get_next_order($tableName = 'bcs_headings')
	{
		$this->reset_model($tableName);

		$maxOrder = $this->db->select_max('order')
							 ->get($this->get_table_name());
		$newMaxOrder = FALSE;
		if (is_numeric($maxOrder->row()->order)) {
			$filter = $this->_primary_filter;
			$newMaxOrder = $filter($maxOrder->row()->order) + 1;
		} 

		$this->reset_model();
		return $newMaxOrder;
	}

}