<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_bcs_profiles_school extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'bcs_profiles_school';			// ALWAYS ADD 
	protected $_order_by = 'id';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = TRUE;			// ------------------------------------

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

	public function locations()
	{
		//$this->db->select('SELECT DISTINCT(`location`) AS location FROM bcs_profiles_school ORDER BY location');
		$this->db->distinct();
		$this->db->select('location');
		$this->db->order_by('location','ASC');
		$this->db->from($this->_table_name);
		return $this->db->get();
	}

}