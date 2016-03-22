<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_NAME extends MY_Model {
											// DEFAULTS:
	protected $_table_name = '';			// ALWAYS ADD 
	protected $_order_by = '';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = FALSE;			// ------------------------------------

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

}