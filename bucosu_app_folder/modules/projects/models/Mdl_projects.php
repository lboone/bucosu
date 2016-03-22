<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_projects extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'projects';			// ALWAYS ADD 
	protected $_order_by = 'id';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = TRUE;			// ------------------------------------

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

}