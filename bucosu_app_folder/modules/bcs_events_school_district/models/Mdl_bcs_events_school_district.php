<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_bcs_events_school_district extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'v_bcs_events_school_district';			// ALWAYS ADD 
	protected $_order_by = 'event_name';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = FALSE;			// ------------------------------------

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

}